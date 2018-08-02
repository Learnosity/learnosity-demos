<?php
include_once '../../../../config.php';

$version = '1.0.0';
$versionPath = 'dev';

if (isset($_GET['version'])) {
    $version = $_GET['version'];
    if (!$version) {
        $version = 'dev';
    }
}
if ($version !== 'dev') {
    $versionPath = 'v' . $version;
}
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>QE V3 - Algorithmic Math Demo</title>

        <script src="//code.jquery.com/jquery-1.12.4.min.js"></script>

        <!-- LEARNOSITY APIS -->
        <script src="//questioneditor.learnosity.com/?v3"></script>
        <script src="//questions.learnosity.com/?v2"></script>

        <link type="text/css" rel="stylesheet" href="build/<?php echo $versionPath; ?>/css/algorithmicMath.css">
    </head>

    <body>
        <div class="container">
            <header class="header">
                <div class="header-content">
                    <span class="logo"></span>Algorithmic Math
                </div>
            </header>
            <div class="my-editor shadow-page">
                <div class="lrn-qe-wait-panel">
                    <div class="lrn-qe-spinner">
                        <div class="lrn-qe-bounce1"></div>
                        <div class="lrn-qe-bounce2"></div>
                        <div class="lrn-qe-bounce3"></div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/template" data-lrn-qe-layout="algorithmic-formulaV2-layout">
            <?php include_once 'build/' . $versionPath . '/templates/algorithmicMath.html' ?>
        </script>

        <!-- EXAMPLE -->
        <script>
            var domain = '<?php echo $domain; ?>';
            var versionPath = '<?php echo $versionPath; ?>';
        </script>

        <script src="build/<?php echo $versionPath; ?>/js/algorithmicMath.js"></script>
        <script src="demo.js"></script>
    </body>

</html>
