const $ = sel => document.querySelector(sel);
const a = $('#a'), b = $('#b'), out = $('#kq');

function toNumber(el){
  const v = el.value.trim().replace(',', '.');
  const n = Number(v);
  const ok = v !== '' && !Number.isNaN(n);
  const err = el.parentElement.querySelector('small.error');
  err.textContent = ok ? '' : 'Vui lòng nhập số hợp lệ';
  return ok ? n : null;
}

function compute(op){
  const x = toNumber(a), y = toNumber(b);
  if(x===null || y===null) { out.textContent = 'Kết quả: Lỗi dữ liệu (*)'; return; }
  if(op==='/' && y===0){ out.textContent = 'Kết quả: Không thể chia cho 0'; return; }
  let r;
  switch(op){
    case '+': r = x+y; break;
    case '-': r = x-y; break;
    case '*': r = x*y; break;
    case '/': r = x/y; break;
    case '%': r = x%y; break;
  }
  out.textContent = `Kết quả: ${r}`;
}

document.addEventListener('click',(e)=>{
  const btn = e.target.closest('button[data-op]');
  if(btn) compute(btn.dataset.op);
});
