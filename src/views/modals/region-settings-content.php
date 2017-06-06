<div class="form-group">
    <label for="title-element" class="col-sm-3 control-label">Title</label>
    <div class="col-sm-9">
        <input type="radio" class="radioButton" name="regionsSetting['title_element']" value="top-left" <?php if(in_array(array("type"=> "title_element"),$request['config']['regions']['top-left'])){ echo ' checked';}?>> Top-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['title_element']" value="top-right" disabled> Top-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['title_element']" value="right" disabled> Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['title_element']" value="bottom" disabled> Bottom &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['title_element']" value="bottom-left" disabled> Bottom-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['title_element']" value="bottom-right" disabled> Bottom-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['title_element']" value="items" disabled> Items &nbsp;
        <input type="text" class="orderInput form-control" min="1" max="16" step="1" name="elementPosition['title_element']" value="0">

    </div>
</div>


<div class="form-group">
    <label for="next-button" class="col-sm-3 control-label">Next Button</label>
    <div class="col-sm-9">
        <input type="radio" class="radioButton" name="regionsSetting['next_button']" value="top-left" <?php if(in_array(array("type"=> "next_button"),$request['config']['regions']['top-left'])){ echo ' checked';}?>> Top-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['next_button']" value="top-right" <?php if(in_array(array("type"=> "next_button"),$request['config']['regions']['top-right'])){ echo ' checked';}?>> Top-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['next_button']" value="right" <?php if(in_array(array("type"=> "next_button"),$request['config']['regions']['right'])){ echo ' checked';}?>> Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['next_button']" value="bottom" <?php if(in_array(array("type"=> "next_button"),$request['config']['regions']['bottom'])){ echo ' checked';}?>> Bottom &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['next_button']" value="bottom-left" <?php if(in_array(array("type"=> "next_button"),$request['config']['regions']['bottom-left'])){ echo ' checked';}?>> Bottom-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['next_button']" value="bottom-right" <?php if(in_array(array("type"=> "next_button"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>> Bottom-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['next_button']" value="items" disabled> Items &nbsp;

    </div>
</div>


<div class="form-group">
    <label for="previous-button" class="col-sm-3 control-label">Previous Button</label>
    <div class="col-sm-9">
        <input type="radio" class="radioButton" name="regionsSetting['previous_button']" value="top-left" <?php if(in_array(array("type"=> "previous_button"),$request['config']['regions']['top-left'])){ echo ' checked';}?>> Top-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['previous_button']" value="top-right" <?php if(in_array(array("type"=> "previous_button"),$request['config']['regions']['top-right'])){ echo ' checked';}?>> Top-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['previous_button']" value="right" <?php if(in_array(array("type"=> "previous_button"),$request['config']['regions']['right'])){ echo ' checked';}?>> Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['previous_button']" value="bottom" <?php if(in_array(array("type"=> "previous_button"),$request['config']['regions']['bottom'])){ echo ' checked';}?>> Bottom &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['previous_button']" value="bottom-left" <?php if(in_array(array("type"=> "previous_button"),$request['config']['regions']['bottom-left'])){ echo ' checked';}?>> Bottom-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['previous_button']" value="bottom-right" <?php if(in_array(array("type"=> "previous_button"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>> Bottom-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['previous_button']" value="items" disabled> Items &nbsp;

    </div>
</div>


<div class="form-group">
    <label for="pause-button" class="col-sm-3 control-label">Pause Button</label>
    <div class="col-sm-9">
        <input type="radio" class="radioButton" name="regionsSetting['pause_button']" value="top-left" <?php if(in_array(array("type"=> "pause_button"),$request['config']['regions']['top-left'])){ echo ' checked';}?>> Top-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['pause_button']" value="top-right" <?php if(in_array(array("type"=> "pause_button"),$request['config']['regions']['top-right'])){ echo ' checked';}?>> Top-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['pause_button']" value="right" <?php if(in_array(array("type"=> "pause_button"),$request['config']['regions']['right'])){ echo ' checked';}?>> Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['pause_button']" value="bottom" <?php if(in_array(array("type"=> "pause_button"),$request['config']['regions']['bottom'])){ echo ' checked';}?>> Bottom &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['pause_button']" value="bottom-left" <?php if(in_array(array("type"=> "pause_button"),$request['config']['regions']['bottom-left'])){ echo ' checked';}?>> Bottom-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['pause_button']" value="bottom-right" <?php if(in_array(array("type"=> "pause_button"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>> Bottom-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['pause_button']" value="items" disabled> Items &nbsp;

    </div>
</div>


