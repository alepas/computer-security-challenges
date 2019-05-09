<!doctype html>
<html lang="en">
<head>
    <title>Login or Register</title>
    <link href="bootstrap.min.css" rel="stylesheet">
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="container" style="max-width: 600px; margin-top: 2em;">

    <?php if(!empty(trim($alert))) { ?>
        <div class="alert alert-danger"><?php echo $alert; ?></div>
    <?php } ?>

    <h1 style="text-align: center;">Welcome!</h1>
    <form method="post" id="login_form" class="form-horizontal" style="max-width: 75%; margin: 0 auto;">
        <div class="form-group">
            <label for="name">Name: </label>
            <input type="text" name="username" class="form-control">
        </div>
        <div class="form-group">
            <label for="name">Password: </label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="form-group">
            <input type="submit" name="login" value="Login" class="btn btn-primary" style="display: block; margin: 0 auto; min-width: 50%">
        </div>
        <div class="form-group">
            <input type="submit" name="register" value="Register" class="btn btn-primary" style="display: block; margin: 0 auto; min-width: 50%">
        </div>
    </form>

</div>
</body>
</html>
