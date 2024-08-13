<?php
$uploadDirectory = "uploads/";
$hashedPassword = '$2b$12$9CPdiVwfkYfSgVM2lWKHxePr6Qc6Pom18CAhgyjzmOJso8cv5gPaS'; // Замените это на сгенерированный хеш пароля

// Проверка пароля
if (isset($_POST['password']) && password_verify($_POST['password'], $hashedPassword)) {
    if (isset($_FILES['fileToUpload'])) {
        $targetFile = $uploadDirectory . basename($_FILES['fileToUpload']['name']);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Проверка, является ли файл изображением
        $check = getimagesize($_FILES['fileToUpload']['tmp_name']);
        if($check !== false) {
            echo "Файл является изображением - " . $check['mime'] . ".";
            $uploadOk = 1;
        } else {
            echo "Файл не является изображением.";
            $uploadOk = 0;
        }

        // Проверка, существует ли файл
        if (file_exists($targetFile)) {
            echo "Извините, файл уже существует.";
            $uploadOk = 0;
        }

        // Проверка размера файла (например, не более 5MB)
        if ($_FILES['fileToUpload']['size'] > 5000000) {
            echo "Извините, ваш файл слишком большой.";
            $uploadOk = 0;
        }

        // Разрешение только определенных форматов файлов
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            echo "Извините, только JPG, JPEG, PNG и GIF файлы разрешены.";
            $uploadOk = 0;
        }

        // Проверка на ошибки и загрузка файла
        if ($uploadOk == 0) {
            echo "Извините, ваш файл не был загружен.";
        } else {
            if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFile)) {
                echo "Файл ". htmlspecialchars(basename($_FILES['fileToUpload']['name'])). " был загружен.";
            } else {
                echo "Извините, произошла ошибка при загрузке вашего файла.";
            }
        }
    }
} else {
    echo "Неверный пароль.";
}
?>

