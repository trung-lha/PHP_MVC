<?php
class User extends Controller
{

    protected $modelUser;

    function __construct()
    {
        $this->modelUser = $this->model("UserModel");
    }

    public function index()
    {

        $data = [123, 412];
        $this->render('login/index', $data);
    }

    public function handleLogin()
    {

        if (isset($_POST['username'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
        }
        $all = $this->modelUser->buildQueryParams([
            "select" => "*",
            "where" => "",
        ])->selectAll();
        $check = 0;
        foreach ($all as $key => $value) {
            if (strcmp($username, $value['Username']) == 0 && strcmp($password, $value['Pass']) == 0) {
                $check = 1;
            }
        }
        if ($check == 1) {
            $_SESSION["username"] =  $username;
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
            header('location:http://localhost:8888/PHP_MVC/san-pham');
        } else {
            $message = "Invalid Login";
        }
    }
}