<div class="form-group">
    <label for="save-button" class="col-sm-3 control-label">Save Button</label>
    <div class="col-sm-9">
        <input type="radio" class="radioButton" name="regionsSetting['save_button']" value="top-left" <?php if(in_array(array("type"=> "save_button"),$request['config']['regions']['top-left'])){ echo ' checked';}?>> Top-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['save_button']" value="top-right" <?php if(in_array(array("type"=> "save_button"),$request['config']['regions']['top-right'])){ echo ' checked';}?>> Top-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['save_button']" value="right" <?php if(in_array(array("type"=> "save_button"),$request['config']['regions']['right'])){ echo ' checked';}?>> Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['save_button']" value="bottom" <?php if(in_array(array("type"=> "save_button"),$request['config']['regions']['bottom'])){ echo ' checked';}?>> Bottom &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['save_button']" value="bottom-left" <?php if(in_array(array("type"=> "save_button"),$request['config']['regions']['bottom-left'])){ echo ' checked';}?>> Bottom-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['save_button']" value="bottom-right" <?php if(in_array(array("type"=> "save_button"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>> Bottom-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['save_button']" value="items" disabled> Items &nbsp;

    </div>
</div>

<div class="form-group">
    <label for="separator" class="col-sm-3 control-label">Separator Element</label>
    <div class="col-sm-9">
        <input type="radio" class="radioButton" name="regionsSetting['separator_element']" value="top-left" disabled> Top-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['separator_element']" value="top-right" disabled> Top-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['separator_element']" value="right" <?php if(in_array(array("type"=> "separator_element"),$request['config']['regions']['right'])){ echo ' checked';}?>> Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['separator_element']" value="bottom" disabled> Bottom &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['separator_element']" value="bottom-left" disabled> Bottom-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['separator_element']" value="bottom-right" disabled> Bottom-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['separator_element']" value="items" disabled> Items &nbsp;

    </div>
</div>

<div class="form-group">
    <label for="accessibility-button" class="col-sm-3 control-label">Accessibility Button</label>
    <div class="col-sm-9">
        <input type="radio" class="radioButton" name="regionsSetting['accessibility_button']" value="top-left" <?php if(in_array(array("type"=> "accessibility_button"),$request['config']['regions']['top-left'])){ echo ' checked';}?>> Top-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['accessibility_button']" value="top-right" <?php if(in_array(array("type"=> "accessibility_button"),$request['config']['regions']['top-right'])){ echo ' checked';}?>> Top-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['accessibility_button']" value="right" <?php if(in_array(array("type"=> "accessibility_button"),$request['config']['regions']['right'])){ echo ' checked';}?>> Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['accessibility_button']" value="bottom" <?php if(in_array(array("type"=> "accessibility_button"),$request['config']['regions']['bottom'])){ echo ' checked';}?>> Bottom &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['accessibility_button']" value="bottom-left" <?php if(in_array(array("type"=> "accessibility_button"),$request['config']['regions']['bottom-left'])){ echo ' checked';}?>> Bottom-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['accessibility_button']" value="bottom-right" <?php if(in_array(array("type"=> "accessibility_button"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>> Bottom-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['accessibility_button']" value="items" disabled> Items &nbsp;

    </div>
</div>


<div class="form-group">
    <label for="fullscreen-button" class="col-sm-3 control-label">Full Screen Button</label>
    <div class="col-sm-9">
        <input type="radio" class="radioButton" name="regionsSetting['fullscreen_button']" value="top-left" <?php if(in_array(array("type"=> "fullscreen_button"),$request['config']['regions']['top-left'])){ echo ' checked';}?>> Top-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['fullscreen_button']" value="top-right" <?php if(in_array(array("type"=> "fullscreen_button"),$request['config']['regions']['top-right'])){ echo ' checked';}?>> Top-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['fullscreen_button']" value="right" <?php if(in_array(array("type"=> "fullscreen_button"),$request['config']['regions']['right'])){ echo ' checked';}?>> Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['fullscreen_button']" value="bottom" <?php if(in_array(array("type"=> "fullscreen_button"),$request['config']['regions']['bottom'])){ echo ' checked';}?>> Bottom &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['fullscreen_button']" value="bottom-left" <?php if(in_array(array("type"=> "fullscreen_button"),$request['config']['regions']['bottom-left'])){ echo ' checked';}?>> Bottom-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['fullscreen_button']" value="bottom-right" <?php if(in_array(array("type"=> "fullscreen_button"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>> Bottom-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['fullscreen_button']" value="items" disabled> Items &nbsp;

    </div>
</div>


