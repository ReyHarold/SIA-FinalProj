<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="template.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <img src="img/student_portal.png" alt="StudentPortal">
    <div class ="head"><p>Login</p></div>
    <div class="logincontain">
    <form class="loginform"action="index.php" method="POST">
        <h2>Please Login</h2>
        <input type="text" name = "uname"placeholder="Sr-Code">
        <input type="password" name="pass" placeholder="Password">
        <div class="selecta"><label for="student">Student</label><input type="radio" id="student" value="student_rgo"name="select" checked><label for="admin">Staff</label><input type="radio" id="admin" value="employee_rgo" name="select"></div>
        <p class="case">*password is case sensitive</p>
        <div class="signin"><ion-icon class="icon" name="lock-open-outline"></ion-icon><input type="submit" name="signin" value="Sign in" ></div>
    </form>
    <?php
    include "conn.php";
    if (isset($_POST['signin'])) { 
        $type = $_POST['select'];
        $id = $_POST['uname'];
        $password = $_POST['pass'];


    $qry="SELECT * FROM $type WHERE code='$id' AND pass='$password'";
	$result=mysqli_query($conn,$qry);
    $row = mysqli_fetch_array($result);
	
	if(mysqli_num_rows($result) > 0) {
			switch ($type){
                case "employee_rgo":
                    if ($row['type'] == "staff"){
                    header("location: Staff/home.php?code=$id&type=employee_rgo");
                    }else{
                        header("location: Admin/home.php?code=$id&type=employee_rgo");
                    }
                    break;
                case "student_rgo":
                    header("location: Student/home.php?code=$id&type=student_rgo");
                    break;
            }
        
        }else{
			header("location: index.php?MaliPassword");
        }
        exit();
    };
    ?>
</div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>