<div class="container bg-light text-center py-3">
   <div class="row">
      <div class="col-12">
         <span class="text-uppercase text-secondary">
            Vui lòng thực hiện yêu cầu xác thực bên dưới để chuyển sang trang đích.
         </span>
         <form method="post" class="text-center">
      			<div class="g-recaptcha" data-sitekey="<?php echo $siteKey;?>"></div>
      			<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=<?php echo $lang;?>"></script><br/>
				<button type="submit" class="mt-3 btn btn-primary"> Bấm vào đây để tiếp tục </button>
         </form>
      </div>
   </div>
</div>
<style>
.text-color-main {
    color: var(--primary) !important
}

</style>