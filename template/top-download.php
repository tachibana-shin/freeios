<?php

   require_once "modules/sql_connect.php";

   $topDownload = [];
   
   $result = $sql -> query("select name, downloads from Apps order by downloads DESC limit 10");

   if ( $result -> num_rows > 0 ) {
      while ( $row = $result -> fetch_assoc() ) {
      array_push($topDownload, $row);
      };
   };
   
   $result -> free_result();
   

?>

	<div class="p-15px bg-white px-3 listWidget">
		<h1 class="color-666 h6"> Top Download </h1>
		<div class="m-0 p-0 my-2">
		
<?php

	foreach ( $topDownload as $value ) {
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
						 <p class="small text-secondary p-0 m-0 weight-300 d-md-inline ml-md-2">'.$value["downloads"].' lượt tải về</p>
					</div>
			 		<div class="align-self-end ml-auto">
			 			<a class="text-secondary font-130pt px-1" href="'.$href.'"> <i class="fas fa-arrow-to-bottom"></i> </a>
			 		</div>
			 	</div>
			 </div>';
	};
?>
		</div>
	</div>
