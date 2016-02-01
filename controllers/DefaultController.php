<?php
namespace gbksoft\modules\swagger\controllers;

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
                        'actions' => ['index'],
                    ],
                ],
            ],
        ]);
    }
    
    public function actionIndex()
    {
        $this->render('index');
    }
}
