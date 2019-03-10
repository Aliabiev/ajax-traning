<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>

<form id="form">
<input type="text" name="pricefrom">
<table id="result"> </table>
</form>

<script type="text/javascript">
  
const form = document.getElementById('form');
const result = document.getElementById('result');
const pricefrom = document.getElementsByName('pricefrom')[0];

pricefrom.addEventListener('input', getBooks);

function getBooks(){
  let form_data = new FormData(form);
  form_data.append('func', 'getBook');
  let req = new XMLHttpRequest();

  req.addEventListener('readystatechange', ()=>{
    if(req.readyState == 4 && req.status == 200){
      let response = req.responseXML;
          console.log(response);
      showBooks(response);
    }
  });

  req.open("POST", "functions.php", true);
  req.send(form_data);
}

 
function showBooks(xmlDoc){
  let books = xmlDoc.getElementsByTagName('book');
  let str = '';

  for (let i=0; i<books.length; i++){

    let name = books[i].getElementsByTagName('name')[0].innerHTML;
    let price = books[i].getElementsByTagName('price')[0].innerHTML;
    let id = books[i].getAttribute('id');
    
    str+='<tr>';
    str+=`<td>${id}</td>`;
    str+=`<td>${name}</td>`;
    str+=`<td><input type="text" onblur="changePrice(this)" data-id="${id}" class="cor-price" value="${price}" style="border-color:white;  border-width:0;"></td>`;
    str+=`<td> <a href="#" data-id="${id}" class="delete-book"> Delete </a> </td>`;
    str+='</tr>';
    //console.log(name);
  }

  result.innerHTML = str;
}

/*const deleteBook = document.querySelectorAll('.delete-book');
deleteBook.forEach(function(item){
})*/

result.addEventListener('click', function(e){
let target = e.target;
if (target.classList.contains('delete-book'))
{
  let id = target.getAttribute('data-id');
  console.log(id);

  let req = new XMLHttpRequest();
  req.open('POST', 'functions.php', true);
  req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  req.send(`id=${id}&func=deleteBook`);

}
});


function changePrice(target){
  let id = target.getAttribute('data-id');
  let price = target.value;
  let req = new XMLHttpRequest();
  req.open('POST', 'functions.php', true);
  req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  req.send(`id=${id}&price=${price}&func=corPrice`);
}; 


</script>


</body>
</html>