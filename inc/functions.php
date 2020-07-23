<?php
function add_entry($title, $date, $time, $learned, $resources, $id = null) {
    include('connection.php');
    if($id) {
        $sql = "UPDATE entries SET title = :title, date = :date, time_spent = :time_spent, learned = :learned, resources = :resources  WHERE id = :id";
    } else {
    $sql = "INSERT INTO entries (title, date, time_spent, learned, resources) VALUES(:title, :date, :time_spent, :learned, :resources)";
    }
    try {
        $stmt = $db_connect->prepare($sql);
        if($id) {
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':time_spent', $time, PDO::PARAM_STR);
            $stmt->bindParam(':learned', $learned, PDO::PARAM_STR);
            $stmt->bindParam(':resources', $resources, PDO::PARAM_STR);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } else {
        $stmt->execute(array(':title' => $title, ':date' => $date, ':time_spent' => $time, ':learned' => $learned, ':resources' => $resources));
        }
    } catch(Exception $e) {
        echo "Error: " . $e->getMessage() . "<br />";
        return false;
    }
    return true;
}

function list_entry() {
    include('connection.php');

    try {
        return $db_connect->query("SELECT id, title, date FROM entries ORDER BY date DESC");
    } catch(Exception $e) {
        echo "Error: " . $e->getMessage() . "<br />";
        return false;
    }
}

function get_detail($id) {
    include('connection.php');
    $sql = "SELECT entries.* FROM entries WHERE id = :id";
    try {
        $stmt = $db_connect->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    } catch(Exception $e) {
        echo "Error: " . $e->getMessage() . "<br />";
        return false;
    }
    return $stmt->fetch();
}

function delete_entry($id) {
    include('connection.php');
    $sql = "DELETE FROM entries WHERE id = :id";
    try {
        $stmt = $db_connect->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    } catch(Exception $e) {
        echo "Error: " . $e->getMessage() . "<br />";
        return false;
    }
        return true;
}
?>