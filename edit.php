<?php 
require 'inc/functions.php';

$pageTitle = "My Journal | Edit Entry";

if(isset($_GET['id'])) {
    list($id, $title, $date, $time, $learned, $resources) = get_detail(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
    $time = trim(filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_STRING));
    $learned = filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING);
    $resources = filter_input(INPUT_POST, 'ResourcesToRemember', FILTER_SANITIZE_STRING);

    $dateMatch = explode('-', $date);

    if(empty($learned) || empty($title) || empty($date) || empty($time)) {
        $error_message = 'Please fill in the required fields: Title, Date, Time, Learned';
    } else if(count($dateMatch) != 3
            || strlen($dateMatch[0]) != 4
            || strlen($dateMatch[1]) != 2
            || strlen($dateMatch[2]) != 2
            || !checkdate($dateMatch[1], $dateMatch[2], $dateMatch[0])) {
                $error_message = 'Invalid date';
    } else { 
        if (add_entry($title, $date, $time, $learned, $resources, $id)) {
            header('location: index.php');
            exit;
        } else {
            $error_message = "Could not update entry!";
        }
    }
}

include('inc/header.php');
?>
        <section>
            <div class="container">
                <div class="edit-entry">
                    <h2>Edit Entry</h2>
                    <?php 
                    if(isset($error_message)) {
                        echo "<p class='message'>$error_message</p>";
                    }
                    ?>
                    <form method="post" action="edit.php">
                        <label for="title"> Title</label>
                        <input id="title" type="text" name="title" value="<?php echo htmlspecialchars($title); ?>"><br>
                        <label for="date">Date</label>
                        <input id="date" type="date" name="date" value="<?php echo htmlspecialchars($date); ?>"><br>
                        <label for="time-spent"> Time Spent</label>
                        <input id="time-spent" type="text" name="timeSpent" value="<?php echo htmlspecialchars($time); ?>"><br>
                        <label for="what-i-learned">What I Learned</label>
                        <textarea id="what-i-learned" rows="5" name="whatILearned"><?php echo htmlspecialchars($learned); ?></textarea>
                        <label for="resources-to-remember">Resources to Remember</label>
                        <textarea id="resources-to-remember" rows="5" name="ResourcesToRemember"><?php echo htmlspecialchars($resources); ?></textarea>
                        <?php 
                        if(!empty($id)) {
                            echo '<input type="hidden" name="id" value="' . $id . '"/>';
                        }
                        ?>
                        <input type="submit" value="Update Entry" class="button">
                        <a href="index.php" class="button button-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </section>
        <?php include("inc/footer.php"); ?>