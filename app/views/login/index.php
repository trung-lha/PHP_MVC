<!DOCTYPE html>
<html>

<head>
    <title>Mini-Project-PHP</title>
    <link rel="stylesheet" href="CSS/login.css">
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
    <?php
    session_start();
    //connection to server & database
    $conn = mysqli_connect('localhost', 'root', 'root', 'Mini_project_php') or die('Unable to connect');

    if (isset($_POST["login"])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql = "Select * from tb_student where Username ='$username' and Pass ='$password'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        if ($row) {
            $_SESSION["username"] = $row["Username"];
            if (!empty($_POST["remember"])) {
                setcookie("user_login", $_POST["username"], time() + (10 * 365 * 24 * 60 * 60));
                setcookie("userpassword", $_POST["password"], time() + (10 * 365 * 24 * 60 * 60));
            } else {
                if (isset($_COOKIE["user_login"])) {
                    setcookie("user_login", "");
                }
                if (isset($_COOKIE["userpassword"])) {
                    setcookie("userpassword", "");
                }
            }
            header('location:Views/home.php');
        } else {
            $message = "Invalid Login";
        }
    }

    ?>
</body>

</html>