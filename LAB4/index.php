<!--
AUTHOR: ANSAL MUHAMMED
ASSIGNMENT 4 : LAB 4
STUDENT ID: 100881383
INFT2100
-->
<?php
$title = "Home";
include "./includes/header.php";
if (!isset($_SESSION['user'])) 
{
    redirect("./sign-in.php");
} 
else 
{
    if($_SESSION['user']['usertype'] == 's'){
        redirect("./clients-all.php");
    } else {
        redirect("./salespeople-all.php");
    }
}
?>

<h1 class="cover-heading">Home</h1>

<p class="lead"></p>
<p class="lead">
    <a href="#" class="btn btn-lg btn-secondary">Learn more</a>
</p>

<?php
include "./includes/footer.php";
?>    