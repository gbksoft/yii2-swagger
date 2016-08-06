<?php
/**
 * Copyright © 2016 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
namespace tests\components\shell\Command;

use gbksoft\modules\swagger\components\shell\Command\Argument;

/**
 * Class ArgumentTest
 */
class ArgumentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $expected
     * @param $argumentString
     *
     * @dataProvider dataProviderForTestSuccess
     */
    public function testSuccess($expected, $argumentString)
    {
        $argument = new Argument($argumentString);

        self::assertEquals($expected, (string) $argument);
    }

    public function testCheckLen()
    {
        $command = new Argument(str_repeat('a', Argument::MAX_LEN + 35));

        self::assertEquals(Argument::MAX_LEN + 2, strlen((string) $command));
    }

    /**
     * @return array
     */
    public function dataProviderForTestSuccess()
    {
        return include __DIR__ . '/../_data/argument/success/arguments.php';
    }
}
