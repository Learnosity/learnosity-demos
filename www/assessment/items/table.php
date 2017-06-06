<div class="divTable">
    <div class="divTableBody">
        <div class="divTableRow">
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">Top Left</div>
            <div class="divTableCell">Top Right</div>
            <div class="divTableCell">Right</div>
            <div class="divTableCell">Bottom</div>
            <div class="divTableCell">Bottom Left</div>
            <div class="divTableCell">Bottom Right</div>
        </div>
        <div class="divTableRow">
            <div class="divTableCell"><label for="top-left" class="col-sm-6 control-label resize">Title</label></div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" id="rad0" name="regionsSetting['title_element']" value="top-left" <?php if(in_array(array("type"=> "title_element"),$request['config']['regions']['top-left'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['title_element']" value="topRight" disabled>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['title_element']" value="right" disabled>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['title_element']" value="bottom" disabled>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['title_element']" value="bottomLeft" disabled>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['title_element']" value="bottomRight" disabled>
                </div>
            </div>
        </div>
        <div class="divTableRow">
            <div class="divTableCell"><label for="top-left" class="col-sm-6 control-label resize">Next Button</label></div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['next_button']" value="top-left" <?php if(in_array(array("type"=> "next_button"),$request['config']['regions']['top-left'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['next_button']" value="top-right" <?php if(in_array(array("type"=> "next_button"),$request['config']['regions']['top-right'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['next_button']" value="right" <?php if(in_array(array("type"=> "next_button"),$request['config']['regions']['right'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['next_button']" value="bottom" <?php if(in_array(array("type"=> "next_button"),$request['config']['regions']['bottom'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['next_button']" value="bottom-left" <?php if(in_array(array("type"=> "next_button"),$request['config']['regions']['bottom-left'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['next_button']" value="bottom-right" <?php if(in_array(array("type"=> "next_button"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>>
                </div>
            </div>
        </div>
        <div class="divTableRow">
            <div class="divTableCell"><label for="top-left" class="col-sm-6 control-label  resize">Previous Button</label></div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['previous_button']" value="top-left" <?php if(in_array(array("type"=> "previous_button"),$request['config']['regions']['top-left'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['previous_button']" value="top-right" <?php if(in_array(array("type"=> "previous_button"),$request['config']['regions']['top-right'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['previous_button']" value="right" <?php if(in_array(array("type"=> "previous_button"),$request['config']['regions']['right'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['previous_button']" value="bottom" <?php if(in_array(array("type"=> "previous_button"),$request['config']['regions']['bottom'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['previous_button']" value="bottom-left" <?php if(in_array(array("type"=> "previous_button"),$request['config']['regions']['bottom-left'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['previous_button']" value="bottom-right" <?php if(in_array(array("type"=> "previous_button"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>>
                </div>
            </div>
        </div>
        <div class="divTableRow">
            <div class="divTableCell"><label for="top-left" class="col-sm-6 control-label  resize">Pause Button</label></div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['pause_button']" value="top-left" <?php if(in_array(array("type"=> "pause_button"),$request['config']['regions']['top-left'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['pause_button']" value="top-right" <?php if(in_array(array("type"=> "pause_button"),$request['config']['regions']['top-right'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['pause_button']" value="right" <?php if(in_array(array("type"=> "pause_button"),$request['config']['regions']['right'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['pause_button']" value="bottom" <?php if(in_array(array("type"=> "pause_button"),$request['config']['regions']['bottom'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['pause_button']" value="bottom-left" <?php if(in_array(array("type"=> "pause_button"),$request['config']['regions']['bottom-left'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['pause_button']" value="bottom-right" <?php if(in_array(array("type"=> "pause_button"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>>
                </div>
            </div>
        </div>
        <div class="divTableRow">
            <div class="divTableCell"><label for="top-left" class="col-sm-6 control-label  resize">Save Button</label></div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['save_button']" value="top-left" <?php if(in_array(array("type"=> "save_button"),$request['config']['regions']['top-left'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['save_button']" value="top-right" <?php if(in_array(array("type"=> "save_button"),$request['config']['regions']['top-right'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['save_button']" value="right" <?php if(in_array(array("type"=> "save_button"),$request['config']['regions']['right'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['save_button']" value="bottom" <?php if(in_array(array("type"=> "save_button"),$request['config']['regions']['bottom'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['save_button']" value="bottom-left" <?php if(in_array(array("type"=> "save_button"),$request['config']['regions']['bottom-left'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['save_button']" value="bottom-right" <?php if(in_array(array("type"=> "save_button"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>>
                </div>
            </div>
        </div>
        <div class="divTableRow">
            <div class="divTableCell"><label for="top-left" class="col-sm-6 control-label  resize">Accessibility Button</label></div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['accessibility_button']" value="top-left" <?php if(in_array(array("type"=> "accessibility_button"),$request['config']['regions']['top-left'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['accessibility_button']" value="top-right" <?php if(in_array(array("type"=> "accessibility_button"),$request['config']['regions']['top-right'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['accessibility_button']" value="right" <?php if(in_array(array("type"=> "accessibility_button"),$request['config']['regions']['right'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['accessibility_button']" value="bottom" <?php if(in_array(array("type"=> "accessibility_button"),$request['config']['regions']['bottom'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['accessibility_button']" value="bottom-left" <?php if(in_array(array("type"=> "accessibility_button"),$request['config']['regions']['bottom-left'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['accessibility_button']" value="bottom-right" <?php if(in_array(array("type"=> "accessibility_button"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>>
                </div>
            </div>
        </div>
        <div class="divTableRow">
            <div class="divTableCell"><label for="top-left" class="col-sm-6 control-label  resize">Full Screen Button</label></div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['fullscreen_button']" value="top-left" <?php if(in_array(array("type"=> "fullscreen_button"),$request['config']['regions']['top-left'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['fullscreen_button']" value="top-right" <?php if(in_array(array("type"=> "fullscreen_button"),$request['config']['regions']['top-right'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['fullscreen_button']" value="right" <?php if(in_array(array("type"=> "fullscreen_button"),$request['config']['regions']['right'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['fullscreen_button']" value="bottom" <?php if(in_array(array("type"=> "fullscreen_button"),$request['config']['regions']['bottom'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['fullscreen_button']" value="bottom-left" <?php if(in_array(array("type"=> "fullscreen_button"),$request['config']['regions']['bottom-left'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['fullscreen_button']" value="bottom-right" <?php if(in_array(array("type"=> "fullscreen_button"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>>
                </div>
            </div>
        </div>
        <div class="divTableRow">
            <div class="divTableCell"><label for="top-left" class="col-sm-6 control-label  resize">Review Screen Button</label></div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['reviewscreen_button']" value="top-left" <?php if(in_array(array("type"=> "reviewscreen_button"),$request['config']['regions']['top-left'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['reviewscreen_button']" value="top-right" <?php if(in_array(array("type"=> "reviewscreen_button"),$request['config']['regions']['top-right'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['reviewscreen_button']" value="right" <?php if(in_array(array("type"=> "reviewscreen_button"),$request['config']['regions']['right'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['reviewscreen_button']" value="bottom" <?php if(in_array(array("type"=> "reviewscreen_button"),$request['config']['regions']['bottom'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['reviewscreen_button']" value="bottom-left" <?php if(in_array(array("type"=> "reviewscreen_button"),$request['config']['regions']['bottom-left'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['reviewscreen_button']" value="bottom-right" <?php if(in_array(array("type"=> "reviewscreen_button"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>>
                </div>
            </div>
        </div>
        <div class="divTableRow">
            <div class="divTableCell"><label for="top-left" class="col-sm-6 control-label  resize">Calculator Button</label></div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['calculator_button']" value="top-left" <?php if(in_array(array("type"=> "calculator_button"),$request['config']['regions']['top-left'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['calculator_button']" value="top-right" <?php if(in_array(array("type"=> "calculator_button"),$request['config']['regions']['top-right'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['calculator_button']" value="right" <?php if(in_array(array("type"=> "calculator_button"),$request['config']['regions']['right'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['calculator_button']" value="bottom" <?php if(in_array(array("type"=> "calculator_button"),$request['config']['regions']['bottom'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['calculator_button']" value="bottom-left" <?php if(in_array(array("type"=> "calculator_button"),$request['config']['regions']['bottom-left'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['calculator_button']" value="bottom-right" <?php if(in_array(array("type"=> "calculator_button"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>>
                </div>
            </div>
        </div>
        <div class="divTableRow">
            <div class="divTableCell"><label for="top-left" class="col-sm-6 control-label  resize">Flag Item Button</label></div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['flagitem_button']" value="top-left" <?php if(in_array(array("type"=> "flagitem_button"),$request['config']['regions']['top-left'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['flagitem_button']" value="top-right" <?php if(in_array(array("type"=> "flagitem_button"),$request['config']['regions']['top-right'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['flagitem_button']" value="right" <?php if(in_array(array("type"=> "flagitem_button"),$request['config']['regions']['right'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['flagitem_button']" value="bottom" <?php if(in_array(array("type"=> "flagitem_button"),$request['config']['regions']['bottom'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['flagitem_button']" value="bottom-left" <?php if(in_array(array("type"=> "flagitem_button"),$request['config']['regions']['bottom-left'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['flagitem_button']" value="bottom-right" <?php if(in_array(array("type"=> "flagitem_button"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>>
                </div>
            </div>
        </div>
        <div class="divTableRow">
            <div class="divTableCell"><label for="top-left" class="col-sm-6 control-label  resize">Masking Button</label></div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['masking_button']" value="top-left" <?php if(in_array(array("type"=> "masking_button"),$request['config']['regions']['top-left'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['masking_button']" value="top-right" <?php if(in_array(array("type"=> "masking_button"),$request['config']['regions']['top-right'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['masking_button']" value="right" <?php if(in_array(array("type"=> "masking_button"),$request['config']['regions']['right'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['masking_button']" value="bottom" <?php if(in_array(array("type"=> "masking_button"),$request['config']['regions']['bottom'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['masking_button']" value="bottom-left" <?php if(in_array(array("type"=> "masking_button"),$request['config']['regions']['bottom-left'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['masking_button']" value="bottom-right" <?php if(in_array(array("type"=> "masking_button"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>>
                </div>
            </div>
        </div>
        <div class="divTableRow">
            <div class="divTableCell"><label for="top-left" class="col-sm-6 control-label  resize">Timer</label></div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['timer_element']" value="top-left" <?php if(in_array(array("type"=> "timer_element"),$request['config']['regions']['top-left'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['timer_element']" value="top-right" <?php if(in_array(array("type"=> "timer_element"),$request['config']['regions']['top-right'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['timer_element']" value="right" disabled>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['timer_element']" value="bottom" disabled>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['timer_element']" value="bottom-left" disabled>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['timer_element']" value="bottom-right" <?php if(in_array(array("type"=> "timer_element"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>>
                </div>
            </div>
        </div>
        <div class="divTableRow">
            <div class="divTableCell"><label for="top-left" class="col-sm-6 control-label  resize">Reading Timer</label></div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['reading_timer_element']" value="top-left" <?php if(in_array(array("type"=> "reading_timer_element"),$request['config']['regions']['top-left'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['reading_timer_element']" value="top-right" <?php if(in_array(array("type"=> "reading_timer_element"),$request['config']['regions']['top-right'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['reading_timer_element']" value="right" disabled>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['reading_timer_element']" value="bottom" disabled>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['reading_timer_element']" value="bottom-left" disabled>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['reading_timer_element']" value="bottom-right" <?php if(in_array(array("type"=> "reading_timer_element"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>>
                </div>
            </div>
        </div>
        <div class="divTableRow">
            <div class="divTableCell"><label for="top-left" class="col-sm-6 control-label  resize">Horizontal TOC</label></div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['horizontaltoc_element']" value="top-left" disabled>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['horizontaltoc_element']" value="top-right" disabled>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['horizontaltoc_element']" value="right" disabled>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['horizontaltoc_element']" value="bottom" <?php if(in_array(array("type"=> "horizontaltoc_element"),$request['config']['regions']['bottom'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['horizontaltoc_element']" value="bottom-left" <?php if(in_array(array("type"=> "horizontaltoc_element"),$request['config']['regions']['bottom-left'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['horizontaltoc_element']" value="bottom-right" <?php if(in_array(array("type"=> "horizontaltoc_element"),$request['config']['regions']['bottom'])){ echo ' checked';}?>>
                </div>
            </div>
        </div>
        <div class="divTableRow">
            <div class="divTableCell"><label for="top-left" class="col-sm-6 control-label  resize">Vertical TOC</label></div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['verticaltoc_element']" value="top-left" disabled>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['verticaltoc_element']" value="top-right" disabled>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['verticaltoc_element']" value="right" <?php if(in_array(array("type"=> "verticaltoc_element"),$request['config']['regions']['right'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['verticaltoc_element']" value="bottom" disabled>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['verticaltoc_element']" value="bottom-left" disabled>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['verticaltoc_element']" value="bottom-right" disabled>
                </div>
            </div>
        </div>
        <div class="divTableRow">
            <div class="divTableCell"><label for="top-left" class="col-sm-6 control-label resize">Item Count Element</label></div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['itemcount_element']" value="top-left" <?php if(in_array(array("type"=> "itemcount_element"),$request['config']['regions']['top-left'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['itemcount_element']" value="top-right" <?php if(in_array(array("type"=> "itemcount_element"),$request['config']['regions']['top-right'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['itemcount_element']" value="right" disabled>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['itemcount_element']" value="bottom" disabled>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['itemcount_element']" value="bottom-left" disabled>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['itemcount_element']" value="bottom-right" <?php if(in_array(array("type"=> "itemcount_element"),$request['config']['regions']['bottom-right'])){ echo ' checked';}?>>
                </div>
            </div>
        </div>
        <div class="divTableRow">
            <div class="divTableCell"><label for="top-left" class="col-sm-6 control-label  resize">Separator Element</label></div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['separator_element']" value="top-left" disabled>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['separator_element']" value="top-right" disabled>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['separator_element']" value="right" <?php if(in_array(array("type"=> "separator_element"),$request['config']['regions']['right'])){ echo ' checked';}?>>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['separator_element']" value="bottom" disabled>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['separator_element']" value="bottom-left" disabled>
                </div>
            </div>
            <div class="divTableCell">
                <div class="col-sm-6">
                    <input type="radio" class="radioButton" name="regionsSetting['separator_element']" value="bottom-right" disabled>
                </div>
            </div>
        </div>
    </div>
</div>