<?php
$target_dir = "uploads/";

// Tạo thư mục nếu chưa có
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// Cấu hình database
$servername = "localhost";
$username = "epaeywtw_saveanhesp32cam";
$password = "nheyj4aBXSdZdKynhVDE";
$dbname = "epaeywtw_saveanhesp32cam";

// Kết nối database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

// Tìm số thứ tự lớn nhất từ các file hiện có
$files = glob($target_dir . "esp32cam*.{jpg,jpeg,png}", GLOB_BRACE);
$max_index = 0;
foreach ($files as $file) {
    if (preg_match('/esp32cam(\d+)\.(jpg|jpeg|png)/i', basename($file), $matches)) {
        $num = intval($matches[1]);
        if ($num > $max_index) $max_index = $num;
    }
}
$new_index = $max_index + 1;

// Xác định loại file
$imageFileType = strtolower(pathinfo($_FILES["imageFile"]["name"], PATHINFO_EXTENSION));
$filename = "esp32cam" . sprintf("%03d", $new_index) . "." . $imageFileType;
$target_file = $target_dir . $filename;

// Kiểm tra file ảnh
$uploadOk = 1;
$check = getimagesize($_FILES["imageFile"]["tmp_name"]);
if ($check === false) {
    echo "File is not an image.";
    $uploadOk = 0;
}

if (!in_array($imageFileType, ["jpg", "jpeg", "png"])) {
    echo "Only JPG, JPEG, PNG files are allowed.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "Upload failed.";
} else {
    if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $target_file)) {
        // Lưu tên file vào database
        $stmt = $conn->prepare("INSERT INTO photos (filename) VALUES (?)");
        $stmt->bind_param("s", $filename);
        $stmt->execute();
        echo "Upload successful: " . htmlspecialchars($filename);
        $stmt->close();
    } else {
        echo "Error uploading file.";
    }
}

$conn->close();
?>
