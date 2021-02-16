<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];


//simple api request object for Items API
$request = [
    'activity_id' => 'itemsinlinedemo',
    'name' => 'Items API demo - inline activity',
    'rendering_type' => 'inline',
    'type' => 'submit_practice',
    'session_id' => Uuid::generate(),
    'user_id' => '$ANONYMIZED_USER_ID',
    'items' => [
        'inline_demo_q1',
        'inline_demo_q2',
        'Tut002_Item2'
    ]
];

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview" aria-label="Preview API Initialisation Object"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000101737-Learnosity-Assessments" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Embed Formative Assessment Questions into Editorial Content</h2>
            <p>Place questions <i>in context</i> throughout your editorial without the design restrictions of an assessment player. This demo makes use of the <a href="https://help.learnosity.com/hc/en-us/articles/360000758317-Embedding-the-Items-API-Into-Formative-Content-With-Inline-Rendering">inline</a> rendering type.</p>
        </div>
    </div>

    <div class="section pad-sml" style="font-size:16px;">
        <h1>What is Color?</h1>

        <span class="pull-left">
            <img src="itemsapi_inline_images/berries-blueberries-lemons.jpg" width="400px" style="margin-right:20px;" alt="strawberries, blueberries, lemon">
            <p style="font-size:12px;">image: rawpixel.com</p>
        </span>

        <p class="lead">When you look at a fresh, ripe lemon it’s yellow, right? Strawberries are red, and blueberries are blue. But what does color mean? Can you see colors in the dark?</p>

        <p>Lots of things make up how and why we each see color, including different wavelengths of light and even our own bodies--such as whether or not we are color blind. But in simple terms, we see color because different kinds of light are either absorbed by an object’s surface, or bounce off into our eyes. We see different colors because each object absorbs or reflects light differently. </p>

        <div class="pull-right" style="margin-left:20px;width:300px;" >

            <table class="table">
                <tr>
                    <th class="info" style="text-align:center;">Ask Yourself</th>
                </tr>
                <tr>
                    <td><span class="learnosity-item" data-reference="inline_demo_q1"></span></td>
                </tr>
            </table>
        </div>

        <p>When light shines on a field of snow, the snow appears white to us because it absorbs very little color and reflects nearly all color equally. When light shines on a typical street surface, we see it as black because it absorbs nearly all color equally and reflects very little color. You might think of black as a color, like a black marker or a slightly darker black turtleneck, but, if you think about it scientifically, black is really the <i>absence</i> of color.</p>

        <p>White light, on the other hand, contains all colors. We can even see this with our own eyes when it passes through certain things. For example, we can shoot white light through a prism to see it split into multiple colors, and we even see this in nature, when light passes through moisture droplets in the air. When the sun shines brightly through a mist or light rainfall, what do we see?</p>


        <h1 style="clear:both;">A Rainbow of Colors</h1>

        <span class="pull-right"  style="margin-left:10px;">
            <img src="itemsapi_inline_images/colorful-colourful-outdoors-830829.jpg" width="400px" alt="rainbow">
            <p style="font-size:12px;text-align:right;">image: Frans Van Heerden</p>
        </span>

        <p>You probably know there are seven colors in a rainbow: red, orange, yellow, green, blue, indigo, and violet. Our good friend, Roy G. Biv. But what you may not know is that only three of those colors can’t be created by mixing other colors together. These colors—red, yellow, and blue—are called <i>primary colors</i>.</p>

        <div class="pull-left" style="margin-right:20px;width:300px;" >
            <table class="table">
                <tr>
                    <th class="info" style="text-align:center;">Ask Yourself</th>
                </tr>
                <tr>
                    <td><span class="learnosity-item" data-reference="inline_demo_q2"></span></td>
                </tr>
            </table>
        </div>

        <p>When these colors are mixed new colors are created. For example, if you mix red and yellow you get orange. Mixing yellow and blue makes green, and mixing blue and red make violet. These mixed colors are called <i>secondary colors</i>.</p>

        <p>Another way to represent these colors is to show them on a color wheel. Primary colors appear equidistant from each other on the wheel. Secondary colors appear between the primary colors mixed to create them. The color wheel shown here includes primary and secondary colors.</p>

        <span class="pull-right"  style="margin-left:10px;">
            <img src="//s3-us-west-1.amazonaws.com/assets.staging.learnosity.com/organisations/1/primary_secondary_wheel.png" alt="A color wheel.">
            <p style="font-size:12px;text-align:center;">a color wheel</p>
        </span>

        <p>You can find more colors between positions on the wheel. For example, <i>tertiary colors</i>—or a third level of color—appear between primary and secondary colors. The rainbow’s indigo, for instance, appears between blue and violet.</p>


        <h1 style="clear:both;">Let’s Review</h1>

        <div>
        ✓ We see color because some light is absorbed, and other light is reflected, by surfaces.<br>
        ✓ White light contains all color.<br>
        ✓ Black is the absence of color.<br>
        ✓ Primary colors are red, yellow, and blue.<br>
        ✓ Secondary colors are created by mixing primary colors.<br>
        ✓ Tertiary colors are created by mixing primary and secondary colors.<br>
        ✓ There are millions of colors in the world for you to discover!<br><br>
        </div>

        <h4>Think of what you've learned and answer the bonus question below.</h4>

        <div>
            <table class="table">
                <tr>
                    <th class="info" style="text-align:center;">Ask Yourself</th>
                </tr>
                <tr>
                    <td><span class="learnosity-item" data-reference="Tut002_Item2"></span></td>
                </tr>
            </table>
        </div>

    </div>

    <script src="<?php echo $url_items; ?>"></script>
    <script>
        var initializationObject = <?php echo $signedRequest; ?>;

        //optional callbacks for ready
        var callbacks = {
            readyListener: function () {
                console.log("Items API has successfully initialized.");
            },
            errorListener: function (err) {
                console.log(err);
            }
        };

        var itemsApp = LearnosityItems.init(initializationObject, callbacks);
    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
