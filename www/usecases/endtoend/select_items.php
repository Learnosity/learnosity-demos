<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

use LearnositySdk\Request\Init;

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];

$request = [
    'mode'      => 'item_list',
    'config'    => [
        'item_list' => [
            'item' => [
                'enable_selection' => true,
                'status' => true
            ]
        ]
    ],
    'user' => [
        'id'        => 'demos-site',
        'firstname' => 'Demos',
        'lastname'  => 'User',
        'email'     => 'demos@learnosity.com'
    ]
];

$Init = new Init('author', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="overview">
        <h1>End to End Demo – Authoring</h1>
        <p>Learnosity's Author API enable professional authors (as well as teachers) to create and edit content.</p>
        <p>Existing items can be selected and added to the activity or new items can be created.</p>
        <p>Questions are saved to the Learnosity item bank to be included in the assessment.</p>
    </div>
</div>

<div class="section">
    <div class="row">
            <div id="learnosity-author"></div>
    </div>
    <p class="text-right">
        <br>
        <a class="btn btn-primary btn-md btn-goToAssessment">Go to Assessment</a>
    </p>
</div>

<script src="<?=$url_authorapi?>"></script>
<script>
    let initOptions = <?=$signedRequest?>;
    let authorApp = LearnosityAuthor.init(initOptions, {

        readyListener: function () {
            console.log("Author API loaded.")
        },
        errorListener: function(e){
            console.log(e);
        }
    });

    $(document).ready(function(){
        //Go to assessment handler
        $(".btn-goToAssessment").click(function(){
            let itemPromise = authorApp.getSelectedItems();
            if (itemPromise === false) {
                console.log("No items selected.");
                return;
            };
            itemPromise
                .then(function (result) {
                    let itemIDs = [];
                    $.each(result.data.items, function (index, value) {
                        itemIDs.push(value.item.reference);
                    });
                    window.location = 'assessment.php?itemIDs=' + itemIDs.join(",");
                })
                .then(null, function (error) {
                    console.log(error)
                });
        });
    });
</script>

<?php
    include_once 'includes/footer.php';
