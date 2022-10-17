<?php

namespace Language\File;


abstract class FileType
{
    const TYPE_PHP = 'php';
    const TYPE_RAW = 'raw';
    const TYPE_XML = 'xml';

    const EXT_PHP = 'php';
    const EXT_RAW = '';
    const EXT_XML = 'xml';

    const EXTENSIONS = [
        self::TYPE_PHP => self::EXT_PHP,
        self::TYPE_XML => self::EXT_XML,
        self::TYPE_RAW => self::EXT_RAW
    ];
}
