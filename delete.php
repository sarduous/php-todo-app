<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {

    require_once 'db.php';
    $id = $_POST['id'];

    try {

        $stmt = $db->prepare("DELETE FROM tasks WHERE id = :id");


        $stmt->execute([
            ':id' => $id
        ]);
    } catch (PDOException $e) {
        die("Silme hatası: " . $e->getMessage());
    }
}

header("Location: index.php?durum=silindi");
exit;
?>