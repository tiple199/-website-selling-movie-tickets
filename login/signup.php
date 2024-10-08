<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/login/stylesignup.css">
</head>

<body>
    <div class="login">
        <figure>
            <img src="./IMG_8850 (1).jpg" alt="" class="bg_body">
        </figure>

        <div class="login__inner">
            <h1 align="center" class="title">Register Form</h1>
            <p class="text__error">
                <% response.Write(session("login_error")) %>
            </p>
            <form action="signup__action.asp" method="post" name="f" onsubmit="return check()">
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

                </div>
                <div class="form___group">
                    <div class="container">
                        <label for="address" class=" label_form">Address</label>
                        <input type="text" id="address" class="input_form input__address" placeholder="Address"
                            name="txtaddress">
                    </div>

                </div>
                <div class="form___group">
                    <div class="container">
                        <label for="email" class=" label_form">Email</label>
                        <input type="email" id="email" class="input_form input__email" placeholder="Email"
                            name="txtemail">
                    </div>

                </div>
                <div class="form___group">
                    <div class="container">
                        <label for="phone" class=" label_form">Phone</label>
                        <input type="tel" id="phone" class="input_form input__phone" placeholder="Phone"
                            name="txtphone">
                    </div>

                </div>
                <div class="control">
                    <div class="container">
                        <div class="control__btn">
                            <button type="submit" class="btn__form btn__submit">Sign Up</button>
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
            else if (f.txtaddress.value == "") {
                alert("Bạn chưa nhập Address");
                f.txtaddress.focus();
                return false;
            }
            else if (f.txtemail.value == "") {
                alert("Bạn chưa nhập Email");
                f.txtemail.focus();
                return false;
            }
            else if (f.txtphone.value == "") {
                alert("Bạn chưa nhập Phone");
                f.txtphone.focus();
                return false;
            }
        }
    </script>
</body>
<%
    session("login_error") = ""
%>
</html>