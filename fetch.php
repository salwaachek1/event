<?php
require_once(__DIR__ . '/database.php');
$connection = database::OpenConnection();  // connection to database
$result_array = array();
$query_string=" ";
if(!empty($_POST['employee'])){  // check if the field that have the employee's name is not empty
	$emp="%".$_POST["employee"]."%";
$query_string.=" employee.name like :emp" ;  // create a string that contains the condition of the WHERE clause of the SQL STATEMENT
		if(!empty($_POST['event'])||!empty($_POST['date'])){
			$query_string.=" and " ;  // add an "AND" in case there's another condition (related to date and event name) to add in the WHERE clause of the SQL STATEMENT
		}
}
if(!empty($_POST['event'])){ // check if the field that have the event's name is not empty
$evt="%".$_POST["event"]."%";	
$query_string.=" event.name like :evt " ;	// create a string that contains the condition of the WHERE clause of the SQL STATEMENT
		if(!empty($_POST['date'])){
			$query_string.=" and event.date >= :date " ; // add another condition to the WHERE clause of the SQL STATEMENT in case the field date was set 
		} 
}
else{
	if(!empty($_POST['date'])){
		$query_string.=" event.date >= :date" ;
	}
}
		
$sql='SELECT
 employee.name as ep_n, event.name as ev_n , employee.email as ep_em, event.date as ev_d, participation.fee as part_f
FROM participation 
LEFT JOIN employee 
  ON participation.employee_id = employee.id
LEFT JOIN event
  ON event.id = participation.event_id WHERE '.$query_string;  
	

$stmt = $connection->prepare($sql);	
if((!empty($_POST['employee'])&&!empty($_POST['date']))&&!empty($_POST['event'])){
	$stmt->execute(array(':emp' => $emp, ':date' => $_POST['date'],':evt' => $evt));
	
}
else if(!empty($_POST['employee'])&&empty($_POST['date'])&&!empty($_POST['event'])){
	$stmt->execute(array(':emp' =>$emp,':evt' => $evt));
	
}
else if((!empty($_POST['employee'])&&empty($_POST['date']))&&empty($_POST['event'])){
	$stmt->execute(array(':emp' => $emp));	
}
else if(empty($_POST['employee'])&&empty($_POST['date'])&&!empty($_POST['event'])){
	$stmt->execute(array(':evt' => $evt));
	
}
else if(empty($_POST['employee'])&&!empty($_POST['date'])&&empty($_POST['event'])){
 $stmt->execute(array(':date' => $_POST['date']));	
}
while($row =$stmt->fetch(PDO::FETCH_ASSOC)){
    $employee_name = $row['ep_n'];	
	
	$employee_email = $row['ep_em'];
	$event_name = $row['ev_n'];
	$event_date = $row['ev_d'];
	$participation_fee = $row['part_f'];
    $result_array[] = array("employee_name" => $employee_name,"employee_email" => $employee_email,"event_name" => $event_name,"event_date" => $event_date,"participation_fee" => $participation_fee);
}
echo json_encode($result_array);
?>






