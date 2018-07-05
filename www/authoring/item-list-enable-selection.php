<?php

	/*
	 *** demo revamp questions: we need to: ***
	 * TODO: composer update to 5.4 or later to support PHPStorm
	 * TODO: check with Sydney about PHP 7 guidelines and linting
	 * TODO: default reactive views?
	 * TODO: address settings overrides
	 * Style Guide: align consistently; consistent quotes; variable names
	 *** end demo revamp questions ***
	 *
	 *** unique to this demo ***
	 * TODO: Create custom tag set for filtering
	 *** end unique to this demo ***
	 */



    //common environment attributes including search paths. not specific to Learnosity
	include_once '../env_config.php';

    //site scaffolding
	include_once 'includes/header.php';

    //common Learnosity config elements including API version control vars
	include_once '../lrn_config.php';

    //alias(es) to eliminate the need for fully qualified classname(s) from sdk
	use LearnositySdk\Request\Init;


    //security object. timestamp added by SDK
	$security = [
		'consumer_key' => $consumer_key,
		'domain'       => $domain
	];


	//TODO: org id, including get rid of it and try it yourself. Rich to create org. Name?

    //simple api request object, with additional common features added and commented
	$request = [
		'mode'      => 'item_list',
		'config'    => [
			'item_list' => [
				//demo specific: filter content by user and tag
				'item' => [
					'enable_selection' => true
				]
			],
			'item_edit' => [
				'item' => [
					//show item reference and allow editing
					'reference' => [
					    'show' => true,
						'edit' => true
					],
					/*
					 * enable dynamic content and shared passages in items
					 * allow duplication of items
					 */
					'dynamic_content' => true,
					'duplicate' => true,
					'shared_passage' => true
				]
			]
		],
		//user for whom this API is initialized. recorded when editing item content.
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

    <!--site scaffolding-->
    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/authorapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Filter items in your Item Bank</h2>
            <p>The item list mode allows authors to search the Learnosity hosted item bank for existing items.
                In this case, we've also passed configuration to only show items that match certain criteria, using tagging.</p>
        </div>
    </div>


    <div class="section pad-sml">
        <!--HTML placeholder that is replaced by Author API-->
        <div id="learnosity-author"></div>
        <div class="text-right" style="margin-top:10px;">
            <!--duplicate button will be enabled when readyListener fires-->
            <button id="clearSelectedItems" class="btn btn-primary btn-md" type="submit" disabled>Clear Selected Items</button>
            <button id="doSelectedItems" class="btn btn-primary btn-md" type="submit" disabled>Log Reference and Title</button>
        </div>
    </div>


    <!-- version of api maintained in lrn_config.php file -->
    <script src="<?php echo $url_authorapi; ?>"></script>
    <script>
        var initializationObject = <?php echo $signedRequest; ?>;

        //optional callbacks for ready and/or error event(s)
        var callbacks = {
            readyListener: function () {
                console.log("Author API has successfully initialized.");
                $("#doSelectedItems, #clearSelectedItems").removeAttr("disabled");
            },
            errorListener: function (err) {
                console.log(err);
            }
        };

        var authorApp = LearnosityAuthor.init(initializationObject, callbacks);

        $("#doSelectedItems").click(function() {
            var itemPromise = authorApp.getSelectedItems();
            if (itemPromise === false) {
                console.log("No items selected.");
                return;
            };
            itemPromise
                .then(function (result) {
                    $.each(result.data.items, function (index, value) {
                        console.log("item:\n\treference: " + value.item.reference + "\n\ttitle: " + value.item.title);
                    });
                })
                .then(null, function (error) {
                    console.log(error)
                });
        });
        $("#clearSelectedItems").click(function() {
            authorApp.clearSelectedItems();
        });
    </script>


<?php
	include_once 'views/modals/initialisation-preview.php';
	include_once 'includes/footer.php';