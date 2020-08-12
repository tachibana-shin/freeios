<?php
    require_once __DIR__."/modules/Auth.php";
    
    if ( isset($_POST["submit"]) && isset($_POST["username"]) && isset($_POST["password"]) ) {
       
        $mess = $auth -> login($_POST["username"], $_POST["password"]);
           
    }
    if ( $auth -> checkLogin() ) {
        header("Location: ".(isset($_GET["goto"]) ? $_GET["goto"] : "/admin"));
        die();
    }
    //echo ($auth -> signUp("thanhbanh1995", "admin", "thanhbanh"));
    //echo $auth -> login("thanhbanh1995", "thanhbanh");
    //print_r($_COOKIE);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Page Title</title>
        <link rel="stylesheet" href="https://nguyenthanh1995.github.io/lib/awesome pro/css/all.min.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

    </head>
    <body>
        <div id="app" class="container__login">
            <form method="post" class="wrap__login--body">
                
                <span class="wrap__login--body-avatar">
                    <i class="fas fa-user"></i>
                </span>
                <h1 class="wrap__login--body-title">
                    Log in
                </h1>
                
                <?= isset($mess) && !$mess ? '<p class="text-light text-center mb-3">
                    Tên đăng nhập hoặc mật khẩu không đúng
                </p>' : "" ?>
                
                <div class="wrap__login--input-group">
                    <input class="input" placeholder="Username" required name="username">
                    <span class="icon"> <i class="fas fa-user"></i> </span>
                    <span class="progress"></span>
                </div>
                <div class="wrap__login--input-group">
                    <input class="input" placeholder="Password" required name="password" type="password">
                    <span class="icon"> <i class="fas fa-lock"></i> </span>
                    <span class="progress"></span>
                </div>
                <div class="wrap__login--input-checkbox">
                    <input type="checkbox" class="input">
                    <label> Remember me </label>
                </div>
                
                <div class="wrap__login--input-btn">
                    <button class="button" name="submit" type="submit"> Login </button>
                </div>
                
                <div class="wrap__login--forgot text-center">
                    Forgot Password?
                </div>
            </form>
        </div>
        
        <style>

* {
    margin: 0;
    padding: 0;
}
body {
    background-image: url("https://colorlib.com/etc/lf/Login_v3/images/bg-01.jpg");
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
}

.container__login {
    background-color: rgba(255, 255, 255, .9);
    padding: 15px;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.wrap__login--body {
    background-color: #9152f8;
    background: -webkit-linear-gradient(top, #7579ff, #b224ef);
    padding: 55px 55px 37px 55px;
    border-radius: 10px;
    min-width: 50%;
}

.wrap__login--body-avatar {
    background-color: #fff;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    left: 0; right: 0;
    margin: auto;
    font-size: 60px;
}

.wrap__login--body-title {
    padding-top: 27px;
    padding-bottom: 34px;
    font-size: 30px;
    text-transform: uppercase;
    text-align: center;
    color: #fff;
}




/* ========= Input customs ========= */

.wrap__login--input-group {
    width: 100%;
    position: relative;
    border-bottom: 2px solid rgba(255, 255, 255, 0.24);
    margin-bottom: 30px;
    display: flex;
    height: 45px;
    width: 100%;
}
.wrap__login--input-group > .progress {
    position: absolute;
    width: 0;
    height: 2px;
    left: 0;
    bottom: -2px;
    background-color: #fff;
    transition: all 0.4s;
}

.wrap__login--input-group > .icon {
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
    width: 45px;
    height: 45px;
    order: 0;
    transition: all 0.4s;
}
.wrap__login--input-group > .input {
    display: inline-block;
    flex-basis: 1;
    min-width: 0%;
    max-width: 100%;
    height: 100%;
    order: 1;
    background-color: transparent;
    -webkit-appearance: none;
    border: 0;
    border-radius: 0;
    color: #fff;
    outline: none;
}
.wrap__login--input-group > .input::-webkit-input-placeholder {
    color:  #fff;
    
}

.wrap__login--input-group > .input:focus + .icon,
.wrap__login--input-group > .input:valid + .icon {
    font-size: 14px;
    transform: translateY(-50%);
}
.wrap__login--input-group > .input:focus::-webkit-input-placeholder,
.wrap__login--input-group > .input:valid::-webkit-input-placeholder {
    color: transparent;
}
.wrap__login--input-group > .input:focus ~ .progress,
.wrap__login--input-group > .input:valid ~ .progress {
    width: 100%;
}


@media (max-width: 576px) {
    .wrap__login--body {
        padding: 55px 15px 37px 15px;
    }
}




/* ======= Checkbox  ======== */

.wrap__login--input-checkbox {
    color: #fff;
}
.wrap__login--input-checkbox > .input {
    border-radius: 50%;
    background-color: #fff;
    border: 0;
    position: relative;
    margin-bottom: 30px;
}

.wrap__login--input-checkbox > .input::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background-color: #fff;
}
.wrap__login--input-checkbox > .input::after {
    content: "";
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
    display: inline-block;
    position: absolute;
    width: 60%;
    height: 60%;
    border-radius: 50%;
    background-color: transparent;
    transition: all 0.2s;
}
.wrap__login--input-checkbox > .input:checked::after {
    background-color: #7579ff;
}



/* =========== Button ============ */

.wrap__login--input-btn {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
}
.wrap__login--input-btn > .button {
    padding: 0 20px;
    min-width: 120px;
    height: 50px;
    border-radius: 25px;
    text-align: center;
    background-color: #fff;
    transition: all 0.4s;
    outline: none;
    border: 0;
    font-size: 120%;
    text-transform: uppercase;
    transition: all 0.2s;
}
.wrap__login--input-btn > .button:hover {
    background-color: #952f8;
    color: #fff;
    background: -webkit-linear-gradient(bottom, #7579ff, #b224ef);
}



.wrap__login--forgot {
    padding-top: 90px;
    color: #e5e5e5;
    font-size: 13px;
}

        </style>
    </body>
</html>