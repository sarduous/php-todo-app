<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {

    require_once 'db.php';
    $id = $_POST['id'];

    try {
        $stmt = $db->prepare("UPDATE tasks SET is_completed = 1, bitirme_tarihi = CURRENT_TIMESTAMP WHERE id = :id");


        $stmt->execute([
            ':id' => $id
        ]);
    } catch (PDOException $e) {
        die("Güncelleme hatası: " . $e->getMessage());
    }
}
header("Location: index.php?durum=bitti");
exit;
?>
<?php