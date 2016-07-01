<?php
$html = <<<HTML
<div class="container">
    <div class="row">
        <div>
            <form method="post" action=$formAction>
                <strong>Enter your poll question:</strong>
                <div class="form-group"><input class="input-width" id="poll_topic" type="text" name="poll_question" placeholder="Enter your question here">
                    <br/><br/>
                    <strong>Poll Options:</strong>
                    <div id="poll_options">
                        <div class="form-group"><input class="input-width" type="text" name="poll_option[]" placeholder="Put your option here"></div>
                        <div class="form-group"><input class="input-width" type="text" name="poll_option[]" placeholder="Put your option here"></div>
                        <div class="form-group"><input class="input-width" type="text" name="poll_option[]" placeholder="Put your option here"></div>
                    </div>
                        <button type="button" id="add_option" class="btn-info btn block input-width ">Add another option</button><br/>
                        <button type="submit" name="Task" value="Create_poll" class="btn-primary margin_top btn-block input-width">Make Poll</button>
                    </div>
            </form>

        </div>
    </div>
</div>
HTML;
echo $html;