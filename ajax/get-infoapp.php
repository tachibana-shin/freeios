<?php
   include_once "../modules/sql_connect.php";
   
   if ( isset($_POST["ajax"]) ) {
      if ( !isset($_POST["name"]) || !$_POST["name"] )
		die(json_encode([
			"error" => 403
		]));
      $name = $_POST["name"];
      
      $name = str_replace("-", " ", str_replace(" ", "+", $name));

      $result = $sql -> query('select category, timeupload, supports from Apps where name="'.$name.'"');

      if ( $result -> num_rows > 0 ) {
         $app = $result -> fetch_array();
         $result -> free_result();
         echo json_encode([
            "category" => stripslashes($app["category"]),
			"timeupload" => date("h:i d/m/Y", strtotime($app["timeupload"])),
			"supports" => unserialize($app["supports"])
         ]);
      }
      else
      echo json_encode([
        "error" => 404
      ]);
   };
   
   //print_r($_SERVER);
?>