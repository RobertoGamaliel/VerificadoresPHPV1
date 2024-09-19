<?php
/**
 * Clase que contiene funciones para verificar y normalizar datos en un solo paso
 */
class Verifiers{

    /**
     * Revisa si un valor recibido contiene datos para generar un entero, admite la rcepción de verificación de maximos y minumos, retorna el valor convertido en caso de pasar el test
     * o false en caso de que no
     * @param int $value valor a verificar
     * @param int $min valor minimo que puede tener, se compara que el valor sea mayor o igual a este
     * @param int $max valor maximo que puede tener, se compara que el valor sea menor o igual a este
     * @return int|false retorna el valor convertido a entero en caso de pasar la verificación o false en caso de no
     */
    public function int($value = null, $min = null, $max = null) {
        if(!isset($value) || !is_numeric($value)) return false;
        $conversion = intval($value);
        if(($min && $conversion < $min) || ($max && $conversion > $max)) return false;
        return $conversion;
    }

    /**
         * Revisa si un valor recibido contiene datos para generar un flotante, admite la rcepción de verificación de maximos y minumos, retorna el valor convertido en caso de pasar el test
         * o false en caso de que no
         * @param float $value valor a verificar
         * @param float $min valor minimo que puede tener, se compara que el valor sea mayor o igual a este
         * @param float $max valor maximo que puede tener, se compara que el valor sea menor o igual a este
         * @return float|false retorna el valor convertido a flotante en caso de pasar la verificación o false en caso de no
     */
    public function float($value = null, $min = null, $max = null) {
        if(!isset($value) || !is_numeric($value)) return false;
        $conversion = floatval($value);
        if(($min && $conversion < $min) || ($max && $conversion > $max)) return false;
        return $conversion;
    }
    
    /**
        * Revisa si un valor recibido contiene datos para generar un string, admite la rcepción de verificación de longitud, minimo y maximo, retorna true en caso de pasar el test
        * o false en caso de no
        * @param string $value valor a verificar
        * @param int | null $matchLen longitud que debe tener el string
        * @param int | null $min longitud minima que puede tener el string
        * @param int | null $max longitud maxima que puede tener el string
    */
    public function string($value, $min = null, $max = null) {
        if(!is_string($value)) return false;
        $strLen = strlen($value);
        if(($min && $strLen < $min) || ($max && $strLen > $max)) return false;
        return $value; 
    }

    /**
        * Revisa si un valor recibido contiene datos para generar un string, adicionalmente aplica la función trim para eliminar espacios adicionales admite la rcepción de verificación de longitud, minimo y maximo, retorna true en caso de pasar el test
        * o false en caso de no
        * @param string $value valor a verificar
        * @param int | null $matchLen longitud que debe tener el string
        * @param int | null $min longitud minima que puede tener el string
        * @param int | null $max longitud maxima que puede tener el string
    */
    public function string_trim($value, $min = null, $max = null) {
        if(!is_string($value)) return false;
        $verified = preg_replace('/\s+/', ' ', trim($value));
        return $this->string($verified, $min, $max); 
    }

    /**
     * Normaliza un valor recibido, elimnando espacioa adicionales, acentos, commas, y dejando sus equivalentes en alfanumericos simples
     * @param string $value valor a normalizar
     * @param bool $uppercase si se desea que el valor resultante sea en mayusculas
     * @return string retorna el valor normalizado, si no se puede normalizar retorna un string vacio
     */
    public function string_normalice($value, $uppercase = false) {
        if(!$verified = $this->string_trim($value)) return "";
        $map = array(
            'á' => 'a', 'Á' => 'A',
            'é' => 'e', 'É' => 'E',
            'í' => 'i', 'Í' => 'I',
            'ó' => 'o', 'Ó' => 'O',
            'ú' => 'u', 'Ú' => 'U',
            'ñ' => 'n', 'Ñ' => 'N',
            'ä' => 'a', 'Ä' => 'A',
            'ë' => 'e', 'Ë' => 'E',
            'ï' => 'i', 'Ï' => 'I',
            'ö' => 'o', 'Ö' => 'O',
            'ü' => 'u', 'Ü' => 'U',
            'ç' => 'c', 'Ç' => 'C',
            'ß' => 'ss',
            // Añade más reemplazos según sea necesario
        );
    
        // Reemplazar caracteres acentuados y especiales
        $verified = strtr($verified, $map);
    
        // Eliminar caracteres no permitidos (excepto letras, números, guiones y espacios)
        $verified = preg_replace('/[^a-zA-Z0-9\- :]/', '', $verified);
    
        // Convertir a minúsculas o minusculas segun se requiera
        $verified = $uppercase? strtoupper($verified) : strtolower($verified);
        return $verified;
    }

