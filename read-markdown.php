<?php
   include "lib/Parsedown.php";
   include "modules/replace-str.php";
   include_once __DIR__."/admin/modules/Auth.php";

   if ( isset($_GET["file"]) && !!$_GET["file"] && is_file("markdown/".$_GET["file"].".md") ) {
      $name = $_GET["file"];
   	  $file = str_replace("..", ".", "markdown/".$_GET["file"].".md");
   } else {
      http_response_code(404);
      include("404.php");
      die();
   };
?>
<!doctype html>
<html>
   <head>
   	  <?php
   	  
		include_once "modules/render-meta.php";
		
		if ( $name == "faqs" )
		   renderMeta([
		       "title" => "FAQs - Free iOS",
		       "des" => "Mẹo: Trước khi tải app/game nhìn dòng màu đỏ trên cùng xem sử dụng tài khoản nào, truy cập https://".$_SERVER["HTTP_HOST"]."/id lấy tài khoản đó đăng nhập vào Appstore trước rồi sau đó tiến hành tải app/game tại iOS CodeVN. 1. Lấy tài khoản kích hoạt app/game ở đâu? &#8211; Tài khoản kích hoạt được cập &hellip; ",
		       "icon" => ""
		   ]);
		 else if ( $name == "rules" )
		   renderMeta([
		       "title" => "Nội quy - Free iOS",
		       "des" => "Free iOS là dịch vụ cung cấp phương pháp cải đặt ứng dụng bên thứ ba cho iOS. Vui lòng đọc kỹ các điều khoản sau và trả lời đầy đủ các câu hỏi để được xét duyệt tham gia vào group. 1. Tài khoản kích hoạt app nằm tại website https://".$_SERVER["HTTP_HOST"]."/id. 2. Xin tài khoản trong group -&gt; chưa đọc nội quy -&gt; &hellip; ",
		       "icon" => ""
		   ]);
		 else if ( $name == "tutorial" )
		   renderMeta([
		       "title" => "Hướng dẫn tải và cài đặt trên Free iOS - Free iOS",
		       "des" => "Bài viết này mình sẽ hướng dẫn các bạn cách tải và cài đặt app trực tiếp trên điện thoại mà không cần sử dụng máy tính, điện thoại bạn cũng không cần phải Jailbreak. Bước 1: Sử dụng trình duyệt Safari hoặc Puffin để truy cập vào &hellip ",
		       "icon" => ""
		   ]);
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
				  
                  <div class="p-15px bg-white px-3 listWidget" style="font-size: 14px">
                      
                     <? if ( $auth -> checkLogin() )
                           echo '<a href="/admin/edit-md/'.$file.'" class="no-a"><i class="fad fa-edit"></i> Chỉnh sửa </a>'
                     ?>
					 <div class="render__markdown my-3">
						<?= Replace((new Parsedown()) -> text(file_get_contents($file))); ?>
					 </div>
                  </div>
               </div>
               
               <!-- -->
               
               <div class="col">
               		<? include "template/social.php" ?>
              		<? include "template/top-download.php" ?>
			   </div>
            </div>
            
            <!-- -->
           
         </div>
         
      </div>
      
      <?php include "template/footer.php" ?>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>
      
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>

	  <style>
	     .render__markdown h1 {
	        font-weight: 300 !important;
	     }
	  </style>
   </body>
</html>