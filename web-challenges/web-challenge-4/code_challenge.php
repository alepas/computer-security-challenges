<?php
require_once('config.php');
?>

<!doctype html>
<html lang="en">
<head>
    <title>Insecure Password Strength Meter</title>
    <link href="bootstrap.min.css" rel="stylesheet">
    <link href="custom.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<?php

function filter($str) {
    $str = preg_replace('/<\w+.*?>/', '', $str);
    $str = str_replace('\'', '', $str);
    $str = str_replace('"', '', $str);
    $str = str_replace('`', '', $str);
    $str = str_replace('&', '', $str);
    $str = str_replace(';', '', $str);
    $str = str_replace('%', '', $str);
    $str = str_replace('$', '', $str);
    if (strpos(strtolower($str), 'script') !== false) {
        die("Hackerz!!!");
    }
    if (strpos(strtolower($str), 'img') != false) {
        die("Hackerz!!!");
    }
    if (strpos(strtolower($str), 'img') != false) {
        die("Hackerz!!!");
    }
    if (strpos(strtolower($str), 'onload') != false) {
        die("Hackerz!!!");
    }
    if (strpos(strtolower($str), 'onerror') != false) {
        die("Hackerz!!!");
    }
    return $str;
}

class PasswordStrength {
    public $strength;
    public $error;
    public $success;

    function __construct($password) {
        $this->success = false;
        try {
            $this->strength = $this->compute_strength($password);
            $this->success = true;
        } catch (Exception $e) {
            $this->error = $e->getMessage();
        }
    }

    function compute_strength($password) {
        $num = 0;
        $chr_lower = 0;
        $chr_upper = 0;
        $spe = 0;
        $repeat = 0;

        $length = strlen($password);

        for($i=0; $i<$length; $i++) {
            $char = ord($password[$i]);
            if($char >= ord('0') && $char <= ord('9')) {
                $num++;
            } else if($char >= ord('A') && $char <= ord('Z')) {
                $chr_upper++;
            } else if($char >= ord('a') && $char <= ord('z')) {
                $chr_lower++;
            } else {
                $spe++;
            }
            if($i < $length - 1) {
                if($password[$i] == $password[$i + 1]) {
                    $repeat++;
                }
            }
        }

        if($length <= 0 || $chr_upper < 2 || $chr_lower < 2 || $num < 2) {
            throw new Exception("Warning: the password " . $password . " does not fullfill the minimum requirements.");
        }

        $strength = $length * 4 + ($length - $chr_lower) * 2 + ($length - $chr_upper) * 2 + $num * 4 + $spe * 6;
        if ($spe == 0 && $num == 0) {
            $strength = $strength - $length;
        }
        if ($chr_lower == 0 && $chr_upper == 0 && $spe == 0) {
            $strength = $strength - $length;
        }
        $strength = $strength - 4 * $repeat;
        return $strength;
    }

}

if(isset($_REQUEST['q'])) {
    $result = new PasswordStrength($_REQUEST['q']);
}

?>

<div class="container">
    <?php if(isset($result->error)) { ?>
    <div id="feedback" class="alert alert-warning">
        <?php echo filter($result->error); ?>
    </div>
    <?php } ?>

    <?php if($result->success) { ?>
    <div id="feedback" class="alert alert-warning">
        <?php echo "Your password's strength is " . $result->strength . "!"; ?>
    </div>
    <?php } ?>

    <h1>Insecure Password Strength Meter</h1>

    <form method="get" id="passstrenght_form" class="form-horizontal">
        <div class="form-group">
            <div class="col-sm-11">
                <input type="password" class="form-control" name="q" id="q">
            </div>
        </div>
        <button id="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>
