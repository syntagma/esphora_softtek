<?php

class Translator {
	public function getTrans($key, $default = null) {
		if ($default == null) $default = $key;
		
		if (isset($_SESSION['idioma'])) {
			$arrIdioma = $_SESSION['idioma'];
			if (!isset($arrIdioma[$key])) { 
				$arrGlobal = parse_ini_file('ui/translator/'.GLOBAL_I10N.'/translator.cfg', false);
				if(!isset($arrGlobal[$key])) {
					return $default;
				}
				$arrIdioma[$key] = $arrGlobal[$key];
				$_SESSION['idioma'] = $arrIdioma;
			} 
		}
		else {
			$arrGlobal = parse_ini_file('ui/translator/'.GLOBAL_I10N.'/translator.cfg', false);
			$arrIdioma = array();
			if(!isset($arrGlobal[$key])) {
				return $default;
			}
			$arrIdioma[$key] = $arrGlobal[$key];
			$_SESSION['idioma'] = $arrIdioma;
		}
		
		return $arrIdioma[$key];
	}
}

?>