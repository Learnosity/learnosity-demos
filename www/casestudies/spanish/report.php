<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

//assessment session id
$session_id = $_GET['session_id'];

$security = [
    'user_id'      => $studentid,
    'domain'       => $domain,
    'consumer_key' => $consumer_key,
];

$request = array(
    'reports' => array(
        array(
            'id'             => 'report-1',
            'type'           => 'session-detail-by-item',
            'user_id'        => $studentid,
            'session_id'     => $session_id,
            'show_correct_answers' => true
        )
    ),
    'label_bundle' => array(
        'activity'=> 'Actividad',
        'attempted'=> 'Con respuesta',
        'not_attempted'=> 'Sin respuesta',
        'not_marked'=> 'Sin respuesta',
        'partial'=> 'Parcialmente correcta',
        'correct'=> 'Correcto',
        'incorrect'=> 'Incorrecto',
        'incomplete'=> 'Incompleto',
        'items'=> 'Preguntas',
        'total'=> 'Total',
        'question'=> 'Pregunta',
        'item'=> 'Pregunta',
        'score'=> 'Puntuación'
    )
);

$Init = new Init('reports', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="overview">
        <h1>Spanish Demo</h1>
        <p>Finally, the assessment answers and scoring are displayed for review.</p>
    </div>
</div>

<div class="section">
    <span class="learnosity-report" id="report-1"></span>    
</div>

<script src="<?php echo $url_reports; ?>"></script>
<script>

var reportsApp = LearnosityReports.init(<?php echo $signedRequest; ?>);

</script>

<?php
    include_once 'includes/footer.php';