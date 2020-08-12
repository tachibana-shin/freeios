<?php
   session_start();
   
   require_once "modules/sql_connect.php";
   include_once "lib/Parsedown.php";
   include_once "modules/replace-str.php";
   require_once __DIR__."/admin/modules/Auth.php";

   if ( isset($_GET["name"]) ) {
      $name = $_GET["name"];
      
      if ( isset($_GET["nospace"]) && $_GET["nospace"] == "1" ) {
          $name = str_replace("-", " ", str_replace(" ", "+", $name));
      };
      
      
      if ( !isset($_SESSION) || !isset($_SESSION["view-$name"]) ) {
          $_SESSION["view-$name"] = true;
          $sql -> query("update Apps set views = views + 1 where name = '$name'");
      } else
         $_SESSION["view-$name"] = true;
      
      $result = $sql -> query('select name, author, account, description, versions, timeupload, downloads, views from Apps where name="'.$name.'"');
      if ( $result -> num_rows > 0 ) {
         $app = $result -> fetch_array();
         $result -> free_result();
      };
   };
   
   if ( !isset($app) || !$app ) {
      include "404.php";
      exit;
   };
   
   // $app exiss
   
?>

<!DOCTYPE html>
<html>
    <head>
    	<?
    	   include_once "modules/render-meta.php";
		   echo renderMeta([
		   	  "title" => "Tải ".$app["name"]." miễn phí cho iOS - Free iOS",
			  "des" => Replace(strip_tags((new Parsedown()) -> text($app["description"]))),
              "icon" => "https://".$_SERVER["HTTP_HOST"]."/upload/".urlencode(urlencode($app["name"])).".png"
		   ]);
    	?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
		<!--link rel="stylesheet" href="https://nguyenthanh1995.github.io/lib/bootstrap.min.css">-->
		<link rel="stylesheet" href="https://nguyenthanh1995.github.io/lib/awesome pro/css/all.min.css">
		<link rel="stylesheet" href="/style.css">
		<script src="https://nguyenthanh1995.github.io/my-new.js"></script>
		<script src="https://nguyenthanh1995.github.io/lib/my-sticky.js"></script>
   </head>
   <body>
		<?php include "template/header.php" ?>
        <div class="main p-0 m-0">
            <? if ( $auth -> checkLogin() )
                  echo '
            <a href="/admin/edit/'.str_replace(" ", "-", stripslashes($app["name"])).'" class="no-a d-block p-3 bg-white"> <i class="fad fa-edit"></i> Chỉnh sửa </a>'; ?>
            <div class="main--header d-flex align-items-center">
                <div class="header__avatar">
                    <img class="header__avatar--icon bg-muted rounded border" src="/upload/<?= urlencode(urlencode($app["name"])) ?>.png">
                </div>
                
                <div class="header__name-author col">
                    <h1 class="app-title"> <?= stripslashes($app["name"]); ?> </h1>
                    
                    <h3 class="dev-title"> <i class="fad fa-at"></i><?= trim(stripslashes($app["author"])); ?> </h3>
                    <h5 class="app-update"> <i class="fad fa-calendar-alt"></i> <?= date("h:i d/m/Y", strtotime($app["timeupload"])); ?> </h5>
                    <h5 class="app-download d-flex">
                        <span class="col-6"> <i class="fad fa-arrow-alt-circle-down"></i> <?= $app["downloads"] ?> lượt tải về</span>
                        <span class="col-6"> <i class="fad fa-eye"></i> <?= $app["views"] ?> lượt xem </span>
                   </h5>
                </div>
            </div>
            
            <div class="mt-3">
                <div class="container-fluid">
                   <div class="row">
						<div class="col-12 col-lg-8 pt-30px">

							<div class="alert alert-danger text-center font-15px mb-4" id="alert--account-active">
<?php
	if ( !!$app["account"] ) {
		echo "Sử dụng tài khoản <strong> ".stripslashes($app['account'])."</strong> để kích hoạt";
	} else echo "Dành cho máy đã jailbreak và cài appsync";
