<?php

require_once('../sessions.inc.php');

?>

<!doctype html>
<html lang="en">
<head>
    <title>Reserved Area</title>
    <link href="bootstrap.min.css" rel="stylesheet">
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="container" style="max-width: 600px; margin-top: 2em;">

    <h1>Welcome, <?php echo $user->username; ?>!</h1>
    <?php if($user->role === 'admin') {?>
        <h2>Access Token</h2>
        <p>Your access token is: <?php echo get_secret($user->username); ?></p>
    <?php } else { ?>
    <p>Your role does not allow you to retrieve access tokens</p>
    <p>Please ask your supervisor to enable you.</p>
    <?php } ?>

    <p><a href="/?p=login">Log in as a different user</a></p>

</div>
</body>
</html>
