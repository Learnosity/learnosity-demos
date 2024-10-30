# Learnosity PHP-SDK: Reference guide

## Usage

There are three main classes:

 * The Init class, which creates the signed security packets to initialise the JavaScript APIs;
 * The Remote class, which encapsulates remote calls to the APIs and their responses;
 * The DataAPI class, which allows your app to interact with the Data API from PHP code.

### Example

A Data API example, showing how to pull specific data from the system is included in the `docs/quickstart/analytics` folder. You can run it like so:

    php docs/quickstart/analytics/init_data.php

You can find a complete PHP site with more examples of Learnosity API integration in our [demos site](https://demos.learnosity.com/).

You can also download the entire demo site or browse the code directly on [GitHub](https://github.com/Learnosity/learnosity-demos/).

### Init

The Init class is used to create the necessary *security* and *request* details used to integrate with a Learnosity API. Most often this will be a JavaScript object.

``` php
//Include the Init and Uuid classes.
use LearnositySdk\Request\Init;
$user_id = Uuid::generate();
```

The Init constructor takes up to 5 arguments:

 * [string]  service type
 * [array]   security details (**no secret**)
 * [string]  secret
 * [request] request details *(optional)*
 * [string]  action *(optional)*

``` php
<?php

// Instantiate the SDK Init class with your security and request data:
$Init = new Init(
   'questions',
   [
       'consumer_key' => 'yis0TYCu7U9V4o7M',
       'domain'       => 'localhost',
       'user_id'      => $user_id // Never transmit the student names or personally identifiable information over the wire. Instead, we use an anonymized UUID string.
   ],
   'superfragilisticexpialidocious',
   [
       'type'      => 'local_practice',
       'state'     => 'initial',
       'questions' => [
           [
               'response_id'        => '60005',
               'type'               => 'association',
               'stimulus'           => 'Match the cities to the parent nation.',
               'stimulus_list'      => ['London', 'Dublin', 'Paris', 'Sydney'],
               'possible_responses' => ['Australia', 'France', 'Ireland', 'England'],
               'validation' => [
                   'valid_responses' => [
                       ['England'], ['Ireland'], ['France'], ['Australia']
                   ]
               ]
           ]
       ]
   ]
);

// Call the generate() method to retrieve a JavaScript object
$request = $Init->generate();
?>

// Pass the object to the initialisation of any Learnosity API, in this example the Questions API
<script src="//questions.learnosity.com"></script>
<script>
    var questionsApp = LearnosityApp.init(<?php echo $request; ?>);
</script>
```

#### Init() Arguments
**service**<br>
A string representing the Learnosity service (API) you want to integrate with. Valid options are:

* assess
* author
* data
* events
* items
* questions
* reports

**security**<br>
An array^ that includes your *consumer_key* but does not include your *secret*. The SDK sets defaults for you, but valid options are:

* consumer_key
* domain (optional - defaults to *localhost*)
* timestamp (optional - the SDK will generate this for you)
* user_id (optional - not necessary for all APIs)

^Note – the SDK accepts a JSON string and native PHP arrays.

**secret**<br>
Your private key, as provided by Learnosity.

**request**<br>
An optional associative array^ of data relevant to the API being used. This will be any data minus the security details that you would normally use to initialise an API.

^Note – the SDK accepts a JSON string and native PHP arrays.

**action**<br>
An optional string used only if integrating with the Data API. Valid options are:

* get
* set
* update
* delete

<hr>

### Remote

The Remote class is used to make server side, cross domain requests. Think of it as a cURL wrapper.

You'll call either `get()` or `post()` (mimicking the HTTP request type you want to make) with the following arguments:

* [string] URL
* [array]  Data payload
* [array]  Options


``` php
//Include the Remote classes.
use LearnositySdk\Request\Remote;
```

``` php
// Instantiate the SDK Remote class:
$Remote = new Remote();
// Call get() or post() with a URL:
$response = $Remote->get('http://schemas.learnosity.com/latest/questions/templates');

// getBody() gives you to body of the request
$requestPacket = $response->getBody();
```

#### Remote() arguments

**URL**<br>
A string URL, including schema and path. Eg:

    https://schemas.learnosity.com/latest/questions/templates

**Data**<br>
An optional array of data to be sent as a payload. For GET it will be a URL encoded query string.

**Options**<br>
An optional array of [cURL parameters](http://www.php.net/manual/en/curl.constants.php).

#### Remote methods
The following methods are available after making a `get()` or `post()`.

**getBody()**<br>
Returns the body of the response payload.

**getError()**<br>
Returns an array that includes the error code and message (if an error was thrown)

**getHeader()**<br>
Currently only returns the *content_type* header of the response.

**getSize()**<br>
Returns the size of the response payload in bytes.

**getStatusCode()**<br>
Returns the HTTP status code of the response.

<hr>

### DataApi

This is a helper class for use with the Data API. It creates the initialisation packet and sends a request to the Data API, returning an instance of Remote. You can then interact as you would with Remote, e.g., `getBody()`

#### request()

Used for a single request to the Data API. You can call as many times as necessary. It will return a `Remote` object, on which `getBody()` needs to be called to get the contents of the response.

``` php
$DataApi = new DataApi();
$response = $DataApi->request(
    'https://data.learnosity.com/v2023.1.lts/itembank/items',
    [
       'consumer_key' => 'yis0TYCu7U9V4o7M',
       'domain'       => 'localhost'
    ],
    'superfragilisticexpialidocious',
    [
       'limit' => 20
    ],
    'get' // optional, will default to 'get' in the backend if unspecified
);
```

#### requestRecursive()

Used to make recursive requests to the Data API, using the *next* token, for as much data is returned based on the request filtering provided.

You can pass a callback as the 6th argument, that will be executed upon completion of every request.

``` php
$DataApi = new DataApi();

$response = $DataApi->requestRecursive(
    'https://data.learnosity.com/v2023.1.lts/itembank/items',
    [
       'consumer_key' => 'yis0TYCu7U9V4o7M',
       'domain'       => 'localhost'
    ],
    'superfragilisticexpialidocious',
    [
       'limit' => 20
    ],
    'get',
    function ($data) {
        $this->processData($data);
    }
);

function processData($data)
{
    // Do something with $data
}
```

#### Overriding the remote options

You can send an array to the DataAPI constructor to override any remote (cURL) options, e.g.:

``` php
$options = array(
    'connect_timeout' => 20
    'timeout' => 60
);

$dataapi = new DataApi($options);
```

## Further reading
Thanks for reading to the end! Find more information about developing an app with Learnosity on our documentation sites: 
<ul>
<li><a href="http://help.learnosity.com">help.learnosity.com</a> -- general help portal, tutorials, and developer reference materials.
<li><a href="http://authorguide.learnosity.com">authorguide.learnosity.com</a> -- authoring documentation for content creators.
</ul>

Back to [README.md](README.md)
