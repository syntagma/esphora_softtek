<?php
$__connection = null;

class ConnectionSingleton {
	public function getConnection($dsn) {
		if ($__connection == null) {
			$__connection = MDB2::connect($dsn);
		}
		return $__connection;
	}
}
