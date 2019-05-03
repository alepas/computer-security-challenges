<?php
require_once 'filters.php';
require_once 'config.php';
?>
<!doctype html>
<html lang="en">
<head>
    <title>Inception</title>
    <link href="bootstrap.min.css" rel="stylesheet">
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="container" style="max-width: 600px; margin-top: 2em;">
<?php
$user = filter($_REQUEST['user']);
$pwd = filter($_REQUEST['pwd']);
$register = $_REQUEST['register'];

$logged_in = FALSE;
if(!empty($user) && !empty($pwd)) {
    if(isset($register)) {
        register_user($user, $pwd);
    } else {
        $logged_in = login_user($user, $pwd);
    }
}

function login_user($user, $pwd) {
    global $vuln_db;
    // We store the password in plaintext to keep the homework's code short.
    // For anything even remotely real, use a proper password storage scheme.
    $query = "SELECT user_id FROM users WHERE username=? and password=?";
    $statement = mysqli_prepare($vuln_db, $query);
    mysqli_stmt_bind_param($statement, 'ss', $user, $pwd);
    mysqli_stmt_bind_result($statement, $user_id);
    if (!mysqli_stmt_execute($statement)) {
        echo '<div class="alert alert-danger">An error occurred</div>';
        return FALSE;
    }
    if (mysqli_stmt_fetch($statement)) {
        echo '<h1>Hello ' . htmlentities($user) . '!</h1>';
        echo '<img src="img2.jpg" style="max-width: 100%;display: block; margin: 1em auto;">';
        return TRUE;
    }
    echo '<div class="alert alert-danger">Sorry, invalid username or password</div>';
    return FALSE;
}

function register_user($user, $pwd) {
    global $vuln_db;
    $query = "SELECT username FROM users WHERE username='$user'";
    $result = mysqli_query($vuln_db, $query);
    if(!$result) {
        echo '<div class="alert alert-danger">Error retrieving the user</div>';
        return FALSE;
    }
    if($result && mysqli_num_rows($result) == 1) {
        $row = $result->fetch_assoc();
        $u = htmlentities($row["username"]);
        echo '<div class="alert alert-warning"><b>Bad news! </b>The user ' . $u . ' already exists!</div>';
        return FALSE;
    }
    $query = "INSERT INTO users (username, password) VALUES ('$user', '$pwd')";
    $result = mysqli_query($vuln_db, $query);
    if(!$result) {
        echo '<div class="alert alert-danger">Error inserting a user</div>';
        return FALSE;
    } else {
        echo '<div class="alert alert-success"><b>Yay! </b>User ' . htmlentities($user) . ' registered successfully!</div>';
        return TRUE;
    }
}

if(!$logged_in) {
?>
    <h1 style="text-align: center;">Inception</h1>
    <img src="img1.jpg" style="max-width: 100%" class="img-rounded">
    <form method="post" id="login_form" class="form-horizontal" style="max-width: 75%; margin: 1em auto;">
        <div class="form-group">
            <label for="name">Name: </label>
            <input type="text" name="user" class="form-control">
        </div>
        <div class="form-group">
            <label for="name">Password: </label>
            <input type="password" name="pwd" class="form-control">
        </div>
        <input type="submit" value="login" name="login" class="btn btn-primary">
        <input type="submit" value="register" name="register" class="btn">
    </form>
</div>
<?php
}
?>
</body>
</html>