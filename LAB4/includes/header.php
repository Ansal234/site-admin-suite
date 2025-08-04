<!--
AUTHOR: ANSAL MUHAMMED
ASSIGNMENT 4 : LAB 4
STUDENT ID: 100881383
INFT2100
-->
<!doctype html>
<html lang="en">
  <head>
    <?php
    /*
       Initialize PHP session, output buffering, and include necessary files.

    */
        session_start();
        ob_start();
        require("./includes/constants.php");
        require("./includes/db.php");
        require("./includes/functions.php");

        flashMessage();

        $url = explode('/', $_SERVER['REQUEST_URI']);

    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title><?php //echo $title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/styles.css?v=<?php echo date('Y-m-d H:i:s');?>" rel="stylesheet">
	
  </head>
  <body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">
            <?php if(isset($_SESSION['user'])){
                echo $_SESSION['user']['firstname'].' '.$_SESSION['user']['lastname'];
            } else {
                echo "Welcome";
            } 
            ?>
        </a>
        <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap d-flex">
            <?php
            if(isset($_SESSION['user']))
            {
                echo '<a class="nav-link ml-2" href="./logout.php">Log out</a>';
            }
            else
            {
             echo '<a class="nav-link ml-2" href="./sign-in.php">Log in</a>';
            }?>
        </li>
        </ul>
    </nav>
    <div class="container-fluid">
      <div class="row">
        
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
            <ul class="nav flex-column">
            <?php
            if(isset($_SESSION['user'])){               
                if($_SESSION['user']['usertype'] === 'a'){
                    echo '<li class="nav-item">
                        <a class="nav-link '.(end($url) == "salespeople.php"?"active":"").'" href="./salespeople.php">
                            <span data-feather="home"></span>
                            Sales People <span class="sr-only">(current)</span>
                        </a>
                    </li>';
                    echo '<li class="nav-item">
                        <a class="nav-link '.(end($url) == "salespeople-all.php"?"active":"").'" href="./salespeople-all.php">
                            <span data-feather="home"></span>
                            View Sales People <span class="sr-only">(current)</span>
                        </a>
                    </li>';
                }                
                echo '<li class="nav-item">
                <a class="nav-link '.(end($url) == "clients.php"?"active":"").'" href="./clients.php">
                    <span data-feather="home"></span>
                    Clients <span class="sr-only">(current)</span>
                </a>
                </li>';
                echo '<li class="nav-item">
                <a class="nav-link '.(end($url) == "clients-all.php"?"active":"").'" href="./clients-all.php">
                    <span data-feather="home"></span>
                    View Clients <span class="sr-only">(current)</span>
                    </a>
                </li>';                            
                echo '<li class="nav-item">
                    <a class="nav-link '.(end($url) == "calls.php"?"active":"").'" href="./calls.php">
                        <span data-feather="home"></span>
                        Calls <span class="sr-only">(current)</span>
                    </a>
                </li>';
                echo '<li class="nav-item">
                <a class="nav-link '.(end($url) == "calls-all.php"?"active":"").'" href="./calls-all.php">
                    <span data-feather="home"></span>
                    View Calls <span class="sr-only">(current)</span>
                    </a>
                </li>';    
                echo '<li class="nav-item">
                <a class="nav-link '.(end($url) == "updatepassword.php"?"active":"").'" href="./updatepassword.php">
                    <span data-feather="home"></span>
                    Update Password <span class="sr-only">(current)</span>
                    </a>
                </li>';
            }     
            ?>           

                <!-- <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file"></span>
                    Orders
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="shopping-cart"></span>
                    Products
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="users"></span>
                    Customers
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="bar-chart-2"></span>
                    Reports
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="layers"></span>
                    Integrations
                </a>
                </li> -->
            </ul>
            </div>
        </nav>

        <main class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
          <div class="d-flex justify-content-between flex-wrap align-items-center pb-2 mb-3 border-bottom">