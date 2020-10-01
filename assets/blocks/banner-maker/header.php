<?php

// User agent
require_once 'includes/Mobile_Detect.php';
$detect     = new Mobile_Detect;
$isDevice   = false;

if ($detect->isMobile() || $detect->isTablet()){
    $isDevice = true; 
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        
        <link rel="icon" type="image/png" href="img/climate-justice.png" />
        <title>Banner maker app | Greenpeace</title>


        <!-- Fonts -->
        <!--<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700,400italic' rel='stylesheet' type='text/css'>-->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

        <!-- links -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/bm-main.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="<?php echo $isDevice ? 'is-device' : '' ?>">