<?php
    session_start();
    if(!isset($_SESSION["login_error"])){
        $_SESSION["login_error"] = "";
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/login/style.css">
</head>

<body>
    <div class="login">
        <figure>
            <img src="./bglogin.jpg" alt="" class="bg_body">
        </figure>

        <div class="login__inner">
            <h1 align="center" class="title">Login Form</h1>
            <form action="login__action.php" method="post" name="f" onsubmit="return check()">
                <div class="form___group">
                    <div class="container">
                        <label for="username" class="label_user label_form">Username</label>
                        <input type="text" id="username" class="input_form input__username" placeholder="Username"
                            name="txtusername">
                    </div>
                </div>
                <div class="form___group">
                    <div class="container">
                        <label for="password" class="label__password label_form">Password</label>
                        <input type="password" id="password" class="input_form input__password" placeholder="Password"
                            name="txtpassword">
                    </div>
                    <p class="text__error">
                         <?php echo $_SESSION["login_error"]?>
                    </p>
                </div>
                <div class="control">
                    <div class="container">
                        <div class="control__btn">
                            <button type="submit" class="btn__form btn__submit">Sign in</button>
                            <a href="./signup.php" class="btn__form btn__signup">Sign up</a>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function check() {
            if (f.txtusername.value == "") {
                alert("Bạn chưa nhập Username");
                f.txtusername.focus();
                return false;
            }
            else if (f.txtpassword.value == "") {
                alert("Bạn chưa nhập Password");
                f.txtpassword.focus();
                return false;
            }
        }
    </script>
</body>
 <?php $_SESSION["login_error"]=""?> 

</html>