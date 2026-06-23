<?php
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['yeni_title'])) {

    $id = $_POST['id'];
    $yeni_metin = $_POST['yeni_title'];
    try {
        $stmt = $db->prepare("UPDATE tasks SET title = :title, guncelleme_tarihi = CURRENT_TIMESTAMP WHERE id = :id");
        $stmt->execute([
            ':title' => $yeni_metin,
            ':id' => $id
        ]);
    } catch (PDOException $e) {
    }
}
header("Location: index.php?durum=guncellendi");
exit;