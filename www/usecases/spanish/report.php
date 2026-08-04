<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

//assessment session id
$session_id = filter_input(INPUT_GET, 'session_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$security = [
    'user_id'      => 'demo_student',
    'domain'       => $domain,
    'consumer_key' => $consumer_key,
];

$request = array(
    'reports' => array(
        array(
            'id'             => 'report-1',
            'type'           => 'sessions-summary',
            'user_id'        => 'demo_student',
            'session_ids'    => array($session_id)
        ),
        array(
            'id'             => 'report-2',
            'type'           => 'session-detail-by-item',
            'user_id'        => 'demo_student',
            'session_id'     => $session_id,
            'show_correct_answers' => false
        )
    ),
    'label_bundle' => array(
        'activity' => 'Actividad',
        'attempted' => 'Con respuesta',
        'not_attempted' => 'Sin respuesta',
        'not-attempted' => 'Sin respuesta',
        'not_marked' => 'Sin puntaje',
        'not-marked' => 'Sin puntaje',
        'partial' => 'Parcialmente correcta',
        'correct' => 'Correcto',
        'incorrect' => 'Incorrecto',
        'incomplete' => 'Incompleto',
        'items' => 'Preguntas',
        'question' => 'Pregunta',
        'item' => 'Pregunta',
        'score' => 'Puntuación',
        'total_n_of_items' => 'Número total de preguntas',
        'n_of_items_correct' => 'Número de preguntas correctas',
        'n_of_items_incorrect' => 'Número de preguntas incorrectas',
        'n_of_items_skipped' => 'Número de preguntas sin respuesta',
        'n_of_items_not_marked' => 'Número de preguntas sin puntaje',
        'of_items_were_answered_correctly' => 'de preguntas con respuestas correctas.',
        'of_items_were_attempted' => 'de preguntas con respuestas.',
        'of_score_was_answered_correctly' => 'del puntaje total con respuestas correctas'
    )
);

$Init = new Init('reports', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li class="list-inline-item"><a href="#"  data-bs-toggle="modal" data-bs-target="#initialisation-preview" aria-label="Preview API Initialisation Object" data-bs-title="Preview API Initialisation Object"><span class="bi bi-search" aria-hidden="true"></span></a></li>
            <li class="list-inline-item"><a href="https://support.learnosity.com/hc/en-us/articles/360000758697-Internationalizing-and-Localizing-the-Assessment-Experience" aria-label="Visit the documentation" data-bs-title="Visit the documentation"><span class="bi bi-book" aria-hidden="true"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Spanish Demo</h1>
        <p>Finally, the assessment answers and scoring are displayed for review.</p>
    </div>
</div>

<div class="section">
    <h1>Resumen de la actividad</h1>
    <span class="learnosity-report" id="report-1"></span>
    <h1>Detalle de la actividad</h1>
    <span class="learnosity-report" id="report-2"></span>
</div>

<script src="<?php echo $url_reports; ?>"></script>
<script>

var reportsApp = LearnosityReports.init(<?php echo $signedRequest; ?>);

</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
