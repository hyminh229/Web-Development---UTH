/* jQuery + RegExp validation for Week 8 - Exercise 1
 * (a) register form; (b) facebook-like form
 */

// ===== Common helpers =====
const re = {
  // a) username: bắt đầu bằng chữ, có thể kèm số/._- , không khoảng trắng
  username: /^[A-Za-z][A-Za-z0-9._-]*$/,
  // a) password: >=8, có ít nhất 1 số, 1 chữ in hoa, 1 ký tự đặc biệt
  strongPwd: /^(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).{8,}$/,
  // email chuẩn
  email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
  // VN phone: 10 số, bắt đầu 09/03/07/06/05/04
  phoneVN: /^(09|03|07|06|05|04)\d{8}$/,
};

function showError($input, msg) {
  $input.addClass("is-invalid").removeClass("is-valid");
  $input.siblings("small.error").text(msg);
}
function showOK($input) {
  $input.removeClass("is-invalid").addClass("is-valid");
  $input.siblings("small.error").text("");
}
// Viết hoa chữ cái đầu mỗi từ
function isCapitalizedWords(str) {
  const parts = str.trim().split(/\s+/);
  if (parts.length < 2) return false;
  return parts.every(w => /^[A-ZÀ-ỸĐ][a-zà-ỹđ'.-]+$/.test(w));
}
// đủ 16 tuổi - hỗ trợ cả ISO và dd/mm/yyyy
function isAgeAtLeast(dobStr, years = 16) {
  if (!dobStr) return false;
  let dob;
  // Kiểm tra định dạng dd/mm/yyyy
  if (/^\d{2}\/\d{2}\/\d{4}$/.test(dobStr)) {
    const parts = dobStr.split('/');
    const day = parseInt(parts[0], 10);
    const month = parseInt(parts[1], 10) - 1; // month is 0-indexed
    const year = parseInt(parts[2], 10);
    dob = new Date(year, month, day);
  } else {
    dob = new Date(dobStr);
  }
  if (isNaN(dob.getTime())) return false;
  const now = new Date();
  const age = now.getFullYear() - dob.getFullYear() -
    ((now.getMonth() < dob.getMonth() || (now.getMonth() === dob.getMonth() && now.getDate() < dob.getDate())) ? 1 : 0);
  return age >= years;
}

// ====== (a) Register form ======
function initRegisterValidation(formSelector) {
  const $f = $(formSelector);

  $f.on("submit", function (e) {
    e.preventDefault();
    let ok = true;

    const $user = $("#txtDN");
    const userVal = $user.val().trim();
    if (!userVal) {
      ok = false;
      showError($user, "Tên đăng nhập là bắt buộc.");
    } else if (!re.username.test(userVal)) {
      ok = false;
      showError($user, "Tên đăng nhập bắt đầu bằng chữ, có thể có số và ký tự đặc biệt, không được có khoảng trắng.");
    } else {
      showOK($user);
    }

    const $pwd = $("#txtMK");
    const pwdVal = $pwd.val();
    if (!pwdVal) {
      ok = false;
      showError($pwd, "Mật khẩu là bắt buộc.");
    } else if (!re.strongPwd.test(pwdVal)) {
      ok = false;
      showError($pwd, "Mật khẩu từ 8 ký tự trở lên, có ít nhất 1 ký tự số, 1 ký tự in hoa, 1 ký tự đặc biệt.");
    } else {
      showOK($pwd);
    }

    const $re = $("#txtNLMK");
    const reVal = $re.val();
    if (!reVal) {
      ok = false;
      showError($re, "Nhập lại mật khẩu là bắt buộc.");
    } else if (reVal !== pwdVal) {
      ok = false;
      showError($re, "Nhập lại mật khẩu phải giống Mật khẩu.");
    } else {
      showOK($re);
    }

    const $name = $("#txtName");
    const nameVal = $name.val().trim();
    if (!nameVal) {
      ok = false;
      showError($name, "Họ và tên là bắt buộc.");
    } else if (!isCapitalizedWords(nameVal)) {
      ok = false;
      showError($name, "Họ tên phải có ít nhất Họ và Tên. Ký tự đầu mỗi từ bắt buộc phải viết hoa.");
    } else {
      showOK($name);
    }

    const $dob = $("#txtDOB");
    const dobVal = $dob.val().trim();
    if (!dobVal) {
      ok = false;
      showError($dob, "Ngày sinh là bắt buộc.");
    } else if (!/^\d{2}\/\d{2}\/\d{4}$/.test(dobVal)) {
      ok = false;
      showError($dob, "Ngày sinh phải đúng định dạng dd/mm/yyyy.");
    } else if (!isAgeAtLeast(dobVal, 16)) {
      ok = false;
      showError($dob, "Tuổi phải ≥ 16.");
    } else {
      showOK($dob);
    }

    const $addr = $("#txtDC");
    if (!$addr.val().trim()) { ok = false; showError($addr, "Địa chỉ không được để trống."); }
    else showOK($addr);

    const $phone = $("#txtDT");
    const phoneVal = $phone.val().trim();
    if (!phoneVal) {
      ok = false;
      showError($phone, "Điện thoại là bắt buộc.");
    } else if (!re.phoneVN.test(phoneVal)) {
      ok = false;
      showError($phone, "Điện thoại phải là số điện thoại 10 ký tự số, bắt đầu là 09, 03, 07, 06, 05, 04.");
    } else {
      showOK($phone);
    }

    const $email = $("#txtEmail");
    const emailVal = $email.val().trim();
    if (!emailVal) {
      ok = false;
      showError($email, "Email là bắt buộc.");
    } else if (!re.email.test(emailVal)) {
      ok = false;
      showError($email, "Email phải đúng định dạng của địa chỉ email.");
    } else {
      showOK($email);
    }

    if (ok) {
      alert("Đăng ký thành công!");
      this.reset();
      $f.find(".is-valid").removeClass("is-valid");
    }
  });
}

// ====== (b) Facebook form ======
function initFacebookValidation(formSelector) {
  const $f = $(formSelector);
  $f.on("submit", function (e) {
    e.preventDefault();
    let ok = true;

    // Kiểm tra Họ - bắt buộc và bắt đầu bằng chữ hoa
    const $last = $("#fbLast");
    const lastVal = $last.val().trim();
    if (!lastVal) {
      ok = false;
      showError($last, "Họ là bắt buộc.");
    } else if (!/^[A-ZÀ-ỸĐ]/.test(lastVal)) {
      ok = false;
      showError($last, "Họ phải bắt đầu bằng ký tự chữ hoa.");
    } else {
      showOK($last);
    }

    // Kiểm tra Tên - bắt buộc và bắt đầu bằng chữ hoa
    const $first = $("#fbFirst");
    const firstVal = $first.val().trim();
    if (!firstVal) {
      ok = false;
      showError($first, "Tên là bắt buộc.");
    } else if (!/^[A-ZÀ-ỸĐ]/.test(firstVal)) {
      ok = false;
      showError($first, "Tên phải bắt đầu bằng ký tự chữ hoa.");
    } else {
      showOK($first);
    }

    // Kiểm tra Email - bắt buộc và đúng định dạng
    const $email = $("#fbEmail");
    const emailVal = $email.val().trim();
    if (!emailVal) {
      ok = false;
      showError($email, "Email là bắt buộc.");
    } else if (!re.email.test(emailVal)) {
      ok = false;
      showError($email, "Email không đúng định dạng.");
    } else {
      showOK($email);
    }

    // Kiểm tra Nhập lại Email - bắt buộc và trùng khớp
    const $email2 = $("#fbEmail2");
    const email2Val = $email2.val().trim();
    if (!email2Val) {
      ok = false;
      showError($email2, "Nhập lại email là bắt buộc.");
    } else if (email2Val !== emailVal) {
      ok = false;
      showError($email2, "Nhập lại email phải trùng khớp với email đã nhập.");
    } else {
      showOK($email2);
    }

    // Kiểm tra Mật khẩu - bắt buộc, có chữ và số, ít nhất 6 ký tự
    const $pwd = $("#fbPwd");
    const pwdVal = $pwd.val();
    if (!pwdVal) {
      ok = false;
      showError($pwd, "Mật khẩu là bắt buộc.");
    } else if (!/^(?=.*[A-Za-z])(?=.*\d).{6,}$/.test(pwdVal)) {
      ok = false;
      showError($pwd, "Mật khẩu phải có ký tự chữ, số và ít nhất 6 ký tự.");
    } else {
      showOK($pwd);
    }

    // Kiểm tra Năm sinh - bắt buộc và < 2002
    const $year = $("#fbYear");
    const yearVal = $year.val().trim();
    if (!yearVal) {
      ok = false;
      showError($year, "Năm sinh là bắt buộc.");
    } else {
      const y = parseInt(yearVal, 10);
      if (isNaN(y) || y >= 2002) {
        ok = false;
        showError($year, "Năm sinh phải nhỏ hơn 2002.");
      } else {
        showOK($year);
      }
    }

    if (ok) {
      alert("Bạn đã đăng ký thành công!");
      this.reset();
      $f.find(".is-valid").removeClass("is-valid");
    }
  });
}

// export to global
window.initRegisterValidation = initRegisterValidation;
window.initFacebookValidation = initFacebookValidation;
