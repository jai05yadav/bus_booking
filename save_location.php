<?php
include('db_connect.php');

extract($_POST);
	$data = " terminal_name = '$terminal_name' ";
	$data .= ", city = '$city' ";
	$data .= ", state = '$state' ";
if(empty($id)){
	
	$insert= $conn->query("INSERT INTO location set ".$data);
	if($insert)
		echo 1;
}else{
	$update= $conn->query("UPDATE location set ".$data." where id =".$id);
	if($update)
		echo 1;
}