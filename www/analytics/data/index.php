<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

// Full base URL of the Data API
$URL = $url_data;

if (isset($_REQUEST['data-url'])) {
    $URL = $_REQUEST['data-url'];
}

// Which version of the Data API to use
$version = $lts_version;

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/dataapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
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
    * Setup a bootstrap panel group to house Data API interactive
    * demos, grouped by section.
    *
    ********************************************************************
    -->
    <div class="content-container">
        <div class="panel-group" id="accordion">
            <!-- Interactives demos for the 'itembank' section -->
            <h2>Item Bank</h2>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#activities">
                            <span class="block">action: get</span>
                            <?php echo '/' . $version . '/itembank/activities'; ?>
                            <span class="glyphicon glyphicon-chevron-down pull-right" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="activities" class="panel-collapse collapse">
                    <div class="panel-body">
                        <?php include_once 'itembank/activities.php'; ?>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#activitytemplates">
                            <span class="block">action: get</span>
                            <?php echo '/' . $version . '/itembank/activities/templates'; ?>
                            <span class="glyphicon glyphicon-chevron-down pull-right" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="activitytemplates" class="panel-collapse collapse">
                    <div class="panel-body">
                        <?php include_once 'itembank/activitytemplates.php'; ?>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#items">
                            <span class="block">action: get</span>
                            <?php echo '/' . $version . '/itembank/items'; ?>
                            <span class="glyphicon glyphicon-chevron-down pull-right" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="items" class="panel-collapse collapse">
                    <div class="panel-body">
                        <?php include_once 'itembank/items.php'; ?>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#itembankquestions">
                            <span class="block">action: get</span>
                            <?php echo '/' . $version . '/itembank/questions'; ?>
                            <span class="glyphicon glyphicon-chevron-down pull-right" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="itembankquestions" class="panel-collapse collapse">
                    <div class="panel-body">
                        <?php include_once 'itembank/questions.php'; ?>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#itembankfeatures">
                            <span class="block">action: get</span>
                            <?php echo '/' . $version . '/itembank/features'; ?>
                            <span class="glyphicon glyphicon-chevron-down pull-right" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="itembankfeatures" class="panel-collapse collapse">
                    <div class="panel-body">
                        <?php include_once 'itembank/features.php'; ?>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#itembanktags">
                            <span class="block">action: get</span>
                            <?php echo '/' . $version . '/itembank/tagging/tags'; ?>
                            <span class="glyphicon glyphicon-chevron-down pull-right" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="itembanktags" class="panel-collapse collapse">
                    <div class="panel-body">
                        <?php include_once 'itembank/tags.php'; ?>
                    </div>
                </div>
            </div>

            <!-- Interactives demos for the 'Item Pools' section -->
            <h2>Item Pools</h2>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#itempools">
                            <span class="block">action: get</span>
                            <?php echo '/' . $version . '/itembank/pools'; ?>
                            <span class="glyphicon glyphicon-chevron-down pull-right" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="itempools" class="panel-collapse collapse">
                    <div class="panel-body">
                        <?php include_once 'itembank/pools.php'; ?>
                    </div>
                </div>
            </div>

            <!-- Interactives demos for the 'sessions' section -->
            <h2>Sessions</h2>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#sessionsresponses">
                            <span class="block">action: get</span>
                            <?php echo '/' . $version . '/sessions/responses'; ?>
                            <span class="glyphicon glyphicon-chevron-down pull-right" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="sessionsresponses" class="panel-collapse collapse">
                    <div class="panel-body">
                        <?php include_once 'sessions/responses.php'; ?>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#responsescores">
                            <span class="block">action: get</span>
                            <?php echo '/' . $version . '/sessions/responses/scores'; ?>
                            <span class="glyphicon glyphicon-chevron-down pull-right" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="responsescores" class="panel-collapse collapse">
                    <div class="panel-body">
                        <?php include_once 'sessions/responsescores.php'; ?>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#sessionsscores">
                            <span class="block">action: get</span>
                            <?php echo '/' . $version . '/sessions/scores'; ?>
                            <span class="glyphicon glyphicon-chevron-down pull-right" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="sessionsscores" class="panel-collapse collapse">
                    <div class="panel-body">
                        <?php include_once 'sessions/scores.php'; ?>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#sessionsstatuses">
                            <span class="block">action: get</span>
                            <?php echo '/' . $version . '/sessions/statuses'; ?>
                            <span class="glyphicon glyphicon-chevron-down pull-right" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="sessionsstatuses" class="panel-collapse collapse">
                    <div class="panel-body">
                        <?php include_once 'sessions/statuses.php'; ?>
                    </div>
                </div>
            </div>

            <!-- Interactives demos for the 'scoring' section -->
            <h2>Scoring</h2>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#scoring">
                            <span class="block">action: get</span>
                            <?php echo '/' . $version . '/scoring'; ?>
                            <span class="glyphicon glyphicon-chevron-down pull-right" aria-hidden="true"></span>
                        </a>
                    </h4>
                </div>
                <div id="scoring" class="panel-collapse collapse">
                    <div class="panel-body">
                        <?php include_once 'scoring/scoring.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('.glyphicon-question-sign').tooltip({
            container: 'body'
        })
    });

    var config = {
        apiRequest: {
            security: {
                consumer_key: '<?php echo $consumer_key; ?>',
                domain: '<?php echo $domain; ?>',
                timestamp: '<?php echo gmdate('Ymd-Hi'); ?>',
                signature: '[add request signature here]'
            }
        }
    };

</script>
<script src="<?php echo $env['www'] ?>static/vendor/ladda/spin.min.js"></script>
<script src="<?php echo $env['www'] ?>static/vendor/ladda/ladda.min.js"></script>
<script src="<?php echo $env['www'] ?>static/js/dataapi/formToObject.js?20150622"></script>
<script src="<?php echo $env['www'] ?>static/js/dataapi/dataApiRequest.js"></script

<?php include_once 'includes/footer.php'; ?>
