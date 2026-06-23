<?php
require 'db.php';
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.23.0/sweetalert2.min.css"
        integrity="sha512-Ivy7sPrd6LPp20adiK3al16GBelPtqswhJnyXuha3kGtmQ1G2qWpjuipfVDaZUwH26b3RDe8x707asEpvxl7iA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e8f5e9;
            color: #1b5e20;
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-image: linear-gradient(to bottom right, #e8f5e9, #c8e6c9);
            min-height: 100vh;
        }

        h1 {
            text-align: center;
            color: #2e7d32;
            margin-bottom: 30px;
        }

        form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        input[type="text"] {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #81c784;
            border-radius: 4px;
            outline: none;
            font-size: 16px;
        }

        input[type="text"]:focus {
            border-color: #4caf50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        }

        button {
            padding: 10px 20px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.1s;
            font-weight: bold;
            font-size: 16px;
        }

        button:hover {
            background-color: #388e3c;
        }

        button:active {
            transform: scale(0.98);
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background-color: white;
            color: black;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 4px;
            border-left: 5px solid #4caf50;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        li form {
            margin: 0;
            margin-left: 10px;
        }

        li>span {
            flex-grow: 1;
        }

        button[style*="color: red;"] {
            background-color: #ffebee;
            color: #c62828 !important;
            border: 1px solid #ef9a9a;
        }

        button[style*="color: red;"]:hover {
            background-color: #ffcdd2;
            color: #b71c1c !important;
        }

        del {
            color: #9e9e9e;
        }
    </style>

</head>

<body>
    <h1>Yapılacaklar</h1>

    <form action="add.php" method="POST">
        <input type="text" name="title" placeholder="Lüfen yeni bir görev ekleyiniz." required>
        <button type="submit">Ekle</button>
    </form>

    <hr>

    <ul>
        <?php
        $query = $db->query("SELECT * FROM tasks ORDER BY id DESC");
        $tasks = $query->fetchAll(PDO::FETCH_ASSOC);

        if (count($tasks) === 0) {
            echo "<li><em>Şu anda yeni bir göreviniz yok.</em></li>";
        } else {
            foreach ($tasks as $task) {
                $safe_title = htmlspecialchars($task['title']);
                $task_id = $task['id'];

                $tarih = date("d/m/Y", strtotime($task['tarih']));
                $saat = date("H:i:s", strtotime($task['tarih']));

                if (!empty($task['guncelleme_tarihi'])) {
                    $g_tarih = date("d/m/Y", strtotime($task['guncelleme_tarihi']));
                    $g_saat = date("H:i:s", strtotime($task['guncelleme_tarihi']));
                    $zaman_metni = "Görevin değiştirilme tarihi: " . $g_tarih . " Saat: " . $g_saat;
                } else {
                    $zaman_metni = "Görevin kaydedilme tarihi: " . $tarih . " Saat: " . $saat;
                }

                echo "<li>";

                if ($task['is_completed'] == 1) {
                    $bitirme_tarihi = date("d/m/Y", strtotime($task['bitirme_tarihi']));
                    $bitirme_saati = date("H:i:s", strtotime($task['bitirme_tarihi']));

                    echo '<span style="flex-grow: 1;">';
                    echo "<del>" . $safe_title . "</del> (Tamamlandı)<br>";

                    echo $zaman_metni . "<br>";

                    echo "Görevin tamamlanma tarihi: " . $bitirme_tarihi . " Saat: " . $bitirme_saati;
                    echo '</span>';

                    echo '<form action="delete.php" method="POST" style="margin-left: 5px;">
                            <input type="hidden" name="id" value="' . $task_id . '">
                            <button type="submit" style="color: red;">Sil</button>
                          </form>';
                } else {
                    echo '<div id="gorunum_' . $task_id . '" style="display: flex; align-items: center; width: 100%;">';

                    echo '<span style="flex-grow: 1;">' . $safe_title . ' - ' . $zaman_metni . '</span>';

                    echo '<button type="button" onclick="guncelleAc(' . $task_id . ')" style="margin-left: 10px;">Güncelle</button>';

                    echo '<form action="bitir.php" method="POST" style="margin-left: 5px;">
                            <input type="hidden" name="id" value="' . $task_id . '">
                            <button type="submit">Bitir</button>
                          </form>';

                    echo '<form action="delete.php" method="POST" style="margin-left: 5px;">
                            <input type="hidden" name="id" value="' . $task_id . '">
                            <button type="submit" style="color: red;">Sil</button>
                          </form>';

                    echo '</div>';

                    echo '<form id="form_' . $task_id . '" action="update.php" method="POST" style="display: none; width: 100%; gap: 10px; align-items: center;">
                            <input type="hidden" name="id" value="' . $task_id . '">
                            <input type="text" name="yeni_title" value="' . $safe_title . '" required style="flex-grow: 1; margin: 0;">
                            <button type="submit">Kaydet</button>
                            <button type="button" onclick="guncelleKapat(' . $task_id . ')" style="background-color: #9e9e9e; color: white;">İptal</button>
                          </form>';
                }

                echo "</li>";
            }
        }
        ?>
    </ul>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.23.0/sweetalert2.min.js"
        integrity="sha512-pnPZhx5S+z5FSVwy62gcyG2Mun8h6R+PG01MidzU+NGF06/ytcm2r6+AaWMBXAnDHsdHWtsxS0dH8FBKA84FlQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        function guncelleAc(id) {
            document.getElementById('gorunum_' + id).style.display = 'none';
            document.getElementById('form_' + id).style.display = 'flex';
        }
        function guncelleKapat(id) {
            document.getElementById('gorunum_' + id).style.display = 'flex';
            document.getElementById('form_' + id).style.display = 'none';
        }

        <?php
        if (isset($_GET['durum']) && $_GET['durum'] == 'guncellendi') {
            echo "
                Swal.fire({
                    icon: 'success',
                    title: 'Başarılı!',
                    text: 'Göreviniz başarıyla güncellendi.',
                    showConfirmButton: false,
                    timer: 2000
                });
            ";
        }
        if (isset($_GET['durum']) && $_GET['durum'] == 'silindi') {
            echo "
                Swal.fire({
                    icon: 'info', 
                    title: 'Silindi!',
                    text: 'Görev listeden tamamen kaldırıldı.',
                    showConfirmButton: false,
                    timer: 2000
                });
            ";
        }
        if (isset($_GET['durum']) && $_GET['durum'] == 'bitti') {
            echo "
                Swal.fire({
                    icon: 'info', 
                    title: 'Tamamlandı!',
                    text: 'Görevinizi tamamladınız.',
                    showConfirmButton: false,
                    timer: 2000
                });
            ";
        }

        ?>
    </script>
</body>

</html>