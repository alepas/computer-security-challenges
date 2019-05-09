<?php

require_once '../sessions.inc.php';
require_once '../config.inc.php';

$page = $_GET['p'];

if(isset($_COOKIE['s'])) {
    $user = check_session();
}

// page: home, login
if(!isset($_GET['p'])) {
    $page = 'home';
}

if($user === NULL) {
    $page = 'login';
}

if($page === 'login' && isset($_POST['login'])) {
    $u = login($_POST['username'], $_POST['password']);
    if($u) {
        set_session($u);
        header('Location: /tokenapp.php');
        die();
    } else {
        $alert = 'Login error';
    }
}

if($page === 'login' && isset($_POST['register'])) {
    if(register($_POST['username'], $_POST['password'])) {
        $alert = 'Registered successfully';
    } else {
        $alert = 'Registration error';
    }
}

// Tip!
// Look at this: https://secure.php.net/manual/en/wrappers.php.php
// and then look at this: https://secure.php.net/manual/en/filters.php
require($page . '.inc.php');

?>
