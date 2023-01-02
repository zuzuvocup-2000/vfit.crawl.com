<?php
 
namespace App\Libraries;


/**
* Author: https://roytuts.com
*/
 
class MongoDB {
             
	private $conn;

	function __construct() {
		$host = VFIT_HOST;
		$port = VFIT_PORT;
		$username = VFIT_USER;
		$password = VFIT_PASS;
		$authRequired = VFIT_AUTH_REQUIRED;

		try {
			if($authRequired === true) {
				$this->conn = new \MongoDB\Driver\Manager('mongodb://' . $username . ':' . $password . '@' . $host. ':' . $port);
			} else {
				$this->conn = new \MongoDB\Driver\Manager('mongodb://' . $host. ':' . $port);
			}
		} catch(MongoDB\Driver\Exception\MongoConnectionException $ex) {
			show_error('Couldn\'t connect to mongodb: ' . $ex->getMessage(), 500);
		}
	}

	function getConn() {
		return $this->conn;
	}
             
}