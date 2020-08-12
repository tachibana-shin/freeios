<?php
   require_once __DIR__."/../../modules/sql_connect.php";
   require_once __DIR__."/../libs/JWT.php";
   
   define("KEYJWT", $_SERVER["HTTP_HOST"]);
   
   
   use \Firebase\JWT\JWT;
   
   
   $auth = new class {
       public function __construct() {
           global $sql;
           $sql -> query("create table if not exists AccountAdmin (
                  username tinytext not null,
                  fullname tinytext not null,
                  password tinytext not null
               )");
           if ( isset($_COOKIE["auth"]) ) {
               $this -> user = (array) JWT::decode($_COOKIE["auth"], KEYJWT, array("HS256"));
           }
       }
       
       public $user = null;
       public function login($username, $password) {
           global $sql;
           $result = $sql -> query("select * from AccountAdmin where username='$username' and password = '".md5($password)."'");
           if ( $result -> num_rows > 0 ) {
              $this -> user = $result -> fetch_array();
              unset($this -> user["password"]);
              $result -> free_result();
           
              setcookie("auth", (string) JWT::encode($this -> user, KEYJWT), strtotime("+30days"), "/");
               
             JWT::$leeway = 30 * 24 * 3600;
             return true;
           }
           return false;
       }
       public function has($username) {
           global $sql;
           return $sql -> query("select * from AccountAdmin where username='$username'") -> num_rows > 0;
       }
       public function signUp($username, $fullname, $password) {
           global $sql;
           if ( $this -> has($username) )
              return 2;
           if ( $sql -> query("insert into AccountAdmin (username, fullname, password) values ('$username', '$fullname', '".md5($password)."')"))
              return 1;
           return 0;
       }
       public function logout() {
           setcookie("auth", "", 1);
           $this -> user = null;
       }
       public function checkLogin() {
           return $this -> user != null && $this -> has($this -> user["username"]);
       }
   }

   
?>