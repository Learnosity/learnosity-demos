
<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;


$item_ref = Uuid::generate();

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$request = array(
    'mode'      => 'item_edit',
    'reference' => $item_ref,
    'config'    => array(
        'item_edit' => array(
            'widget' => array(
                'edit'   => true,
                'delete' => true
            )
        ),
        'dependencies' => [
            'question_editor_api' => [
                'init_options' => array(
                    'ui' => array(
                        'public_methods'     => array(),
                        'question_tiles'     => false,
                        'documentation_link' => false,
                        'change_button'      => true,
                        'source_button'      => false,
                        'fixed_preview'      => true,
                        'advanced_group'     => false,
                        'search_field'       => false
                    )
                )
            ]
        ]
    ),
    'user' => array(
        'id'        => 'demos-site',
        'firstname' => 'Demos',
        'lastname'  => 'User',
        'email'     => 'demos@learnosity.com'
    )
);

$Init = new Init('author', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="overview">
        <h1>End to End Demo - Authoring</h1>
        <p>Learnosity's Author API enable professional authors (as well as teachers) to create and edit content.</p>
        <p>Questions are saved to the Learnosity item bank to be included in the assessment.</p>
    </div>
</div>

<div class="section">
    <div class="row">
        <div id="notifications" class="col-md-2"></div>
        <div class="col-md-10">
            <div id="learnosity-author"></div>
        </div>
    </div>
    <p class="text-right">
        <br>
        <a class="btn btn-primary btn-md btn-addMore">Add more</a>
        <a class="btn btn-primary btn-md btn-goToAssessment">Go to Assessment</a>
    </p>
</div>

<script src="<?php echo $url_authorapi; ?>"></script>
<script>
    var initOptions = <?php echo $signedRequest; ?>;
    var itemIDs = new Array();
    var activeItemID = '<?php echo $item_ref; ?>';


    var authorApp = LearnosityAuthor.init(initOptions, {

        readyListener: function () {
            authorApp.on('save:success', function (event) {
                saveItemID(activeItemID);
            });
        }

    });

    $(document).ready(function(){
        //add more question handler
        $(".btn-addMore").click(function(){
            activeItemID = guid();
            authorApp.setItem(activeItemID);
        });
        //go to assessment handler
        $(".btn-goToAssessment").click(function(){
            window.location = 'assessment.php?itemIDs=' + itemIDs.join(",");
        });
    });

    function showNotification (itemID) {
         var $message = $('<a/>').text('Item ' + itemIDs.length)
                                 .attr('onclick','editItem("' + itemID + '")')
                                 .attr('style','cursor:pointer')
        var $closeBtn = $('<button/>').attr('type', 'button')
                                      .attr('data-dismiss', 'alert')
                                      .attr('aria-hidden', 'true')
                                      .attr('title', 'Delete question')
                                      .attr('onclick', 'removeItem("' + itemID + '")')
                                      .addClass('close')
                                      .text('×');
        var $notification = $('<div/>').addClass('alert alert-info alert-dismissable')
                                       .attr('id', 'ItemNotification' + itemID)
                                       .append($closeBtn)
                                       .append($message);
        $('#notifications').append($notification);
    }

    function guid() {
      function s4() {
        return Math.floor((1 + Math.random()) * 0x10000)
          .toString(16)
          .substring(1);
      }
      return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
        s4() + '-' + s4() + s4() + s4();
    }

    function saveItemID(itemID) {
        if(jQuery.inArray(itemID, itemIDs) == -1){
            itemIDs.push(itemID);
            showNotification(itemID);
        }
    }

    function removeItem(itemID) {
        itemIDs.splice(itemIDs.indexOf(itemID), 1);
        $("#ItemNotification" + itemID).remove();
    }

    function editItem(itemID) {
        activeItemID = itemID;
        authorApp.setItem(itemID);
    }
</script>


<?php
    include_once 'includes/footer.php';
