// Tính tổng thành tiền
function calculateTotal() {
  let total = 0;
  
  $('.quantity').each(function() {
    const quantity = parseInt($(this).val()) || 0;
    const price = parseInt($(this).data('price')) || 0;
    total += quantity * price;
  });
  
  $('#totalAmount').text(total.toLocaleString('vi-VN'));
}

// Xử lý sự kiện khi số lượng thay đổi
$(document).ready(function() {
  // Tính tổng ban đầu
  calculateTotal();
  
  // Lắng nghe sự kiện thay đổi số lượng
  $('.quantity').on('input change', function() {
    // Đảm bảo giá trị không âm
    if ($(this).val() < 0) {
      $(this).val(0);
    }
    calculateTotal();
  });
  
  // Xử lý khi người dùng nhập số âm
  $('.quantity').on('keyup', function() {
    if ($(this).val() < 0) {
      $(this).val(0);
      calculateTotal();
    }
  });
});



