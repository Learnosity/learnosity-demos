<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$session_id = Uuid::generate();

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$request = array(
    'activity_id'    => 'parccadaptivedemo',
    //'activity_template_id' => 'parcc_adaptive_ela_decoding', /* Load from IBK */
    'name'           => 'PARCC Adaptive activity',
    'rendering_type' => 'assess',
    'state'          => 'initial',
    'session_id'     => $session_id,
    'user_id'        => $studentid,
    'assess_inline'  => true,
    'adaptive'       => array(
        'type'           => 'parccadaptive',
        'required_tags'  => array(
            array('type' => 'adaptive-item-set', 'name' => 'ELA Decoding')
        ),
        'custom_config'  => [
                        "controls" => [
                            "SCORE_OPTION" => "DINA 0.000001 0.000009 0.000009 0.000009 0.000009 0.000009 0.000009 0.000081 0.000081 0.000081 0.000081 0.000081 0.000081 0.000081 0.000081 0.000081 0.000081 0.000081 0.000081 0.000081 0.000081 0.000081 0.000729 0.000729 0.000729 0.000729 0.000729 0.000729 0.000729 0.000729 0.000729 0.000729 0.000729 0.000729 0.000729 0.000729 0.000729 0.000729 0.000729 0.000729 0.000729 0.000729 0.006561 0.006561 0.006561 0.006561 0.006561 0.006561 0.006561 0.006561 0.006561 0.006561 0.006561 0.006561 0.006561 0.006561 0.006561 0.059049 0.059049 0.059049 0.059049 0.059049 0.059049 0.531441",
                            "DCM_INF" => "SHE_MARG2",
                            "DCM_ATTRIBUTES" => "CVC_words  Blends_and_Digraphs  Complex_vowels  Complex_consonants  Word_Recognition/Inflectional_Endings  Affixes_(prefixes/suffixes)/Syllabication",
                            "DCM_START_PROFILE" => "0;0;0;0;0;0",
                            "TEST_FORMAT" => "ADAPTIVE",
                            "N_STRANDS" => 6,
                            "MIN_N_ITEMS_IN_STRAND" => "7 7 7 7 7 7",
                            "MAX_N_ITEMS_IN_STRAND" => "7 7 7 7 7 7",
                            "TEST_I_STRANDS" => "1 1 1 1 1 1 1 2 2 2 2 2 2 2 3 3 3 3 3 3 3 4 4 4 4 4 4 4 5 5 5 5 5 5 5 6 6 6 6 6 6 6",
                            "CONTENT" => "QUOTA",
                            "IEC" => "CON_RANDOMESQUE",
                            "IEC_PARS" => "10 10 10 10 10 10",
                            "TERMINATION_RULE" => "PROF_PROB",
                            "TERMINATION_VALUE" => "0.2 0.2 0.2 0.2 0.2 0.2"
                        ],
                        "item_parameter_reference" => "ela_decoding",
                        "constraints" => [
                            "1    100  0       1       CVC_words",
                            "2    100  0       1       Blends_and_Digraphs",
                            "3    100  0       1       Complex_vowels",
                            "4    100  0       1       Complex_consonants",
                            "5    100  0       1       Word_Recognition/Inflectional_Endings",
                            "6    100  0       1       Affixes_(prefixes/suffixes)/Syllabication",
                            "1    50   0       0.15    CVC_with_Short_a",
                            "1    50   0       0.15    CVC_with_Short_e",
                            "1    50   0       0.15    CVC_with_Short_i",
                            "1    50   0       0.15    CVC_with_Short_o",
                            "1    50   0       0.15    CVC_with_Short_u",
                            "5    50   0       0.15    Compound_Words",
                            "4    50   0       0.15    Consonant_Combinations_(gh,_ph)",
                            "4    50   0       0.15    Consonant_Combinations_(gn,_mb)",
                            "4    50   0       0.15    Consonant_Combinations_(kn,_wr)",
                            "2    50   0       0.15    Consonant_Digraphs",
                            "2    50   0       0.15    Consonant_l-blends",
                            "2    50   0       0.15    Consonant_r-blends",
                            "2    50   0       0.15    Consonant_s-blends",
                            "5    50   0       0.15    Contractions",
                            "5    50   0       0.15    Endings_ed_and_ing",
                            "5    50   0       0.15    Endings_s,_es,_and_ed",
                            "5    50   0       0.15    Endings_with_Doubled_Consonants",
                            "5    50   0       0.15    Endings_with_y",
                            "2    50   0       0.15    Final_Consonant_Blends",
                            "2    50   0       0.15    Final_Consonant_Blends_and_Combinations",
                            "2    50   0       0.15    Final_Consonant_Combinations",
                            "2    50   0       0.15    Final_Consonant_Digraphs",
                            "1    50   0       0.15    Final_Consonants",
                            "4    50   0       0.15    Hard_and_Soft_c_Sound",
                            "4    50   0       0.15    Hard_and_Soft_g_Sound",
                            "1    50   0       0.15    Initial_Consonants",
                            "3    50   0       0.15    Long_Vowel_Sounds",
                            "3    50   0       0.15    Long_a_Vowel_Patterns",
                            "3    50   0       0.15    Long_e_Vowel_Patterns",
                            "3    50   0       0.15    Long_i_Vowel_Patterns",
                            "3    50   0       0.15    Long_o_Vowel_Patterns",
                            "3    50   0       0.15    Long_u_Vowel_Patterns",
                            "6    50   0       0.15    Number_of_Syllables",
                            "5    50   0       0.15    Phonics:_Irregular_Verbs",
                            "5    50   0       0.15    Plurals_That_End_with_o,_f",
                            "5    50   0       0.15    Plurals_for_Words_Ending_in_y",
                            "5    50   0       0.15    Plurals_with_es",
                            "5    50   0       0.15    Plurals_with_s",
                            "6    50   0       0.15    Prefixes",
                            "6    50   0       0.15    Prefixes_in-,_im-,_il-,_sub-,_mis-",
                            "6    50   0       0.15    Prefixes_un-,_re-,_pre-",
                            "4    50   0       0.15    Review_Complex_Consonants",
                            "5    50   0       0.15    Root_Words",
                            "6    50   0       0.15    Root_Words",
                            "3    50   0       0.15    Schwa_Sound",
                            "1    50   0       0.15    Short_Vowels",
                            "6    50   0       0.15    Suffixes_-er,_-est",
                            "6    50   0       0.15    Suffixes_-ful,_-less",
                            "6    50   0       0.15    Suffixes_-ness,_-ment",
                            "6    50   0       0.15    Syllabication�Accented_Syllables",
                            "6    50   0       0.15    Syllabication�V/CV_Divide_Words_with_Single_Consonant,_Long_Vowel_Sound",
                            "6    50   0       0.15    Syllabication�VC/CV_Divide_Words_with_Like_and_Unlike_Double_Consonants",
                            "6    50   0       0.15    Syllabication�VC/V_Divide_Words_with_Single_Consonant,_Short_Vowel_Sound",
                            "4    50   0       0.15    Three-Letter_Combinations_with_Blends",
                            "4    50   0       0.15    Three-Letter_Combinations_with_Digraphs",
                            "3    50   0       0.15    Vowel_-r_Words",
                            "3    50   0       0.15    Vowel_Diphthongs_ou/ow_and_oi/oy",
                            "3    50   0       0.15    Vowel_Sound_in_ball",
                            "3    50   0       0.15    Vowel_Sounds_for_oo",
                            "3    50   0       0.15    Vowel_Sounds_for_y_(long_i_and_e_sounds)"
                        ]
                    ],
    ),
    'config' => array(
        'title' => 'Adaptive Assessment – PARCC ELA algorithm',
        'administration' => array(
            'pwd' => '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8' // `password`
        ),
        'navigation' => array(
            'show_prev'              => false,
            'show_progress'          => false,
            'show_fullscreencontrol' => false,
            'toc'                    => false
        ),
        'time' => array(
            'max_time' => 1800
        ),
        'assessApiVersion'    => "latest",
        'configuration'       => array(
            'onsubmit_redirect_url' => '../../analytics/reports/session-report.php?session_id=' . $session_id,
            'onsave_redirect_url'   => 'itemsapi_parccadaptive.php'
        )
    )
);

if (isset($_POST['adaptive'])) {
    foreach ($_POST['adaptive'] as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $childKey => $childValue) {
                if (strlen($childValue)) {
                    $request['adaptive'][$key][$childKey] = (float) $childValue;
                } else {
                    unset($request['adaptive'][$key][$childKey]);
                }
            }
        } else {
            if (strlen($value)) {
                $request['adaptive'][$key] = (float) $value;
            } else {
                unset($request['adaptive'][$key]);
            }
        }
    }
}

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="pull-right toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Customise API Settings"><a href="#" class="text-muted" data-toggle="modal" data-target="#settings"><span class="glyphicon glyphicon-list-alt"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/assessment/items/knowledgebase/adaptiveassessment" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <h1>PARCC Adaptive ELA algorithm</h1>
    <p>Your session ID is <?php print($session_id)?>.</p>
</div>

<div class="section">
    <!-- Container for the items api to load into -->
    <div id="learnosity_assess"></div>
</div>
<script src="<?php echo $url_items; ?>"></script>
<script>
    var itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>);
</script>

<?php
    include_once '../../../src/views/modals/settings-items-adaptive.php';
    include_once '../../../src/views/modals/initialisation-preview.php';
    include_once '../../../src/includes/footer.php';
