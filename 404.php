<!doctype html>
<html>
   <head>
      <title> 404 Not Found </title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
      <!--link rel="stylesheet" href="https://nguyenthanh1995.github.io/lib/bootstrap.min.css">-->
      <link rel="stylesheet" href="https://nguyenthanh1995.github.io/lib/awesome pro/css/all.min.css">
	  <link rel="stylesheet" href="https://<?= $_SERVER["HTTP_HOST"] ?>/style.css">
      <script src="https://nguyenthanh1995.github.io/my-new.js"></script>
      <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
   </head>
   <body>
      <?php include_once "template/header.php" ?>

      <div class="main">
      
         <div class="container">
            
            <!-- flex 404 -->
            <div class="row">
               <div class="col-12 col-lg-8">
       	      	  <div class="errorPage">
       	      	     <div class="d-table-row">
       	      	        <a href="#">
       	      	           <div class="errorLeft d-table-cell">
       	      	              <h1 class="weight-300">404</h1>
       	      	              <h5 clas="weight-300">Whoops!</h5>
       	      	           </div>
       	      	           <div class="errorRight d-table-cell">
       	      	              <h3 class="weight-300">Oops! That page can&rsquo;t be found.</h3>
       	      	              <br />
       	      	              It looks like nothing was found at this location. Maybe try one of the links below or a search?
                            </div>
       	      	         </a>
       	    	      </div>
       	      	   </div>
               </div>
               
               <!-- -->
               
               <div class="col">
                  <? include_once "template/social.php" ?>
                  <? include_once "template/top-download.php" ?>
			             <? include_once "template/recently-update.php" ?>
			   </div>
            </div>
            
            <!-- -->
           
         </div>
         
      </div>
      
      <? include_once "template/footer.php" ?>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>
      
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>

   </body>
</html>