async function fetchData() {
    try {
        const response = await fetch('http://192.168.242.90/'); // Thay <ESP32_IP> bằng IP của ESP32
        const data = await response.json();
        document.querySelector("section").innerHTML = `
            <h2>HIỂN THỊ THÔNG TIN THỜI TIẾT RA BẢNG LED</h2>
            <p>Nhiệt độ: ${data.temperature} °C</p>
            <p>Độ ẩm: ${data.humidity} %</p>
        `;
    } catch (error) {
        console.error("Error fetching data:", error);
    }
}

setInterval(fetchData, 5000); // Lấy dữ liệu mỗi 5 giây
