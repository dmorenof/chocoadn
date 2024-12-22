# Chocobo DNA generator

## Instalación

1. Asegúrate de que tienes instalados en tu entorno:
    - php >= 8
    - composer

2. Clona este repositorio en tu máquina local:

```bash
   git clone https://github.com/dmorenof/chocoadn.git
   cd chocoadn
```

3. Instala composer para activar autoload:

```bash
   composer install
```

## Uso

Ejecuta processor con el siguiente comando:

```bash
  php index.php < input.txt > output.txt
```

### Ejemplo de uso básico

Ejemplo de un archivo input:
```txt
ChocoboRojo 2
0 115
0 102
ChocoboAmarillo 2
2 98
4 50
```
Resultado:
```txt
ChocoboRojo 0: 00000000
ChocoboRojo 1: 1b0ecf0b
ChocoboRojo 2: bb72fe58
ChocoboAmarillo 0: 00000000
ChocoboAmarillo 1: 5cfdd966
ChocoboAmarillo 2: 45a6b9d3
```
Otro ejemplo de un archivo input:
```txt
ChocoboRojo 2
0 224
0 192
ChocoboAzul 4
1 227
2 232
2 46
0 169
```
Resultado:
```txt
ChocoboRojo 0: 00000000
ChocoboRojo 1: 72080df5
ChocoboRojo 2: 2a2927c9
ChocoboAzul 0: 00000000
ChocoboAzul 1: 78daa13d
ChocoboAzul 2: 24c31377
ChocoboAzul 3: 2f36d283
ChocoboAzul 4: b5670765
```