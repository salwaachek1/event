<?php
class Participation {
public $fee;	
public $employee;
public $event;
function Insert($data,$employee_id,$event_id){
	    $connection = database::OpenConnection(); // connection to database
	    $sql = "SELECT id from participation where id =:id"; // check if there's a participation  with the same ID in database
		$stmt = $connection->prepare($sql);
		$stmt->bindParam(":id",$data["participation_id"]);
		$stmt->execute();
	if($stmt->rowCount() == 0){ // if participation doesn't exist in database -> creating a new row 
		$sql = "INSERT INTO participation(id,fee,employee_id,event_id) VALUES(?,?,?,?)";
		$stmt= $connection->prepare($sql);
		$stmt->execute([$data["participation_id"],$data["participation_fee"],$employee_id,$data["event_id"],]);	
		return $data["participation_id"]; 
	}
	else{
		$result = $stmt -> fetch();
		$id=$result["id"];
		return $id;
	}
}
}
?>