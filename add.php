<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    require_once 'db.php';

    $title = trim($_POST['title']);

    if (!empty($title)) {
        try {
            $stmt = $db->prepare("INSERT INTO tasks (title) VALUES (:title)");

            $stmt->execute([
                ':title' => $title
            ]);
        } catch (PDOException $e) {
            die("Veritabanına kaydedilirken bir hata oluştu: " . $e->getMessage());
        }
    }
}
header("Location: index.php");
exit;
?>