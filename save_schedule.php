<?php
include('db_connect.php');

extract($_POST);
	$data = " bus_id = '$bus_id' ";
	$data .= ", from_location = '$from_location' ";
	$data .= ", to_location = '$to_location' ";
	$data .= ", departure_time = '$departure_time' ";
	$data .= ", eta = '$eta' ";
	$data .= ", availability = '$availability' ";
	$data .= ", price = '$price' ";
if(empty($id)){
	
	$insert= $conn->query("INSERT INTO schedule_list set ".$data);
	if($insert)
		echo 1;
}else{
	$update= $conn->query("UPDATE schedule_list set ".$data." where id =".$id);
	if($update)
		echo 1;
}