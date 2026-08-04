<?php
//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
    'user_id'      => 'demo_student'
];


$sessionId = filter_input(INPUT_GET, 'sessionid', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$state = 'initial';

if ($sessionId) {
    $state = filter_input(INPUT_GET, 'state', FILTER_SANITIZE_FULL_SPECIAL_CHARS, ['options' => ['default' => 'resume']]);
} else {
    $sessionId = Uuid::generate();
}

$request = json_encode([
    "type" => "submit_practice",
    "state" => $state,
    "id" => "questionsapi-demo",
    "name" => "Questions API Demo",
    "session_id" => $sessionId,
    "questions" => [],
    "features" => []
]);

$Init = new Init('questions', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

$jsonId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS, ['options' => ['default' => '']]);

?>
<link rel="stylesheet" href="assets/style.css">
<script src="<?php echo $url_questions; ?>"></script>
<div class="section responsiveApp">
    <!-- Main question content below here: -->
    <div class="responsiveApp__toolbar">
        <button class="btn" data-device="desktop">
            <span class="icon-display"></span>
        </button>
        <button class="btn" data-device="tablet">
            <span class="icon-tablet"></span>
        </button>
        <button class="btn" data-device="mobile">
            <span class="icon-mobile"></span>
        </button>

        <button class="btn btn-review" data-action="review">Save & Review</button>
    </div>
    <div class="widgets-container"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var activity = Object.assign(<?php echo $signedRequest; ?>, {
            type: 'submit_practice',
            state: '<?php echo $state ?>',
            id: 'questionsapi-responsive-demo',
            name: 'Questions API Demo',
            session_id: '<?php echo $sessionId ?>',
        });
        var sessionId = '<?php echo $sessionId; ?>';

        (function () {
            var apps = document.querySelectorAll('.responsiveApp');
            var deviceButtons = document.querySelectorAll('button[data-device]');

            deviceButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var deviceName = this.dataset.device;

                    deviceButtons.forEach(function (other) {
                        other.classList.remove('selected');
                    });
                    apps.forEach(function (app) {
                        app.classList.remove('desktop', 'tablet', 'mobile');
                        app.classList.add(deviceName);
                    });

                    this.classList.add('selected');
                });
            });

            document.querySelectorAll('[data-action="review"]').forEach(function (reviewBtn) {
                reviewBtn.addEventListener('click', function () {
                var btn = this;

                window.questionsApp.save({
                    success: function () {
                        var url = window.location.href;

                        if (url.indexOf('?') < 0) {
                            url += '?';
                        }

                        url += '&sessionid=' + sessionId;
                        url += '&state=review';

                        window.location.replace(url);
                    },
                    error: function (e) {
                        btn.disabled = false;
                        alert('Failed to save');
                    }
                });

                btn.disabled = true;
                });
            });

            document.querySelector('button[data-device="desktop"]').classList.add('selected');
        })();

        function loadData() {
            var jsonId = '<?php echo $jsonId; ?>';
            var linkToLoad = jsonId ? 'https://jsonblob.com/api/jsonBlob/' + jsonId : 'config/data.json';
            return fetch(linkToLoad)
                .then(function (response) { return response.json(); })
                .then(function (data) { prepareActivity(data); });
        }

        function prepareActivity(data) {
            var widgetContainers = document.querySelectorAll('.widgets-container');
            var processWidget = function (widgetType, widgets) {
                var keyId = widgetType === 'feature' ? 'feature_id' : 'response_id';

                widgets.forEach(function (widget, idx) {
                    var id = sessionId + '__' + idx;
                    var identifier = '';

                    widget[keyId] = id;

                    identifier += widgetType === 'feature' ? 'learnosity-feature ' : 'learnosity-response ';
                    identifier += widgetType === 'feature' ? 'feature-' + id : 'question-' + id;

                    widgetContainers.forEach(function (container) {
                        container.insertAdjacentHTML('beforeend',
                            '<div class="widget"><span class="' + identifier + '"></span></div>');
                    });
                });

                return widgets;
            };

            if (data.questions) {
                activity.questions = processWidget('question', data.questions);
            }

            if (data.features) {
                activity.features = processWidget('feature', data.features);
            }
        }

        function initApi() {
            window.activity = activity;

            window.questionsApp = LearnosityApp.init(activity);
        }


        loadData()
            .then(initApi);
    });
</script>
<?php
    include_once 'includes/footer.php';
