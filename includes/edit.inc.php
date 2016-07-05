<?php
$user_id = $_SESSION['uId'];
$question = $todo[1];
$polls = EditPoll($dbConnection, $todo);

unset($_POST['Task']);

$html = <<<HTML
    <div class='container' xmlns="http://www.w3.org/1999/html">
      <div class='row'>
        <div><span class='h3'>Editing: <small>$todo[1]</small></span> </div>
        <br/>
        <div>
            <form id="options" action=$formAction method='post'>
                <div> <strong> Poll Question:</div>
                <div><strong><input class='input-width' name="poll_question" value="$question" >  </div> <br/></strong>
                <strong><span class="h3">Poll Choices:<small>(Leaving an option blank will delete it too).</small></span></strong>
                $polls
                <button id="update_btn" type="submit" name="Task" value="Update_$question" class="btn btn-primary">Update Poll</button>
            </form>
        </div>
        <div>
            <br/><br/>
            <form id="add_option" action=$formAction method='post'>
                <button type="submit" name="Task" value="Insert_$question" class="btn btn-success btn-block input-width"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></button>
                <div> <strong> Add a new option:</div>
                <div><strong><input class='input-width' id="new_option" name="option" value="" ></div>
            </form> <br/><br/>
            <div class='poll_btn'><button type="submit" id="see_polls" name="Task" value="Default_" class="btn btn-primary btn-block input-width">View All Your Polls</button> </div>
        </div>
      </div>
    </div>
HTML;
echo $html;

