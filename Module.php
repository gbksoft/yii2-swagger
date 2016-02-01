<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace gbksoft\modules\swagger;

use Yii;
use yii\base\BootstrapInterface;
use yii\web\ForbiddenHttpException;

/**
 * This is the main module class for the Swagger module.
 *
 *
 * @author Hryhorii Furletov <littlefuntik@gmail.com>
 * @since 2.0
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    const MODULE_ID = 'swagger';
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'gbksoft\modules\swagger\controllers';
    public $swaggerPath;

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
}
