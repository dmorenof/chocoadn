<?php

namespace ChocoDNA;

use InvalidArgumentException;

class CRISPR
{
    /* @var File[] */
    public static array $files = [];

    public static function parseFile($input): void
    {
        while ($line = fgets($input)) {
            [$name, $num_additions] = explode(' ', trim($line));

            if (!is_string($name) || !is_numeric($num_additions)) {
                throw new InvalidArgumentException('file format error on ' . $line);
            }

            $changes = [];

            for ($i = 1; $i <= (int)$num_additions; $i++) {
                [$position, $byte] = explode(' ', trim(fgets($input)));

                if (!is_numeric($position) || !is_numeric($byte)) {
                    throw new InvalidArgumentException('file format error near ' . $line);
                }

                $changes[] = new Change((int)$position, chr((int)$byte));;
            }

            self::$files[] = new File($name, $changes);
        }
    }

    public static function executeChanges(): void
    {
        foreach (self::$files as $File) {
            $File->applyChanges();
        }
    }
}