<?php
/**
 * Copyright © 2016 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
namespace gbksoft\modules\swagger\controllers;

use gbksoft\modules\swagger\components\BeforeJsonEvent;
use gbksoft\modules\swagger\components\shell\Command;
use gbksoft\modules\swagger\components\shell\Command\Argument;
use gbksoft\modules\swagger\components\shell\Command\Flag;
use gbksoft\modules\swagger\components\shell\Command\Option;
use gbksoft\modules\swagger\components\shell\CommandBuilder;
use gbksoft\modules\swagger\Module;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class DefaultController
 */
class DefaultController extends Controller
{
    const EVENT_BEFORE_JSON = 'beforeJson';

    /**
     * @inheritdoc
     */
    public $layout = 'main';

    /**
     * @var Module
     */
    public $module;

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                        'actions' => ['index', 'history', 'json'],
                    ],
                ],
            ],
        ]);
    }
    
    /**
     * Main swagger page
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    /**
     * Display git commit(s) log(s)
     * 
     * Todo: refactoring..
     */
    public function actionHistory()
    {
        $builder = new CommandBuilder();
        $hash = \Yii::$app->request->get('c');
        $pathToJson = $this->module->swaggerPath;


        // set executable external!!!
        // @chmod(__DIR__ . '/../ansi2html.sh', 0755);

        if ($hash && preg_match('#[a-z0-9]{4,40}#', $hash)) {
            $commands = [];
            $commands[] = $builder->setCommand(new Command('cd'))
                ->addArgument(new Argument(dirname($pathToJson)))
                ->build();

            $commands[] = $builder->setCommand(new Command('git'))
                ->addArgument(new Argument('log'))
                ->addFlag(new Flag('--color'))
                ->addFlag(new Flag('-p'))
                ->addFlag(new Flag('-1'))
                ->addArgument(new Argument($hash))
                ->addFlag(new Flag('--'))
                ->addArgument(new Argument('./' . basename($pathToJson)))
                ->build();

            $result = shell_exec(implode('; ', $commands) . ' | ' . __DIR__ . '/../ansi2html.sh');
            echo $result;
            \Yii::$app->end();
        }

        $format = '<tr class="log-item">';
        $format .= '<td class="log-hash">%h</td>';
        $format .= '<td class="log-date">%ad</td>';
        $format .= '<td class="log-short-comment">%s</td>';
        $format .= '<td class="log-full-comment">%b</td>';
        $format .= '</tr>';

        $commands = [];

        $commands[] = $builder->setCommand(new Command('cd'))
            ->addArgument(new Argument(dirname($pathToJson)))
            ->build();

        $commands[] = $builder->setCommand(new Command('git'))
            ->addArgument(new Argument('log'))
            ->addFlag(new Flag('--color'))
            ->addOption(new Option('--pretty', 'format:' . $format))
            ->addFlag(new Flag('--no-merges'))
            ->addFlag(new Flag('-10'))
            ->addFlag(new Flag('--'))
            ->addArgument(new Argument('./' . basename($pathToJson)))
            ->build();
        echo '<table>';
        echo stripslashes(shell_exec(implode('; ', $commands)));
        echo '</table>';
        \Yii::$app->end();
    }

    /**
     * Parse swagger.json file, do replacements and return json
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionJson()
    {
        /** @var \yii\web\Response */
        $response = \Yii::$app->getResponse();
        
        if (!is_readable($this->module->swaggerPath)) {
            throw new NotFoundHttpException();
        }
        
        // Read source json file
        $json = file_get_contents($this->module->swaggerPath);
    
        // Do replacements
        if (is_array($this->module->swaggerReplace)) {
            foreach ($this->module->swaggerReplace as $find => $replace) {
                if (is_callable($replace)) {
                    $replaceText = call_user_func($replace);
                } else {
                    $replaceText = (string) $replace;
                }
                $json = mb_ereg_replace((string)$find, $replaceText, $json);
            }
        }
        
        // Override default response formatters
        // To avvoid json format modification
        $response->format = Response::FORMAT_RAW;
        $response->getHeaders()->set('Content-Type', 'application/json; charset=UTF-8');
        
        // Trigger events
        $event = new BeforeJsonEvent;
        $event->responseText = $json;
        $this->module->trigger(self::EVENT_BEFORE_JSON, $event);
        
        return $event->responseText;
    }
}
