<!--
AUTHOR: ANSAL MUHAMMED
ASSIGNMENT 4 : LAB 4
STUDENT ID: 100881383
INFT2100
-->
<?php
// Define functions

// Redirect user to a specified URL
function redirect ($url){
    header("Location:".$url);
    ob_flush();
    exit();
}

// Sets a message in the user's session
function setMessage($msg)
{
    $_SESSION['message'] = $msg;
}


function getMessage()
{
    if (isset($_SESSION['message'])) 
    {

        $returnmessage = $_SESSION['message'];
        unset($_SESSION['message']);
        return $returnmessage;

    } else 
    {
        return ""; 
    }
}


function isMessage()
{
    return isset($_SESSION['message'])?true:false;
}

function removeMessage()
{
    unset($_SESSION['message']);
}

function flashMessage()
{
    $message = isset($_SESSION['message'])?$_SESSION['message']:"";
}

function setLogs($logmessage)
{
    $datecode = date("Ymd");
    $file = fopen("./{$datecode}_Logs.txt", "a");
    fwrite($file, $logmessage . "\n");
    fclose($file);
}

function generateResetToken() {
    return bin2hex(random_bytes(32));
}

function display_form($elements) {
    $html = '';
    $attributes = '';
    foreach ($elements as $element) {
        if($element["type"] == "file"){
            $attributes .= ' accept="image/*"';
        }
        $html .= '<label for="'.$element["name"].'">'.$element["label"].'</label>';
        $html .= '<input type="'.$element["type"].'" id="'.$element["name"].'" value="'.$element["value"].'" name="'.$element["name"].'" class="form-control" placeholder="'.$element["label"].'" '.$element["required"].$attributes.'>';
    }
    return $html;
}

function display_client_selection($selectedClientIdValue){
    $clients = clients_for_dropdown();
    $html = generate_dropdown($clients,$selectedClientIdValue);       
    return $html;
}

function display_user_selection($selectedUserIdValue){
    $html = '';
    if(isset($_SESSION['user'])){
        if($_SESSION['user']['usertype'] == 's'){
            $html .= '<input type="hidden" value="'.$_SESSION['user']['id'].'" name="userid">';
        } else {
            $users = users_for_dropdown();
            $html .= generate_dropdown($users,$selectedUserIdValue);            
        }
    }
    return $html;
}

function generate_dropdown($users,$selectedUserIdValue){
    $html = '';
    $html .= '<label for="userid">Select User</label>';
    $html .= '<select id="userid" name="userid" required class="form-control">';
    foreach ($users as $user) :
        $html .= '<option '.($selectedUserIdValue == $user["id"]?"selected":"").' value="'.$user['id'].'">'.$user['firstname'].' '.$user['lastname'].'</option>';
    endforeach;
    $html .= '</select>';
    return $html;
}

function display_table($fieldNames, $records, $totalRecords, $currentpage) {
    $html = '<table class="table table-striped table-sm">';
        $html .= '<thead>';
            $html .= '<tr>';
                foreach ($fieldNames as $fieldName) {
                    $html .= '<th>' . $fieldName . '</th>';
                }
            $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
    foreach ($records as $record) {
            $html .= '<tr>';
                foreach ($record as $key => $value) {
                    if(str_contains($value,'./images/')){
                        $html .= '<td><img class="logo" src="' . $value. '"></td>';
                    } else if(strtolower($key) === "isactive"){
                        $html .= '<td>';
                            $html .= '<form method="post" action="./salespeople-all.php">';
                                $html .= '<div class="form-check">';
                                    $html .= '<input class="form-check-input" type="radio" name="active['.$record["id"].']" id="Active-'.$record["id"].'" value="Active" ' . ($value === '1' ? 'checked' : '') . '>';
                                    $html .= '<label class="form-check-label" for="Active-'.$record["id"].'">Active</label>';
                                $html .= '</div>';
                                $html .= '<div class="form-check mt-1">';
                                    $html .= '<input class="form-check-input" type="radio" name="active['.$record["id"].']" id="Inactive-'.$record["id"].'" value="Inactive" ' . ($value === '0' ? 'checked' : '') . '>';
                                    $html .= '<label class="form-check-label" for="Inactive-'.$record["id"].'">Inactive</label>';
                                $html .= '</div>';
                                $html .= '<button class="btn btn-sm btn-primary btn-block mt-2" type="submit">Update</button>';
                            $html .= '</form>';
                        $html .= '</td>';                        
                    } else {
                        $html .= '<td>' . $value . '</td>';
                    }                    
                }
            $html .= '</tr>';
    }
        $html .= '</tbody>';
    $html .= '</table>';

    $lastPage = ceil($totalRecords / RECORDS_PER_PAGE);
    if(($currentpage + 1) > $lastPage){
        return $html;
    }

    $html .= '<nav aria-label="Page navigation">';
    $html .= '<ul class="pagination">';
        if(($currentpage - 1) >= 0){
            $html .= '<li class="page-item"><a class="page-link" href="salespeople-all.php?page='.$currentpage.'">Previous</a></li>';
        }
        if(($currentpage + 1) != $lastPage){
            $html .= '<li class="page-item"><a class="page-link" href="salespeople-all.php?page='.($currentpage + 2).'">Next</a></li>';
        }
    $html .= '</ul>';
    $html .= '</nav>';
    
    return $html;
}

?>