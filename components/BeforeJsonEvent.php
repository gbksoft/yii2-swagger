<?php
/**
 * Copyright © 2016 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
namespace gbksoft\modules\swagger\components;

use yii\base\Event;

/**
 * Response handler for method DefaultController::actionJson()
 */
class BeforeJsonEvent extends Event
{
    public $responseText;
}
