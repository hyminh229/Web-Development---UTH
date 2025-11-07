// Kiểm tra định dạng họ tên: chữ hoa đầu mỗi từ
function isValidFullName(name) {
  if (!name || !name.trim()) {
    return false;
  }
  const parts = name.trim().split(/\s+/);
  if (parts.length < 1) {
    return false;
  }
  // Kiểm tra mỗi từ phải bắt đầu bằng chữ hoa
  return parts.every(word => /^[A-ZÀ-ỸĐ][a-zà-ỹđ'.-]*$/.test(word));
}

// Hiển thị lỗi
function showError(inputId, errorId, message) {
  $(`#${inputId}`).addClass('error-input');
  $(`#${errorId}`).text(message);
}

// Xóa lỗi
function clearError(inputId, errorId) {
  $(`#${inputId}`).removeClass('error-input');
  $(`#${errorId}`).text('');
}

// Kiểm tra form có hợp lệ không
function isFormValid() {
  const fullName = $('#fullName').val().trim();
  return fullName && isValidFullName(fullName);
}

// Cập nhật trạng thái nút đăng ký
function updateRegisterButton() {
  const isValid = isFormValid();
  $('#btnRegister').prop('disabled', !isValid);
  if (isValid) {
    $('#btnRegister').removeClass('disabled');
  } else {
    $('#btnRegister').addClass('disabled');
  }
}

// Thêm dữ liệu vào bảng
function addToTable(data) {
  const tbody = $('#tableBody');
  const row = $('<tr></tr>');
  
  row.append($('<td></td>').text(data.fullName));
  row.append($('<td></td>').text(data.className));
  row.append($('<td></td>').text(data.subject));
  row.append($('<td></td>').text(data.type));
  
  tbody.append(row);
}

// Xử lý khi trang load
$(document).ready(function() {
  // Focus vào ô Họ tên
  $('#fullName').focus();
  
  // Kiểm tra ban đầu
  updateRegisterButton();
  
  // Xử lý khi nhập họ tên
  $('#fullName').on('input blur', function() {
    const fullName = $(this).val().trim();
    
    if (!fullName) {
      showError('fullName', 'fullNameError', 'Họ tên là bắt buộc.');
    } else if (!isValidFullName(fullName)) {
      showError('fullName', 'fullNameError', 'Họ tên phải viết hoa chữ cái đầu mỗi từ.');
    } else {
      clearError('fullName', 'fullNameError');
    }
    
    updateRegisterButton();
  });
  
  // Xử lý khi các trường khác thay đổi (để cập nhật nút)
  $('#className, #subject, input[name="type"]').on('change', function() {
    updateRegisterButton();
  });
  
  // Xử lý submit form
  $('#registerForm').on('submit', function(e) {
    e.preventDefault();
    
    const fullName = $('#fullName').val().trim();
    
    // Kiểm tra lại trước khi submit
    if (!fullName) {
      showError('fullName', 'fullNameError', 'Họ tên là bắt buộc.');
      updateRegisterButton();
      return;
    }
    
    if (!isValidFullName(fullName)) {
      showError('fullName', 'fullNameError', 'Họ tên phải viết hoa chữ cái đầu mỗi từ.');
      updateRegisterButton();
      return;
    }
    
    // Lấy dữ liệu từ form
    const formData = {
      fullName: fullName,
      className: $('#className').val(),
      subject: $('#subject').val(),
      type: $('input[name="type"]:checked').val()
    };
    
    // Thêm vào bảng
    addToTable(formData);
    
    // Reset form
    $('#registerForm')[0].reset();
    clearError('fullName', 'fullNameError');
    $('#fullName').focus();
    updateRegisterButton();
  });
});

