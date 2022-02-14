<?php

class adminLogin{
    private $connection;

    public function __construct()
    {
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $dbname = "ecom-php";

        $this->connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

        if(!$this->connection){
            die("Database connection error");
        }
    }

    function adminLogin($data){
        $admin_email = $data['admin_email'];
        $admin_pass = md5($data['admin_pass']);

        $query = "SELECT * FROM adminlog WHERE admin_email='$admin_email' AND admin_pass='$admin_pass'";

        if (mysqli_query($this->connection, $query)){
            $result = mysqli_query($this->connection, $query);
            $admin_info = mysqli_fetch_assoc($result);

            if ($admin_info){
                header('location:dashboard.php');
                session_start();
                $_SESSION['id'] = $admin_info['id'];
                $_SESSION['admin_email'] = $admin_info['admin_email'];
            }else{
                $errormsg = "You username or password is incorrect.";
                return $errormsg;
            }
        }
    }

    function adminLogout(){
        unset($_SESSION['id']);
        unset($_SESSION['admin_email']);

        header('location:index.php');
    }
}