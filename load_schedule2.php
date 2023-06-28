<?php
include 'db_connect.php';
extract($_POST);
$where = '';
if(empty($id)){
	if(!empty($from_location) || !empty($from_location))
	$where .=" and (s.from_location LIKE '%".$from_location."%' or s.to_location LIKE '%".$to_location."%') ";
	if(!empty($departure_time)){
		$departure_time = str_replace('/', '-', $departure_time);
			$where .= " and date(s.departure_time) = '".$departure_time."'  ";
		}
}
$qry = $conn->query("SELECT s.*,concat(b.bus_number,' | ',b.name) as bus FROM schedule_list s inner join bus b on b.id = s.bus_id where s.status = 1 ".$where." order by date(s.departure_time) asc");
$data = array();
while($row = $qry->fetch_assoc()){
	$from_location = $conn->query("SELECT id,Concat(terminal_name,', ',city,', ',state) as location FROM location where id = ".$row['from_location'])->fetch_array()['location'];
	$to_location = $conn->query("SELECT id,Concat(terminal_name,', ',city,', ',state) as location FROM location where id = ".$row['to_location'])->fetch_array()['location'];
	$row['from_location'] = $from_location;
	$row['to_location'] = $to_location;
	$row['date'] = date('M d, Y',strtotime($row['departure_time']));
	$row['time'] = date('h:i A',strtotime($row['departure_time']));
	if(date('F d, Y',strtotime($row['departure_time'])) == date('F d, Y',strtotime($row['eta']))){
		$row['eta'] = date('h:i A',strtotime($row['eta']));
	}else{
		$row['eta'] = date('M d,Y h:i A',strtotime($row['eta']));
	}
	$data[]= $row;
}
echo json_encode($data);