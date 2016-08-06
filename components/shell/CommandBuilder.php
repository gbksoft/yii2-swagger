<?php
/**
 * Copyright © 2016 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
namespace gbksoft\modules\swagger\components\shell;

use gbksoft\modules\swagger\components\shell\Command\Argument;
use gbksoft\modules\swagger\components\shell\Command\Flag;
use gbksoft\modules\swagger\components\shell\Command\Option;

/**
 * Class CommandBuilder
 */
class CommandBuilder
{
    /**
     * @var string
     */
    private $command;

    /**
     * @var string[]
     */
    private $arguments = [];

    /**
     * @param Command $command
     * @return $this
     */
    public function setCommand(Command $command)
    {
        $this->command = sprintf('%s', $command);

        return $this;
    }

    /**
     * @param Argument $argument
     * @return $this
     */
    public function addArgument(Argument $argument)
    {
        $this->arguments[] = sprintf('%s', $argument);

        return $this;
    }

    /**
     * @param Flag $flag
     * @return $this
     */
    public function addFlag(Flag $flag)
    {
        $flag = sprintf('%s', $flag);
        $this->arguments[sprintf('%x', crc32($flag))] = $flag;

        return $this;
    }

    /**
     * @param Option $option
     * @return $this
     */
    public function addOption(Option $option)
    {
        $option = sprintf('%s', $option);
        $this->arguments[sprintf('%x', crc32($option))] = $option;

        return $this;
    }

    /**
     * @return string
     */
    public function build()
    {
        try {
            $this->assertCommand();

            $arguments = trim(implode(' ', $this->arguments));

            return escapeshellcmd(
                sprintf(
                    '%s%s',
                    $this->command,
                    empty($arguments) ? '' : ' ' . $arguments
                )
            );
        } finally {
            $this->dispose();
        }
    }

    /**
     * Assert command value
     */
    private function assertCommand()
    {
        if (empty($this->command)) {
            throw new \InvalidArgumentException('You need to add a command to execute.');
        }
    }

    /**
     * Clear shell command data
     */
    private function dispose()
    {
        $this->command = '';
        $this->arguments = [];
    }
}
