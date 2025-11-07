const box = document.getElementById('box');
const colorSel = document.getElementById('colorSel');

document.getElementById('apply').addEventListener('click', ()=>{
  const color = colorSel.value;
  if(!color) return;
  const mode = document.querySelector('input[name="mode"]:checked').value;
  if(mode==='bg'){
    box.style.background = color;
    // giữ độ tương phản chữ
    box.style.color = getLuma(color) < 160 ? '#ffffff' : '#111111';
  }else{
    box.style.color = color;
  }
});

document.getElementById('reset').addEventListener('click', ()=>{
  box.style.background = '';
  box.style.color = '';
  colorSel.value = '';
});

// tính độ sáng đơn giản để chọn màu chữ
function getLuma(hex){
  const c = hex.replace('#','');
  const r = parseInt(c.substring(0,2),16);
  const g = parseInt(c.substring(2,4),16);
  const b = parseInt(c.substring(4,6),16);
  return 0.2126*r + 0.7152*g + 0.0722*b;
}
