<?php

   require_once __DIR__."/sql_connect.php";
   /*
   if ( !($sql -> select_db("iOS")) ) {
      $sql -> query("CREATE DATABASE iOS");
      $sql -> select_db("iOS");
   };
*/
   $App = new class {
      public function __construct() {
         global $sql;
         $sql -> query("CREATE TABLE IF NOT EXISTS Apps (
            name TINYTEXT NOT NULL,
            author TINYTEXT NOT NULL,
            account TINYTEXT,
            description TEXT,
            versions TEXT NOT NULL,
            downloads INT NOT NULL DEFAULT 0,
            views INT NOT NULL DEFAULT 0,
            timeupload TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            category TINYTEXT NOT NULL,
            supports TINYTEXT NOT NULL)"
         );
      }

      private function uploadImage( $img, $name ) {
          
          if ( $img["error"] != 0 )
             return;
          
         $name = urlencode($name);
      
         if ( !is_dir("../upload") ) {
             mkdir("../upload");
         };
         if ( file_exists("../upload/$name.png") )
             unlink("../upload/$name.png");

         move_uploaded_file($img["tmp_name"], "../upload/$name.png");
      }

      public function hash($name) {
          global $sql;
          return $sql -> query("select * from Apps where name='$name'") -> num_rows > 0;
      }

      public function add( $info ) {
         global $sql;
         
         if ( !$info -> replace && empty($info -> icon) )
            return;
         
         if ( !$this -> hash($info -> name) ) {
             if ( $sql -> query("insert into Apps (
                 name, author, account, description, versions, category, supports
              ) values (
                  '".addslashes($info -> name)."',
                  '".addslashes($info -> author)."', 
                  '".addslashes($info -> account)."',
                  '".addslashes($info -> description)."',
                  '".serialize($info -> versions)."',
                  '".addslashes($info -> category)."',
                  '".serialize($info -> supports)."'
            )") ) {
              $this -> uploadImage($info -> icon, $info -> name);
           }
        } else if ( isset($info -> name) && $info -> replace ) {
           $this -> remove($info -> name, $info -> icon["error"] == 0);
           $this -> add($info);
           $sql -> query("update Apps set name='".addslashes($info -> name)."', author='".addslashes($info -> author)."', account='".addslashes($info -> account)."', description='".addslashes($info -> description)."', versions='".serialize($info -> versions)."', category='".addslashes($info -> category)."', supports='".serialize($info -> supports)."' where id=".($info -> id));
           return false;
        } else {
           return false;
        };
    
      }

      public function remove( $name, $removeImage) {
         global $sql;
         if ( $sql -> query("delete from Apps where name='$name'") ) {
            if ( $removeImage && is_file("../upload/".urlencode($name).".png")) unlink("../upload/".urlencode($name).".png");
         }
      }
   }
   
?>