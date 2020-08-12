<?
   session_start();
   require_once "modules/sql_connect.php";
   $STATUS = 0;

   function createHash( $time ) {
      global $_SERVER;
   
      return md5($_SERVER["HTTP_USER_AGENT"].$_SERVER["REMOTE_ADDR"].$time);
   }


   if ( isset($_POST["submit"]) ) {
   
      $time = $_SERVER["REQUEST_TIME"];
   
      $_SESSION["_"] = $time;
  
      header("Location: /id/$time");

      die();
   }

   if ( isset($_GET["_"]) ) {
      if ( isset($_SESSION["_"]) && isset($_GET["_"]) && createHash($_SESSION["_"]) == createHash($_GET["_"]) )
         $STATUS = 1;
      else $STATUS = 2;
   };
   
   session_unset();
   session_destroy();
   
   if ( $STATUS == 1 ) {
       if ( ! ($sql -> query("select * from AccountActive")) ) {
           $sql -> query("create table AccountActive (
                 id tinytext not null,
                 password tinytext not null,
                 hide tinyint(1) default 0
              )");
            echo $sql -> error;
       };
       
       // exists Table  AccountActive
       
       $result = $sql -> query("select id, password from AccountActive where hide = 0");
       echo $sql -> error;
       $ID_ACTIVE = [];
       if ( $result -> num_rows > 0 ) {
           while ( $row = $result -> fetch_array())
              array_push($ID_ACTIVE, $row);
       }
       
       $result -> free_result();
   };
?>

<!doctype html>
<html>
   <head>
   
  	  <?php
  		 include "modules/render-meta.php";
 		 renderMeta($STATUS == 0 || $STATUS == 1 ? [
   			"title" => "Tài khoản - Free iOS",
   			"des" => "Tài khoản mở khóa các ứng dụng cho Free iOS."
   		 ] : [
   		     "title" => "Địa chỉ không tồn tại - Free iOS",
   		     "des" => "Lỗi này xảy ra khi bạn cố gắng tái sử dụng liên kết. Điều này là không được phép để tránh kẻ xấu lợi dụng lấy cắp dữ liệu."
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
                  <div class="p-15px bg-white px-3 listWidget">
                     <div class="m-0 p-0 my-2">
						 <p class="small"> <b>Lưu ý:</b> Nghiêm cấm tuyệt đối việc đăng nhập tài khoản trên vào iCloud, chúng tôi sẽ không chịu trách nhiệm nếu bạn đăng nhập vào iCloud. </p>
						 
						 <?php
						 
	if ( $STATUS == 0 )
		echo  "
			<form method='post' class='text-center'>
				<button class='btn btn-primary' type='submit' name='submit'> Xem tài khoản </button>
			</form>
		";
	else if ( $STATUS == 1 ) {
		if ( !isset($ID_ACTIVE) || count($ID_ACTIVE) == 0 )
		   echo "<p class='text-secondary'> Không tìm thấy gì trong DB. </p>";
		else {
		    echo "<table>";
		    echo "
		       <tr>
		          <th> Tài khoản </th>
		          <th> Mật khẩu </th>
		       </tr>
		    ";
		    foreach ( $ID_ACTIVE as $value ) {
		        echo "<tr>";
		           echo "<td>".$value["id"]."</td>";
		           echo "<td>".$value["password"]."</td>";
		        echo "</tr>";
		    }
		    echo "</table>";
		}
	}
	else echo "<h2 class='text-center'>Token đã hết hạn. Vui lòng quay lại trang chủ và thử lại.</h2>";
						 
						 ?>
						 
                     </div>
                  </div>
               </div>
               
               <!-- -->
               
               <div class="col">
                  <? include "template/social.php" ?>
               	  <? include "template/top-download.php" ?>
               </div>
               
               <!-- -->
               
            </div>
            
            <!-- -->
           
         </div>
         
      </div>
      
      <?php include "template/footer.php" ?>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>
      
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>

	<style>
	table {
		margin: 0 auto;
		width: 100%;
		text-align: center;
	}
	
	tr {
		border-top: 1px solid #ccc;
		background-color: #fff;
	}
	
	th {
		text-align: inherit;
		border: 1px solid #ddd;
		padding: 6px 13px;
	}
	
	td {
		border: 1px solid #ddd;
		padding: 6px 13px;
	}
	</style>
   </body>
</html>