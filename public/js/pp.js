//carrega cidades após o estado ter sido escolhido
$('select[name=estado]').change(function (){
  //var url =(window.location.host)
  var idEstado = $(this).val();
    $.get('/get-cidades/' +idEstado, function (cidades) {
      $('select[name=cidade]').empty();
      $.each(cidades, function(key,value) {
      $('select[name=cidade]').append('<option value=' + value.id + '>' 
      + value.cidade + '</option>');
        });
    });
});


//função usada em admin_contatos.blade.php para confirmar ação de deletar todos os clientes da base
function del1(){
    var bcad = window.document.getElementById('bcad')
    var del = window.document.getElementById('deldiv')
    deldiv.innerHTML = "<p><strong> Ao realizar esta ação você estará apagando todos os contatos e em todos os grupos.</strong> <br> Tem certeza que deseja continuar esta ação? </p>"+
    "<br><a href='contatos_del' class='btn alert-primary'>Confirmar</a>"
    bcad.style.background = 'red' 
}


//validação de senha
var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirm_password");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Senhas diferentes!");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;



