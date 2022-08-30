<?php
function checkUsername($username) {
    $username = trim($username);
    if (empty($username)) {
        return "username was left blank.";
    }else if (strlen($username) < 4) {
        return "username was too short";
    }else if (strlen($username) > 26) {
        return "username was too long";
    }else if (!preg_match('~^[a-z]{2}~i', $username)) {
        return "username must start with two letters";
    }else if (preg_match('~[^a-z0-9_.]+~i', $username)) {
        return "username contains invalid characters.";
    }else if (substr_count($username, ".") > 1) {
        return "username may only contain one or less periods.";
    }else if (substr_count($username, "_") > 1) {
        return "username may only contain one or less underscores.";
    }else{
        return true;
    }
} 

function checkName($name) {
    $name = trim($name);
    if (empty($name)) {
        return "Name was left blank.";
    }else if (strlen($name) > 26) {
        return "Name was too long";
    }else if (preg_match('~[^a-z0-9_.]+~i', $name)) {
        return "Name contains invalid characters.";
    }else if (substr_count($name, "_") > 1) {
        return "Name may only contain one or less underscores.";
    }else{
        return true;
    }
} 

function checkPassword($password) {
    $password = trim($password);
    if (empty($password)) {
        return "Password was left blank.";
    }else if (strlen($password) < 8) {
        return "Password was too short";
    }else if (strlen($password) > 26) {
        return "Password was too long";
    }else if (!preg_match('~[^a-z0-9_.]+~i', $password)) {
        return "Password must contains special characters.";
    }else{
        return true;
    }
} 
?>