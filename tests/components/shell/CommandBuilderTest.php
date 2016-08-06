<?php
/**
 * Copyright © 2016 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
namespace tests\components\shell;

use gbksoft\modules\swagger\components\shell\Command;
use gbksoft\modules\swagger\components\shell\Command\Argument;
use gbksoft\modules\swagger\components\shell\Command\Flag;
use gbksoft\modules\swagger\components\shell\Command\Option;
use gbksoft\modules\swagger\components\shell\CommandBuilder;

/**
 * Class CommandBuilderTest
 */
class CommandBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testCommandWithArgumentFlagSuccess()
    {
        $path = 'path/to/any/directory/with/file.tes';
        $builder = new CommandBuilder();

        $cmd = $builder->setCommand(new Command('git'))
            ->addArgument(new Argument('log'))
            ->addFlag(new Flag('--color'))
            ->addFlag(new Flag('-p'))
            ->addFlag(new Flag('-1'))
            ->addArgument(new Argument('db3b7f6f645'))
            ->addFlag(new Flag('--'))
            ->addArgument(new Argument('./' . basename($path)))
            ->build();

        self::assertEquals("git 'log' --color -p -1 'db3b7f6f645' -- './file.tes'", $cmd);
    }

    public function testCommandWithArgumentFlagOptionSuccess()
    {
        $path = 'path/to/any/directory/with/file.tes';
        $format = '#%h#-%ad-~%s~*%b*';
        $builder = new CommandBuilder();

        $cmd = $builder->setCommand(new Command('git'))
            ->addArgument(new Argument('log'))
            ->addFlag(new Flag('--color'))
            ->addOption(new Option('--pretty', 'format:' . $format))
            ->addFlag(new Flag('--no-merges'))
            ->addFlag(new Flag('-10'))
            ->addFlag(new Flag('--'))
            ->addArgument(new Argument('./' . basename($path)))
            ->build();

        self::assertEquals(
            "git 'log' --color --pretty='format:\#%h\#-%ad-\~%s\~\*%b\*' --no-merges -10 -- './file.tes'",
            $cmd
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Name of flag must comply with the mask "[/.\w-]+".
     */
    public function testCommandWithInjectionInCommand()
    {
        $builder = new CommandBuilder();

        $cmd = $builder->setCommand(new Command('git; rm -rf /etc'))
            ->addArgument(new Argument('log'))
            ->addFlag(new Flag('--color'))
            ->addOption(new Option('--pretty', 'format:%ad'))
            ->addFlag(new Flag('--no-merges'))
            ->addFlag(new Flag('-10'))
            ->addFlag(new Flag('--'))
            ->addArgument(new Argument('./'))
            ->build();
    }

    public function testCommandWithInjectionInArgument()
    {
        $path = 'path/to/any/directory/with/file.tes';
        $builder = new CommandBuilder();

        $cmd = $builder->setCommand(new Command('git'))
            ->addArgument(new Argument('log'))
            ->addFlag(new Flag('--color'))
            ->addFlag(new Flag('-p'))
            ->addFlag(new Flag('-1'))
            ->addArgument(new Argument('db3b7f6f645; rm -rf /etc'))
            ->addFlag(new Flag('--'))
            ->addArgument(new Argument('./' . basename($path)))
            ->build();

        self::assertEquals(
            "git 'log' --color -p -1 'db3b7f6f645\; rm -rf /etc' -- './file.tes'",
            $cmd
        );
    }
}
