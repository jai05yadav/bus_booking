<?php
include 'db_connect.php';

$qry = $conn->query("SELECT * FROM location where status = 1 order by terminal_name asc,city asc,state asc");
$data = array();
while($row = $qry->fetch_assoc()){
	$data[]= $row;
}
echo json_encode($data);