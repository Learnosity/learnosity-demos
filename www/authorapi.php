<?php

include_once 'config.php';
include_once '../src/utils/RequestHelper.php';
include_once '../src/includes/header.php';

$security = [
    "consumer_key" => $consumer_key,
    "domain"       => $domain,
    "timestamp"    => $timestamp
];

$request = [
    "limit" => 100,
    "tags"  => [
        ["type" => "course", "name" =>"commoncore"],
        ["type" => "subject", "name" =>"English"]
    ]
];

$RequestHelper = new RequestHelper(
    'author',
    $security,
    $consumer_secret,
    $request
);

$signedRequest = $RequestHelper->generateRequest();

?>

<div class="jumbotron">
    <h1>Author API</h1>
    <p>Learnosity's Author API allows searching and integration of Learnosity powered content into your content management system.<p>
    <div class="row">
        <div class="col-md-8">
            <h4><a href="http://docs.learnosity.com/authorapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
        </div>
        <div class="col-md-4"><p class='text-right'><a class="btn btn-primary btn-lg" href="questioneditorapi.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<!-- Container for the author api to load into -->
<span class="learnosity-author"></span>
<script src="http://authorapi.learnosity.com/"></script>
<script>
    var config = <?php echo $signedRequest; ?>;
    config.ui = {
        onItemClick: function (item) {
            var data = {
                item_references: [item.reference],
                sign_type: 'itemsinline'
            };
            $.ajax({
                url: './xhr.php',
                data: data,
                type: 'POST'
            })
            .done(function(data) {
                $('#render-items').html(data);
                $('#itemsInlineModal').modal();
            })
            .fail(function() {
                alert('There was an error attempting to preview the item');
            });
        }
    }
    LearnosityAuthor.init(config);
</script>

<script src="http://items.learnosity.com/"></script>
<!-- Container for the items api to load into -->
<div id="render-items"></div>

<?php include_once '../src/includes/footer.php';
