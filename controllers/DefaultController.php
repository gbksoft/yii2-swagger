<?php
namespace gbksoft\modules\swagger\controllers;

use Yii;
use yii\base\Event;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use gbksoft\modules\swagger\Module;

/**
 * Class DefaultController
 * 
 * @package gbksoft\tokens\controllers
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public $layout = 'main';
    /**
     * @var \gbksoft\modules\swagger\Module
     */
    public $module;
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
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
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                        'actions' => ['index', 'history'],
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
        $pathToJson = $this->module->swaggerPath;
        
        // set executable external!!!
        @chmod(__DIR__ . '/../ansi2html.sh', 0755);
        
        if (isset($_GET['c']) and !empty($_GET['c'])) {
            echo passthru("cd " . dirname($pathToJson) . "; git log --color -p -1 ". $_GET['c'] ." -- ./" . basename($pathToJson) . " | " . __DIR__ . "/../ansi2html.sh");
            die;
        }

        $format = '<div class="log-item">';
        $format .= '<span class="log-hash">%h</span>';
        $format .= '<span class="log-date">%ad</span>';
        $format .= '<div class="log-short-comment">%s</div>';
        $format .= '<div class="log-full-comment">%b</div>';
        $format .= '</div>';
        echo passthru("cd ". dirname($pathToJson) ."; git log --color  --pretty=format:\"".$format."\"  --no-merges -10 -- ./" . basename($pathToJson));
        Yii::$app->end();
    }
    
    /**
     * Parse swagger.json file, do replacements
     * and return json
     * 
     * @return string
     */
    public function actionJson()
    {
        /** @var \yii\web\Response */
        $response = Yii::$app->getResponse();
        
        if (!is_readable($this->module->swaggerPath)) {
            throw new NotFoundHttpException;
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
        $this->module->trigger(Module::EVENT_BEFORE_JSON, new Event($json));
        
        return $json;
    }
}
