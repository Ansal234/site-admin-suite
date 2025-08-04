<!--
AUTHOR: ANSAL MUHAMMED
ASSIGNMENT 4 : LAB 4
STUDENT ID: 100881383
INFT2100
-->
<?php
$title = "Add Clients";
include "./includes/header.php";

if (!isset($_SESSION['user'])) 
{
    redirect("./sign-in.php");
}

$email = "";
$firstname = "";
$lastname = "";
$phone = "";
$extension = "";
$userid = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{   

    if(isset($_POST['emailaddress']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['phone']) && isset($_POST['userid']))
    {
        $logo = $_FILES['logo_path'];

        if (!isset($logo) || empty($logo['name'])) {
            setMessage("Please choose a logo to upload!");
            return;
        }

        $tmp_name = $logo["tmp_name"];
        $name = basename($logo["name"]);
        $path = "./images/".$name;

        if(!move_uploaded_file($tmp_name, $path)){
            setMessage("Something went wrong with upload!");
            return;
        }            

        $email = trim($_POST['emailaddress']);
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $phone = trim($_POST['phone']);
        $extension = trim($_POST['extension']);
        $userid = trim($_POST['userid']);

        $success = client_add($email, $firstname, $lastname, $phone, $extension, $userid, $path);

        if ($success) 
        {
            $email = "";
            $firstname = "";
            $lastname = "";
            $phone = "";
            $extension = "";
            $userid = "";
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

<form class="form-signin" method="post" action="clients.php" enctype="multipart/form-data">
    <h3 class="h3 mb-3 font-weight-normal">Add Clients</h3>
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
                "type" => "number",
                "name" => "extension",
                "value" => $extension,
                "label" => "Extension",
                "required" => ""
            )
        )
    ); 
    echo display_user_selection($userid);
    echo display_form(
        array(
            array(
                "type" => "file",
                "name" => "logo_path",
                "value" => "",
                "label" => "Logo",
                "required" => "required"
            )
        )
    );    
    ?>
    <button class="btn btn-lg btn-primary btn-block" type="Add">Add Client</button>
    <h5 class="mt-2 text-primary text-center"><?php echo getMessage();?></h5>
</form>

<?php
include "./includes/footer.php";
?>    