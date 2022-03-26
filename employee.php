<?php
class Employee {
public $name;
public $email;	
function Insert($data){
	    $connection = database::OpenConnection(); // connection to database
	    $sql = "SELECT id from employee where name =:name"; // check if there's an employee with the same name in database
		$stmt = $connection->prepare($sql);
		$stmt->bindParam(":name",$data["employee_name"]);
		$stmt->execute();

	if($stmt->rowCount() == 0){ // if employee doesn't exist in database -> creating a new row  
		$sql = "INSERT INTO employee(name,email) VALUES(?,?)";
		$stmt= $connection->prepare($sql);
		$stmt->execute([$data["employee_name"],$data["employee_mail"]]);	
		$last_employee_id = $connection->lastInsertId();
		return $last_employee_id; // returning ID to use it in the participation table
	}
	else{ // if employee does exist in database -> getting ID to use it in the participation table
	$result = $stmt -> fetch();
		$id=$result["id"];
		return $id;
	}
}

}	
?>