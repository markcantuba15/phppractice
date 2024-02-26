<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
require_once("include/function.php");
require_once("include/connection.php");
?>
</head>


<body>
    <?php 
    //start session
    //check if login is true
    session_start();


    if(isset($_POST['submit'])){

    if($fc->login()==true){


        echo 'logine';
    }
    }
    else {
?>

    
    <center>
<br><br><br><br><br><br>
<div class="form">
<br>
<h1>Log In</h1>
<form autocomplete="off" action="" method="post" name="login">
<input type="text" name="username" placeholder="Username" required />
<br><br>
<input type="password" name="password" placeholder="Password" required />
<br><br>
<input name="submit" type="submit" value="Submit" />
</form>
<p>Not registered yet? <a href='register.php'>Register Here</a></p>

<br /><br />

</div>
</center>

</body>
</html>
<?php

}
 ?>