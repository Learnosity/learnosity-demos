<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$session_id = Uuid::generate();

$request = array(
    'user_id'        => 'demo_student',
    'rendering_type' => 'assess',
    'name'           => 'Learnosity Spanish Demo',
    'state'          => 'initial',
    'activity_id'    => 'spanish-demo',
    'session_id'     => $session_id,
    'type'           => 'submit_practice',
    'assess_inline'  => true,
    'items'          => array('LEAR_222416777787000072', 'LEAR_222416777787000078','LEAR_222416777787000080','LEAR_222416777787000079','LEAR_222416777787000074','LEAR_222416777787000081','LEAR_222416777787000082', 'LEAR_222416777787000085', 'LEAR_99455450458884454545539'),
    'config' => array(
        'navigation' => array(
            'show_accessibility' => array(
                'show_colourscheme' => true,
                'show_fontsize' => true,
                'show_zoom' => true
            ),
            'scroll_to_top'            => false,
            'scroll_to_test'           => false,
            'show_configuration'       => false,
            'show_fullscreencontrol'   => true,
            'show_progress'            => true,
            'show_submit'              => true,
            'show_calculator'          => false,
            'show_itemcount'           => true,
            'skip_submit_confirmation' => true,
            'warning_on_change'        => false,
            'scrolling_indicator'      => false,
            'show_answermasking'       => true,
            'show_acknowledgements'    => true
        ),
        'ui_style'            => 'main',
        'configuration' => array(
            'lazyload'               => false,
            'onsubmit_redirect_url' => 'report.php?session_id='. $session_id
        ),
        'time' => array(
            'show_time'  => true,
            'show_pause' => true,
            'max_time'   => 1500,
            'warning_time' => 10,
            'limit_type'   => 'soft'
        ),
        'title' => 'Learnosity demo en Español',
        'subtitle' => 'Juan Perez',
        'labelBundle' => array(
            'actionsave' => 'guardar',
            'actionsubmit' => 'enviar',
            'allQuestionsAttempted' => 'Todas las preguntas fueron contestadas.',
            'calculator' => 'Calculadora',
            'close' => 'Cerrar',
            'configuration' => 'Configuración',
            'confirm' => 'Aceptar',
            'continue' => 'Continuar',
            'decline' => 'Cancelar',
            'elapsedTime' => 'Tiempo transcurrido',
            'error' => 'Error',
            'fullScreen' => 'Pantalla completa',
            'idleCancelButton' => 'Sí, quiero continuar!',
            'idleHeadingMsg' => '¿Sigues ahí?',
            'idleQuitButton' => 'Salir',
            'introItemMessage' => 'Por favor presione <b>Comenzar</b> cuando este listo para empezar la actividad.',
            'item' => 'Pregunta',
            'itemCountOf' => 'de',
            'loading' => 'Cargando',
            'nextButtonLabel' => 'Siguiente',
            'pause' => 'Pausa',
            'previousButtonLabel' => 'Anterior',
            'questionHeader' => 'Pregunta',
            'quit' => 'Salir',
            'retry' => 'Reintentar',
            'save' => 'Guardar',
            'saveButtonLabel' => 'Guardar',
            'saveError' => 'Error al guardar.',
            'saveInProgress' => 'Guardando...',
            'saving' => 'guardando',
            'startTest' => 'Comenzar',
            'submit' => 'Enviar',
            'submitButtonLabel' => 'Finalizar',
            'submitComplete' => 'Enviado',
            'submittingInProgress' => 'Enviando...',
            'submitting' => 'enviando',
            'test' => 'actividad',
            'testPaused' => 'Actividad detenida',
            'tryAgain' => 'Vuelva a intentar',
            'idleSaveError' => 'Se produjo un error al guardar la actividad.',
            'errorOccurredWhile' => 'Se ha producido un error',
            'submitFailed' => 'Su actividad no pudo ser guardada, posiblemente debido a un error de red.',
            'submitWarningMsg' => 'Su actividad ha sido guardada y enviada por un administrador y finalizará en ',
            'submitFailedWithOnlyAccessRawDataOption' => 'Tiene la opción de intentar de nuevo o acceder a una copia de su actividad y enviársela a un administrador.',
            'submitFailedWithOtherOptions' => 'Tiene la opción de intentar de nuevo o acceder a una copia de su actividad y enviársela a un administrador.',
            'actionDownloadAsFile' => 'Descargar como un archivo.',
            'actionSendEmail' => 'Enviar un email',
            'actionAccessRawData' => 'Acceder a los datos de la actividad.',
            'warningOnChangeCancelButton' => 'Cancelar',
            'warningOnChangeContinueButton' => 'Continar',
            'answerMasking' => 'Enmascarar respuestas',
            'accessibility' => 'Accesibilidad',
             // ACCESSIBILITY PANEL
            'accessibilityPanel'=> 'Opciones de Accesibilidad',
            'colorScheme' => 'Esquema de color',
            'fontSize' => 'Tamaño de fuente',
            'zoom' => 'Zoom',
            'paletteInstructions' => 'Haga Click en el esquema de color siguiente para cambiar el color',
            'blackOnWhite' => 'Negro sobre blanco (predeterminado)',
            'purpleOnGreen' => 'Purpura sobre verde claro',
            'yellowOnBlue' => 'Amarillo sobre azul',
            'blackOnRose' => 'Negro sobre rosa',
            'greyOnGrey' => 'Gris medio sobre gris claro',
            'whiteOnBlack' => 'Blanco sobre negro',
            'customColorPalette' => 'Personalizar esquema',
            'fontSizeInstructions' => 'Para ajustar el tamaño de fuente seleccione una opción de la siguiente lista.',
            'small' => 'Chica',
            'normal' => 'Normal',
            'large' => 'Grande',
            'xlarge' => 'X Grande',
            'xxlarge' => 'XX Grande',
            'zoomInstructions' => 'Puede acercarse o alejarse usando los siguientes atajos en el teclado =>',
            'command' => 'cmd',
            'control' => 'ctrl',
            'zoomIn' => 'Acercarse',
            'zoomOut' => 'Alejarse',
            'returnZoom' => 'Volver al zoom original',
            'toZoomIn' => 'Para acercarse presione',
            'toZoomOut' => 'Para alejarse presione',
            'toReturnZoom' => 'La forma mas rápida de volver el navegador al zoom oringinal es presionando',
            'plus' => '+',
            'minus' => '-',
            'zero' => '0',
            'zoomInResult' => 'El navegador aumentará el zoom cuando presione la tecla de suma (+).',
            'zoomOutResult' => 'El navegador disminuirá el zoom cuando presione la tecla de restar (-).',
            'collapseMenu' => 'Menú desplegable',
            'submitActionConfirmation' => 'Está seguro que desea finalizar la actividad?',
            'submitWithUnattemptedQuestion' => '{{unattemptedResponsesCount}} pregunta no tiene respuestas. Está seguro que desea finalizar la actividad?',
            'submitWithUnattemptedQuestions' => '{{unattemptedResponsesCount}} preguntas no tienen respuestas. Está seguro que desea finalizar la actividad?',
            'isAllResponsesAttempted' => '{{allQuestionsAttempted}}. Está seguro que desea finalizar la actividad?',
            'existingResponsesTitle' => 'Se encontraron respuestas existentes.',
            'existingResponsesMessage' => 'Esta actividad ya fue resuelta.',
            'existingResponsesDetail' => 'Por favor refresque la pagina para iniciar una nueva actividad.',
            'questionsApiLabelBundle' => array(
                'word' => 'Palabra',
                'wordLength' => 'Límite de palabras',
                'editorBoldIcon' => 'N',
                'editorBoldTitle' => 'Negrita',
                'editorItalicsIcon' => 'K',
                'editorItalicsTitle'  => 'Cursiva',
                'editorUnderlineIcon' => 'S',
                'editorUnderlineTitle' => 'Subrayado',
                'graphingTools'=>[
                    'parabola' => 'Parábola'
                ],
                'reset' => 'Reiniciar',
                'undo' => 'Deshacer',
                'redo' => 'Rehacer'
            )
        ),
        'questions_api_init_options' => [
            'beta_flags' => [
                'reactive_views' => true
            ]
        ]
    )
);


$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview" aria-label="Preview API Initialisation Object"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/articles/360000758697-Internationalizing-and-Localizing-the-Assessment-Experience" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Spanish Demo</h1>
        <p>This demostrates the Learnosity approach to internationalisation of labels and text rendered by the API UI.</p>
        <p>The demo starts with an assessment rendered through Items API (assess) and then the responses review using Reports API. Everything is localised to the Spanish language using label bundles.</p>
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
