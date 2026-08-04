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

/**
 * Flattens a nested object into the bracketed form-encoded keys endpoint.php reads
 * out of $_POST, e.g. { request: { items: ['a'] } } -> "request[items][0]=a".
 * jQuery's $.ajax did this for us; fetch does not.
 */
function toFormData (value, prefix, params) {
    params = params || new URLSearchParams();
    if (value !== null && typeof value === 'object') {
        Object.entries(value).forEach(([key, inner]) => {
            toFormData(inner, prefix ? prefix + '[' + key + ']' : key, params);
        });
    } else {
        params.append(prefix, value);
    }
    return params;
}

document.addEventListener('shown.bs.modal', async function (e) {  // When the Modal is shown

    //Get the item ref which is stored as a custom data attribute of the Modal div.
    // TODO: Try to do this by adding the param directly into the learnosity-item span
    item_ref = document.getElementById('endtoend-item-preview').dataset.parameter_1;

    // Add the learnosity-item span to hold the item, complete with the appropriate reference
    document.getElementById('item_container').innerHTML =
        '<span class="learnosity-item" data-reference="' + item_ref + '"></span>';

    // Prepare the Request data. This will be POSTed to a PHP endpoint so we can add the security signature
    // This example only provides the minimum required params, no fake dummy params are aded.
    var post_data = {
       "request": {
          "user_id": "",
          "rendering_type": "inline",
          "name": "",
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
    try {
        const response = await fetch('endpoint.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
            body: toFormData(post_data)
        });
        if (!response.ok) {
            throw new Error('endpoint.php responded ' + response.status);
        }
        const data = await response.json();
        console.log(data);
        const eventOptions = {
            readyListener: function () {
                console.log('Learnosity Items API is ready');
            }
        };
        LearnosityItems.init(data, eventOptions); //Generate the Item
    } catch (error) {
        console.dir(error);
        alert("Error: " + error.message);
    }

});

document.addEventListener('DOMContentLoaded', function () {

    // addToList question handler
    document.querySelectorAll('.btn-addToList').forEach(function (button) {
        button.addEventListener('click', function () {

            // Add a green bg to the Item from the list which was added
            //   find all elements with the class 'lrn-list-view-heading'
            document.querySelectorAll('.lrn-list-view-heading').forEach(function (heading) {
                if (heading.outerText === item_ref) {  // Test for an exact match on outterText
                    heading.parentElement.classList.add('alert-success'); // Highlight this Item
                }
            });

            // Save the item to the list
            saveItemID(item_ref);
            if (itemHasQuestions == true) {
              itemWithQuestionsAdded = true;
            }
            // Finally close the Modal
            const preview = document.getElementById('endtoend-item-preview');
            bootstrap.Modal.getOrCreateInstance(preview).hide();

        });
    });
});

</script>


<script src="<?php echo $url_items; ?>"></script>

<div class="modal fade preview" id="endtoend-item-preview" data-parameterone="custom">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <a class="btn btn-primary btn-md btn-addToList">Add To List</a>
                <a class="btn btn-outline-secondary btn-md btn-gcancel"  data-bs-dismiss="modal">Cancel</a>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <a class="btn btn-outline-secondary btn-md btn-gcancel"  data-bs-dismiss="modal">Cancel</a>
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
