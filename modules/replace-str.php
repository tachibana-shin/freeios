<?php
function Replace($str) {
   return str_replace("%WEB", $_SERVER["HTTP_HOST"], $str);
}

?>