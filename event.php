<?php
class Event {
public $name;
public $launching_date;	
function Insert($data){
	    $connection = database::OpenConnection(); // connection to database
	    $sql = "SELECT id FROM event WHERE id =:id"; // check if there's an event with the same ID in database
		$stmt = $connection->prepare($sql);
		$stmt->bindParam(":id",$data["event_id"]);
		$stmt->execute();
	if($stmt->rowCount() == 0){ // if event doesn't exist in database -> creating a new row 
		$sql = "INSERT INTO event(id,name,date) VALUES(?,?,?)";
		$stmt= $connection->prepare($sql);
		$stmt->execute([$data["event_id"],$data["event_name"],$data["event_date"]]);			
		return $data["event_id"];  // returning ID to uses it in the participation table
	}
	else{ // if event does exist in database -> getting ID to use it in the participation table		
		$result = $stmt -> fetch();
		$id=$result["id"];
		return $id;
	}
}
}
?>