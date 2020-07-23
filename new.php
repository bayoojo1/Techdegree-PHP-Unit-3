<?php 
require 'inc/functions.php';
$pageTitle = "My Journal";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
    $time = trim(filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_STRING));
    $learned = filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING);
    $resources = filter_input(INPUT_POST, 'ResourcesToRemember', FILTER_SANITIZE_STRING);

    $dateMatch = explode('-', $date);
    echo strlen($dateMatch[0]);
    echo strlen($dateMatch[1]);
    echo strlen($dateMatch[2]);
    echo count($dateMatch);
    if(empty($learned) || empty($title) || empty($date) || empty($time)) {
        $error_message = 'Please fill in the required fields: Title, Date, Time, Learned';
    } else if(count($dateMatch) != 3
            || strlen($dateMatch[0]) != 4
            || strlen($dateMatch[1]) != 2
            || strlen($dateMatch[2]) != 2
            || !checkdate($dateMatch[1], $dateMatch[2], $dateMatch[0])) {
                $error_message = 'Invalid date';
    } else { 
        if (add_entry($title, $date, $time, $learned, $resources)) {
            header('location: index.php');
            exit;
        } else {
            $error_message = "Could not add entry!";
        }
    }
}

if(isset($_GET['msg'])) {
    $error_message = trim(filter_input(INPUT_GET, 'msg', FILTER_SANITIZE_STRING));
}

include('inc/header.php');
?>
        <section>
            <div class="container">
                <div class="new-entry">
                    <h2>New Entry</h2>
                    <?php 
                    if(isset($error_message)) {
                        echo "<p class='message'>$error_message</p>";
                    }
                    ?>
                    <form method="post" action="new.php">
                        <label for="title"> Title</label>
                        <input id="title" type="text" name="title"><br>
                        <label for="date">Date</label>
                        <input id="date" type="date" name="date"><br>
                        <label for="time-spent"> Time Spent</label>
                        <input id="time-spent" type="text" name="timeSpent"><br>
                        <label for="what-i-learned">What I Learned</label>
                        <textarea id="what-i-learned" rows="5" name="whatILearned"></textarea>
                        <label for="resources-to-remember">Resources to Remember</label>
                        <textarea id="resources-to-remember" rows="5" name="ResourcesToRemember" placeholder="Please ensure you end each entry with full stop."></textarea>
                        <input type="submit" value="Publish Entry" class="button">
                        <a href="#" class="button button-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </section>
        <?php include("inc/footer.php"); ?>