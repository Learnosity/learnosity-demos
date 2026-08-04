<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

// Full base URL of the Data API
$URL = $url_data;

// Which version of the Data API to use
$version = $lts_version;

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li class="list-inline-item"><a href="https://support.learnosity.com/hc/en-us/categories/360000105378-Learnosity-Analytics" aria-label="Visit the documentation" data-bs-title="Visit the documentation"><span class="bi bi-book" aria-hidden="true"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Data API</h1>
        <p>A back office service that allows authenticated users to retrieve and store information from
        within the Learnosity Assessment platform. Only authenticated users can access their information, over SSL.<p>
        <p>The examples below are a (readonly) subset of what you can do with the Data API. Integration is recommended using our
        SDK, available in <a href="https://github.com/Learnosity/learnosity-sdk-php">PHP</a>, <a href="https://github.com/Learnosity/learnosity-sdk-asp.net">C#.NET</a>
        or <a href="https://github.com/Learnosity/learnosity-sdk-java">Java</a>.</p>
    </div>
</div>

<div class="section">
    <!--
    ********************************************************************
    *
    * Bootstrap collapse on a list of cards, housing the Data API
    * interactive demos grouped by section.
    *
    ********************************************************************
    -->
    <div class="content-container">
        <div id="accordion">
            <!-- Interactives demos for the 'itembank' section -->
            <h2>Item Bank</h2>
            <div class="card panel-data">
                <div class="card-header">
                    <h4 class="card-title">
                        <a data-bs-toggle="collapse" href="#activities">
                            <span class="block">action: get</span>
                            <?php echo '/' . $version . '/itembank/activities'; ?>
                            <span class="bi bi-chevron-down float-end" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="activities" class="collapse" data-bs-parent="#accordion">
                    <div class="card-body">
                        <?php include_once 'itembank/activities.php'; ?>
                    </div>
                </div>
            </div>
            <div class="card panel-data">
                <div class="card-header">
                    <h4 class="card-title">
                        <a data-bs-toggle="collapse" href="#activitytemplates">
                            <span class="block">action: get</span>
                            <?php echo '/' . $version . '/itembank/activities/templates'; ?>
                            <span class="bi bi-chevron-down float-end" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="activitytemplates" class="collapse" data-bs-parent="#accordion">
                    <div class="card-body">
                        <?php include_once 'itembank/activitytemplates.php'; ?>
                    </div>
                </div>
            </div>
            <div class="card panel-data">
                <div class="card-header">
                    <h4 class="card-title">
                        <a data-bs-toggle="collapse" href="#items">
                            <span class="block">action: get</span>
                            <?php echo '/' . $version . '/itembank/items'; ?>
                            <span class="bi bi-chevron-down float-end" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="items" class="collapse" data-bs-parent="#accordion">
                    <div class="card-body">
                        <?php include_once 'itembank/items.php'; ?>
                    </div>
                </div>
            </div>
            <div class="card panel-data">
                <div class="card-header">
                    <h4 class="card-title">
                        <a data-bs-toggle="collapse" href="#itembankquestions">
                            <span class="block">action: get</span>
                            <?php echo '/' . $version . '/itembank/questions'; ?>
                            <span class="bi bi-chevron-down float-end" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="itembankquestions" class="collapse" data-bs-parent="#accordion">
                    <div class="card-body">
                        <?php include_once 'itembank/questions.php'; ?>
                    </div>
                </div>
            </div>
            <div class="card panel-data">
                <div class="card-header">
                    <h4 class="card-title">
                        <a data-bs-toggle="collapse" href="#itembankfeatures">
                            <span class="block">action: get</span>
                            <?php echo '/' . $version . '/itembank/features'; ?>
                            <span class="bi bi-chevron-down float-end" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="itembankfeatures" class="collapse" data-bs-parent="#accordion">
                    <div class="card-body">
                        <?php include_once 'itembank/features.php'; ?>
                    </div>
                </div>
            </div>
            <div class="card panel-data">
                <div class="card-header">
                    <h4 class="card-title">
                        <a data-bs-toggle="collapse" href="#itembanktags">
                            <span class="block">action: get</span>
                            <?php echo '/' . $version . '/itembank/tagging/tags'; ?>
                            <span class="bi bi-chevron-down float-end" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="itembanktags" class="collapse" data-bs-parent="#accordion">
                    <div class="card-body">
                        <?php include_once 'itembank/tags.php'; ?>
                    </div>
                </div>
            </div>

            <!-- Interactives demos for the 'Item Pools' section -->
            <h2>Item Pools</h2>
            <div class="card panel-data">
                <div class="card-header">
                    <h4 class="card-title">
                        <a data-bs-toggle="collapse" href="#itempools">
                            <span class="block">action: get</span>
                            <?php echo '/' . $version . '/itembank/pools'; ?>
                            <span class="bi bi-chevron-down float-end" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="itempools" class="collapse" data-bs-parent="#accordion">
                    <div class="card-body">
                        <?php include_once 'itembank/pools.php'; ?>
                    </div>
                </div>
            </div>

            <!-- Interactives demos for the 'sessions' section -->
            <h2>Sessions</h2>
            <div class="card panel-data">
                <div class="card-header">
                    <h4 class="card-title">
                        <a data-bs-toggle="collapse" href="#sessionsresponses">
                            <span class="block">action: get</span>
                            <?php echo '/' . $version . '/sessions/responses'; ?>
                            <span class="bi bi-chevron-down float-end" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="sessionsresponses" class="collapse" data-bs-parent="#accordion">
                    <div class="card-body">
                        <?php include_once 'sessions/responses.php'; ?>
                    </div>
                </div>
            </div>
            <div class="card panel-data">
                <div class="card-header">
                    <h4 class="card-title">
                        <a data-bs-toggle="collapse" href="#responsescores">
                            <span class="block">action: get</span>
                            <?php echo '/' . $version . '/sessions/responses/scores'; ?>
                            <span class="bi bi-chevron-down float-end" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="responsescores" class="collapse" data-bs-parent="#accordion">
                    <div class="card-body">
                        <?php include_once 'sessions/responsescores.php'; ?>
                    </div>
                </div>
            </div>
            <div class="card panel-data">
                <div class="card-header">
                    <h4 class="card-title">
                        <a data-bs-toggle="collapse" href="#responses-feedback">
                            <span class="block">action: get</span>
                            <?php echo '/' . $version . '/sessions/responses/feedback'; ?>
                            <span class="bi bi-chevron-down float-end" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="responses-feedback" class="collapse" data-bs-parent="#accordion">
                    <div class="card-body">
                        <?php include_once 'sessions/responses-feedback.php'; ?>
                    </div>
                </div>
            </div>
            <div class="card panel-data">
                <div class="card-header">
                    <h4 class="card-title">
                        <a data-bs-toggle="collapse" href="#responses-feedback-update">
                            <span class="block">action: update</span>
                            <?php echo '/' . $version . '/sessions/responses/feedback'; ?>
                            <span class="bi bi-chevron-down float-end" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="responses-feedback-update" class="collapse" data-bs-parent="#accordion">
                    <div class="card-body">
                        <?php include_once 'sessions/responses-feedback-update.php'; ?>
                    </div>
                </div>
            </div>
            <div class="card panel-data">
                <div class="card-header">
                    <h4 class="card-title">
                        <a data-bs-toggle="collapse" href="#sessionsscores">
                            <span class="block">action: get</span>
                            <?php echo '/' . $version . '/sessions/scores'; ?>
                            <span class="bi bi-chevron-down float-end" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="sessionsscores" class="collapse" data-bs-parent="#accordion">
                    <div class="card-body">
                        <?php include_once 'sessions/scores.php'; ?>
                    </div>
                </div>
            </div>
            <div class="card panel-data">
                <div class="card-header">
                    <h4 class="card-title">
                        <a data-bs-toggle="collapse" href="#sessionsstatuses">
                            <span class="block">action: get</span>
                            <?php echo '/' . $version . '/sessions/statuses'; ?>
                            <span class="bi bi-chevron-down float-end" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="sessionsstatuses" class="collapse" data-bs-parent="#accordion">
                    <div class="card-body">
                        <?php include_once 'sessions/statuses.php'; ?>
                    </div>
                </div>
            </div>

            <!-- Interactives demos for the 'scoring' section -->
            <h2>Scoring</h2>
            <div class="card panel-data">
                <div class="card-header">
                    <h4 class="card-title">
                        <a data-bs-toggle="collapse" href="#scoring">
                            <span class="block">action: get</span>
                            <?php echo '/' . $version . '/scoring'; ?>
                            <span class="bi bi-chevron-down float-end" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="scoring" class="collapse" data-bs-parent="#accordion">
                    <div class="card-body">
                        <?php include_once 'scoring/scoring.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.bi-question-circle-fill').forEach((element) => {
            new bootstrap.Tooltip(element, { container: 'body' });
        });
    });

    var config = {
        apiRequest: {
            security: {
                consumer_key: '<?php echo $consumer_key; ?>',
                domain: '<?php echo $domain; ?>',
                timestamp: '<?php echo gmdate('Ymd-Hi'); ?>',
                signature: '[add request signature here]'
            },
            security_postgres: {
                consumer_key: '<?php echo $consumer_key_postgres; ?>',
                domain: '<?php echo $domain; ?>',
                timestamp: '<?php echo gmdate('Ymd-Hi'); ?>',
                signature: '[add request signature here]'
            }
        }
    };

</script>
<script src="/static/vendor/ladda/spin.min.js"></script>
<script src="/static/vendor/ladda/ladda.min.js"></script>
<script src="/static/js/dataapi/formToObject.js?20150622"></script>
<script src="/static/js/dataapi/dataApiRequest.js"></script>

<?php
include_once 'includes/footer.php';
