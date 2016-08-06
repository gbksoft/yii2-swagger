<?php
/**
 * Copyright © 2016 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
namespace tests\components\shell\Command;

use gbksoft\modules\swagger\components\shell\Command\Flag;

/**
 * Class FlagTest
 */
class FlagTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $expected
     * @param $flagString
     *
     * @dataProvider dataProviderForTestSuccess
     */
    public function testSuccess($expected, $flagString)
    {
        $flag = new Flag($flagString);

        self::assertEquals($expected, (string) $flag);
    }

    /**
     * @param string $flagString
     *
     * @dataProvider dataProviderForTestFailed
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Name of flag must comply with the mask "--?[\w]{0,}".
     */
    public function testFailed($flagString)
    {
        new Flag($flagString);
    }

    public function testCheckLen()
    {
        $command = new Flag('-' . str_repeat('a', Flag::MAX_LEN + 35));

        self::assertEquals(Flag::MAX_LEN, strlen((string) $command));
    }

    /**
     * @return array
     */
    public function dataProviderForTestFailed()
    {
        return include __DIR__ . '/../_data/flag/failed/flags.php';
    }

    /**
     * @return array
     */
    public function dataProviderForTestSuccess()
    {
        return include __DIR__ . '/../_data/flag/success/flags.php';
    }
}
