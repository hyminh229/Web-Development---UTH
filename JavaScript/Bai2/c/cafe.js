const result = document.getElementById('result');
const boxes = Array.from(document.querySelectorAll('input[type="checkbox"]'));

function update(){
  const list = boxes.filter(b=>b.checked).map(b=>b.value);
  result.textContent = list.length ? list.join(', ') : '(chưa chọn)';
}
update();

document.getElementById('show').addEventListener('click', update);
document.getElementById('clear').addEventListener('click', ()=>{
  boxes.forEach(b=>b.checked=false); update();
});
