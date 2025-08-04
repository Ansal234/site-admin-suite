<!--
AUTHOR: ANSAL MUHAMMED
ASSIGNMENT 4 : LAB 4
STUDENT ID: 100881383
INFT2100
-->
<?php
/*
Logout: for resetting session.

*/
include "./includes/header.php";

    if(isset($_SESSION['user']))
    {
        $user = $_SESSION['user']['emailaddress'];
        $lastAccess = $_SESSION['user']['lastaccess'];
        setLogs("{$user} successfully logged out at {$lastAccess}");

        session_unset();
        session_destroy();
        session_start();
        setMessage("Logout successful");
        redirect("./sign-in.php");

    }
    else
    {
        setMessage("You're currently not logged in");
        redirect("./sign-in.php");
    }



?>   


   