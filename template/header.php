<nav class="navbar navbar-expand-lg navbar-dark justify-content-start py-1 py-sm-2 header" style="background-color: hsl(<?= $p=rand(0, 360) ?>, 50%, 50%)">
   <div class="navbar-toggler border-0 header__collapse--btn-open">
      <span class="navbar-toggler-icon small"></span>
   </div>

   <a class="navbar-brand d-lg-none" href="/">
       Free iOS
   </a>
   
   <span class="navbar-brand header__search--item d-flex d-none d-lg-flex order-lg-last header__search--item-pr-input">
       <span style="margin: 0 .75rem">
           <i class="fas fa-search"></i>
       </span>
       <input class="rounded-0 form-control bg-0 border-0" placeholder="Tìm kiếm">
   </span>

   <span class="navbar-brand align-self-end align-self-xl-start ml-auto ml-xl-0 header__search--btn d-lg-none">
       <i class="fas fa-search"></i>
   </span>

   <span class="navbar-brand align-self-end header__search--item d-none d-lg-none header__search--btn-close ml-auto" style="margin: 0 .75rem">
      <i class="fas fa-times"></i>
   </span>

   <div class="collapse navbar-collapse" id="navbar-collapse">
      <ul class="navbar-nav pl-3">
         <li class="nav-item pt-lt-lg-3 align-self-lg-center pr-lg-3">
            <h5 class="weight-300 text-lg-secondary" href="/"> <img src="https://<?= $_SERVER["HTTP_HOST"]; ?>/AppIcon.png" style="max-width: 100%; max-height: 2.5em"> <span class="d-lg-none"> Free iOS </span> </h5>
         </li>
         <?php
            $itemsNavBar = [
               [
                  "href" => "/category/iPA",
                  "text" => '<i class="fab fa-itunes"></i> iPA'
               ], [
                  "href" => "/category/Apps",
                  "text" => '<i class="fab fa-app-store"></i> Apps'
               ], [
                  "href" => "/category/Games",
                  "text" => '<i class="fad fa-gamepad"></i> Games'
               ], [
                  "href" => "/category/jailbreak",
                  "text" => '<i class="fad fa-toolbox"></i>  Jailbreak'
               ], [
                  "href" => "/tutorial/",
                  "text" => '<i class="fad fa-lightbulb-on"></i> Hướng dẫn'
               ], [
                  "href" => "/rules/",
                  "text" => '<i class="fad fa-file-alt"></i> Nội quy'
               ], [
                  "href" => "/faqs/",
                  "text" => '<i class="fad fa-question-circle"></i> FAQs'
               ], [
                   "href" => "/id/",
                   "text" => '<i class="fad fa-quidditch"></i> Tài khoản'
               ], [
                  "href" => "/install.mobileconfig",
                  "text" => '<i class="fas fa-file-download"></i> Cài đặt'
               ], [
                  "href" => "/change-log",
                  "text" => '<i class="fas fa-history"></i> Change log'
               ]
            ];
            foreach ( $itemsNavBar as $value )
               echo "
                  <li class='nav-item'> <a class='nav-link' href='${value['href']}'> ${value['text']} </a> </li>
               "
         ?>
      </ul>
   </div>
</nav>

<style>

.header input:placeholder {
   color: #f8f9fa !important;
}
.header input::-webkit-input-placeholder {
   color: #f8f9fa !important;
}
.header input::-moz-placeholder {
   color: #f8f9fa !important; 
}
.header input:-ms-input-placeholder {
   color: #f8f9fa !important; 
}
.header input:-moz-placeholder {
   color: #f8f9fa !important; 
}
.header input {
   color: #f8f9fa !important
}
.header input:focus {
   outline: none;
   border: 0;
   box-shadow: none;
}
.header .navbar-toggler-icon {
   background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 30 30'%3e%3cpath stroke='rgb%28255, 255, 255%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
}

.header .nav-item i {
   margin-right: 5px;
   width: 1.5em;
   font-size: 1.35em;
   text-align: center;
}

.header .header__search--item.d-none {
    display: none !important;
}

body .header__navbar-collapse--backdrop {
   position: fixed;
   top: 0; left: 0;
   height: 100%; width: 100%;
   z-index: 1023;
   background-color: #000;
   transition: opacity .15s linear;
   opacity: 0;
   display: none;
}
body .header__navbar-collapse--backdrop.show {
   display: block;
}

