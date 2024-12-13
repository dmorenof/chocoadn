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
  processor <path-to-input.txt>
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
Ejemplo de un resultado:

```txt
ChocoboRojo 1: 1b0ecf0b
ChocoboRojo 2: bb72fe58
ChocoboAmarillo 1: 5cfdd966
ChocoboAmarillo 2: 45a6b9d3
```