<div class="form-group">
    <label for="reviewscreen-button" class="col-sm-3 control-label">Review Screen Button</label>
    <div class="col-sm-9">
        <input type="radio" class="radioButton" name="regionsSetting['reviewscreen_button']" value="top-left" <?php if(in_array(array("type"=> "reviewscreen_button"),$request['config']['regions']['top-left'])){ echo ' checked';}?>> Top-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['reviewscreen_button']" value="top-right" <?php if(in_array(array("type"=> "reviewscreen_button"),$request['config']['regions']['top-right'])){ echo ' checked';}?>> Top-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['reviewscreen_button']" value="right" <?php if(in_array(array("type"=> "reviewscreen_button"),$request['config']['regions']['right'])){ echo ' checked';}?>> Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['reviewscreen_button']" value="bottom" <?php if(in_array(array("type"=> "reviewscreen_button"),$request['config']['regions']['bottom'])){ echo ' checked';}?>> Bottom &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['reviewscreen_button']" value="bottom-left" <?php if(in_array(array("type"=> "reviewscreen_button"),$request['config']['regions']['bottom-left'])){ echo ' checked';}?>> Bottom-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['reviewscreen_button']" value="bottom-right" <?php if(in_array(array("type"=> "reviewscreen_button"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>> Bottom-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['reviewscreen_button']" value="items" disabled> Items &nbsp;

    </div>
</div>


<div class="form-group">
    <label for="calculator-button" class="col-sm-3 control-label">Calculator Button</label>
    <div class="col-sm-9">
        <input type="radio" class="radioButton" name="regionsSetting['calculator_button']" value="top-left" <?php if(in_array(array("type"=> "calculator_button"),$request['config']['regions']['top-left'])){ echo ' checked';}?>> Top-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['calculator_button']" value="top-right" <?php if(in_array(array("type"=> "calculator_button"),$request['config']['regions']['top-right'])){ echo ' checked';}?>> Top-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['calculator_button']" value="right" <?php if(in_array(array("type"=> "calculator_button"),$request['config']['regions']['right'])){ echo ' checked';}?>> Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['calculator_button']" value="bottom" <?php if(in_array(array("type"=> "calculator_button"),$request['config']['regions']['bottom'])){ echo ' checked';}?>> Bottom &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['calculator_button']" value="bottom-left" <?php if(in_array(array("type"=> "calculator_button"),$request['config']['regions']['bottom-left'])){ echo ' checked';}?>> Bottom-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['calculator_button']" value="bottom-right" <?php if(in_array(array("type"=> "calculator_button"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>> Bottom-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['calculator_button']" value="items" disabled> Items &nbsp;

    </div>
</div>


<div class="form-group">
    <label for="flagitem-button" class="col-sm-3 control-label">Flag Item Button</label>
    <div class="col-sm-9">
        <input type="radio" class="radioButton" name="regionsSetting['flagitem_button']" value="top-left" <?php if(in_array(array("type"=> "flagitem_button"),$request['config']['regions']['top-left'])){ echo ' checked';}?>> Top-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['flagitem_button']" value="top-right" <?php if(in_array(array("type"=> "flagitem_button"),$request['config']['regions']['top-right'])){ echo ' checked';}?>> Top-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['flagitem_button']" value="right" <?php if(in_array(array("type"=> "flagitem_button"),$request['config']['regions']['right'])){ echo ' checked';}?>> Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['flagitem_button']" value="bottom" <?php if(in_array(array("type"=> "flagitem_button"),$request['config']['regions']['bottom'])){ echo ' checked';}?>> Bottom &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['flagitem_button']" value="bottom-left" <?php if(in_array(array("type"=> "flagitem_button"),$request['config']['regions']['bottom-left'])){ echo ' checked';}?>> Bottom-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['flagitem_button']" value="bottom-right" <?php if(in_array(array("type"=> "flagitem_button"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>> Bottom-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['flagitem_button']" value="items" disabled> Items &nbsp;

    </div>
</div>


<div class="form-group">
    <label for="masking-button" class="col-sm-3 control-label">Masking Button</label>
    <div class="col-sm-9">
        <input type="radio" class="radioButton" name="regionsSetting['masking_button']" value="top-left" <?php if(in_array(array("type"=> "masking_button"),$request['config']['regions']['top-left'])){ echo ' checked';}?>> Top-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['masking_button']" value="top-right" <?php if(in_array(array("type"=> "masking_button"),$request['config']['regions']['top-right'])){ echo ' checked';}?>> Top-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['masking_button']" value="right" <?php if(in_array(array("type"=> "masking_button"),$request['config']['regions']['right'])){ echo ' checked';}?>> Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['masking_button']" value="bottom" <?php if(in_array(array("type"=> "masking_button"),$request['config']['regions']['bottom'])){ echo ' checked';}?>> Bottom &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['masking_button']" value="bottom-left" <?php if(in_array(array("type"=> "masking_button"),$request['config']['regions']['bottom-left'])){ echo ' checked';}?>> Bottom-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['masking_button']" value="bottom-right" <?php if(in_array(array("type"=> "masking_button"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>> Bottom-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['masking_button']" value="items" disabled> Items &nbsp;

    </div>
</div>

