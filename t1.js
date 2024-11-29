// Lấy phần tử "Giới thiệu" từ menu
const gioiThieuLink = document.querySelector('nav ul li a[href="#"]');

// Lấy phần tử "Giới thiệu" cần hiển thị
const gioiThieuSection = document.getElementById('gioiThieu');

// Xử lý sự kiện khi nhấp vào
gioiThieuLink.addEventListener('click', function (event) {
    event.preventDefault(); // Ngăn chuyển hướng
    gioiThieuSection.style.display = 'block'; // Hiển thị phần tử
});
