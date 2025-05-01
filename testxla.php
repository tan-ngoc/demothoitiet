<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📸 Danh sách ảnh ESP32-CAM và Dự đoán</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h2 {
            color: #2a7;
        }
        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .card {
            width: 320px;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
            text-align: center;
            word-wrap: break-word;
        }
        .card img {
            max-width: 100%;
            border-radius: 5px;
            cursor: pointer;
        }
        .label {
            margin-top: 10px;
            font-weight: bold;
            color: #009688;
            word-wrap: break-word;
            white-space: normal;
        }
        .color-circle {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-block;
            margin-left: 8px;
            border: 1px solid #333;
        }
        .timestamp {
            font-size: 0.9em;
            color: #777;
            margin-top: 4px;
        }
        .color-text {
            font-size: 0.9em;
            font-weight: normal;
            color: #333;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #fff;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
            cursor: pointer;
        }
        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>📸 Danh sách ảnh ESP32-CAM và kết quả dự đoán</h2>

    <div class="gallery">
        <?php
        $log_file = "log.txt";
        $upload_dir = "uploads/";

        if (file_exists($log_file)) {
            $lines = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach (array_reverse($lines) as $line) {
                $parts = explode(",", $line);

                if (count($parts) >= 6) {
                    $timestamp = trim($parts[0]);
                    $filename = trim($parts[1]);
                    $label = trim($parts[2]);
                    $r = intval(trim($parts[3]));
                    $g = intval(trim($parts[4]));
                    $b = intval(trim($parts[5]));

                    if (file_exists($upload_dir . $filename)) {
                        $color_style = "background-color: rgb($r,$g,$b);";
                        $color_text = "RGB($r, $g, $b)";

                        echo "<div class='card'>";
                        echo "<a href='#' onclick='openModal(\"" . $upload_dir . $filename . "\")'>";
                        echo "<img src='" . $upload_dir . $filename . "' alt='$filename'>";
                        echo "</a>";
                        echo "<div class='label'>Dự đoán: $label <span class='color-circle' style='$color_style' title='$color_text'></span></div>";
                        echo "<div class='color-text'>$color_text</div>";
                        echo "<div class='timestamp'>$timestamp</div>";
                        echo "</div>";
                    }
                }
            }
        } else {
            echo "<p>⚠️ Chưa có ảnh nào được tải lên.</p>";
        }
        ?>
    </div>

    <!-- Modal for large image -->
    <div id="myModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="imgModal">
    </div>

    <script>
        function openModal(imageSrc) {
            var modal = document.getElementById("myModal");
            var modalImg = document.getElementById("imgModal");
            modal.style.display = "block";
            modalImg.src = imageSrc;
        }

        function closeModal() {
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
        }
    </script>
</body>
</html>
