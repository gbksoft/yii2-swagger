<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace gbksoft\modules\swagger;

use yii\web\AssetBundle;

/**
 * Swagger asset bundle
 *
 * @author Hryhorii Furletov <littlefuntik@gmail.com>
 * @since 2.0
 */
class SwaggerAsset extends AssetBundle
{
    public $sourcePath = '@vendor/gbksoft/yii2-swagger/assets';
    public $css = [
        'css/typography.css',
        'css/reset.css',
        'css/screen.css',
        'css/tags.css',
        'css/reset.css',
        'css/style.css',
        // 'css/print.css',
        'css/apihistory.css',
    ];
    public $js = [
        'lib/jquery-1.8.0.min.js',
        'lib/jquery.slideto.min.js',
        'lib/jquery.wiggle.min.js',
        'lib/jquery.ba-bbq.min.js',
        'lib/handlebars-2.0.0.js',
        'lib/underscore-min.js',
        'lib/backbone-min.js',
        'swagger-ui.min.js',
        'lib/highlight.7.3.pack.js',
        'lib/jsoneditor.min.js',
        'lib/marked.js',
        'lib/swagger-oauth.js',
        'lib/apihistory.js',
    ];
    public $depends = [];
}
