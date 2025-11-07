<?php
include_once '../env_config.php';
include_once 'includes/header.php';
include_once '../lrn_config.php';
include_once '../../src/utils/date-gating.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = [
    'consumer_key' => $consumer_key,
    'domain' => $domain
];

// Get distractor reduction settings from URL parameters
$amount = isset($_GET['amount']) ? (int)$_GET['amount'] : 1;
$exclude = isset($_GET['exclude']) ? $_GET['exclude'] : 'none';
$minimum_distractors_count = isset($_GET['minimum_distractors_count']) ? (int)$_GET['minimum_distractors_count'] : 3;

// Build distractor_reduction config
$distractorReduction = [];
if ($amount > 0) {
    $distractorReduction['amount'] = $amount;
}
if ($exclude !== 'none') {
    $distractorReduction['exclude'] = $exclude;
}
$distractorReduction['minimum_distractors_count'] = $minimum_distractors_count;

$questionModifications = $amount > 0 ? [
    'mcq' => [
        'distractor_reduction' => $distractorReduction
    ]
] : [];

/* Demo configuration and signature sign */
$requestDemo = [
    'name' => 'Distractor Reduction Demo',
    'rendering_type' => 'inline',
    'type' => 'local_practice',
    'session_id' => Uuid::generate(),
    'user_id' => 'ANONYMIZED_USER_ID',
    'items' => [
        [
            'id' => 'demo_mcq_distractor_reduction',
            'reference' => 'demo_mcq_distractor_reduction'
        ]
    ],
    'config' => [
        'question_modifications' => $questionModifications
    ]
];

$InitDemo = new Init('items', $security, $consumer_secret, $requestDemo);
$signedRequest = $InitDemo->generate();

?>
<?php if (show_date_gated_content('2026-02-11')): ?>
    <div class="jumbotron section">
        <div class="overview">
            <h2>Distractor Reduction</h2>
            <br>
            <p>Distractor Reduction makes it easy to reduce the number of distractors in multiple-choice questions to support each student’s Individual Education Plan (IEPs).</p>
            <p>In this context, a distractor is an intentionally incorrect option in a multiple choice question.</p>
            <p>For more details, see <a href="https://help.learnosity.com/hc/en-us/articles/31392371210525-config-question-modifications-Initialization-Items-API" target="_blank">the Items API question_modifications documentation</a>.</p>
        </div>
    </div>

    <!--  Control Panel  -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">Distractor Reduction Settings</h4>
        </div>
        <div class="panel-body">
            <form method="GET" action="">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label"><strong>Amount of distractors to drop:</strong></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="amount" id="amount0" value="0" <?= $amount === 0 ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="amount0">None (disabled)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="amount" id="amount1" value="1" <?= $amount === 1 ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="amount1">1 (default)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="amount" id="amount2" value="2" <?= $amount === 2 ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="amount2">2</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><strong>Exclude:</strong></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exclude" id="excludeNone" value="none" <?= $exclude === 'none' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="excludeNone">None</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exclude" id="excludeSingle" value="single-select" <?= $exclude === 'single-select' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="excludeSingle">Single select questions</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exclude" id="excludeMulti" value="multi-select" <?= $exclude === 'multi-select' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="excludeMulti">Multi select questions</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><strong>Minimum distractor count:</strong></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="minimum_distractors_count" id="minCount1" value="1" <?= $minimum_distractors_count === 1 ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="minCount1">1</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="minimum_distractors_count" id="minCount2" value="2" <?= $minimum_distractors_count === 2 ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="minCount2">2</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="minimum_distractors_count" id="minCount3" value="3" <?= $minimum_distractors_count === 3 ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="minCount3">3 (default)</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Apply & Reload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!--  Question  -->
    <div class="section pad-sml">
        <h4>Multiple Choice</h4>
        <hr>
        <span class="learnosity-item" data-reference="demo_mcq_distractor_reduction"></span>
    </div>

    <!--  Load items API  -->
    <script src="<?= $url_items; ?>"></script>
    <script>
        // Initialise Items API
        const itemsApp = LearnosityItems.init(<?= $signedRequest; ?>);
    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
?>
<?php else: ?>
    <div class="jumbotron section">
        <div class="overview">
            <h2>Distractor Reduction</h2>
            <p>This demo is not currently available.</p>
        </div>
    </div>
<?php endif; ?>
<?php
include_once 'includes/footer.php';