    /**
     * Verifica si un valor recibido es un correo electronico, adicionalmente se puede verificar si el dominio del correo es el correcto
     * @param string $mail correo electronico a verificar
     * @param string | null $domain dominio que debe tener el correo
     */
    public function email($mail, $domain = null){
        if (!$verified = $this->string($mail, 1, 400)) return false;

        if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $verified)) return false;
    
        if ($domain) {
            if (($index = strpos($verified, '@')) === false) return false;
            if (substr($verified, $index + 1) !== $domain) return false;
        }
    
        return true; 
    }

    /**
     * Verifica si un valor recibido es una fecha, admite diferentes formatos de fecha, y retorna la fecha en formato YYYY-MM-DD si es correcta, o false si no
     * @param string $value fecha a verificar
     * @return string|false retorna la fecha en formato YYYY-MM-DD si es correcta, o false si no
     */
    public function fecha($value) {
        $date = $this->string_normalice($value, true);
        $map = array(
            'ENERO' => '01', 
            'FEBRERO' => '02',
            'MARZO' => '03', 
            'ABRIL' => '04',
            'MAYO' => '05', 
            'JUNIO' => '06',
            'JULIO' => '07', 
            'AGOSTO' => '08',
            'SEPTIEMBRE' => '09', 
            'OCTUBE' => '10', 
            'NOVIEMBRE' => '11',
            'DICIEMBRE' => '12',
            'JANUARY' => '01',
            'FEBRUARY' => '02',
            'MARCH' => '03',
            'APRIL' => '04',
            'MAY' => '05',
            'JUNE' => '06',
            'JULY' => '07',
            'AUGUST' => '08',
            'SEPTEMBER' => '09',
            'OCTOBER' => '10',
            'NOVEMBER' => '11',
            'DECEMBER' => '12'
        );
        
        //Si hay nombres de meses tratar de reemplazarlos con su equivalente en numero y espacios por guiones 
        $date = strtr($date, $map);

          // Detectar y reordenar fechas en formato "DD-MM-YYYY", "DD/MM/YYYY", "DD MM YYYY" y opcionalmente "HH:MM:SS"
        if (preg_match('/(\d{2})[-\/ ](\d{2})[-\/ ](\d{4})(?:\s+(\d{2}):(\d{2}):(\d{2}))?/', $date, $matches)) {
            $day = $matches[1];
            $month = $matches[2];
            $year = $matches[3];
            $date = "$year-$month-$day";
            if (isset($matches[4], $matches[5], $matches[6])) {
                $hour = $matches[4];
                $minute = $matches[5];
                $second = $matches[6];
                $date .= " $hour:$minute:$second";
            }
        }
         return $date;
         $len = strlen($date);
         if($len > 19 || $len <19) return false;
        // Verificar formato YYYY-MM-DD

        $dateOnly = \DateTime::createFromFormat('Y-m-d', $date);
        if ($dateOnly && $dateOnly->format('Y-m-d') === $date) {
            return $date;
        }
    
        // Verificar formato YYYY-MM-DD HH:MM:SS
        $dateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $date);
        if ($dateTime && $dateTime->format('Y-m-d H:i:s') === $date) {
            return $date;
        }
    
        return false;
    }
}