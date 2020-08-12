<?
   require_once "modules/sql_connect.php";

   $appLastUpload = [];
   $renderUpload = true;
   
   if ( isset($_GET["page"]) ) {
      $page = (int) trim($_GET["page"]);
   } else $page = 1;
   
   if ( isset($_GET["q"]) && !!$_GET["q"] ) {
      $q = stripslashes(trim($_GET["q"]));
	  $renderUpload = false;
   };
   
   if ( isset($_GET["category"]) && !!$_GET["category"] ) {
      $category = stripslashes(trim($_GET["category"]));
	  $renderUpload = false;
   };
  
   if ( isset($category) ) {
      $result = $sql -> query("select * from Apps where category = '".strtolower($category)."'");
      
      if ( $result -> num_rows == 0 ) {
         http_response_code(404);
         include("404.php");
         die();
      };
      
      $result -> free_result();
   };

   
   
   $result = $sql -> query($qr = "select name, author from Apps".(isset($q) ? " where (name like '%$q%' or description like '%$q%' or author like '%$q%' or versions like '%$q%')" : "").(isset($category) ? (isset($q) ? " " : " where ")."category = '".strtolower($category)."'": "")." order by timeupload DESC limit 20 offset ".($page - 1) * 20);
   echo $sql -> error;
   if ( $result -> num_rows > 0 ) {
      while ( $row = $result -> fetch_assoc() ) {
         array_push($appLastUpload, $row);
      };
   };
   
   $numResult = $result -> num_rows;
   
   $countRows = round($result -> num_rows / 21);

   if ( $page > ceil($numResult / 21) && $numResult > 0 ) {
 		http_response_code(404);
		include("404.php");
 		die();
   };
   
   $result -> free_result();
   
 ?>
<!doctype html>
<html>
   <head>
   	  <?
   	     include_once "modules/render-meta.php";
		 
		 $SEO = [
		 	"title" => "Free iOS - Các ứng dụng miễn phí cho iOS",
			"des" => " Download app miễn phí cho các dòng máy iOS chưa bao giờ dễ đến thế, không cần phải dùng máy tính, không cần jailbreak mà chỉ việc chọn phiên bản cần cài đặt và chờ cho đến khi cài xong."
		 ];
		 
		 if ( isset($category) ) {
		     if ( $category == "ipa" ) {
		         $SEO["title"] = "iPA - Free iOS";
		         $SEO["des"] = "Kho iPA apps/games đã loại bỏ ID dành cho máy đã jailbreak (bạn có thể sử dụng Appcake để cài đặt file iPA dành cho máy chưa jaibreak) do iOS CodeVN thực hiện.
Yêu cầu: iPhone 5s trở lên.";
		     }
		     else if ( $category == "games" ) {
		         $SEO["title"] = "Games - Free iOS";
		         $SEO["des"] = "Tải trò chơi phiên bản cũ cho các dòng máy iOS đời thấp chưa bao giờ dễ đến thế, không cần phải dùng máy tính, không cần jailbreak mà chỉ việc chọn phiên bản cần cài đặt và chờ cho đến khi cài xong.";
		     }
		     else if ( $category == "apps" ) {
		         $SEO["title"] = "Apps - Free iOS";
		         $SEO["des"] = "Tải ứng dụng phiên bản cũ cho các dòng máy iOS đời thấp chưa bao giờ dễ đến thế, không cần phải dùng máy tính, không cần jailbreak mà chỉ việc chọn phiên bản cần cài đặt và chờ cho đến khi cài xong.";
		     } else if ( $category == "jailbreak" ) {
		         $SEO["title"] = "Jailbreaks - Free iOS";
		         $SEO["des"] = "Tải trò chơi phiên bản cũ cho các dòng máy iOS đời thấp chưa bao giờ dễ đến thế, không cần phải dùng máy tính, không cần jailbreak mà chỉ việc chọn phiên bản cần cài đặt và chờ cho đến khi cài xong. ";
		     }
		 };
		 echo renderMeta($SEO);
   	  ?>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
      <!--link rel="stylesheet" href="https://nguyenthanh1995.github.io/lib/bootstrap.min.css">-->
      <link rel="stylesheet" href="https://nguyenthanh1995.github.io/lib/awesome pro/css/all.min.css">
	  <link rel="stylesheet" href="/style.css">
      <script src="https://nguyenthanh1995.github.io/my-new.js"></script>
      <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
   </head>
   <body>
      <?php include "template/header.php" ?>

      <div class="main">
      
         <div class="container">
            
            <!-- flex apps -->
            <div class="row">
               <div class="col-12 col-lg-8 pt-30px">
                        
                  <div class="p-15px bg-white px-3 listWidget">
                     <h1 class="color-666 h6"> <?php
   if ( isset($q) ) 
     echo "Kết quả tìm kiếm cho \"$q\" ($numResult kết quả)".( isset($category) ? " trong $category" : "");
   else if  (isset($category) )
     echo "Category: $category";
   else
     echo "Mới cập nhật"//date("d/m/Y"); ?> </h1>
                     <?php
                        if ( isset($category) )
                           echo "<small>".$SEO["des"]."</small>";
                     ?>
                     <div class="m-0 p-0 my-2">
