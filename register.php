<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php 


require_once('include/connection.php');

require_once('include/function.php');



if(isset($_POST['submit'])){

$password = $fc->sanitize($_REQUEST['password']);

$username = $fc->sanitize($_REQUEST['username']);


if($fc->checkusername($username)==true){

echo 'USERNAME IS ALREADY TAKEN';

}
else {

if($fc->SaveUsers($username,$password)== true){

    echo 'REGISTERED';
}
}
}


?>



<h1>Registration</h1>
<br>
<form autocomplete="off" name="registration" action="" method="post">
<input type="text" name="username" placeholder="Username" required />
<br><br>
<input type="password" name="password" placeholder="Password" required />
<br><br>

<br><br>

<input type="submit" name="submit" value="Register" />
</body>
</html>