function resultado()
{
    var saldo = document.getElementById('saldoatual').value
    var recarga = document.getElementById('recarga').value
    var divoperamais = document.getElementById('operacaomais')
    var divoperamenos = document.getElementById('operacaomenos')
    var divrecarrega = document.getElementById('recarrega')
    var botao = document.getElementById('botao')
    var nsaldo = Number(saldo)
    var nrecarga = Number(recarga)
    if(document.getElementById('opmais').checked == true)
    {
        var sgeral = nsaldo + nrecarga
    } 
    if(document.getElementById('opmenos').checked == true)
    {
       var sgeral = nsaldo - nrecarga
    }
    if(!sgeral)
    {
       divrecarrega.innerHTML = '<p>Você esqueceu de selecionar a operação!</p>' 
    } else {
        divoperamais.innerHTML = ' o saldo era '+ saldo
        divoperamenos.innerHTML = 'você está inserindo '+ recarga
        divrecarrega.innerHTML = `<input type="hidden" name="saldo_geral_novo" value="${sgeral}">
                                <p><strong>O novos saldo será ${sgeral}</strong><br>
                                Deseja confirmar a operação?</p>`
        botao.innerHTML = '<input type="submit" class="btn btn-primary" value="Sim prosseguir">'
    }
    
}