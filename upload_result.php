<?php
$target_dir = "uploads/";

// Tạo thư mục nếu chưa có
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// Nhận thông tin từ POST
$label = $_POST['label'] ?? 'unknown';
$fruit_count = $_POST['fruit_count'] ?? '0';  // ✅ Thêm dòng này
$color_r = $_POST['color_r'] ?? '0';
$color_g = $_POST['color_g'] ?? '0';
$color_b = $_POST['color_b'] ?? '0';

// Xử lý ảnh upload
if (isset($_FILES['image'])) {
    $filename = basename($_FILES['image']['name']);
    $target_file = $target_dir . $filename;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Kiểm tra định dạng file hợp lệ
    if (in_array($imageFileType, ["jpg", "jpeg", "png"])) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "✅ Upload thành công. Tên ảnh: $filename, Dự đoán: $label, Số quả: $fruit_count, Màu: RGB($color_r, $color_g, $color_b)";

            // Ghi log kết quả
            $log = fopen("log.txt", "a");
            $timestamp = date("Y-m-d H:i:s");
            fwrite($log, "$timestamp,$filename,$label,$fruit_count,$color_r,$color_g,$color_b\n");
            fclose($log);

            // (Tùy chọn) Ghi vào database
            /*
            $conn = new mysqli("localhost", "user", "pass", "db");
            if ($conn->connect_error) {
                die("Kết nối DB thất bại: " . $conn->connect_error);
            }
            $stmt = $conn->prepare("INSERT INTO photos (filename, label, fruit_count, color_r, color_g, color_b) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssiiii", $filename, $label, $fruit_count, $color_r, $color_g, $color_b);
            $stmt->execute();
            $stmt->close();
            $conn->close();
            */
        } else {
            echo "❌ Lỗi upload ảnh.";
        }
    } else {
        echo "❌ Chỉ chấp nhận JPG, JPEG, PNG.";
    }
} else {
    echo "❌ Không nhận được ảnh.";
}
?>
