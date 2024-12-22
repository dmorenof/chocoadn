<?php

namespace ChocoDNA;

class Change
{
    public int $position;
    public string $byte;

    public function __construct(int $position, string $byte)
    {
        $this->position = $position;
        $this->byte = $byte;
    }
}