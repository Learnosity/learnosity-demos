<?php

/**
 * Text Mappings to convert the element name to a human readable description.
 */

$regionElements = array(
    // Buttons
    'accessibility_button' => 'Accessibility',
    'calculator_button' => 'Calculator',
    'flagitem_button' => 'Flag Item',
    'fullscreen_button' => 'Full Screen',
    'masking_button' => 'Masking',
    'next_button' => 'Next',
    'pause_button' => 'Pause',
    'previous_button' => 'Previous',
    'protractor_button' => 'Protractor',
    'reviewscreen_button' => 'Review Screen',
    'ruler_button' => 'Ruler',
    'save_button' => 'Save',
    'submit_button' => 'Submit',

    // Elements
    'horizontaltoc_element' => 'Pager Navigation',
    'itemcount_element' => 'Item Count',
    'progress_element' => 'Progress',
    'reading_timer_element' => 'Reading Timer',
    'separator_element' => 'Separator',
    'timer_element' => 'Timer',
    'title_element' => 'Title',
    'verticaltoc_element' => 'Table of Contents',
);

/**
 * Create a readable title from the region key (ex. 'top-right' => 'Top Right')
 * @param $region - the region string to be titilised
 */
function regionTitle($region)
{
    return ucwords(str_replace('-', ' ', $region));
}

$allButtons = ['accessibility_button', 'calculator_button', 'flagitem_button', 'fullscreen_button', 'masking_button', 'next_button', 'pause_button', 'previous_button', 'protractor_button', 'reviewscreen_button', 'ruler_button', 'save_button', 'submit_button'];

/**
 * Mapping of which elements are permitted in which regions, used to generate the select lists for each region
 */
$regionElementMapping = array(
    'top' => array(
        'elements' => ['horizontaltoc_element', 'itemcount_element', 'reading_timer_element', 'timer_element', 'title_element'],
        'buttons' => $allButtons
    ),
    'top-left' => array(
        'elements' => ['itemcount_element', 'reading_timer_element', 'timer_element', 'title_element'],
        'buttons' => $allButtons
    ),
    'top-right' => array(
        'elements' => ['itemcount_element', 'reading_timer_element', 'timer_element'],
        'buttons' => $allButtons
    ),
    'items' => array(
        'elements' => ['progress_element'],
        'buttons' => []
    ),
    'right' => array(
        'elements' => ['separator_element', 'verticaltoc_element'],
        'buttons' => $allButtons
    ),
    'bottom-left' => array(
        'elements' => ['horizontaltoc_element'],
        'buttons' => $allButtons
    ),
    'bottom-right' => array(
        'elements' => ['horizontaltoc_element', 'itemcount_element', 'reading_timer_element', 'timer_element'],
        'buttons' => $allButtons
    ),
    'bottom' => array(
        'elements' => ['horizontaltoc_element'],
        'buttons' => $allButtons
    ),
);

foreach ($regionElementMapping as $region => $elements) { ?>
<div class="regions-row">
    <div class="regions-element-dropdown">
        <select id="<?= $region; ?>ElementAdder">
            <option value="none"></option>

            <?php if (count($elements['elements']) > 0) { ?>
                <optgroup label="Elements">
                    <?php foreach ($elements['elements'] as $element) { ?>
                        <option value="<?= $element; ?>"><?= $regionElements[$element] ?></option>
                    <?php } ?>
                </optgroup>
            <?php } // if count(elements) > 0

            if (count($elements['buttons']) > 0) { ?>
                <optgroup label="Buttons">
                    <?php foreach ($elements['buttons'] as $button) { ?>
                        <option value="<?= $button; ?>"><?= $regionElements[$button] ?></option>
                    <?php } ?>
                </optgroup>
            <?php } // if count(buttons) > 0 ?>

        </select>
    </div>

    <div class="regions-element-summary <?= $region; ?>">
        <div class="regionLabel">
             <label class="control-label" for="<?= str_replace(' ', '-', regionTitle($region)); ?>"><?= regionTitle($region); ?></label>
        </div>
        <div class="<?= $region; ?>Container regionContainer">
        </div>
    </div>
</div>
<br>
<?php } ?>
