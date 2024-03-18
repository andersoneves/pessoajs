<?php
	function pessoa()
	{
		if(isset($_GET["id"])){//se a requisisao conter um elemento id no $_GET a pagina deve devolver somente os demais dados da pessoa
			$id=$_GET["id"];//recupera o id a ser buscado
			$com=mysqli_connect("127.0.0.1","mariadaAdm","123456","pessoa");//conecta ao banco de dados 
			$sql="select * from pessoas where id=$id";//query que seleciona todos os dados da pessoa
			$dados=mysqli_query($com,$sql);//executa a query
			$dados=mysqli_fetch_assoc($dados);//transforma o objeto resultado do banco em um vetor associativo
			$dados=json_encode($dados);//converte o vetor em um objeto json para facititar a manipulação do lado do js
			echo($dados);//imprime o jsom 

		}else{//se não vir id no $_GET o sistema deve devolver o id e nome de todas as pesssoas
			$com=mysqli_connect("127.0.0.1","mariadaAdm","123456","pessoa");//conecta ao banco de dados 
			$sql="select id,nome from pessoas";//query que seleciona somente o id e nome de todos as pessoas do banco
			$dados=mysqli_query($com,$sql);//executa query
			$i=0;//inicializa comtador de pesssoas
			while ($pessoas[$i]=mysqli_fetch_assoc($dados)) {//para cada pessoa retornada no objeto de retorno do banco de dados adicionara uma possição do vetor de pessoas
				$i++;//incrementar o id da proxima posição de pessoa a ser incluida
			}
			
			$dados=json_encode($pessoas);//converte as pessoas para um objeto json
			echo($dados);//imprime o jsom
		}
	}
pessoa();//chama a função pessoa
?>