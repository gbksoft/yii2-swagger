Swagger Module for Yii 2
========================

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require gbksoft/yii2-swagger
```

or add

```
"gbksoft/yii2-swagger": "~1.0.0"
```

to the require section of your `composer.json` file.

Usage
-----

```
...
    'modules' => [
        'swagger' => [
            'class' => 'gbksoft\modules\swagger\Module',
            'swaggerUrl' => '/api/web/swagger/swagger.json',
            'swaggerPath' => __DIR__ . '/../../api/web/swagger/swagger.json',
        ],
    ],
...
```