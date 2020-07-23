<?php 
require 'inc/functions.php';

$pageTitle = "My Journal";
include('inc/header.php');
?>
        <section>
            <div class="container">
                <div class="entry-list">
                <?php
                foreach(list_entry() as $list) { 
                    echo "<article>";
                        echo "<h2><a href='detail.php?id=" . $list['id'] . "'>" . $list['title'] . "</a></h2>";
                        echo "<time datetime='" . $list['date'] . "'>" . date("F d, Y", strtotime($list['date'])) . "</time>";
                    echo "</article>";
                }
                ?>
                </div>
            </div>
        </section>
        <?php include("inc/footer.php"); ?>