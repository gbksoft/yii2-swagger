<?php
/**
 * Copyright © 2016 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */

return [
    [
        'expected' => './composer.phar',
        'commandString' => './composer.phar',
    ],
    [
        'expected' => 'composer.phar',
        'commandString' => 'composer.phar',
    ],
    [
        'expected' => 'composer',
        'commandString' => 'composer',
    ],
    [
        'expected' => 'ls',
        'commandString' => 'ls',
    ],
    [
        'expected' => './test/path/command',
        'commandString' => './test/path/command',
    ],
    [
        'expected' => '/test/path/command',
        'commandString' => '/test/path/command',
    ],
    [
        'expected' => '/test_path_command',
        'commandString' => '/test_path_command',
    ],
    [
        'expected' => '/test-path-command',
        'commandString' => '/test-path-command',
    ],
    [
        'expected' => '/testPathCommand',
        'commandString' => '/testPathCommand',
    ],
    [
        'expected' => 'test/path/command',
        'commandString' => 'test/path/command',
    ],
    [
        'expected' => 'test_path_command',
        'commandString' => 'test_path_command',
    ],
    [
        'expected' => 'test-path-command',
        'commandString' => 'test-path-command',
    ],
    [
        'expected' => 'testPathCommand',
        'commandString' => 'testPathCommand',
    ],
];
