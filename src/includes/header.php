<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Learnosity API Demos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./static/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./static/vendor/bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="./static/vendor/reveal/reveal.css">
    <link rel="stylesheet" href="./static/css/main.css">
    <script src="./static/vendor/jquery/jquery-1.10.2.min.js"></script>
    <script>
        // Show alert if not being used form localhost
        if (location.hostname !== 'localhost') {
            document.write("<p>Note: Most demos will only work from 'localhost' please contact support@learnosity.com to get an additional domain added.</p>");
        }
    </script>
</head>
<body>

<?php include_once '../src/includes/nav.php'; ?>

<div class="container">
