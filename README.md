Clase de Verificación y Normalización de Datos
Esta clase contiene funciones para verificar y normalizar diversos tipos de datos en un solo paso. Cada función recibe parámetros para realizar validaciones y retorna el valor normalizado si pasa las pruebas, o false en caso contrario. A continuación, se detalla cada función:

int($value, $min, $max)
Descripción: Verifica si el valor recibido puede ser convertido a un número entero. Permite la validación opcional de un valor mínimo y máximo.
Parámetros:
int $value - Valor a verificar.
int $min - Valor mínimo permitido (opcional).
int $max - Valor máximo permitido (opcional).
Retorno: El valor convertido a entero si pasa la validación, o false en caso contrario.

float($value, $min, $max)
Descripción: Verifica si el valor recibido puede ser convertido a un número flotante. También admite la validación de límites mínimos y máximos.
Parámetros:
float $value - Valor a verificar.
float $min - Valor mínimo permitido (opcional).
float $max - Valor máximo permitido (opcional).
Retorno: El valor convertido a flotante si pasa la validación, o false en caso contrario.

string($value, $matchLen, $min, $max)
Descripción: Verifica si el valor recibido puede ser un string válido. Permite la validación de la longitud exacta, mínima o máxima del string.
Parámetros:
string $value - Valor a verificar.
int|null $matchLen - Longitud exacta que debe tener el string (opcional).
int|null $min - Longitud mínima permitida (opcional).
int|null $max - Longitud máxima permitida (opcional).
Retorno: true si el string cumple con las condiciones, o false en caso contrario.

string_trim($value, $matchLen, $min, $max)
Descripción: Verifica si el valor recibido puede ser un string válido, aplicando además la función trim para eliminar espacios en blanco adicionales. También permite validar la longitud mínima, máxima o exacta.
Parámetros:
string $value - Valor a verificar.
int|null $matchLen - Longitud exacta que debe tener el string (opcional).
int|null $min - Longitud mínima permitida (opcional).
int|null $max - Longitud máxima permitida (opcional).
Retorno: true si el string cumple con las condiciones, o false en caso contrario.

email($mail, $domain)
Descripción: Verifica si el valor recibido es un correo electrónico válido. Opcionalmente, se puede verificar que el dominio del correo sea el correcto.
Parámetros:
string $mail - Correo electrónico a verificar.
string|null $domain - Dominio que debe tener el correo (opcional).
Retorno: true si es un correo válido, o false en caso contrario.

fecha($value)
Descripción: Verifica si el valor recibido es una fecha válida en varios formatos. Retorna la fecha en formato YYYY-MM-DD si es válida, o false en caso contrario.
Parámetros:
string $value - Fecha a verificar.
Retorno: La fecha en formato YYYY-MM-DD si es válida, o false en caso contrario.
