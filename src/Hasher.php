<?php

namespace ChocoDNA;

trait Hasher
{
    public static function hash(string $input):string
    {
        return hash('crc32b', $input);
    }
}