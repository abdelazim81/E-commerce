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