<?php

include_once '../../config.php';
include_once 'includes/header.php';

$request = '{
  "base_question_type": {
    "hidden": [],
    "attribute_groups": [
      {
        "reference": "basic",
        "name": "Basic"
      },
      {
        "reference": "formatting",
        "name": "Formatting"
      },
      {
        "reference": "validation",
        "name": "Validation"
      },
      {
        "reference": "metadata",
        "name": "Metadata"
      },
      {
        "reference": "advanced",
        "name": "Advanced"
      }
    ]
  },
  "template_defaults": true,
  "widget_type": "response",
  "widget_json": {
    "options": [
      {
        "label": "[Choice A]",
        "value": "0"
      },
      {
        "label": "[Choice B]",
        "value": "1"
      },
      {
        "label": "[Choice C]",
        "value": "2"
      },
      {
        "label": "[Choice D]",
        "value": "3"
      }
    ],
    "ui_style": {
      "choice_label": "upper-alpha",
      "type": "block"
    },
    "stimulus": "<p>This is the question the student will answer</p>",
    "type": "mcq",
    "validation": {
      "scoring_type": "exactMatch",
      "valid_response": {
        "score": 1,
        "value": [
          ""
        ]
      }
    }
  },
  "ui": {
    "layout": "2-column",
    "question_tiles": false,
    "documentation_link": false,
    "change_button": true,
    "source_button": true,
    "fixed_preview": true
  },
  "configuration": {
    "questionsApiVersion": "v2"
  },
    "dependencies": {
        "questions_api": {
            "init_options": {
                "beta_flags": {
                    "reactive_views": true
                }
            }
        }
    }
}';

include_once 'utils/settings-override.php';

$signedRequest = $request;
$signedRequest = $signedRequest;

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Customise API Settings"><a href="#" class="text-muted" data-toggle="modal" data-target="#settings"><span class="glyphicon glyphicon-list-alt"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/questioneditorapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Question Editor API V2 – Test Custom Initialisation</h1>
        <p><a href="#" class="text-muted" data-toggle="modal" data-target="#settings">Enter a JSON initialisation</a> object to test your settings.<p>
    </div>
</div>

<div class="section editor-wrapper">
    <!-- Container for the question editor api to load into -->
    <script src="<?php echo $url_questioneditor; ?>"></script>
    <div class="learnosity-question-editor"></div>
</div>

<script>
    var init, questionEditorApp;

    init = <?php echo $signedRequest; ?>;

    questionEditorApp = LearnosityQuestionEditor.init(init);
</script>

<?php
    include_once 'views/modals/settings-questioneditor-test-init.php';
    include_once 'views/modals/asset-upload.php';
    include_once 'includes/footer.php';
