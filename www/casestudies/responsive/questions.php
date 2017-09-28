<?php
include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
    'user_id'      => $studentid
);

$sessionId = isset($_GET['sessionid']) ? $_GET['sessionid'] : Uuid::generate();
$state = 'initial';

if (isset($_GET['sessionid'])) {
    $state = isset($_GET['state']) ? $_GET['state'] : 'resume';
}

$request = '{
    "type": "submit_practice",
    "state": "' . $state . '",
    "id": "questionsapi-demo",
    "name": "Questions API Demo",
    "session_id" "' . $sessionId . '",
    "course_id": "' . $courseid . '",
    "questions": [],
    "features": [],
    "beta_flags": {
        "reactive_views": true
    }'
;

$Init = new Init('questions', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

$jsonId = isset($_GET['id']) ? $_GET['id'] : '';

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
    $(function () {
        var activity = $.extend(<?php echo $signedRequest; ?>, {
            type: 'submit_practice',
            state: '<?php echo $state ?>',
            id: 'questionsapi-responsive-demo',
            name: 'Questions API Demo',
            session_id: '<?php echo $sessionId ?>',
            course_id: '<?php echo $courseid ?>'
        });
        var sessionId = '<?php echo $sessionId; ?>';

        (function () {
            var $app = $('.responsiveApp');
            var $deviceBtn = $('button[data-device]');

            $deviceBtn.on('click', function () {
                var deviceName = this.dataset.device;

                $deviceBtn.removeClass('selected');
                $app.removeClass('desktop tablet mobile')
                    .addClass(deviceName);

                this.classList.add('selected');
            });

            $('[data-action="review"]').on('click', function () {
                var $btn = $(this);

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
                        $btn.prop('disabled', false);
                        alert('Failed to save');
                    }
                });

                $btn.prop('disabled', true);
            });

            $('button[data-device="desktop"]').addClass('selected');
        })();

        function loadData() {
            var jsonId = '<?php echo $jsonId; ?>';
            var linkToLoad = jsonId ? 'https://jsonblob.com/api/jsonBlob/' + jsonId : 'config/data.json';
            var status = $.Deferred();

            $.get(linkToLoad, function (data) {
                prepareActivity(data);

                status.resolve();
            });

            return status.promise();
        }

        function prepareActivity(data) {
            var $widgetContainers = $('.widgets-container');
            var processWidget = function (widgetType, widgets) {
                var keyId = widgetType === 'feature' ? 'feature_id' : 'response_id';

                $.each(widgets, function (idx, widget) {
                    var id = sessionId + '__' + idx;
                    var identifier = '';

                    widget[keyId] = id;

                    identifier += widgetType === 'feature' ? 'learnosity-feature ' : 'learnosity-response ';
                    identifier += widgetType === 'feature' ? 'feature-' + id : 'question-' + id;

                    $widgetContainers.append('<div class="widget"><span class="' + identifier + '"></span></div>');
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
