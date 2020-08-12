<?php
   require_once __DIR__."/sql_connect.php";

   $TinyLink = new class {
      public function __construct() {
         global $sql;
         $sql -> query("CREATE TABLE IF NOT EXISTS TinyLink (
               hash TINYTEXT NOT NULL,
               link TEXT NOT NULL
          )");
      }

      private function findHashInDB( $url ) {
         global $sql;
         $result = $sql -> query("select hash from TinyLink where link = '$url'");
         if ( $result -> num_rows > 0 ) {
            $app = $result -> fetch_array();
		         $result -> free_result();
		         return $app["hash"];
         }
         else return false;
  	  }
	  
	    public function createHash( $url ) {
         global $sql;
         if ( ($pam = $this -> findHashInDB( trim($url) )) == false ) {
            $pam = substr( str_replace("=", "_", base64_encode( md5( $url.time().rand(0, 9999) ) ) ), 0, 6);
	    	    if ( !($sql -> query("insert into TinyLink (hash, link) values ('$pam', '$url')")) ) {
               echo $sql -> error;
           } else {
               return $pam;
           };
       	 } else {
	  	       return $pam;
   	     };
	  }
	  public function findLink( $pam ) {
       global $sql;
	     $result = $sql -> query("select link from TinyLink where hash = '$pam'");
	     if ( $result -> num_rows > 0 ) {
	        $app = $result -> fetch_array();
	        $result -> free_result();
	        return $app["link"];
	     }
	     else return false;
	  }
   }
   
?>
