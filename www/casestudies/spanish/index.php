<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$session_id = Uuid::generate();

$request = [
    'user_id'        => $studentid,
    'rendering_type' => 'assess',
    'name'           => 'Learnosity Spanish Demo',
    'state'          => 'initial',
    'activity_id'    => 'spanish-demo',
    'session_id'     => $session_id,    
    'type'           => 'submit_practice',
    'items'          => array('LEAR_222416777787000072', 'LEAR_222416777787000078','LEAR_222416777787000083','LEAR_222416777787000079','LEAR_222416777787000080','LEAR_222416777787000074','LEAR_222416777787000081','LEAR_222416777787000082', 'LEAR_222416777787000085','LEAR_222416777787000087'),
    'config'         => [
        'configuration' => [
            'onsubmit_redirect_url' => 'report.php?session_id='. $session_id
        ],
        'regions' => [
            'top-right' => [
                [
                    'type' => 'itemcount_element',
                ],
                [
                    'type' => 'timer_element'
                ],
                [
                    'type' => 'pause_button'
                ]
            ],
            'bottom-right' => [
                [
                    'type' => 'next_button'
                ],
                [
                    'type' => 'horizontaltoc_element'
                ],
                [
                    'type' => 'previous_button'
                ]
            ]
        ],
        'time' => [
            'show_pause' => true,
            'max_time' => 300
        ],
        'navigation' => array(
            'show_outro' => false,
            'skip_submit_confirmation' => true
        ),
        'title' => 'Learnosity demo en Español',
        'labelBundle' => [
            'actionsave' => 'guardar',
            'actionsubmit' => 'enviar',
            'allQuestionsAttempted'=> 'Todas las preguntas fueron contestadas.',
            'calculator'=> 'Calculadora',
            'close'=> 'Cerrar',
            'configuration'=> 'Configuración',
            'confirm'=> 'Aceptar',
            'continue'=> 'Continuar',
            'decline'=> 'Cancelar',
            'elapsedTime'=> 'Tiempo transcurrido',
            'error'=> 'Error',
            'fullScreen'=> 'Pantalla completa',
            'idleCancelButton'=> 'Sí, quiero continuar!',
            'idleHeadingMsg'=> '¿Sigues ahí?',
            'idleQuitButton'=> 'Salir',
            'introItemMessage'=> 'Por favor presione <b>Comenzar</b> cuando este listo para empezar la actividad.',
            'item'=> 'Pregunta',
            'itemCountOf'=> 'de',
            'loading'=> 'Cargando',
            'nextButtonLabel'=> 'Siguiente',
            'pause'=> 'Pausa',
            'previousButtonLabel'=> 'Anterior',
            'questionHeader'=> 'Pregunta',
            'quit'=> 'Salir',
            'retry'=> 'Reintentar',
            'save'=> 'Guardar',
            'saveButtonLabel'=> 'Guardar',
            'saveError'=> 'Error al guardar.',
            'saveInProgress'=> 'Guardando...',
            'saving'=> 'guardando',
            'startTest'=> 'Comenzar',
            'submit'=> 'Enviar',
            'submitButtonLabel'=> 'Finalizar',
            'submitComplete'=> 'Enviado',
            'submitInProgress'=> 'Enviando...',
            'submitting'=> 'enviando',
            'test'=> 'actividad',
            'testPaused'=> 'Actividad detenida',
            'tryAgain'=> 'Vuelva a intentar',
            'warningOnChangeCancelButton'=> 'Cancelar',
            'warningOnChangeContinueButton'=> 'Continar',
            'questionsApiLabelBundle' => [
                'word' => 'Palabra',
                'wordLength' => 'Límite de palabras',
                'editorBoldIcon' => 'N',
                'editorBoldTitle' => 'Negrita',
                'editorItalicsIcon' => 'K',
                'editorItalicsTitle'  => 'Cursiva',
                'editorUnderlineIcon' => 'S',
                'editorUnderlineTitle' => 'Subrayado',
                'graphingTools.parabola' => 'Parábola',
                'reset' => 'Reiniciar',                
                'undo' => 'Deshacer',
                'redo' => 'Rehacer'
            ]
        ]
    ]
];

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://docs.learnosity.com/assessment/questions/knowledgebase/i18n" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Spanish Demo</h1>
        <p>This demostrates the Learnosity approach to internationalisation of labels and text rendered by the API UI.</p>
        <p>The demo starts with an assessment rendered through Items API (assess) and then the responses review using Reports API. Everything is localised to the Spanish language using label bundles.</p>
        <div class="previewWrapper preview" style="display: none; height: 300px; overflow: scroll;"><pre><code id="xApiPreview"></code></pre></div>
    </div>
</div>

<div class="section">
    <!-- Container for the items api to load into -->
    <div id="learnosity_assess"></div>
</div>

<script src="<?php echo $url_items; ?>"></script>
<script>
    var itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>);
    
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
