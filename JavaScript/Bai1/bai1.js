function nhapSinhVien() {
  const mssv = prompt("Nhập mã số SV", "001");
  if (mssv === null) return;

  const hoten = prompt("Nhập họ tên", "Nguyễn Dương Minh Hy");
  if (hoten === null) return;

  const lop = prompt("Nhập lớp", "CN2308CLCA");
  if (lop === null) return;

  document.getElementById("mssv").textContent = (mssv || "").trim() || "—";
  document.getElementById("hoten").textContent = (hoten || "").trim() || "—";
  document.getElementById("lop").textContent  = (lop  || "").trim()  || "—";
}

window.addEventListener("DOMContentLoaded", () => {
  nhapSinhVien();
  document.getElementById("reInput").addEventListener("click", nhapSinhVien);
});
