<!--
*************************************************************************************
*
* Setup a modal window to preview the Item before adding it to the asessment list
*
*************************************************************************************
-->


<style>

    .addedItem {
        background-color: #DFF0D8;
    }

    .addedItem:after {
        background-color: #c0c0c0;
    }

</style>

<script>

var item_ref = '';

$(window).on('shown.bs.modal', function (e) {  // When the Modal is shown

    //Get the item ref which is stored as a custom data attribute of the Modal div.
    // TODO: Try to do this by adding the param directly into the learnosity-item span
    item_ref = $('#endtoend-item-preview').data('parameter_1'); 

    // Add the learnosity-item span to hold the item, complete with the appropriate reference
    $('#item_container').html('<span class="learnosity-item" data-reference="'+item_ref+'"></span>');

    // Prepare the Request data. This will be POSTed to a PHP endpoint so we can add the security signature
    // This example only provides the minimum required params, no fake dummy params are aded.
    var post_data = {
       "request": {
          "user_id": "",
          "rendering_type": "inline",
          "name": "",
          "state": "initial",
          "activity_id": "",
          "session_id": "",
          "items": [
            item_ref // This is the item clicked on the list 
          ],
          "type": ""
       },
       domain: window.location.hostname    
    };

    // We send the post_data above to a PHP back end file where it can be security signed.
    $.ajax({
        url : "endpoint.php",
        type: "POST",
        data : post_data,
        success: function(data, textStatus, jqXHR) {
            console.log(data);
            var eventOptions = {
                readyListener: function () {
                    console.log('Learnosity Items API is ready');
                }
            },
            itemsApp = LearnosityItems.init(data, eventOptions); //Generate the Item
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.dir(errorThrown);
            alert("Error: " + errorThrown);
        }
    });

});

$(document).ready(function(){

    // addToList question handler
    $(".btn-addToList").click(function(){

        // Add a green bg to the Item from the list which was added
        //   find all elements with the class 'lrn-list-view-heading' 
        $('.lrn-list-view-heading').each(function(i, obj) {
            if(obj.outerText === item_ref){  // Test for an exact match on outterText
                $(this).parent().addClass('alert-success'); // Add a class to the parent to highlight this Item
            }
        });

        // Save the item to the list
        saveItemID(item_ref);
        if(itemHasQuestions == true){
          itemWithQuestionsAdded = true;
        }
        // Finally close the Modal
        $('#endtoend-item-preview').modal('hide');
         
    });
});

</script>


<script src="<?php echo $url_items; ?>"></script>

<div class="modal fade preview" id="endtoend-item-preview" data-parameterone="custom">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <a class="btn btn-primary btn-md btn-addToList">Add To List</a>
                <a class="btn btn-default btn-md btn-gcancel"  data-dismiss="modal">Cancel</a>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
               <div id="item_container"></div>
               <!-- TODO Add the reference directly into the span from the main page 
               <span class="learnosity-item" id="hello" data-reference=""></span> 
                -->
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <a class="btn btn-primary btn-md btn-addToList">Add To List</a>
                    <a class="btn btn-default btn-md btn-gcancel"  data-dismiss="modal">Cancel</a>
                </div>
            </div>

        </div>
    </div>
</div>

<!--
    POSTed data works with very few params provided, below is a typical example with dummy data
    var post_data = {
       "request": {
          "user_id": "demo_user",
          "rendering_type": "inline",
          "name": "demo_example",
          "state": "initial",
          "activity_id": "not_to_be_submitted",
          "session_id": "d834bc0c-6120-4447-9e8c-47b65cd4c769",
          "items": [
            item_ref // This is the item clicked on the list 
          ],
          "type": "local_practice"
       },
       domain: window.location.hostname    
    };

-->