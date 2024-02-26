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
//create var that handles retvar

function getSession(){

    $retvar = md5($this->randkey);
    $retvar = 'usr_'.substr($retvar,0,10);
    return $retvar;
}


//check ig no session if no start session
//assign sessioncode to session variable
//check if empty if ytes retuen false otehrwise return truyel
function checkLogin(){


    if(!isset($_SESSION)){
        session_start();
    }

    $sessionvar = $this->getSession();

    if(empty($_SESSION[$sessionvar])){
        return false;
    }
    return true;
}




//establish connection
//sanitize user and pass
//query
//result
//condition check the result and return false
//fetchasoc
//create session that pass the username
//return true


function checkLoginInDB($username,$password){

    $con = $this -> DBlogin();

    $username = $this->sanitize($username);
    $pass = $this->ENCRYPT($this->sanitize($password));

    $query = "select * from users where USERNAME = '$username' and PASSWD = '$pass'";

    $result = $con->query($query);


    if(!$result || mysqli_num_rows($result)<=0){
        echo 'ERROR LOGGING IN INVALID USER AND PASS IDIOT';
        return false;
    }

   $row = mysqli_fetch_assoc($result);

   $_SESSION ['username'] = $row ['USERNAME'];
   return true;

}

//login naaa
//get the username and password and trim
//check if no session if no start the session
//check loginindb if has value if no returen false
//create session use getsession and assign to username
//return true


function login(){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);


    if(!isset($_SESSION)){

        session_start();
    }

    if(!$this->checkLoginInDB($username,$password)){
        return false;
    }

    $_SESSION[$this->getSession()] = $username;

    return true;
}


}


?>