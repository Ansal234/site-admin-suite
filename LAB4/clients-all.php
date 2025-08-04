<!--
AUTHOR: ANSAL MUHAMMED
ASSIGNMENT 4 : LAB 4
STUDENT ID: 100881383
INFT2100
-->
<?php
$title = "Dashboard";
include "./includes/header.php";

if (!isset($_SESSION['user'])) 
{
   redirect("./sign-in.php");
}

$page = 1;
if (isset($_GET['page'])) 
{
    $page = $_GET['page'];
}

$fieldNames = array(
    'clientid' => 'Client ID',
    'logopath' => 'Logo',
    'firstname' => 'First Name',
    'lastname' => 'Last Name',
    'phonenumber' => 'Phone Number',
    'extension' => 'Extension',
    'emailaddress' => 'Email Address',
    'enrolldate' => 'Enroll Date'
);

?>
<div>
    <h1 class="h2">Clients</h1>
    <h3 class="text-muted">Your Clients</h3>
    <h5 class="text-primary"><?php echo getMessage();?></h5>
</div>       

<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group mr-2">
        <button class="btn btn-sm btn-outline-secondary">Share</button>
        <button class="btn btn-sm btn-outline-secondary">Export</button>
    </div>
    <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
        <span data-feather="calendar"></span>
        This week
    </button>
</div>

<div class="table-responsive mt-4">
    <?php
        echo display_table(
            $fieldNames,
            client_select_all($page - 1),
            client_count(),
            $page - 1
        );
    ?>
</div>
<?php
include "./includes/footer.php";
?>    