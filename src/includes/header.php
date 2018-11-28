<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Learnosity Demos</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo $env['www'] ?>static/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo $env['www'] ?>static/dist/all.min.css?<?php echo $assetVersion ?>">
    <script src="<?php echo $env['www'] ?>static/dist/all.min.js?<?php echo $assetVersion ?>"></script>
</head>
<body>
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-M2HXW6"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-M2HXW6');</script>
<!-- End Google Tag Manager -->

<?php
    // Show alert if not being used form localhost
    if (strpos($_SERVER['SERVER_NAME'], '.learnosity.com') === false && $_SERVER['SERVER_NAME'] !== 'localhost') {
        echo '<div class="container alert alert-warning"><p><b>Warning</b> – ' .
            'Note: Most demos will only work from <em>localhost</em>. Please ' .
            'contact support@learnosity.com to get an additional domain added.</p></div>';
    }

    include_once 'nav.php';
?>

<div class="container container-content">
    <div class="row">
