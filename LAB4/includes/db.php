<!--
AUTHOR: ANSAL MUHAMMED
ASSIGNMENT 4 : LAB 4
STUDENT ID: 100881383
INFT2100
-->

<?php

function db_connect()
{
    return pg_connect("host=".DB_HOST." port=".DB_PORT." dbname=".DATABASE." user=".DB_ADMIN." password=".DB_PASSWORD);
}

function users_for_dropdown(){
    $users = [];
    $conn = db_connect();
    $query = "SELECT Id, FirstName, LastName FROM users_table WHERE UserType = 's'";
    $result = pg_query($conn, $query);
    while ($row = pg_fetch_assoc($result)) {
        $users[] = $row;
    }
    return $users;
}

function clients_for_dropdown(){
    $clients = [];
    $conn = db_connect();
    $query = "SELECT ClientId AS Id, FirstName, LastName FROM clients";
    $result = pg_query($conn, $query);
    while ($row = pg_fetch_assoc($result)) {
        $clients[] = $row;
    }
    return $clients;
}

function user_select($email)
{
    $conn = db_connect();
    $stmt = pg_prepare($conn, 'user_get', "SELECT * FROM users_table WHERE emailaddress = $1");
    $result = pg_execute($conn, 'user_get', array($email));
    $user = pg_fetch_assoc($result);

    pg_close($conn);

    return $user;

}

function user_select_all($current_page)
{
    $offset = $current_page * RECORDS_PER_PAGE;

    $conn = db_connect();
    $stmt = pg_prepare($conn, 'user_select_all', "SELECT Id, FirstName, LastName, Phone, EmailAddress, LastAccess, EnrollDate, IsActive FROM users_table WHERE UserType = 's' LIMIT $1 OFFSET $2");
    $result = pg_execute($conn, 'user_select_all', array(RECORDS_PER_PAGE, $offset));

    $users = array();
    while ($row = pg_fetch_assoc($result)) {
        $users[] = $row;
    }

    pg_close($conn);

    return $users;
}

function client_select($email)
{
    $conn = db_connect();
    $stmt = pg_prepare($conn, 'client_get', "SELECT * FROM clients WHERE emailaddress = $1");
    $result = pg_execute($conn, 'client_get', array($email));
    $client = pg_fetch_assoc($result);

    pg_close($conn);

    return $client;

}

function client_select_all($current_page)
{
    $offset = $current_page * RECORDS_PER_PAGE;
    $condition = ""; 

    if ($_SESSION['user']['usertype'] == "s") {
        $condition = "WHERE UsersId = ".$_SESSION['user']['id'];
    }

    $conn = db_connect();
    $stmt = pg_prepare($conn, 'client_select_all', "SELECT ClientId, LogoPath, FirstName, LastName, PhoneNumber, Extension, EmailAddress, EnrollDate FROM clients $condition LIMIT $1 OFFSET $2");
    $result = pg_execute($conn, 'client_select_all', array(RECORDS_PER_PAGE, $offset));

    $clients = array();
    while ($row = pg_fetch_assoc($result)) {
        $clients[] = $row;
    }

    pg_close($conn);

    return $clients;
}

function user_authenticate($email, $plain_password)
{
    $user = user_select($email);

    if ($user && password_verify($plain_password, $user['password']))
    {
        $conn = db_connect();
        $time = date('Y-m-d H:i:s');
        $stmt = pg_prepare($conn, 'lastlogin_update', "UPDATE users_table SET lastaccess = $1 WHERE id = $2");
        pg_execute($conn,'lastlogin_update', array($time,$user["id"]));
        $user['lastaccess'] = $time;
    }
    else
    {
        return false;
    }

    pg_close($conn);
    return $user;
}

