<?php
/**
 * Copyright © 2016 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
namespace gbksoft\modules\swagger\components\shell;

/**
 * Class Command
 */
class Command extends AbstractInput
{
    const MAX_LEN = 255;

    const OPTION_NAME_PATTERN = '{^[\/\.\w-]+$}i';

    /**
     * @var string
     */
    private $name;

    /**
     * Command constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = substr($name, 0, self::MAX_LEN);
        $this->assertName();
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return (string) escapeshellcmd($this->name);
    }

    /**
     * Assert flag name
     */
    private function assertName()
    {
        if (!preg_match(self::OPTION_NAME_PATTERN, $this->name)) {
            throw new \InvalidArgumentException('Name of flag must comply with the mask "[/.\w-]+".');
        }
    }
}
