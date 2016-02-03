<?php

namespace gbksoft\modules\swagger\components;

use yii\base\Component;
use yii\base\Event;

/**
 * Response handler for method DefaultController::actionJson()
 *
 * @author Hryhorii Furletov <littlefuntik@gmail.com>
 */
class BeforeJsonEvent extends Event
{
    public $responseText;
}
