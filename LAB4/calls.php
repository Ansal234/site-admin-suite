<!--
AUTHOR: ANSAL MUHAMMED
ASSIGNMENT 4 : LAB 4
STUDENT ID: 100881383
INFT2100
-->
<?php
$title = "Add Calls";
include "./includes/header.php";

if (!isset($_SESSION['user'])) 
{
    redirect("./sign-in.php");
}

$clientid = "";
$notes = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{   

    if(isset($_POST['userid']))
    {
        $notes = trim($_POST['notes']);
        $clientid = trim($_POST['userid']);

        $success = call_add($clientid, $notes);

        if ($success) 
        {
            $notes = "";
            setLogs("Call added successfully at " . date('Y-m-d H:i:s'));
            setMessage("Added successfully!");
        }
        else 
        {
            setLogs("Call add failed at " . date('Y-m-d H:i:s'));
            setMessage("Oops something went wrong!");
        }

    }

}

?>    

<form class="form-signin" method="post" action="calls.php">
    <h3 class="h3 mb-3 font-weight-normal">Add Calls</h3>
    <?php echo display_form(
        array(
            array(
                "type" => "text",
                "name" => "notes",
                "value" => $notes,
                "label" => "Notes",
                "required" => ""
            )
        )
    ); 
    echo display_client_selection($clientid);    
    ?>
    <button class="btn btn-lg btn-primary btn-block" type="Add">Add Call</button>
    <h5 class="mt-2 text-primary text-center"><?php echo getMessage();?></h5>
</form>

<?php
include "./includes/footer.php";
?>    