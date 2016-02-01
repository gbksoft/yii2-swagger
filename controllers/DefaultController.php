<?php
namespace gbksoft\modules\swagger\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\web\Controller;

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
    
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionHistory()
    {
        $pathToJson = $this->module->swaggerPath;
        
        // set executble external!!!
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
}
