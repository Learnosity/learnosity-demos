<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

//alias(es) to eliminate the need for fully qualified classname(s) from sdk
use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

//security object. timestamp added by SDK
$security = [
    'consumer_key' => $consumer_key,
    'domain' => $domain
];

//simple api request object for item list view
$request = [
    'mode' => 'item_edit',
    'reference' => Uuid::generate(),
    'config' => [
        'item_edit' => [
            'item' => [
                'reference' => [
                    'edit' => true
                ]
            ]
        ]
    ],
    'user' => [
        'id' => 'demos-site',
        'firstname' => 'Demos',
        'lastname' => 'User',
        'email' => 'demos@learnosity.com'
    ]
];

$Init = new Init('author', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li class="list-inline-item"><a href="#"  data-bs-toggle="modal" data-bs-target="#initialisation-preview" aria-label="Preview API Initialisation Object" data-bs-title="Preview API Initialisation Object"><span class="bi bi-search" aria-hidden="true"></span></a></li>
            <li class="list-inline-item"><a href="https://support.learnosity.com/hc/en-us/categories/360000105358-Learnosity-Author" aria-label="Visit the documentation" data-bs-title="Visit the documentation"><span class="bi bi-book" aria-hidden="true"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h2>Use Your Own Digital Asset Management System</h2>
        <p>The Author API can be extended to tie in seamlessly with your existing Digital Asset Management system. Click on the 'Edit' button in the image preview, or on the "add image" button in the editor toolbar, to see this in action.<p>
    </div>
</div>

<!-- Container for the author api to load into -->
<div class="section pad-sml">
    <!--    HTML placeholder that is replaced by API-->
    <div id="learnosity-author"></div>
</div>

<!-- version of api maintained in lrn_config.php file -->
<script src="<?php echo $url_authorapi; ?>"></script>
<script>
    // example function to be called by assetRequest
    var assetRequestFunction = function (mediaRequested, returnType, callback) {
        if (mediaRequested === 'image') {
            var modalEl = document.querySelector('.modal.img-upload');
            var modal = bootstrap.Modal.getOrCreateInstance(modalEl, { backdrop: 'static' });
            modalEl.addEventListener('hidden.bs.modal', function () {
                callback();
            });

            var images = [...document.querySelectorAll('.asset-img-gallery img')];
            imgClickHandler = function () {
                if (returnType === 'HTML') {
                    callback('<img src="' + this.dataset.img + '"/>');
                } else {
                    callback(this.dataset.img);
                }
                modal.hide();
                images.forEach(function (img) {
                    img.removeEventListener('click', imgClickHandler);
                });
            };
            images.forEach(function (img) {
                img.addEventListener('click', imgClickHandler);
            });
            modal.show();
        }
    };

    var initializationObject = <?php echo $signedRequest; ?>;

    //optional callbacks for ready
    var callbacks = {
        assetRequest: assetRequestFunction,
        readyListener: function () {
            console.log("Author API has successfully initialized.");
            // navigate to new ImageAssociationV2 question to demonstrate the asset request
            authorApp.navigate(
                'items/new/widgets/new/' + encodeURIComponent(JSON.stringify({
                    widgetTemplate: {
                        template_reference: '6e77b403-8f0c-43af-b464-9450e1ac70dc'
                    }
                }))
            );
        },
        errorListener: function (err) {
            console.log(err);
        }
    };

    var authorApp = LearnosityAuthor.init(initializationObject, callbacks);
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'views/modals/asset-upload.php';
    include_once 'includes/footer.php';
