<?php
/**
 * Copyright © 2016 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */

namespace gbksoft\modules\swagger;

use yii\web\AssetBundle;

/**
 * Swagger asset bundle
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
