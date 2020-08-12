<?php
function renderMeta($arr) {
  
  if ( !isset($arr["icon"]) || !$arr["icon"] ) {
      $arr["icon"] = "https://".$_SERVER["HTTP_HOST"]."/AppIcon.png";
  };
  
  echo '
     <title>'.$arr["title"].'</title>
     <meta property="og:locale" content="vi_VN">
     <meta property="og:type" content="article">
     <meta property="og:title" content="'.$arr["title"].'">
     <meta property="og:description" content="'.$arr["des"].'">
     <meta property="og:url" content="https://'.$_SERVER["HTTP_HOST"]."/".$_SERVER["REQUEST_URI"].'">
     <meta property="og:site_name" content="Free iOS">
     <meta property="article:publisher" content="https://www.facebook.com/CydiaVietHoa/">
     <meta property="og:image" content="'.$arr["icon"].'">
     <meta property="og:image:secure_url" content="'.$arr["icon"].'">
     <meta name="twitter:card" content="summary_large_image">
     <meta name="twitter:description" content="'.$arr["des"].'">
     <meta name="twitter:title" content="'.$arr["title"].'">
     <meta name="twitter:image" content="'.$arr["icon"].'">';
}
?>