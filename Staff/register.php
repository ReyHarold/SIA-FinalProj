<?php
include "../conn.php";
$codereg = $_GET['code'];
$name = $_POST['admname'];
$code = $_POST['idcode'];
$imgData = addslashes(file_get_contents($_FILES['mm']['tmp_name']));
$qry = "UPDATE `employee_rgo` SET `img`= '$imgData' WHERE code = '$code'";
$result = mysqli_query($conn, $qry);

header("location: home.php?code=$codereg&type=employee_rgo");
exit;
?>