<?php

   foreach ( $appLastUpload as $value ) {
      $name = stripslashes ($value["name"]);
      
      $href = "/app/".str_replace(" ", "-", $name);
      $icon = "/upload/".urlencode(urlencode($name)).".png";
      
      echo '
                        <div class="App m-0 px-0 border-bottom">
                           <div class="d-flex justify-content-between align-items-center align-contents-center">
                              <div class="mr-4">
					  	   	     <img style="width:32px; height:32px;"src="'.$icon.'">
                              </div>
                              <div class="col">
                                 <a class="no-a my-1" href="'.$href.'">'.$name.'</a>
                                 <p class="small text-secondary p-0 m-0 weight-300 d-md-inline ml-md-2">by '.$value["author"].'.</p>
                              </div>
                              <div class="align-self-end ml-auto">
                                 <a class="text-secondary font-130pt px-1 toggle-collapse-info" href="'.$href.'" data-name="'.str_replace(" ", "-", addslashes($name)).'"> <i class="fas fa-info-circle"></i> </a>
                                 <a class="text-secondary font-130pt px-1" href="'.$href.'"> <i class="fas fa-arrow-to-bottom"></i> </a>
                              </div>
                           </div>
                           
                           <div class="collapse">
                              <div class="text-center loading--info">
                                 <div class="spinner spinner-border"></div>
                              </div>
                              <ul class="list-unstyled d-table my-3 mx-2 show--info d-none">
                                 <li class="d-table-row">
                                    <div class="d-table-cell text-mute pr-4"> Category: </div>
                                    <div class="d-table-cell category small"></div>
                                 </li>
                                 
                                 <li class="d-table-row">
                                    <div class="d-table-cell text-mute pr-4"> Uploaded: </div>
                                    <div class="d-table-cell uploaded small"></div>
                                 </li>
                                 
                                 <li class="d-table-row">
                                    <div class="d-table-cell text-mute pr-4"> Supports: </div>
                                    <div class="d-table-cell supports small"></div>
                                 </li>
                              </ul>
                           </div>
                        </div>';
   };
?>
                     </div>
                     <?php

include "lib/pagination.php";

$pagination = new Paginator();
$pagination -> count = $countRows+100;
$pagination -> page = $page;
$pagination -> classItem = "a-global";
$pagination -> classActive = "font-weight-bold text-dark";
                     
if ( $countRows > 0 ) {
   echo '<div class="text-center">
			<p class="small"> Page '.$page.' of '.$countRows.'</p>'.$pagination -> render().'
		</div>';
};
                     ?>
                  </div>
               </div>
               
               <!-- -->
               
               <div class="col">
                  <? include "template/social.php" ?>
               	  <? include "template/top-download.php" ?>
			   	  <? if ( $renderUpload )
			   			   include "template/recently-update.php";      ?>
               </div>
               
               <!-- -->
               
            </div>
            
            <!-- -->
           
         </div>
         
      </div>
      
      <?php include "template/footer.php" ?>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>
      
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>

<script>

onerror = e => alert(e + "")

my(".toggle-collapse-info").each((index, item) => {
   my(item).click((e) => {
      e.preventDefault();
      let collapse = my(item).closest(".App").find(".collapse")
      
      
      new bootstrap.Collapse(collapse[0]).toggle()

      my(".App .collapse.show").each((index, item) => {
		 if ( item != collapse ) {
		    new bootstrap.Collapse(item).hide()
		 }
	  })

      let name = my(item).data("name")
      
      if ( collapse.hasClass("ajax--done") )
		return
      
	  my.post("/ajax/get-infoapp.php", "ajax=true&name=" + name, () => {}, "json")
      .then(json => {
         collapse.addClass("ajax--done")

         collapse.find(".loading--info")
		 .addClass("d-none")
		 collapse.find(".show--info")
		 .removeClass("d-none")
		 
		 collapse.find(".show--info .category").text(json.category)

		 collapse.find(".show--info .uploaded").text(json.timeupload)

         collapse.find(".show--info .supports").empty();

		 (Array.isArray(json.supports) ? json.supports : [json.supports]).map((iOS, index, arr) => {
			my(`<a class="a-global" href="/?tag=${iOS}"> iOS ${iOS}${index < arr.length - 1 ? "," : ""} `).appendTo( collapse.find(".show--info .supports") )
		 })
      })
      .catch(e => alert(e + ""))
	  
   })
   
})
//alert( typeof bootstrap.Collapse )

setTimeout(() => {
    let banner = my("a[href='https://www.000webhost.com/']")
    if ( banner.length )
       banner.parent().remove()
}, 2000)
</script>
   </body>
</html>