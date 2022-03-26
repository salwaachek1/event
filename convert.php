<?php
require_once(__DIR__ . './vendor/autoload.php');
require_once(__DIR__ . '/database.php');
require(__DIR__ . '/employee.php');
require(__DIR__ . '/event.php');
require(__DIR__ . '/participation.php');
$bookings =  JsonMachine\Items::fromFile($_FILES['file']['tmp_name']);
try { 
  foreach ($bookings as $booking) 
	{
	$bk =  json_encode($booking, JSON_PRETTY_PRINT);
	$data = json_decode($bk , true);
	$new_employee=new Employee();
	$employee_id=$new_employee->Insert($data);	// insert the employee's data in the employee table  
	$new_event=new Event();
	$event_id=$new_event->Insert($data);	// insert the event's data in the event table
	$new_participation=new Participation();
	$new_participation->Insert($data,$employee_id,$event_id); // insert the participation's data in the participation table	
}} catch(Exception $e) {
  echo "An error has occured !";
}

?>




