<!doctype html>
<html>
   <head>
      <?php
         include_once "modules/render-meta.php";
         echo renderMeta([
            "title" => "Change Log - Free iOS",
            "des" => "Tweets by NguyenThanhDev",
			"icon" => "https://ios.codevn.net/wp-content/uploads/2018/01/ogimage.jpg"
         ]);
      ?>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
      <!--link rel="stylesheet" href="https://nguyenthanh1995.github.io/lib/bootstrap.min.css">-->
      <link rel="stylesheet" href="https://nguyenthanh1995.github.io/lib/awesome pro/css/all.min.css">
	  <link rel="stylesheet" href="style.css">
      <script src="https://nguyenthanh1995.github.io/my-new.js"></script>
      <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
   </head>
   <body>
      <?php include_once "template/header.php" ?>

      <div class="main">
      
         <div class="container">
            <!-- flex apps -->
            <div class="row">
               <div class="col-12 col-lg-8 pt-30px">
                  <div class="p-15px bg-white px-3 listWidget" style="font-size: 14px">
 					 <h5> Change Log </h5>
					 <div class="render__markdown my-3">
					<p><a class="twitter-timeline" href="https://twitter.com/NguyenThanhDev?ref_src=twsrc%5Etfw">Tweets by NguyenThanhDev</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></p>
					 </div>
                  </div>
               </div>
               
               <!-- -->
               
               <div class="col">
                   <? include_once "template/social.php" ?>
                   <? include_once "template/top-download.php" ?>
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