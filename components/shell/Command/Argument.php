<?php
/**
 * Copyright © 2016 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
namespace gbksoft\modules\swagger\components\shell\Command;

use gbksoft\modules\swagger\components\shell\AbstractInput;

/**
 * Class Argument
 */
class Argument extends AbstractInput
{
    const MAX_LEN = 255;

    /**
     * @var string
     */
    private $value;

    /**
     * Argument constructor
     *
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = substr($value, 0, self::MAX_LEN);
    }

    /**
     * @inheritdoc
     */
    function __toString()
    {
        return (string) escapeshellarg($this->value);
    }
}
