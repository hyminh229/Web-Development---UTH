// Helpers
const $ = (sel, scope=document) => scope.querySelector(sel);

function setError(el, msg){
  const holder = el.closest('.row').querySelector('small.error');
  if(holder){ holder.textContent = msg || ''; }
  el.setAttribute('aria-invalid', msg ? 'true' : 'false');
}

function required(el, msg){
  if(!el.value.trim()){ setError(el, msg || 'Không được để trống'); return false; }
  setError(el, ''); return true;
}

function isEmail(el){
  const ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(el.value.trim());
  setError(el, ok ? '' : 'Email không hợp lệ');
  return ok;
}

function minLen(el, n, label='Tối thiểu '+n+' ký tự'){
  const ok = el.value.trim().length >= n;
  setError(el, ok ? '' : label); return ok;
}

// Đăng ký
export function initRegister(){
  const form = $('#registerForm');
  if(!form) return;

  const uname = $('#r_username'), pass = $('#r_password'), email = $('#r_email');
  const out = $('#registerResult');

  form.addEventListener('submit', (e)=>{
    e.preventDefault();
    const ok =
      required(uname,'Nhập tên đăng nhập') && minLen(uname,6) &&
      required(pass,'Nhập mật khẩu') && minLen(pass,6) &&
      required(email,'Nhập email') && isEmail(email);

    if(!ok) return;

    // Giả lập lưu localStorage để sang trang đăng nhập có dữ liệu
    localStorage.setItem('demo_user', JSON.stringify({
      u: uname.value.trim(),
      p: pass.value,
      e: email.value.trim()
    }));
    out.innerHTML = `<div class="success">Đăng ký thành công! Bạn có thể <a href="dangnhap.html">đăng nhập</a>.</div>`;
    form.reset();
  });
}

// Đăng nhập
export function initLogin(){
  const form = $('#loginForm');
  if(!form) return;

  const uname = $('#l_username'), pass = $('#l_password');
  const out = $('#loginResult');

  form.addEventListener('submit',(e)=>{
    e.preventDefault();
    if(!(required(uname) & required(pass))) return;

    const store = localStorage.getItem('demo_user');
    if(!store){ out.textContent = 'Chưa có tài khoản mẫu. Hãy đăng ký trước!'; return; }
    const {u,p} = JSON.parse(store);
    if(uname.value.trim()===u && pass.value===p){
      out.innerHTML = `<div class="success">Đăng nhập thành công. Chào ${u}!</div>`;
    }else{
      out.textContent = 'Sai tài khoản hoặc mật khẩu.';
    }
  });
}
