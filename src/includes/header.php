<?php
if (!isset($pageTitle)) {
    $pageTitle = 'Learnosity Demos';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $pageTitle; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/static/images/favicon.ico?<?php echo $assetVersion ?>" type="image/x-icon">
    <link rel="stylesheet" href="/static/dist/all.min.css?<?php echo $assetVersion ?>">
    <script src="/static/dist/all.min.js?<?php echo $assetVersion ?>"></script>
</head>
<body>

<script>

  const cookieBanner = new CookieBanner();
  const cookiePreference = cookieBanner.getCookiePreference();

  // If cookiePreference is set to true or is undefined, load the GA Tag Manager
  if (cookiePreference === 'true' || cookiePreference === undefined) {

    (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-M2HXW6');

  }

</script>

<?php
    $server_name = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    // Show alert if not being used form localhost
if ($server_name && strpos($server_name, '.learnosity.com') === false && $server_name !== 'localhost') {
    echo '<div class="container alert alert-warning"><p><b>Warning</b> – ' .
        'Note: Most demos will only work from <em>localhost</em>. Signed customers can whitelist additional domains using Console.</p></div>';
}

    include_once 'nav.php';
?>

<div class="container container-content" role="main">
    <div class="row">
