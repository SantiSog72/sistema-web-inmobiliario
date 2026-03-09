<?php
/*
	generar aleatorios reales (random reales)
	generar aleaotiorios decimales (random decimales)
	
	mt_rand () genera un entero aleatorio sin maximos ni minimos
	mt_getrandmax () retorna el valor maximo que "mt_rand ()" puede generar
*/
class Genera_randoms {
	
	public static function aleatorio_real ($min, $max){
		if ($min >= $max) {
            throw new InvalidArgumentException('El mínimo debe ser menor que el máximo.');
        }
	
		return $min + mt_rand() / mt_getrandmax() * ($max - $min);
	}
	
	public static function aleatorio_decimal ($precision = 4) {
	
		if ($precision < 0) {
				throw new InvalidArgumentException('La precisión debe ser un número entero positivo.');
			}
		$factor = pow(10, $precision);
		return mt_rand(0, $factor - 1) / $factor;
	}

}
?>