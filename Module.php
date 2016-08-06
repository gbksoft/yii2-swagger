<?php
/**
 * Copyright © 2016 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
namespace gbksoft\modules\swagger;

use yii\base\BootstrapInterface;

/**
 * This is the main module class for the Swagger module.
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    const MODULE_ID = 'swagger';
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'gbksoft\modules\swagger\controllers';
    
    public $swaggerPath;
    public $swaggerUrl;
    public $swaggerReplace;

    /**
     * Class extended yii\web\IdentityInterface interface
     * Required option.
     * @var string
     */
    public $userClass = 'yii\web\User';
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        // initialize the module with the configuration loaded from config.php
        \Yii::configure($this, require(__DIR__ . '/config.php'));
    }
    
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // pass
    }
}
