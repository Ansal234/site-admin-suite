<!--
AUTHOR: ANSAL MUHAMMED
ASSIGNMENT 4 : LAB 4
STUDENT ID: 100881383
INFT2100
-->
<?php

//LOG ERRORS ON BROWSER

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$title = "Login";
include "./includes/header.php";

if (isset($_SESSION['user'])) 
{
    redirect("./index.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST['inputEmail']) && isset($_POST['inputPassword']))
    {
        $email = trim($_POST['inputEmail']);
        $password = trim($_POST['inputPassword']);
        $user = user_authenticate($email, $password);

        if ($user) 
        {
            if($user["isactive"] == 1){
                $_SESSION['user'] = $user;

                setLogs("{$user['emailaddress']} successfully logged in at " . date('Y-m-d H:i:s'));
                setMessage("You have successfully logged in!");
    
                if($user["usertype"] == 's'){
                    redirect("./clients-all.php");
                } else {
                    redirect("./salespeople-all.php");
                }
            } else {
                setLogs("$email failed to log in at - Account Inactive " . date('Y-m-d H:i:s'));
                setMessage("Login Failed - Account Inactive");
            }
        }
        else 
        {
            setLogs("$email failed to log in at " . date('Y-m-d H:i:s'));
            setMessage("Login Failed");
        }

    }

}

?>   

<form class="form-signin" method="post" action="sign-in.php">
    <h3 class="h3 mb-3 font-weight-normal">Please sign in</h3>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email Address" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    <a href="./reset.php" class="d-block text-primary text-center mt-2">Reset Password?</a>
    <h5 class="mt-2 text-primary text-center"><?php echo getMessage();?></h5>
</form>


<?php
include "./includes/footer.php";
?>    