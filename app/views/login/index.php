<!DOCTYPE html>
<html>

<head>
    <title>Mini-Project-PHP</title>
    <link rel="stylesheet" href="http://localhost:8888/PHP_MVC/app/public/CSS/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <div align="center" style="margin-top: 10%">
        <form action="http://localhost:8888/PHP_MVC/login-validate" method="post" id="login">
            <div class="error-message"><?php if (isset($message)) {
                                            echo $message;
                                        } ?></div>
            <h4>Please login</h4>
            <div class="field-group">
                <div><label for="login">Username</label></div>
                <div>
                    <input required name="username" type="text" value="<?php if (isset($_COOKIE["user_login"])) {
                                                                            echo $_COOKIE["user_login"];
                                                                        } ?>" class="input-field">
                </div>
                <div class="field-group">
                    <div><label for="password">Password</label></div>
                    <div><input required name="password" type="password" value="<?php if (isset($_COOKIE["userpassword"])) {
                                                                                    echo $_COOKIE["userpassword"];
                                                                                } ?>" class="input-field">
                    </div>
                    <div class="field-group">
                        <div><input type="checkbox" name="remember" id="remember" <?php if (isset($_COOKIE["user_login"])) { ?> checked <?php } ?> />
                            <label for="remember-me">Remember me</label>
                        </div>
                        <div class="field-group">
                            <div><input type="submit" name="login" value="Login" class="form-submit-button"></span></div>
                        </div>
        </form>
    </div>

</body>

</html>