<?php

namespace ChocoDNA;

use Exception;

class Generator
{
    use Hasher;

    private static array $output = [];

    /**
     * @throws Exception
     */
    public static function generate(string $input): string
    {
        $lines = explode("\n", $input); // Dividimos el input en líneas.
        $i = 0;

        while ($i < count($lines)) {
            // Leer el archivo y el número de modificaciones.
            [$file_name, $additions] = self::getHeader($lines[$i]);

            $file = []; // Inicializamos el "archivo" como un array vacío.
            // self::addOutput($file_name, 0, self::hash("")); // CRC inicial para el archivo vacío.

            for ($change_number = 1; $change_number <= (int)$additions; $change_number++) {
                $i++;
                self::processChange($lines[$i], $file, $file_name, $change_number);
            }

            $i++;
        }

        // Imprimir la salida.
        return implode("\n", self::$output);
    }

    /**
     * @param string $line
     * @return array
     * @throws Exception
     */
    private static function getHeader(string $line): array
    {
        $header = explode(" ", trim($line));

        if (count($header) !== 2) {
            throw new Exception("Invalid header, expected 2 values");
        }

        if (!is_string($header[0])) {
            throw new Exception("Invalid header, expected string value");
        }

        if ($header[0] === '') {
            throw new Exception("Invalid header, file name cannot be empty");
        }

        if (!is_numeric($header[1])) {
            throw new Exception("Invalid header, expected numeric value");
        }

        $file_name = $header[0];
        $additions = (int)$header[1];

        echo "File name: $file_name" . PHP_EOL;
        echo "Additions: $additions" . PHP_EOL;

        if ($additions < 1 || $additions > 64) {
            throw new Exception("Invalid number of additions, the allowed range is 1-64");
        }

        return [$file_name, $additions];
    }

    /**
     * @param string $line
     * @param array $file
     * @param string $file_name
     * @param int $change_number
     * @return void
     * @throws Exception
     */
    private static function processChange(string $line, array &$file, string $file_name, int $change_number): void
    {
        [$position, $byte] = self::getChanges($line);

        $hash = self::changeDNA($position, $byte, $file);

        // Formateamos la salida.
        self::addOutput($file_name, $change_number, $hash);
        echo json_encode($file) . PHP_EOL;
    }

    /**
     * @param string $line
     * @return array
     * @throws Exception
     */
    private static function getChanges(string $line): array
    {
        $changes = explode(" ", $line);

        if (count($changes) !== 2) {
            throw new Exception("Invalid line, expected 2 values");
        }

        if (!is_numeric($changes[0]) || !is_numeric($changes[1])) {
            throw new Exception("Invalid line, expected numeric values");
        }

        $position = $changes[0];
        $byte = $changes[1];

        echo "Position: $position" . PHP_EOL;
        echo "Byte: $byte" . PHP_EOL;

        return [$position, $byte];
    }

    /**
     * @param int $position
     * @param int $byte
     * @param array $file
     * @return string
     * @throws Exception
     */
    private static function changeDNA(int $position, int $byte, array &$file): string
    {
        if ($position < 0) {
            throw new Exception("Invalid position, has to be greater than 0");
        }

        // if ($position > count($file)) {
        //     throw new Exception("Invalid position, position is greater than the file size");
        // }

        if ($byte < 0 || $byte > 255) {
            throw new Exception("Invalid byte, the allowed range is 0-255");
        }

        // Insertar el byte en el archivo a la posición deseada.
        // Si la posición está más allá del tamaño actual, rellenamos con ceros.
        self::refill($file, $position);

        // Insertar el byte en la posición, desplazando si es necesario.
        self::insertByte($file, $position, $byte);

        // Convertimos el archivo en una cadena de bytes para calcular el CRC32.
        $file_string = implode('', array_map("chr", $file));
        return self::hash($file_string);
    }

    /**
     * @param array $file
     * @param int $position
     */
    private static function refill(array &$file, int $position): void
    {
        while (count($file) < $position) {
            $file[] = 0;
        }
    }

    /**
     * @param array $file
     * @param int $position
     * @param int $byte
     * @return void
     */
    private static function insertByte(array &$file, int $position, int $byte): void
    {
        array_splice($file, $position, 0, $byte);
    }

    /**
     * @param string $file_name
     * @param int $change_number
     * @param string $hash
     * @return void
     */
    private static function addOutput(string $file_name, int $change_number, string $hash): void
    {
        self::$output[] = "$file_name $change_number: $hash";
    }
}