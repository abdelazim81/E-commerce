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
    echo "<div class='row alert alert-success success-msg'>";
    echo '<h3>' . $msg . '</h3>';
    echo "</div>";
    echo "</div>";
}

// function to get users count
function getItemsCount($atrr,$table){
   global $connection;
    $query = "SELECT COUNT($atrr) FROM $table";
    $result = mysqli_query($connection,$query);
    $row = $result->fetch_row();
    return $row[0];
}

// function to get latest
function getLatest($atrr,$table,$order,$limit=4){
    global $connection;
    $query = "SELECT $atrr FROM $table ORDER BY $order DESC LIMIT $limit ";
    $result = mysqli_query($connection, $query);
    if (!$result){
        errorDisplay(array('Cannot Get Latest'));
    }

    return $result;
}


// function to get categories
function getCategories () {
    $selectCatsQuery = "SELECT * FROM categories";
    global $connection;
    $result = mysqli_query($connection,$selectCatsQuery);
    if (! $result){
        errorDisplay(array("Can\'t Get Categories"));
        exit();
    }
    return $result;
}


// function to get categories
function getItems ($ConditionValue) {
    $selectItemsQuery = "SELECT * FROM `items` WHERE Cat_ID='$ConditionValue' ORDER BY Item_ID DESC";
    global $connection;
    $result = mysqli_query($connection,$selectItemsQuery);
    if (! $result){
        errorDisplay(array("Can\'t Get Items"));
        exit();
    }
    return $result;
}
?>
