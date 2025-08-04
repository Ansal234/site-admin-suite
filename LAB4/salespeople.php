<!--
AUTHOR: ANSAL MUHAMMED
ASSIGNMENT 4 : LAB 4
STUDENT ID: 100881383
INFT2100
-->
<?php
$title = "Add Salespeople";
include "./includes/header.php";

if (!isset($_SESSION['user'])) 
{
    redirect("./sign-in.php");
}

$email = "";
$password = "";
$firstname = "";
$lastname = "";
$phone = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{   

    if(isset($_POST['emailaddress']) && isset($_POST['password']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['phone']))
    {
        $email = trim($_POST['emailaddress']);
        $password = trim($_POST['password']);
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $phone = trim($_POST['phone']);

        $success = user_add($email, $password, $firstname, $lastname, $phone);

        if ($success) 
        {
            $email = "";
            $password = "";
            $firstname = "";
            $lastname = "";
            $phone = "";
            setLogs("{$email} successfully created at " . date('Y-m-d H:i:s'));
            setMessage("Added successfully!");
        }
        else 
        {
            setLogs("{$email} already registered and tried to register again at " . date('Y-m-d H:i:s'));
            setMessage("{$email} already registered!");
        }

    }

}

?>    

<form class="form-signin" method="post" action="salespeople.php">
    <h3 class="h3 mb-3 font-weight-normal">Add Sales People</h3>
    <?php echo display_form(
        array(
            array(
                "type" => "text",
                "name" => "firstname",
                "value" => $firstname,
                "label" => "First Name",
                "required" => "required"
            ),
            array(
                "type" => "text",
                "name" => "lastname",
                "value" => $lastname,
                "label" => "Last Name",
                "required" => "required"
            ),
            array(
                "type" => "email",
                "name" => "emailaddress",
                "value" => $email,
                "label" => "Email",
                "required" => "required"
            ),
            array(
                "type" => "number",
                "name" => "phone",
                "value" => $phone,
                "label" => "Phone",
                "required" => "required"
            ),
            array(
                "type" => "password",
                "name" => "password",
                "value" => "",
                "label" => "Password",
                "required" => "required"
            )
        )
    ); ?>
    <button class="btn btn-lg btn-primary btn-block" type="Add">Add Sales People</button>
    <h5 class="mt-2 text-primary text-center"><?php echo getMessage();?></h5>
</form>

<?php
include "./includes/footer.php";
?>    