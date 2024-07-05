<?php  
$nome=$_POST["nome"];
$idade=$_POST["idade"];
$login=$_POST["login"];
$senha=$_POST["senha"];//recepciona os dados para salvar
$imgName=$_FILES['img']['name'];//copia o nome do arquivo original
$temp=$_FILES["img"]['tmp_name'];//seleciona o nome do arquivo temporario
$caminho="img/".$imgName;//monta o caminho com o folder e o  nome da imagem
move_uploaded_file($temp, $caminho);//move o arquivo temporario para a pasta de imagens

$com=mysqli_connect("127.0.0.1","mariadaAdm","123456","pessoa");//conecta ao banco de dados 
$data=mysqli_query($com,"INSERT INTO `pessoas` (`id`, `nome`, `idade`, `login`, `senha`, `img`) VALUES (NULL, '$nome', '$idade', '$login', '$senha', '$caminho');");//executa o insert no  banco com os dados recebidos do ajax que foram recebidos via $_POST

if($data){//define a mensagen a ser devolvida para o ajax
	$msg='{"texto":"Dados salvos com sucesso!","color":"#55b555"}';//mensagem de sucesso com cor verde
}else{
	$msg='{"texto":"Erro ao salvar!","color":"#f44336"}';//mensagen de erro com cor vermelha
}
echo $msg;//imprime a mensagem 
?>
