// Mảng chứa đường dẫn ảnh (đặt 10 ảnh b1.jpg -> b10.jpg trong thư mục "images")
const images = [];
for (let i = 1; i <= 10; i++) {
  images.push(`images/b${i}.jpg`);
}

let timeoutId; // dùng để dừng setTimeout
const imgTag = document.getElementById("hinh");
const playBtn = document.getElementById("playBtn");
const stopBtn = document.getElementById("stopBtn");

// Hàm đổi hình ngẫu nhiên
function doiHinhNgauNhien() {
  const randomIndex = Math.floor(Math.random() * images.length);
  imgTag.src = images[randomIndex];

  // Gọi lại hàm sau mỗi 700ms
  timeoutId = setTimeout(doiHinhNgauNhien, 700);
}

// Khi nhấn nút Play
playBtn.addEventListener("click", () => {
  clearTimeout(timeoutId); // tránh bị chồng lặp
  doiHinhNgauNhien();
});

// Khi nhấn nút Stop
stopBtn.addEventListener("click", () => {
  clearTimeout(timeoutId);
});
