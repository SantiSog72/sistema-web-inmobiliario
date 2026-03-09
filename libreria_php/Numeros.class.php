<?php
class Numeros{
	public static function es_par ($numero){
		return $numero % 2 === 0;		
	}
	
	public static function es_impar ($numero){
		return $numero % 2 !== 0;
	}
	
	public static function es_primo ($numero){
		if ($numero <= 1) return false;
        if ($numero === 2) return true;
        if ($numero % 2 === 0) return false;
        for ($i = 3; $i <= sqrt($numero); $i += 2) {
            if ($numero % $i === 0) return false;
        }
        return true;
	}
	
	
}
?>