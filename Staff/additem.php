<?php
include "../conn.php";
$codereg = $_GET['code'];
$name = $_POST['itemn'];
$imgData = addslashes(file_get_contents($_FILES['imgg']['tmp_name']));
if (isset($_POST['size'])){
    $price = $_POST['prices'];
    foreach ($price as $key){
       $qry = "INSERT INTO `item`( `item`, `price`, `size`, `img`) VALUES ('$name','".$key['price']."','".$key['size']."','$imgData')";
       $result = mysqli_query($conn, $qry);
    }
}else{
$quantity = $_POST['quantity'];
$pricez = $_POST['price'];
$size= "NONE";
$qry = "INSERT INTO `item`( `item`, `price`, `size`, `img`) VALUES ('$name','$pricez','$size','$imgData')";
$result = mysqli_query($conn, $qry);
};
header("location: item.php?code=$codereg&type=employee_rgo");
exit;
?>