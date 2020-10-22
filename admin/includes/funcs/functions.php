<?php
// function for dynamic title
function getTitle() {
    global $pageTitle;
    if (isset($pageTitle)){
        echo $pageTitle;
    } else {
        echo 'Default';
    }
}


// function for displaying proficient errors

function errorDisplay ($errors){
    echo "<div class='container'>";
    echo "<div class='row alert alert-danger'>";
    echo "<ul>";
    foreach ($errors as $error){
        echo "<li>" . $error . "</li>";
    }
    echo "</ul>";
    echo "</div>";
    echo "</div>";
}


// function for display success event
function successDisplay ($msg){
    echo "<div class='container'>";
    echo "<div class='row alert alert-success'>";
    echo '<h3>' . $msg . '</h3>';
    echo "</div>";
    echo "</div>";
}


function getUsersCount($atrr,$table){
    $connection = @mysqli_connect('localhost', 'root', '', 'shop');
    if(!$connection){
        echo 'you are not connected';
        exit();
    }
    $query = "SELECT COUNT($atrr) FROM $table";
    $result = mysqli_query($connection,$query);
    $row = $result->fetch_row();
    return $row[0];
}




?>
