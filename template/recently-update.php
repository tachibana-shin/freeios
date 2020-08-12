<?php

   require_once "modules/sql_connect.php";

   $receltyUpload = [];
   
   $result = $sql -> query("select name, timeupload from Apps order by timeupload DESC limit 10");

   if ( $result -> num_rows > 0 ) {
      while ( $row = $result -> fetch_assoc() ) {
      array_push($receltyUpload, $row);
      };
   };
   
   $result -> free_result();
   

?>

	<div class="p-15px bg-white px-3 listWidget">
		<h1 class="color-666 h6"> Receltly Update </h1>
		<div class="m-0 p-0 my-2">
		
<?php

	foreach ( $receltyUpload as $value ) {
		$name = stripslashes ($value["name"]);
        $href = "/app/".str_replace(" ", "-", $name); 
		$icon = "/upload/".urlencode(urlencode($name)).".png";
        
		echo '
			 <div class="App m-0 px-0 border-bottom">
			 	<div class="d-flex justify-content-between align-items-center align-contents-center">
			 		<div class="mr-4">
			 			<img style="width:32px; height:32px;" src="'.$icon.'">
			 		</div>
			 		<div class="col">
			 			<a class="no-a my-1" href="'.$href.'">'.$name.'</a>
					</div>
			 		<div class="align-self-end ml-auto text-secondary small my-1">
						<div>'.
                       		date("H:i - d/m/Y", strtotime($value["timeupload"]))
			 		.'
			 			</div>
			 		</div>
			  	 </div>
			 </div>';
	};
?>
		</div>
	</div>
