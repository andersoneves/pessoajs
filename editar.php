<?php
$id=$_POST["id"];
$nome=$_POST["nome"];
$idade=$_POST["idade"];
$login=$_POST["login"];
$senha=$_POST["senha"];//recepciona os dados para salvar

if(isset($_FILES['img']['name'])){
	$imgName=$_FILES['img']['name'];//copia o nome do arquivo original
	$temp=$_FILES["img"]['tmp_name'];//seleciona o nome do arquivo temporario
	$caminho="img/".$imgName;//monta o caminho com o folder e o  nome da imagem
	move_uploaded_file($temp, $caminho);//move o arquivo temporario para a pasta de imagens
}

$com=mysqli_connect("127.0.0.1","mariadaAdm","123456","pessoa");//conecta ao banco de dados
if(isset($_FILES['img']['name'])){
	$data=mysqli_query($com,"UPDATE `pessoas` SET `nome` = '$nome', `idade` = '$idade', `login` = '$login', `senha` = '$senha', `img` = '$caminho' WHERE `pessoas`.`id` = $id;");//executa o update no  banco com os dados recebidos do ajax que foram recebidos via $_POST
}else{
	$data=mysqli_query($com,"UPDATE `pessoas` SET `nome` = '$nome', `idade` = '$idade', `login` = '$login', `senha` = '$senha' WHERE `pessoas`.`id` = $id;");//executa o update no  banco com os dados recebidos do ajax que foram recebidos via $_POST
}

if($data){//define a mensagen a ser devolvida para o ajax
	$msg='{"codigo":1,"texto":"Dados editados com sucesso!","color":"#55b555"}';//mensagem de sucesso com cor verde
}else{
	$msg='{"codigo":0,"texto":"Erro ao editar!","color":"#f44336"}';//mensagen de erro com cor vermelha
}
echo $msg;//imprime a mensagem 
?>