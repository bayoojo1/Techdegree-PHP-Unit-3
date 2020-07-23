<?php 
require 'inc/functions.php';
$pageTitle = "My Journal";

if(isset($_GET['id'])) {
    list($id, $title, $date, $time, $learned, $resources) = get_detail(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
}

if(isset($_POST['delete'])) {
    if(delete_entry(filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_NUMBER_INT))) {
        header('location:index.php?msg=Entry+Delete');
        exit;
    } else {
        header('location:detail.php?msg=Unable+to+Delete+Entry');
        exit;
    }
}

if(isset($_GET['msg'])) {
    $error_message = trim(filter_input(INPUT_GET, 'msg', FILTER_SANITIZE_STRING));
}

include('inc/header.php');
?>
        <section>
            <div class="container">
                <div class="entry-list single">
                <?php
                if(isset($error_message)) {
                    echo "<p class='message'>$error_message</p>";
                }
                ?>
                    <article>
                        <h1><?php echo $title; ?></h1>
                        <time datetime="<? echo $date; ?>"><?php echo date("F d, Y", strtotime($date)); ?></time>
                        <div class="entry">
                            <h3>Time Spent: </h3>
                            <p><?php echo $time; ?></p>
                        </div>
                        <div class="entry">
                            <h3>What I Learned:</h3>
                            <p><?php echo nl2br($learned); ?></p>
                        </div>
                        <div class="entry">
                            <h3>Resources to Remember:</h3>
                            <ul>
                            <?php 
                            if(isset($resources)) {
                            $array = explode('.', $resources);
                            
                            foreach($array as $arr) {
                                if(!empty($arr)) {
                                echo "<li>$arr</li>";
                                }
                            }
                        }
                            ?>
                            </ul>
                        </div>
                    </article>
                </div>
            </div>
            <div class="edit">
                <p><a href="edit.php?id=<?php echo $id; ?>">Edit Entry</a></p>
            </div>
            <div class="delete">
                <form method='post' action='detail.php' onsubmit="return confirm('Are you sure you want to delete this task?')">
                <input type='hidden' value="<?php echo $id; ?>" name='delete' />
                <input type='submit' class='button--delete' value='Delete' />
                </form>
            </div>
        </section>
        <?php include("inc/footer.php"); ?>