<div class="form-group">
    <label for="timer" class="col-sm-3 control-label">Timer</label>
    <div class="col-sm-9">
        <input type="radio" class="radioButton" name="regionsSetting['timer_element']" value="top-left" <?php if(in_array(array("type"=> "timer_element"),$request['config']['regions']['top-left'])){ echo ' checked';}?>> Top-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['timer_element']" value="top-right" <?php if(in_array(array("type"=> "timer_element"),$request['config']['regions']['top-right'])){ echo ' checked';}?>> Top-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['timer_element']" value="right" disabled> Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['timer_element']" value="bottom" disabled> Bottom &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['timer_element']" value="bottom-left" disabled> Bottom-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['timer_element']" value="bottom-right" <?php if(in_array(array("type"=> "timer_element"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>> Bottom-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['timer_element']" value="items" disabled> Items &nbsp;

    </div>
</div>


<div class="form-group">
    <label for="readingtimer" class="col-sm-3 control-label">Reading Timer</label>
    <div class="col-sm-9">
        <input type="radio" class="radioButton" name="regionsSetting['reading_timer_element']" value="top-left" <?php if(in_array(array("type"=> "reading_timer_element"),$request['config']['regions']['top-left'])){ echo ' checked';}?>> Top-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['reading_timer_element']" value="top-right" <?php if(in_array(array("type"=> "reading_timer_element"),$request['config']['regions']['top-right'])){ echo ' checked';}?>> Top-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['reading_timer_element']" value="right" disabled> Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['reading_timer_element']" value="bottom" disabled> Bottom &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['reading_timer_element']" value="bottom-left" disabled> Bottom-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['reading_timer_element']" value="bottom-right" <?php if(in_array(array("type"=> "reading_timer_element"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>> Bottom-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['reading_timer_element']" value="items" disabled> Items &nbsp;

    </div>
</div>


<div class="form-group">
    <label for="horizontal-toc" class="col-sm-3 control-label">Horizontal TOC</label>
    <div class="col-sm-9">
        <input type="radio" class="radioButton" name="regionsSetting['horizontaltoc_element']" value="top-left" disabled> Top-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['horizontaltoc_element']" value="top-right" disabled> Top-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['horizontaltoc_element']" value="right" disabled> Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['horizontaltoc_element']" value="bottom" <?php if(in_array(array("type"=> "horizontaltoc_element"),$request['config']['regions']['bottom'])){ echo ' checked';}?>> Bottom &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['horizontaltoc_element']" value="bottom-left" <?php if(in_array(array("type"=> "horizontaltoc_element"),$request['config']['regions']['bottom-left'])){ echo ' checked';}?>> Bottom-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['horizontaltoc_element']" value="bottom-right" <?php if(in_array(array("type"=> "horizontaltoc_element"),$request['config']['regions']['bottom'])){ echo ' checked';}?>> Bottom-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['horizontaltoc_element']" value="items" disabled> Items &nbsp;

    </div>
</div>


<div class="form-group">
    <label for="vertical-toc" class="col-sm-3 control-label">Vertical TOC</label>
    <div class="col-sm-9">
        <input type="radio" class="radioButton" name="regionsSetting['verticaltoc_element']" value="top-left" disabled> Top-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['verticaltoc_element']" value="top-right" disabled> Top-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['verticaltoc_element']" value="right" <?php if(in_array(array("type"=> "verticaltoc_element"),$request['config']['regions']['right'])){ echo ' checked';}?>> Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['verticaltoc_element']" value="bottom" disabled> Bottom &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['verticaltoc_element']" value="bottom-left" disabled> Bottom-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['verticaltoc_element']" value="bottom-right" disabled> Bottom-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['verticaltoc_element']" value="items" disabled> Items &nbsp;

    </div>
</div>


<div class="form-group">
    <label for="itemcount" class="col-sm-3 control-label ">Item Count Element</label>
    <div class="col-sm-9">
        <input type="radio" class="radioButton" name="regionsSetting['itemcount_element']" value="top-left" <?php if(in_array(array("type"=> "itemcount_element"),$request['config']['regions']['top-left'])){ echo ' checked';}?>> Top-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['itemcount_element']" value="top-right" <?php if(in_array(array("type"=> "itemcount_element"),$request['config']['regions']['top-right'])){ echo ' checked';}?>> Top-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['itemcount_element']" value="right" disabled> Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['itemcount_element']" value="bottom" disabled> Bottom &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['itemcount_element']" value="bottom-left" disabled> Bottom-Left &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['itemcount_element']" value="bottom-right" <?php if(in_array(array("type"=> "itemcount_element"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>> Bottom-Right &nbsp;
        <input type="radio" class="radioButton" name="regionsSetting['itemcount_element']" value="items" disabled> Items &nbsp;

    </div>
</div>