function user_add($email, $password, $firstname, $lastname, $phone)
{
    $user = user_select($email);

    if (!$user)
    {
        $conn = db_connect();
        $time = date('Y-m-d H:i:s');
        $stmt = pg_prepare($conn, 'user_add', "INSERT INTO users_table (EmailAddress, Password, FirstName, LastName, LastAccess, EnrollDate, Phone, UserType) VALUES (
            $1, $2, $3, $4, NULL, $5, $6, 's')");
        pg_execute($conn,'user_add', array($email,password_hash($password,PASSWORD_BCRYPT),$firstname,$lastname,$time,$phone));
        pg_close($conn);

        return true;
    }

    return false;
}

function client_add($email, $firstname, $lastname, $phone, $extension, $userid, $logoPath)
{
    $client = client_select($email);

    if (!$client)
    {
        $conn = db_connect();
        $time = date('Y-m-d H:i:s');
        $stmt = pg_prepare($conn, 'client_add', "INSERT INTO clients (EmailAddress, FirstName, LastName, PhoneNumber, Extension, EnrollDate, UsersId, LogoPath) VALUES (
            $1, $2, $3, $4, $5, $6, $7, $8)");
        pg_execute($conn,'client_add', array($email,$firstname,$lastname,$phone,$extension,$time,$userid,$logoPath));
        pg_close($conn);

        return true;
    }

    return false;
}

function call_add($clientid, $notes)
{
    $conn = db_connect();
    $time = date('Y-m-d H:i:s');
    $stmt = pg_prepare($conn, 'call_add', "INSERT INTO calls (Notes, CalledOn, ClientsId) VALUES (
        $1, $2, $3)");
    $result = pg_execute($conn,'call_add', array($notes,$time,$clientid));
    pg_close($conn);

    if($result){
        return true;
    }

    return false;
}

function call_select_all($current_page)
{
    $offset = $current_page * RECORDS_PER_PAGE;

    $condition = ""; 

    if ($_SESSION['user']['usertype'] == "s") {
        $subquery = "SELECT ClientId FROM Clients WHERE UsersId = ".$_SESSION['user']['id'];
        $condition = "WHERE ClientsId IN ($subquery)";
    }

    $conn = db_connect();
    $stmt = pg_prepare($conn, 'call_select_all', "SELECT CallId, CalledOn, Notes FROM Calls $condition LIMIT $1 OFFSET $2");
    $result = pg_execute($conn, 'call_select_all', array(RECORDS_PER_PAGE, $offset));

    $calls = array();
    while ($row = pg_fetch_assoc($result)) {
        $calls[] = $row;
    }

    pg_close($conn);

    return $calls;
}

function update_password($userid, $password) 
{
    $conn = db_connect();
    $stmt = pg_prepare($conn, "user_update_password", "UPDATE users_table SET Password = $1 WHERE Id = $2");
    $result = pg_execute($conn, "user_update_password", array(password_hash($password, PASSWORD_DEFAULT), $userid));
    pg_close($conn);

    if($result){
        return true;
    }

    return false;
}

function update_active_status($userid, $active) 
{
    $conn = db_connect();
    $stmt = pg_prepare($conn, "update_active_status", "UPDATE users_table SET IsActive = $1 WHERE Id = $2");
    $result = pg_execute($conn, "update_active_status", array($active === "Active"?1:0 , $userid));
    pg_close($conn);

    if($result){
        return true;
    }

    return false;
}


function client_count() {
    
    $conn = db_connect();
    $result = pg_query($conn, "SELECT COUNT(*) FROM Clients");
    $row = pg_fetch_row($result);

    pg_close($conn);

    return $row[0];
}

function user_count() {
    
    $conn = db_connect();
    $result = pg_query($conn, "SELECT COUNT(*) FROM users_table WHERE UserType = 's'");
    $row = pg_fetch_row($result);

    pg_close($conn);

    return $row[0];
}

function call_count() {
    
    $conn = db_connect();
    $result = pg_query($conn, "SELECT COUNT(*) FROM Calls");
    $row = pg_fetch_row($result);

    pg_close($conn);

    return $row[0];
}

?>
