<?php
$id=$_GET["id"];
$com=mysqli_connect("127.0.0.1","mariadaAdm","123456","pessoa");
mysqli_query($com,"delete from pessoas where id =$id;");
$dados=mysqli_affected_rows($com);
if($dados==1){
	echo '{"resposta":1,"texto":"Usuario excluido com sucesso!","color":"#55b555"}';
}else{
	echo '{"resposta":1,"texto":"Erro ao salvar!","color":"#f44336"}';
}
?>