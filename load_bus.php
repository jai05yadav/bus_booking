<?php
include 'db_connect.php';

$qry = $conn->query("SELECT * FROM bus where status = 1 order by bus_number asc");
$data = array();
while($row = $qry->fetch_assoc()){
	$data[]= $row;
}
echo json_encode($data);