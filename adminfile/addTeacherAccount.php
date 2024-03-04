<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #Gender {
  width: 200px; /* Adjust the width as needed */
  padding: 5px;
  font-size: 16px;
}
    </style>
</head>
<body>



<?php 
require_once("../include/connection.php");

require_once('../include/function.php');

if(isset($_POST['submit'])){


    $firstname = $fc->sanitize($_REQUEST['firstname']);
    $middlename = $fc->sanitize($_REQUEST['Middlename']);
    $lastname= $fc->sanitize($_REQUEST['Lastname']);
    $gender = $fc->sanitize($_REQUEST['gender']);
    $username = $fc->sanitize($_REQUEST['username']);
    $password = $fc->sanitize($_REQUEST['password']);

    $id = uniqid();

    if($fc->checkTeacherId($id)== true){
        echo 'username is taken';
        return false;
    }
    else {

        if($fc->SaveTeacher($id,$firstname,$middlename,$lastname,$gender,$username,$password)==true){

            echo "REGISTERED";
        }
    }
}

?>
<form autocomplete="off" name="registration" action="" method="post">
<input type="text" name="firstname" placeholder="firstname" required />
<br><br>
<input type="text" name="Middlename" placeholder="Middlename" required />
<br><br>
<input type="text" name="Lastname" placeholder="Lastname" required />
<br><br>
<select id="Gender" name="gender">
  <option value="male">MALE</option>
  <option value="female">Female</option>

  <!-- Add more options as needed -->
</select>
<br><br>

<input type="text" name="username" placeholder="Username" required />
<br><br>
<input type="password" name="password" placeholder="Password" required />
<br><br>

<br><br>

<input type="submit" name="submit" value="Register" />
</body>
</html>