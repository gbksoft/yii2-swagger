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
            'on beforeJson' => function($event) {
                // Replace response content (swagger.json)
                $event->responseText = mb_ereg_replace('{{http_host}}', \Yii::$app->request->hostInfo, $event->responseText);
                $event->responseText = mb_ereg_replace('{{apiversion}}', \Yii::$app->params['apiversion'], $event->responseText);
            },
        ],
    ],
...
```

Module url rules
-----

```
swagger/                <== Main swagger page
swagger/default/json    <== Get swagger.json file with replacements
swagger/default/history <== Get git logs history (included in bottom on main swagger page)
```