?>
							</div>

							<div class="bg-white listWidget">
								<div class="tabs__custom--header border-bottom p-0 m-0">
									<ul class="nav nav-tabs m-0 p-0 d-flex">
 										<li class="nav-item col-6"> <a class="nav-link active" data-toggle="tab" href="#item-1"> MÔ TẢ </a></li>
										<li class="nav-item col-6"><a class="nav-link" data-toggle="tab" href="#item-2"> HƯỚNG DẪN </a></li>
 									</ul>
								</div>
								
								<div class="tab-content tabs__custom--body">

									<div class="tab-pane fade show active" id="item-1">
										<div class="render__markdown">
 <?= (new Parsedown()) -> text($app["description"]); ?>
										</div>

<?php
$html = '
<div class="pt-5 text-center">
	<a class="d-flex align-contents-center justify-content-center text-center no-a" style="line-height: 1.2em" href="#" data-toggle="modal" data-target="#tutorial-install">
		<svg viewBox="0 0 1024 1024" style="width: 1.2em; height: 1.2em; fill: #5c5c5c" class="mr-1">
			<path class="path1" d="M513.067 0c-282.667 0-512 230.4-512 510.933 0 284.8 229.333 513.067 512 513.067 281.6 0 510.933-228.267 510.933-513.067 1.067-280.533-229.333-510.933-510.933-510.933v0zM459.733 771.2l-275.2-195.2 57.6-84.267 194.133 136.533 257.067-358.4 83.2 58.667-316.8 442.667z"></path>
		</svg>
		<span class="text-secondary">
			Lấy tài khoản kích hoạt
		</span>
	</a>
 	<p class="text-center py-2"> Kéo xuống để xem các phiên bản mới hơn </p>
	<div class="dropdown m-0 p-0">
		<button class="btn btn-flat dropdown-toggle btn-raised rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #'.str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT).'; color: #fff">
       		<svg style="width: 24px; height: 24px; fill: currentColor" viewBox="0 0 1024 1024">
       			<path class="path1" d="M510.933 771.2l422.4-410.667h-236.8v-360.533h-362.667v360.533h-243.2l420.267 410.667zM90.667 1024h841.6v-123.733h-841.6v123.733z"></path>
       		</svg>
       		Chọn phiên bản
    	</button>
    	
    	<div class="dropdown-menu dropdown-menu-center">';
    			foreach ( unserialize($app["versions"]) as $ver => $url ) {
					$html .= '
						<a class="dropdown-item font-14px" href="/tiny/'.$url.'">'.$ver.'</a>
					';
				};
    		$html .= '
    	</div>
    </div>
</div>';
echo $html;
?>
									</div>
									<div class="tab-pane fade" id="item-2">
<div class="render__markdown">
 <?= Replace((new Parsedown()) -> text(file_get_contents("markdown/tutorial-install.md")), $_SERVER["HTTP_HOST"]); ?>
</div>
<?= $html; ?>
									</div>
								</div>
							</div>
					  </div>
					  
					  <!-- -->
					  
					  <div class="col">
					  		<?php include "template/social.php"; ?>
					  		<?php include "template/top-download.php"; ?>
					  </div>
					  
                   </div>
                </div>
            </div>
        </div>
		
		<div class="modal font-14px fade" id="tutorial-install">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body">
						<div class="render__markdown">
							<?= (new Parsedown()) -> text(file_get_contents("markdown/warning-no-login.md")); ?>
						</div>
						
						<div class="text-right">
							<button class="btn btn-secondary" data-dismiss="modal"> Go It </button>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<?php include "template/footer.php"; ?>

		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>

		<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>

<style>
.main .nav-item {
	 margin: 0 !important;
}
 .main .nav-link {
	 border: 0 !important;
	 font-size: 13px !important;
	 font-weight: 500 !important;
	 color: #6c757d !important;
	 display: inline-block;
	 width: 100%;
	 text-align: center;
	 padding: 12px 15px 12px 15px !important;
}
 .main .nav-link.active {
	 border-bottom: 2px solid #343a40 !important;
	 color: #343a40 !important;
}
 .main .tabs__custom--body > .tab-pane {
	 padding: 1.5rem 1rem 1.5rem 1rem;
	 font-size: 14px;
}
 .main .font-14px {
	 font-size: 14px;
}
 .main .text-weight-normal {
	 font-weight: initial !important;
}
</style>
    </body>
</html>