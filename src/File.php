<?php

namespace ChocoDNA;

use HashContext;

class File
{
    public string $name;
    /* @var Change[] */
    public array $changes;
    public int $current_length = 0;
    private ?HashContext $hash;

    public function __construct(string $name, array $changes)
    {
        $this->name = $name;
        $this->changes = $changes;
    }

    public function applyChanges(): void
    {
        echo $this->name . ' 0: 00000000' . PHP_EOL;

        /* @var Change[] $appliedChanges */
        $appliedChanges = [];

        foreach ($this->changes as $index => $Change) {
            $this->hash = hash_init('crc32b');
            $this->current_length = 0;
            $pushes = 0;

            array_unshift($appliedChanges, $Change);
            array_multisort(array_column($appliedChanges, 'position'), $appliedChanges);

            foreach ($appliedChanges as $appliedChange) {
                $current_position = $appliedChange->position + $pushes;

                if ($current_position <= $this->current_length) {
                    $pushes++;
                } else {
                    $this->refillWithZeros($current_position);
                }

                hash_update($this->hash, $appliedChange->byte);
                $this->current_length++;
            }

            echo $this->name . ' ' . $index + 1 . ': ' . hash_final($this->hash) . PHP_EOL;
        }
    }

    /**
     * @param int $position
     * @return void
     */
    private function refillWithZeros(int $position): void
    {
        $padding = $position - $this->current_length;

        if ($padding > 0) {
            // Bloques de 8MB
            $block_size = 8 * 1024;

            while ($padding > 0) {
                $chunk = min($padding, $block_size);
                hash_update($this->hash, str_repeat(chr(0), $chunk));
                $padding -= $chunk;
            }

            $this->current_length += $position - $this->current_length;
        }
    }
}