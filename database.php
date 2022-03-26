<?php
Class DataBase{
static $username='root';
static $password='';
static $database_name="event_booking";
public static function OpenConnection()
    {	 
	  try{		  
	  $connection = new PDO("mysql:host=".$_SERVER['SERVER_NAME'].";dbname=".self::$database_name."", self::$username, self::$password);  
	  // set the PDO error mode to exception
	  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	   	
        return $connection;
	  }
	  catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
    }	
}	

?>




