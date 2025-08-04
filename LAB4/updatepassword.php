<!--
AUTHOR: ANSAL MUHAMMED
ASSIGNMENT 4 : LAB 4
STUDENT ID: 100881383
INFT2100
-->
<?php
// Set title for dashboard
$title = "Update Password";
include "./includes/header.php";

if (!isset($_SESSION['user'])) 
{
    redirect("./sign-in.php?");
}

$password = "";
$confirm_password = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{   

    if(isset($_POST['password']) && isset($_POST['confirm_password']))
    {
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);

        if (empty($password) || empty($confirm_password)) {
            setMessage("Both fields are required!");
        } elseif (strlen($password) < 4) {
            setMessage("Passwords must be atleast 3 characters!");
        } elseif ($password !== $confirm_password) {
            setMessage("Passwords do not match!");
        } else {
            $success = update_password($_SESSION['user']['id'], $password);
            if ($success) 
            {
                $password = "";
                $confirm_password = "";
                setLogs("{$_SESSION['user']['emailaddress']} successfully updated password at " . date('Y-m-d H:i:s'));
                setMessage("Updated password successfully!");
            }
            else 
            {
                setLogs("{$_SESSION['user']['emailaddress']} failed updating password at " . date('Y-m-d H:i:s'));
                setMessage("Password update failed!");
            }
        }
    }

}

?>    

<form class="form-signin" method="post" action="updatepassword.php">
    <h3 class="h3 mb-3 font-weight-normal">Update Password</h3>
    <?php echo display_form(
        array(
            array(
                "type" => "password",
                "name" => "password",
                "value" => "",
                "label" => "New Password",
                "required" => "required"
            ),
            array(
                "type" => "password",
                "name" => "confirm_password",
                "value" => "",
                "label" => "Confirm Password",
                "required" => "required"
            )
        )
    ); ?>
    <button class="btn btn-lg btn-primary btn-block" type="Add">Update</button>
    <h5 class="mt-2 text-primary text-center"><?php echo getMessage();?></h5>
</form>

<?php
include "./includes/footer.php";
?>    