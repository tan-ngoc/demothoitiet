<?php
$upload_dir = "uploads/";

// Xử lý xóa 1 ảnh
if (isset($_POST['delete_file'])) {
    $filename = basename($_POST['delete_file']);
    $filepath = $upload_dir . $filename;

    if (file_exists($filepath)) {
        unlink($filepath);
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Xử lý xóa tất cả ảnh gốc (ảnh bắt đầu bằng snapshot_)
if (isset($_POST['delete_all'])) {
    $files = glob($upload_dir . "snapshot_*.jpg");
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Lấy danh sách ảnh gốc snapshot_
$image_files = glob($upload_dir . "snapshot_*.jpg");

// Sắp xếp theo thời gian mới nhất
usort($image_files, function($a, $b) {
    return filemtime($b) - filemtime($a);
});

// Giao diện hiển thị
echo "<h2>📷 Ảnh gốc từ Camera IP</h2>";

// Nút xóa tất cả
echo "<form method='POST' onsubmit='return confirm(\"Bạn có chắc muốn xóa tất cả ảnh gốc?\")'>";
echo "<input type='hidden' name='delete_all' value='1'>";
echo "<button type='submit' style='margin: 10px 0; background-color:red; color:white; padding:5px;'>🗑️ Xóa tất cả ảnh gốc</button>";
echo "</form>";

echo "<div style='display: flex; flex-wrap: wrap; gap: 10px;'>";

if (!empty($image_files)) {
    foreach ($image_files as $file) {
        $filename = basename($file);
        $upload_time = date("Y-m-d H:i:s", filemtime($file));

        echo "<div style='border: 1px solid #ccc; padding: 5px; text-align:center;'>";
        echo "<img src='$upload_dir$filename' width='200'><br>";
        echo "<small>$upload_time</small><br>";
        echo "<form method='POST' style='margin-top:5px;'>
                <input type='hidden' name='delete_file' value='$filename'>
                <button type='submit' style='color:red;'>Xóa ảnh</button>
              </form>";
        echo "</div>";
    }
} else {
    echo "<p>Không có ảnh gốc nào.</p>";
}

echo "</div>";
?>
//gallery
