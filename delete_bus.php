<?php

include('db_connect.php');
extract($_POST);
$remove = $conn->query("UPDATE bus set status = 0 where id =".$id);
if($remove)
	echo 1;