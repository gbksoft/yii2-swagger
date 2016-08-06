<?php
/**
 * Copyright © 2016 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
namespace tests\cpmponents\shell;

use gbksoft\modules\swagger\components\shell\Command;

/**
 * Class CommandTest
 */
class CommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $expected
     * @param string $commandString
     *
     * @dataProvider dataProviderForTestSuccess
     */
    public function testSuccess($expected, $commandString)
    {
        $command = new Command($commandString);

        self::assertEquals($expected, (string) $command);
    }

    /**
     * @param string $commandString
     *
     * @dataProvider dataProviderForTestFailed
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Name of flag must comply with the mask "[/.\w-]+".
     */
    public function testFailed($commandString)
    {
        new Command($commandString);
    }

    public function testCheckLen()
    {
        $command = new Command(str_repeat('a', Command::MAX_LEN + 35));

        self::assertEquals(Command::MAX_LEN, strlen((string) $command));
    }

    /**
     * @return array
     */
    public function dataProviderForTestFailed()
    {
        return include __DIR__ . '/_data/command/failed/commands.php';
    }

    /**
     * @return array
     */
    public function dataProviderForTestSuccess()
    {
        return include __DIR__ . '/_data/command/success/commands.php';
    }
}