body .header__navbar-collapse--backdrop.active {
   opacity: .5;
}

@media (max-width: 319px) {
    .header .navbar-collapse {
        width: 80% !important;
    }
}

@media (max-width: 991px) {
   .header .navbar-collapse {
      position: fixed !important;
      overflow-x: none;
      overflow-y: auto;
      overflow-scrolling: touch !important;
      overflow-style: autohiding-scrollbar !important;
      z-index: 1024;
      top: 0;
      left: 0;
      background-color: #f8f9fa;
      display: none;
      transition: transform 0.25s linear;
      height: 100%;
      width: 300px
   }
   
   .header .navbar-collapse.show {
      display: block;
   }
   
   .header .navbar-collapse .nav-item {
      padding-top: 0.1rem;
      padding-bottom: 0.1rem
   }
   .header .nav-item a {
      color: #6c757d !important;
   }
   
   .pt-lt-lg-3 {
       padding-top: 1rem !important;
   }
   
   
   .header .header__search--item-pr-input input  {
      padding-top: 0 !important;
      padding-bottom: 0 !important;
      min-height: 100% !important;
      line-height: 1 !important;
   }
   
}

@media (min-width: 992px) {
    
    .header .header__search--item.d-lg-flex {
         display: flex !important;
    }
    .navbar-dark .text-lg-secondary {
        color: rgba(255, 255, 255, .9) !important;
    }
    
    .navbar-collapse {
        max-width: 66.66667% !important;
        flex-basis: 66.666667% !important;
        padding-right: 1rem !important;
    }
    
    .header .navbar-brand.header__search--item-pr-input {
        background-color: rgba(255, 255, 255, .2) !important;
        height: 40px !important;
        line-height: 40px !important;
        padding: 0 15px 0 15px !important;
        flex-basis: 0 !important;
        flex-grow: 1 !important;
        min-width: 0% !important;
        max-width: 100% !important;
    }
    
    .header .navbar-brand.header__search--item-pr-input > * {
        margin: 0 !important;
        
    }
    
    .header .navbar-brand.header__search--item-pr-input > input {
        flex-basis: 0 !important;
        flex-grow: 1 !important;
        min-width: 0% !important;
        max-width: 100% !important;
    }
}
</style>

<script>

my(".header__search--btn").click(() => {
   my(".navbar.header").child().each((index, el) => {
      el = my(el)
      if ( el.hasClass("header__search--item") ) {
         el.removeClass("d-none")
      } else {
         el.addClass("d-none")
      }
   })
})

my(".header__search--btn-close").click(() => {
   my(".navbar.header").child().each((index, el) => {
        el = my(el)
      if ( el.hasClass("header__search--item") ) {
         el.addClass("d-none")
      } else {
         el.removeClass("d-none")
      }
   })
   my(".header__search--item > input").val("")
})

my(".header__search--item > input").keyup(e => {
   if ( e.which == 13 || e.keyCode == 13 ) {
      window.open("/?q=" + encodeURIComponent(e.target.value), "_self")
   }
   
})

	my(".header__collapse--btn-open").click((e) => {
		let item = my(e.target)
		let target = my("#navbar-collapse")

        let backdrop = my(".header__navbar-collapse--backdrop")

        if ( backdrop.length > 0 )
            backdrop.addClass("show")
        else
            backdrop = my('<div class="header__navbar-collapse--backdrop show">')
           .appendTo("body")

		target.css(my.prefix("transform"), "translateX(-100%)")
		
		target.addClass("show")

		setTimeout(() => {
		 target.css(my.prefix("transform"), "")
		 backdrop.addClass("active")
		})
		
	    backdrop.click(e => {
	       //if ( e.srcElement != backdrop && e.targetElement != backdrop && e.target != backdrop ) return
           target.css(my.prefix("transform"), "translateX(-100%)")
	       .one(my.fx.transitionEnd, () => {
	          target.removeClass("show")
	          target.css(my.prefix("transform"), "")
	          
	       })
	       
	       if ( target.css(my.prefix("transition-duration")) == "0s" ) {
	          target.trigger(my.fx.transitionEnd)
	       }
	       
	       backdrop.remove()
	       
       })
    })
    
</script>