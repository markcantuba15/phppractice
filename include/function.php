<?PHP 


class Functions {

var $host;
var $username;
var $password;
var $database;
var $db;
var $table;
var $randkey;
function InitDB($dbhost,$uid,$password,$database){

$this ->host = $dbhost;
$this ->username = $uid;
$this -> password = $password;
$this -> database = $database;

}


function dbconnect(){


    if(!$this -> db){

        $this-> db = new mysqli($this->host,$this->username,$this->password,$this->database);
    }
    return $this->db;
}

function DBlogin(){


    $db = new mysqli($this->host,$this->username,$this->password,$this->database);
    
    if($db->connect_errno){

        echo 'failed to connect to server';
        exit;
    }
    else {

        return $db;
    }
}

function ENCRYPT($password){
$encrypt = sha1($password);
return $encrypt;

}

function sanitize($str){

    $con = $this-> DBlogin();

    $real_esc = $con->real_escape_string($str);

    return $real_esc;

}
function checkusername($username){

$con = $this->DBlogin();

if (!$con){

    return false;
}
else {


    $query = "SELECT USERNAME FROM users WHERE USERNAME = '$username'";

    $result = $con->query($query);


    if(mysqli_num_rows($result)>0){


        return true;
    }
    else {

        return false;
    }
}
}

function SaveUsers($username,$password){

$password = $this -> ENCRYPT($password);

$con = $this->DBlogin();

if(!$con){

    return false;

}
else {
 $this -> table = 'users';


 $query = 'insert into ' . $this ->table.  '(USERNAME,PASSWD) values ("'.$username.'" , "'.$password.'")';


 if(!$con->query($query)){

    return false;
 }


 else {

    return true;
 }
}
}
function checkTeacherId($teacherid){

    $con = $this->DBlogin();

    if(!$con){

        return false;
    }

    $query = "SELECT PROF_ID FROM prof WHERE  PROF_ID = '$teacherid'";

    $result = $con->query($query);

    if( mysqli_num_rows($result) >0){
return true;
    }
    else {

        return false;
    }
    return false;
}

function SaveTeacher($id,$firstname,$middlename,$lastname,$gender,$username,$password){

$password = $this->ENCRYPT($password);


$con = $this->DBlogin();
if(!$con){

    return false;
}
else {

    $this->table = 'prof';

    $query = 'insert into ' . $this->table . ' (PROF_ID,FIRSTNAME,MIDDLENAME,LASTNAME,GENDER,USERNAME,PASSWD) values ("'.$id.'"
    ,"'.$firstname.'","'.$middlename.'", "'.$lastname.'","'.$gender.'","'.$username.'","'.$password.'")';




if(!$con->query($query)){

    return false;
    echo 'e';
}
else {
return true;
}

}
}



//get session function
//create a variable assign md5 and rankey
//use the variable and assign usr_ 
//return the variable

function getsession(){

    $retvar = md5($this->randkey);

    $retvar = 'usr-'.substr($retvar,0,10);

    return $retvar;
}



//checklogin function
//check if no session if no start session
//assign getsession function to session variable
//check if the session variable  is empty  if yes return false otehrwise return true



function checklogin(){


    if(!isset($_SESSION)){

session_start();
    }


    $sessionvar = $this->getsession();


    if(empty($_SESSION[$sessionvar])){


        return false;
    }
    return true;
}


//checkloginDB --function
// assign variable for parameter
//establish connection
//sanitize user and pass
//query
//result
//condition check the result if <= 0 if true echo error messagereturn false
//assign variable to mysqli fetch and set the result var as parameter
//create session that pass the username to the asssign variable row 
//return true
function checkloginDB($username , $password){

    $con = $this->DBlogin();

    $username = $this->sanitize($username);
    $password = $this->ENCRYPT($this->sanitize($password));

    $query = "select * from users where USERNAME = '$username' and PASSWD = '$password'";

    $result = $con->query($query);


    if(!$result || mysqli_num_rows($result)<=0){
      //  echo '<script>alert("ERROR: Username and password incorrect.");</script>';
return false;
    }
   $row = mysqli_fetch_assoc($result);

    $_SESSION['username'] = $row['USERNAME'];
    return true;
}
//teacer




//login naaa
//get the username and password and trim
//check if no session if no start the session
//check loginindb if has value if no returen false
//create session use getsession and assign to username
//return true

function login(){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);


    if (!isset($_SESSION)){

        session_start();
    }

    if(!$this->checkloginDB($username,$password)){

        return false;
    }

    $_SESSION [$this->getsession()] = $username;

    return true;
}


//TEACHER LOGIN 
function checkloginDBinTeacher($username , $password){

    $con = $this->DBlogin();

    $username = $this->sanitize($username);
    $password = $this->ENCRYPT($this->sanitize($password));

    $query = "select * from prof where USERNAME = '$username' and PASSWD = '$password'";

    $result = $con->query($query);


    if(!$result || mysqli_num_rows($result)<=0){
      //  echo '<script>alert("ERROR: Username and password incorrect.");</script>';
return false;
    }
   $row = mysqli_fetch_assoc($result);

    $_SESSION['username'] = $row['USERNAME'];
    return true;
}

function loginTeacher(){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);


    if (!isset($_SESSION)){

        session_start();
    }

    if(!$this->checkloginDBinTeacher($username,$password)){

        return false;
    }

    $_SESSION [$this->getsession()] = $username;

    return true;
}
}
?>