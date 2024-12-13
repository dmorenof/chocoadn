<?php

function procesarModificaciones($input) {
    $lines = explode("\n", $input); // Dividimos el input en líneas.
    $output = [];
    $i = 0;

    while ($i < count($lines)) {
        // Leer el archivo y el número de modificaciones.
        $header = $lines[$i];
        if (trim($header) === '') {
            $i++;
            continue;
        }

        list($nombreArchivo, $numAdiciones) = explode(" ", $header);
        $archivo = []; // Inicializamos el "archivo" como un array vacío.
        $output[] = "$nombreArchivo 0: " . hash('crc32b', "") . ""; // CRC inicial para el archivo vacío.

        for ($j = 1; $j <= (int)$numAdiciones; $j++) {
            $i++;
            list($pos, $byte) = explode(" ", $lines[$i]);

            // Insertar el byte en el archivo a la posición deseada.
            $pos = (int)$pos;
            $byte = (int)$byte;

            // Si la posición está más allá del tamaño actual, rellenamos con ceros.
            while (count($archivo) < $pos) {
                $archivo[] = 0;
            }

            // Insertar el byte en la posición, desplazando si es necesario.
            array_splice($archivo, $pos, 0, $byte);

            // Convertimos el archivo en una cadena de bytes para calcular el CRC32.
            $archivoStr = implode('', array_map("chr", $archivo));
            $crc32 = hash('crc32b', $archivoStr);

            // Formateamos la salida.
            $output[] = "$nombreArchivo $j: $crc32";
        }

        $i++;
    }

    // Imprimir la salida.
    return implode("\n", $output);
}

// Entrada de ejemplo.
$input = <<<EOL
ChocoboRojo 2
0 115
0 102
ChocoboAmarillo 2
2 98
4 50
EOL;

// Llamamos a la función y mostramos la salida.
echo procesarModificaciones($input);