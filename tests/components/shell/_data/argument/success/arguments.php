<?php
/**
 * Copyright © 2016 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */

return [
    [
        'expected' => "'argument'",
        'argumentString' => 'argument',
    ],
    [
        'expected' => "'/path/to/custom/dir ; git log'",
        'argumentString' => '/path/to/custom/dir ; git log',
    ],
    [
        'expected' => "'/path/to/custom/dir '\\''; git log'",
        'argumentString' => "/path/to/custom/dir '; git log",
    ],
    [
        'expected' => "'/path/to/custom/dir '\''\"\${sss}\"'\''; git log'",
        'argumentString' => '/path/to/custom/dir \'"${sss}"\'; git log',
    ],
];
