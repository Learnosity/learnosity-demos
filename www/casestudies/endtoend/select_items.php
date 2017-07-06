<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$item_ref = Uuid::generate();

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

// This file is reused in the Demo Tour (misc/tour/end-to-end01.php) via an include, in that instance some restriction filters are applied.
// To make this work in both cases we need to add a setting for the default http://demos.learnosity.com/casestudies/endtoend/select_items.php case.
if (!strpos($_SERVER['PHP_SELF'], 'tour') > 0){
    // Create the restrictions array to include the filter
    $restricted = array(
                   'current_user' => false,
    );
}

$request = array(
    'mode'      => 'item_list',
    'config'    => array(
        'item_list' => array(
            'item' => array(
                'status' =>true
            ),
            'toolbar' => array(
                'add' => false
            ),
            'filter' => array(
                'restricted' => $restricted
            )
        ),
        'item_edit' => array(
            'item' => array(
                "back" => true
            )
        )
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
        <h1>End to End Demo – Authoring</h1>
        <p>Learnosity's Author API enable professional authors (as well as teachers) to create and edit content.</p>
        <p>Existing items can be selected and added to the activity or new items can be created.</p>
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
        <a class="btn btn-primary btn-md btn-addMore">Create New Item</a>
        <a class="btn btn-primary btn-md btn-goToAssessment">Go to Assessment</a>
    </p>
</div>

<script src="<?php echo $url_authorapi; ?>"></script>
<script>
    var initOptions = <?php echo $signedRequest; ?>;
    var itemIDs = new Array();
    var activeItemID = '<?php echo $item_ref; ?>';

    // These are used to ensure that the list contains at least one item which has a question.
    var itemHasQuestions = false;
    var itemWithQuestionsAdded = false;

    var authorApp = LearnosityAuthor.init(initOptions, {

        readyListener: function () {

            authorApp.on('open:item', function (event) {
                
                // Do not proceed if the array is undefined (as would be the case when adding a new item)
                if(typeof(event.data.questions) != 'undefined'){
                
                    // Prevent the default action (open) when an item in the list is clicked
                    event.preventDefault();

                    // Check if the Item contains questions set a flag accordingly
                    //   Need to add the test for "learnosity-response" because data.questions does not contain questions data due to recent reworking of Author API.
                    if(event.data.questions.length > 0 || event.data.item.content.indexOf("learnosity-response") >= 0) {
                        itemHasQuestions = true;
                    } 

                    // For unpublished Items we do not provide the Modal as these can not be added to assessments
                    if(event.data.item.status == 'published') {

                        // Find the items ID and add it to the list.
                        // Add the Item ID to a custom paramater on the Modal DIV
                        $('#endtoend-item-preview').data().parameter_1 = event.data.item.reference;
                        // Open a Modal to preview the Item and provide 'Add' and 'Cancel' options
                        $('#endtoend-item-preview').modal('show');
                        
                    } else {
                        alert('This item is unpublished and therefore can not be added to the assessment.');
                    }
                }

            });

            // When a newly created item is saved save it to our array and redirect back to list view
            authorApp.on('save:success', function (event) {
                saveItemID(activeItemID);
                authorApp.navigate('items');
            });

        }
    });

    $(document).ready(function(){
        //add more question handler
        $(".btn-addMore").click(function(){
            activeItemID = guid();
            authorApp.setItem(activeItemID);
            // Redirect to  new item view
            //authorApp.navigate('items/new/widgets/new');
            authorApp.navigate('items/new');
        });
        //go to assessment handler
        $(".btn-goToAssessment").click(function(){
            
            // Do not proceed to assessment if the list does not conatin at least one question
            if(itemWithQuestionsAdded == true){
                window.location = 'assessment.php?itemIDs=' + itemIDs.join(",");    
            } else {
                alert('None of the Items in the list contain Questions. An assessment requires a minimum of one Question.');
            }
            
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
                                       .attr('title', 'Item: ' + itemID)
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
    include_once 'views/modals/endtoend-item-preview.php';
    include_once 'includes/footer.php';
