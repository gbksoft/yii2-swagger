<?php
/**
 * Copyright © 2016 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
namespace gbksoft\modules\swagger\components\shell\Command;

use gbksoft\modules\swagger\components\shell\AbstractInput;

/**
 * Class Flag
 */
class Flag extends AbstractInput
{
    const MAX_LEN = 32;

    const FLAG_NAME_PATTERN = '{^(--?[\w-]{0,})$}i';

    /**
     * @var string
     */
    private $name;

    /**
     * Flag constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = substr($name, 0, self::MAX_LEN);
        $this->assertName();
    }

    /**
     * @return string
     */
    function __toString()
    {
        return (string) $this->name;
    }

    /**
     * Assert flag name
     */
    private function assertName()
    {
        if (!preg_match(self::FLAG_NAME_PATTERN, $this->name)) {
            throw new \InvalidArgumentException('Name of flag must comply with the mask "--?[\w]{0,}".');
        }
    }
}
