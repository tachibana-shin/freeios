<?php
class Paginator {
   public $count = 1;
   public $page = 5;
   public $classItem = "";
   public $classActive = "active";
   private $html = "";
   private function resetHtml() {
      $this -> html = '
      <ul class="pagination pagination-sm justify-content-center flex-wrap">
         <li class="page-item '.$this -> classItem.'"> <a class="page-link a-global border-0" href="?page=1"> &laquo; </a> </li>
      ';
   }
   public function __construct() {
      
   }
   private function renderItem($text, $link) {
      $this -> html .= '
      <li class="page-item '.($text == $this -> page ? ' '.($this -> classActive) : '').'"> <a class="page-link '.$this -> classItem.' border-0" href="'.$link.'">'.$text.'</a></li>';
   }
   public function render() {
   
      $this -> resetHtml();
      
      $countRows = $this -> count;
      $page = $this -> page;
   
      $start = $page - 2;
      $end = $page + 2;
   
      if ( $start < 1 ) $start = 1;
      if ( $end > $countRows ) $end = $countRows;
   
      $roundDozenFirst = [];
      $roundDozenLast = [];
   
      $item = floor( $page / 10 );
      
      if ( $page % 10 == 0 )
         $item--;
   
      while ( $item * 10 >= 10 ) {
         array_unshift($roundDozenFirst, $item);
         $item--;
      };
   
      $item = floor( $page / 10 ) + 1;
   
      while ( $item * 10 <= $countRows ) {
         array_push($roundDozenLast, $item);
         $item++;
      };
   
      if ( (count($roundDozenFirst) > 0 && $start - $roundDozenFirst[0] * 10 > 1) || ( $start > 1 ) ) {
         $this -> renderItem("...", "#");
      }
   
      foreach ( $roundDozenFirst as $value ) {
         $this -> renderItem($value * 10, "?page=".($value * 10));
      };
   
      if ( count($roundDozenFirst) > 0 && $start - $roundDozenFirst[count($roundDozenFirst) - 1] * 10 > 1) {
         $this -> renderItem("...", "#");
      };
   
      for ( $i = $start; $i < $page; $i++ ) {
         $this -> renderItem($i, "?page=$i");
      };
      for ( $i = $page; $i <= $end; $i++ ) {
         $this -> renderItem($i, "?page=$i");
      };
   
      if ( count($roundDozenLast) > 0 && $roundDozenLast[0] * 10 - $end > 1 ) {
         $this -> renderItem("...", "#");
      };
   
      foreach ( $roundDozenLast as $value ) {
         $this -> renderItem($value * 10, "?page".($value * 10));
      };
   
      if ( count($roundDozenLast) > 0 && $roundDozenLast[count($roundDozenLast) - 1] * 10 < $countRows ) {
         $this -> renderItem("...", "#");
      }
   
      return ($this -> html).'<li class="page-item"> <a class="page-link a-global border-0" href="?page='.$countRows.'"> &raquo; </a></li></ul>';
   }
}
?>