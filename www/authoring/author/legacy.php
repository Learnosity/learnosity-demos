<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Utils\Json;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
    'timestamp'    => gmdate('Ymd-Hi')
);

$request = array(
    'limit' => 100,
    'tags'  => array(
        array('type' => 'course', 'name' =>'commoncore')
    )
);

$security['signature'] = generateSignature($security, $consumer_secret, $request);
$signedRequest = Json::encode(
    array(
        'request'  => $request,
        'security' => $security
    )
);

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/authorapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Author API</h1>
        <p>Learnosity's Author API allows searching and integration of Learnosity powered content into your content management system.<p>
    </div>
</div>

<div class="section">
    <section>
        <h3>Sample CMS/LMS Integration</h3>
        <p>Below is an edit page for a fictional Content/Learning Management System.</p>
        <p>The buttons on the right show how you might integrate the Author API to search for, and add items &mdash;
        allowing your authors to integrate rich content items into existing pages.</p>
        <p>There is also a preview button which integrates the <a href="../../assessment/items/itemsapi_inline.php">Items API</a>
        &mdash; showing a full preview of your content embedded with items from the Item Bank.</p>
        <p>Place your cursor in the edit box below, where you want an item to appear. Click the "Add Item(s)" button
        and select your items from the Learnosity Item Bank.</p>
        <br>
    </section>

    <div class="panel panel-info">
        <div class="panel-heading"><span class="glyphicon glyphicon-edit"></span> Custom Content Management System – Edit Page</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-8">
                    <div id="editor"><?php echo htmlspecialchars('<h1>Sample content page</h1>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget velit libero.
Aenean placerat lacus nunc, et lobortis augue venenatis sed. Vestibulum ornare
malesuada ligula a molestie.</p>

<p>Mauris eget condimentum diam, id porttitor lacus. Phasellus faucibus
condimentum mi, id hendrerit sem cursus ut. Nam purus nisi, vehicula non laoreet
a, volutpat at felis. Mauris molestie congue felis et ultrices. Aenean fermentum
leo sit amet metus molestie, molestie pulvinar tellus tristique. Curabitur
vulputate bibendum erat, vitae ultricies kneque.</p>') . PHP_EOL; ?>

</div>
                </div>
                <div class="col-md-4 text-center">
                    <button type="button" class="btn btn-info btn" data-toggle="modal" data-target="#authorModal">Add Item(s) <span class="glyphicon glyphicon-import"></span></button>
                    <button type="button" class="btn btn-info btn" onclick="signItemsRequest()">Preview Item(s) <span class="glyphicon glyphicon-search"></span></button>
                </div>
            </div>
        </div>
    </div>
</div>

<!--
********************************************************************
*
* Load a fake editor (ACE Editor) to simulate integrating with
* a Content/Learning management system
*
********************************************************************
-->
<script src="<?php echo $env['www'] ?>static/vendor/ace/ace-builds/src-min-noconflict/ace.js"></script>
<script>
    var editor = ace.edit('editor');
    editor.setTheme('ace/theme/clouds');
    editor.getSession().setMode('ace/mode/html');
    editor.setShowPrintMargin(false);
    editor.navigateFileEnd();
    editor.focus();
</script>

<!--
********************************************************************
*
* Setup the Author API modal, using bootstrap 3.0
*
********************************************************************
-->
<div class="modal fade" id="authorModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Learnosity Author API</h4>
            </div>
            <div class="modal-body">
                <!-- Container for the author api to load into -->
                <span class="learnosity-author"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!--
********************************************************************
*
* This is the HTML hook to load the Items API preview into
*
********************************************************************
-->
<div id="render-items"></div>

<!--
********************************************************************
*
* Load the Author and Items API JavaScript files.
*
* The onItemClick() function adds an HTML hook (span) into the
* content editor. This is the tag that an item loads into.
*
* The signItemsRequest() function parses the content block for
* item hooks and sends a request to the server to sign the request
* packet. The response is the HTML of a modal window with the
* Items API initialised to render whatever was found in the content
* editor window (if anything).
* See ./src/views/modals/items-inline.php
*
********************************************************************
-->
<script src="//authorapi.learnosity.com?v0.5"></script>
<script src="//items.learnosity.com/"></script>
<script>
    var config = <?php echo $signedRequest; ?>,
        hook;

    config.ui = {
        onItemClick: function (item) {
            hook = '<span class="learnosity-item" data-reference="' + item.reference + '"></span>';
            editor.insert(hook);
            $('#authorModal').modal('hide');
        }
    }
    LearnosityAuthor.init(config);

    function signItemsRequest() {
        var data = {
            item_references: [],
            sign_type: 'items-inline',
            content: editor.getValue()
        };
        $(data.content).each(function() {
            if (typeof $(this).attr('data-reference') !== 'undefined') {
                data.item_references.push($(this).attr('data-reference'));
            }
        }, data);
        $.ajax({
            url: '<?php echo $env['www'] ?>generateRequest.php',
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
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';

    /**
     * Generate a signature hash for the request, this includes:
     *  - the security credentials
     *  - the `request` packet (a JSON string) if passed
     *  - the `action` value if passed
     *
     * @return string A signature hash for the request authentication
     */
    function generateSignature($securityPacket, $secret, $request)
    {
        $signatureArray = array();
        $validSecurityKeys = getSecurityKeys();

        // Create a pre-hash string based on the security credentials
        // The order is important
        foreach ($validSecurityKeys as $key) {
            if (array_key_exists($key, $securityPacket)) {
                array_push($signatureArray, $securityPacket[$key]);
            }
        }

        // Add the secret
        array_push($signatureArray, $secret);

        // Add the requestPacket if necessary
        if (!empty($requestString)) {
            array_push($signatureArray, $requestString);
        }

        return hashValue($signatureArray);
    }

    /**
     * Hash an array value
     *
     * @param  array  $value An array to hash
     *
     * @return string The hashed string
     */
    function hashValue($value)
    {
        return hash('sha256', implode('_', $value));
    }

    function getSecurityKeys()
    {
        return array('consumer_key', 'domain', 'timestamp', 'user_id');
    }
