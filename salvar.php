<?php  
$nome=$_POST["nome"];
$idade=$_POST["idade"];
$login=$_POST["login"];
$senha=$_POST["senha"];//recepciona os dados para salvar

$com=mysqli_connect("127.0.0.1","mariadaAdm","123456","pessoa");//conecta ao banco de dados 
$data=mysqli_query($com,"INSERT INTO `pessoas` (`id`, `nome`, `idade`, `login`, `senha`, `img`) VALUES (NULL, '$nome', '$idade', '$login', '$senha', ' ');");//executa o insert no  banco com os dados recebidos do ajax que foram recebidos via $_POST

if($data){//define a mensagen a ser devolvida para o ajax
	$msg='[{"texto":"Dados salvos com sucesso!","color":"#55b555"}]';//mensagem de sucesso com cor verde
}else{
	$msg='[{"texto":"Erro ao salvar!","color":"##f44336"}]';//mensagen de erro com cor vermelha
}
echo json_encode($msg);//imprime a mensagem 
?>
