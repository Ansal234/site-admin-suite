<!--
AUTHOR: ANSAL MUHAMMED
ASSIGNMENT 4 : LAB 4
STUDENT ID: 100881383
INFT2100
-->
<?php

$title = "Reset Password";
include "./includes/header.php";

if (isset($_SESSION['user'])) 
{
    redirect("./index.php");
} 

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST['inputEmail']))
    {
        $email = trim($_POST['inputEmail']);
        $user = user_select($email);

        if ($user) 
        {
            $resetToken = generateResetToken();
            $name = $user["firstname"]." ".$user["lastname"];

            $to = $email;
            $subject = 'Password Reset Request';
            $message = "Dear $name,\n\nA password reset has been requested for your account. If you did not request this, please ignore this email.\n\nReset Token: $resetToken\n\nSincerely,\nANSAL MUHAMMED";
            $logMessage = "To: $to\nSubject: $subject\n$message\n\n";

            // send mail function to called here

            setLogs("Successfully sent reset email to $email at " . date('Y-m-d H:i:s'));
            setLogs($logMessage);

            setMessage("Logged Successfully Sent Reset Email!");
        }
        else 
        {
            setLogs("$email password reset failed - email doesn't exist at " . date('Y-m-d H:i:s'));
            setMessage("No User With Email $email Exists!");
        }

    }

}

?>   

<form class="form-signin" method="post" action="./reset.php">
    <h3 class="h3 mb-3 font-weight-normal">Reset Password</h3>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email Address" required autofocus>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Continue</button>
    <h5 class="mt-2 text-primary text-center"><?php echo getMessage();?></h5>
</form>


<?php
include "./includes/footer.php";
?>    