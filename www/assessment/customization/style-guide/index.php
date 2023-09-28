<?php
//common environment attributes including search paths. not specific to Learnosity
include_once '../../../env_config.php';
//common Learnosity config elements including API version control vars
include_once '../../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$sessionid = Uuid::generate();
$servername = $_SERVER['SERVER_NAME'];
$security = [
    'user_id'      => 'demos-site',
    'domain'       => $domain,
    'consumer_key' => $consumer_key,
    'timestamp'    => gmdate('Ymd-Hi')
];
$state =  isset($_GET['state']) ? $_GET['state'] : 'initial' ;

$request = '{
    "type": "submit_practice",
    "state": "'.$state.'",
    "id": "questionsapi-demo",
    "name": "Style Guide Demo",
    "session_id" : "'.$sessionid.'",
    "domain": "'.$servername.'",
    "features":[],
    "questions": []
}';

$Init = new Init('questions', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BETA selector identifier</title>
    <link type="text/css" rel="stylesheet" href="public/preloader.css">
</head>
<body>
<!-- Load Learnosity -->
<script src="<?php echo $url_questions; ?>"></script>
<script>
    // global variables
    window.lrn_gca_signed_request = <?php echo $signedRequest; ?>;
</script>
<div id="app"></div>
<div class="page-preloader">
    <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
</div>
<script type="text/javascript" src="dist/app.js" ></script>
<script type="text/javascript" src="dist/vendor.js" ></script>
<div id="widgetContainer"></div>
<script>
    const globalApiKey = '3063c8a5-7a9b-4e55-95e4-26070136bec9';
    window.onUsersnapCXLoad = function(api) {
        api.init();
        window.Usersnap = api;
    }
    let script = document.createElement('script');
    script.defer = 1;
    script.src = `https://widget.usersnap.com/global/load/${globalApiKey}?onload=onUsersnapCXLoad`;
    document.getElementsByTagName('head')[0].appendChild(script);
</script>
</body>
</html>
