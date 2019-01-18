<?php
header("Content-type: application/json");

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;


//domain must be whitelisted
$domain = $_POST['domain'];

//security object, with domain taking from requester
$security = [
    'user_id'      => $_POST['request']['user_id'],
    'domain'       => $domain,
    'consumer_key' => $consumer_key
];

if (
    isset($_POST['request']['config']) &&
    isset($_POST['request']['config']['questions_api_init_options']) &&
    isset($_POST['request']['config']['questions_api_init_options']['beta_flags']) &&
    isset($_POST['request']['config']['questions_api_init_options']['beta_flags']['reactive_views']) &&
    $_POST['request']['config']['questions_api_init_options']['beta_flags']['reactive_views'] === 'true'
) {
    $_POST['request']['config']['questions_api_init_options']['beta_flags']['reactive_views'] = true;
}
//initialize Items API with provided request object
$init = new Init('items', $security, $consumer_secret, $_POST['request']);
echo $init->generate();

?>
