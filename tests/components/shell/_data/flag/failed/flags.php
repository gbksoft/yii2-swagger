<?php
/**
 * Copyright © 2016 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */

return [
    [
        'flagString' => 'test'
    ],
    [
        'flagString' => '789'
    ],
    [
        'flagString' => '--test ; cat /etc/passwd'
    ],
    [
        'flagString' => '-- ; cat /etc/passwd'
    ],
    [
        'flagString' => ' ; cat /etc/passwd'
    ],
    [
        'flagString' => 'cat /etc/passwd'
    ],
    [
        'flagString' => '"${test}";cat /etc/passwd'
    ]
];
