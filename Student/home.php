<?php
include "../template.php";
?>
<script>
         code = document. getElementById("code").innerHTML;
        document. getElementById("templatebut"). href = "history.php?code="+code+"&type=student_rgo";
        document. getElementById("templatebut2"). innerHTML = "Previous Purchases";
</script>
<style>
.contents{
    width:100%;
    padding:30px 0;
}
.row{
    width:100%;
    display:flex;
    justify-content:space-around;
    margin-bottom:20px;
}
.row button{
    height:200px;
    width:200px;
}
.row img{
    width:100%;
}
.pop{
    left:50%;
    margin-left:-21vw;
    position: absolute;
    height:70vh;
    width:42vw;
    background-color:white;
    display:flex;
    flex-direction:column;
    border:2px solid black;
    border-radius:20px;
    transition:.2s;
    z-index:9;
}
.pop img{
    height:200px;
    width:200px;
}
.pop .up{
    display:flex;
}
.pop .up img{
    margin:10px;
    border:1px solid black;
}
.pop .up div, .pop .down{
    margin: 10px;
}
.middle{
    width:50%;
}
.pop tr th, .pop tr td{
    text-align:center;
}
.pop .clos{
    position:absolute;
    height:20px;
    top:5px;
    right:10px;
    background-color:white;
    border:none;
}
.close{
    transition:.2s;
    transform:scale(0);
}

.pop .clos .icon{
    transform:scale(2);
}
.order {
    margin:0 auto;
}
.order input{
    width:100px;
    height:24px;
    border-radius:5px;
}
.out{
    opacity:0.5;
}
.quant{
    margin-top:20px;
    margin-left:32px;
}
.quant input{
    padding:2px;
} 
.dislab{
    color:gray;
}
.stats{
    display:flex;
    justify-content:space-around;
    width:50%;
}
</style>
<?php
$qry = "SELECT `item`, `price`, `size` FROM `item`";
$result= mysqli_query($conn,$qry);
while($row2= mysqli_fetch_assoc($result)){
        echo  '<Input type="hidden" id="'.$row2['item'].''.$row2['size'].'" value="'.$row2['price'].'">';
        }
?>
<div id="pop">
    <form id = "popform"class="pop close" action="placeorder.php?code=<?php echo $code?>" method="POST">
        <button type="button" class="clos" onclick="close12()"><ion-icon class="icon" name="close-outline"></ion-icon></button>
        <div class="up"><img id = "img" alt="Item_Image">
        <div><h2>Item Name: <span id="itemName"></span></h2>
        <Input type="hidden" name="item" id="itemn" value="">
        <h2>Sr-code: <span id="cod"></span></h2>
        <Input type="hidden" name="codes" id="codes" value="">
        <h2 id="NONEdis"></h2></div></div>
        <table id ="popsize"class="middle">
    </table>
    <div class="quant"><label>Quantity: </label><input type="number" name="quan" id="quan" min=1 required></div>

        <div id="moresize"class="down"></div>
        <div class="order"><input type="submit" name="Order" value="Order"></div>
    </form>
</div>
<div class="contents">
    <div class= "ststs">
    <?php
    $qry3 = "SELECT `statuss` FROM orders WHERE `stud_code` = (SELECT `studid` from student_rgo where `code` = '$code')";
    $result3= mysqli_query($conn,$qry3);
    $ind = 0;
    $ind2 = 0;
    while($row= mysqli_fetch_assoc($result3)){
        if ($row['statuss'] == "Ready for Pickup"){
            $ind++;
    }elseif ($row['statuss'] == "Pending"){
        $ind2++;
    }
}
    if ($ind > 0){
        echo "<script>
        document.addEventListener('DOMContentLoaded', function(event){
            alert('You have $ind order ready for pickup!');
          });
         </script>";
    }
    echo "<div class='stats'><p style=color:green;>Orders that are ready for pickup: $ind </p>";
    echo "<p style=color:red;>Pending Orders: $ind2</p></div>";
    ?>
    </div>
    <?php
    $qry2 = "SELECT img, item, if( size = 'NONE', 'false', 'true') As size from item group by item";
    $result2= mysqli_query($conn,$qry2);
    $i =0;
    $b=0;
    while($row= mysqli_fetch_assoc($result2)){
        if ($i % 4 == 0 || $i == 0){
            echo"<div class='row'>";
            $b=1;
            }
            echo "<button onclick=popup('".$row['item']."',".$row['size'].")><img id='".$row['item']."' src='data:image/png;base64,".base64_encode($row['img'])."'></button>";
            if ($b == 4 ){
                echo "</div>";
                }
        $i++;
        $b++;
}
    ?>
</div>

<script>
    function popup(item, size){
       var name= document.getElementById("name").innerHTML;
       var code = document.getElementById("code").innerHTML;
       document.getElementById("img").src = document.getElementById(item).src;
       document.getElementById("itemName").innerHTML = item;
       document.getElementById("cod").innerHTML = code;
       document.getElementById("codes").value = code;
       document.getElementById("itemn").value = item;
        if (size){
            document.getElementById("popform").setAttribute("style","height:70vh;")
            document.getElementById("quan").max= 2
            document.getElementById("NONEdis").innerHTML = ""
        var smol = document.getElementById(item+"Small").value
        var med = document.getElementById(item+"Medium").value
        var large = document.getElementById(item+"Large").value
        var cus = document.getElementById(item+"Custom").value
        document.getElementById("popsize").innerHTML=`<tr><th>Size</th><th>Select</th><th>Price</th></tr>
        <tr><td><label for="size" >Small </label></td><td><input required id="smolradio" onclick="removecustom()" type="radio" value = "Small, `+smol+`" name="sizes"><td><label>`+smol+`</label></td></tr>
        <tr><td><label for="size" >Medium </label></td><td><input required id="medradio" onclick="removecustom()" type="radio" value ="Medium, `+med+`" name="sizes"><td><label>`+med+`</label></td></tr>
        <tr><td><label for="size" >Large </label></td><td><input required id="larradio" onclick="removecustom()" type="radio" value = "Large, `+large+`" name="sizes"><td><label>`+large+`</label></td></tr>
        <tr><td><label for="size" >Custom </label></td><td><input required id="cusradio" onclick="custom()" type="radio" value = "Custom, `+cus+`" name="sizes"><td><label>`+cus+`</label></td></tr>`

       document.getElementById("popform").classList.remove("close");
        }else{
            document.getElementById("quan").max= 10
            document.getElementById("popform").setAttribute("style","height:50vh;")
            document.getElementById("popsize").innerHTML= `<Input type="hidden" name="sizes" value="NONE">`
           var nonedis = document.getElementById(item+"NONE").value
           nonedis = nonedis.split(',');
            document.getElementById("NONEdis").innerHTML = "PRICE: "+nonedis[0]+""
            document.getElementById("moresize").innerHTML = ""
            document.getElementById("popform").classList.remove("close");
        }
    };

    function close12(){
        document.getElementById("popform").classList.add("close");
    };
    function custom(){
        document.getElementById("moresize").innerHTML = `<label for="width">If Custom Size: Width(Inch):</label><input type="number" name="width" id=""><label for="length">Length(Inch):</label><input type="number" name="length" id="">`
    }
    function removecustom(){
        document.getElementById("moresize").innerHTML = ""
    }
</script>
</body>
</html>