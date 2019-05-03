<?php

require_once 'config.php';

//This function takes the input insert into the 2 fields and decode it.
//This means that both username and password must be encoded in order to be accepted and correcly decoded before the SQL query.
function get_value($str) {
    return base64_decode($str);
}

//This function is foundamental because it contains the vulnerability. 
function login($username, $password) {
    global $db;
    $query = "SELECT user_id FROM users WHERE username='$username' and password='$password'";
    $result = mysqli_query($db, $query);
    if ($result && (mysqli_num_rows($result)>0)) {
            return TRUE;
    }
    return FALSE;
}

$username  = get_value($_POST['username']);
$password  = get_value($_POST['password']);

//NB. Both field must be not empty
if(empty($username) || empty($password)) {
    $alert = "Please insert your credentials!";
    $login_ok = FALSE;
} else {
    $login_ok = login($username, $password);
    if(!$login_ok) {
        $alert = "Wrong username or password!";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>Little Bobby Tables</title>
    <link href="bootstrap.min.css" rel="stylesheet">
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="container" style="max-width: 600px; margin-top: 2em;">

    <?php if($alert !== NULL && trim($alert) !== ""); { ?>
    <div class="alert alert-danger"><?php echo $alert; ?></div>
    <?php } ?>


    <?php if($login_ok === TRUE) { ?>
        <h1>Hi <?php echo htmlentities($username); ?>! You are logged in!</h1>
        <h2>We have some secret information ready for you...</h2>
        <p>Here it is: <b><?php echo htmlentities(get_secret($username)); ?></b></p>
        <img style='width: 100%' src='exploits_of_a_mom.png'>
    <?php } ?>

    <?php if($login_ok != TRUE) { ?>
        <h1 style="text-align: center;">Access Restricted</h1>
        <form method="post" id="login_form" class="form-horizontal" style="max-width: 75%; margin: 0 auto;">
            <div class="form-group">
                <label for="name">Name: </label>
                <input type="text" name="username" class="form-control">
            </div>
            <div class="form-group">
                <label for="name">Password: </label>
                <input type="password" name="password" class="form-control">
            </div>
            <input type="submit" value="Login" class="btn btn-primary" style="display: block; margin: 0 auto; min-width: 50%">
        </form>
    <?php } ?>

    <script type="text/javascript" src="formutils.js"></script>

</div>
</body>
</html>