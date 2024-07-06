<?php
/*$com=mysqli_connect("127.0.0.1","mariadaAdm","123456","pessoa");
$sql="select id,nome from pessoas";
$dados=mysqli_query($com,$sql);
trecho de codigo antigo desnecessario
*/
?>
<!DOCTYPE html>
<html>
<head>
	<title>Pessoas</title>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script><!-- Link para o sistema carregar o Jquery sem a necesssidade de incluir o arquivo na  pasta do projeto. Util para desenvolver porem desaconselhavel ao colocar o sistema em produção  -->

	<script type="text/javascript"> // inclusao de scripty js 
		var ultimo=".listar"; // variavel para guardar o ultimo elemento que foi apresentado na tela. 
		$(document).ready(function(){ //evento documento carregado 
			
			$("#salvar").click(function(e){//evento de click no botão salvar
				e.preventDefault();//prevenindo o evento padrão do botao 
				form=$(this).parent()[0];//seleciona o elemento pai do botão clicado no caso o form. [0] transforma o obj jquery para elemento HTML
				var link=$(this).parent().attr("action");//seleciona a url de submissão do form
				var metodo=$(this).parent().attr("method");//seleciona o metodo de envio do form
				var formData=new FormData(form);//carrega as informações do form
				$.ajax({//inicio do ajax que vai enviar os dados para o servidor sem recarregar pagina
					url:link,//atributo do ajax para onde vai enviar os dados
					type:metodo,//atributo do metodo de trafego de dados
					data:formData,//dados que serão enviados
					contentType:false,//não validade tipo de dados
					processData:false//não processar dados
					}).done(function(response){//evento de finalização com sucesso 
						let msg=$.parseJSON(response);///ransforma o retorno em objeto JSON
						console.log(msg);
						$(".msg")[0].innerHTML=msg.texto;
						$(".msg").attr("style","background-color:"+msg.color);
						$(".msg").show();
						$(".msg").show(200);
						$(form).find("input").each(function () {//para cada item do form limpar os dados
							if($(this).attr("type")!="submit"){//não apagar o valor do botao
  								$($(this)[0]).val("");//esvaziar o campo
							}    
						});
					});
			});


			$(".menu").click(function(){//evento de clique em um dos elementos com a classe menu
				el=$(this);//transforma o elemento clicado de html para obj jquery
				dv=el.attr("data-elemento");//seleciona do valor do atributo data-elemento do elemento clicado
				dv="."+dv;//concatena o '.' ao valor  do data atributo do elemento para selecionar a div a ser apresentada
				
				$(ultimo).hide();//esconde a div que esta a mostra
				$(dv).show();//mostra a div referente ao botão clicado
				if ($(dv).attr("class") == "listar") {
					pessoa();
				}
				if ($(dv).attr("class") == "excluir") {//mostrar o excluir
					pessoa("excluir");//chama  pessoa com parametro de exclusão
					$(dv).hide();//esconde  a dv
					$(".listar").show();//mostra o listar
					dv=".listar";//define o listar como ultima div apresentada
					
				}
				ultimo=dv;//atualiza a div visivel
		});



		function pessoa(pg="listar"){
				$(".listar")[0].innerHTML="";
				$.ajax({//inicio do ajax que vai caregar os dados de nome e id de cada pessoa
				url: "pessoa.php",//url que será envido os dados 
				context: document.body

				}).done(function(json){//evento de finalização com sucesso
					let pessoa=$.parseJSON(json);//transforma o retorno em objeto JSON
					for (var i = 0; i < pessoa.length-1; i++) {//laço para percorrer cada pessoa no objeto json
					html='<div class="info"><div class="nome" data-id="" >Nome: </div> <div class="btn-delete">Delete</div> <div class="btn-editar">Editar</div> </div>';//html base para a criação de cada pessoa
					html=$(html);//converção do html para objeto jquery
					html.find(".nome")[0].innerHTML+=pessoa[i].nome;//concatena no elemento com class nome o nome retornado no objeto json
					$(html.find(".nome")[0]).attr("data-id",pessoa[i].id);//define o id da pessoa que esta no objeto json para o atributo data-id do elemento que acaba de ser criado
					dataInclude(html.find(".nome")[0]);//chama a função que adiciona o evento de click no elemento criado . este evento serve para carregar os demais dados do usuario
					$(".listar").append(html);//seleciona a div listar onde as pessoas são incluidas e adiciona ao final o elemento criado

					}
					if(pg=="excluir")//se for a div de exclusao 
						$(".btn-delete").show();///mostea o botao de exclusao
					$(".btn-delete").click(function(){
						id=$(this).parent().find(".nome").attr("data-id") ;
						elemento=$(this).parent();
					$.ajax({ 
						url: "excluir.php?id="+id,
						context: document.body //contexto da requisiç
						}).done(function(json){
							let msg=$.parseJSON(json);
							if(msg.resposta){
								elemento.hide();
							}
							$(".msg")[0].innerHTML=msg.texto;
							$(".msg").attr("style","background-color:"+msg.color);
							//$(".msg").show();
							$(".msg").show();
							setTimeout(() => {
  								$(".msg").hide();
							},800);

							
						})
					});
				});
		}
		 pessoa();
			
			function dataInclude(el){//função para inclusão dos demais dados de uma pesssoa
				$(el).click(function(){//adiciona o evento de click no elemento
				var el=$(this);//transforma o elemento em obj jquery
				let data=el.parent().find(".dados");//seleciona do pai do elemento "div class='inf' " a div class dados 
				console.log(data.length);//console da quanidade de div dados maximo 1 e minimo 0
				if(data.length<1){//se div dado 0 quer dizer que os dados não foram carregados e devem ser trazidos via jquery. caso contrario os dados ja forao caregados e não tem nada a fazer
					var id=el.attr("data-id");//seleciona o valor do id que esta no atributo  data-id do elemento html. para poder buscar somente os dados da pessoa que recebeu o click
					$.ajax({//inicio do ajax que vai caregar os demais dados de pessoa que recebeu o click
						  url: "pessoa.php?id="+id,//monta a url concatenando o id da pessoa a url da pagina que retorna os dados. a concatenação só e valida para requisições do tipo GET
						  context: document.body //contexto da requisiç
						}).done(function(json){//evento de finalização com sucesso
							let pessoa=$.parseJSON(json);//transforma o retorno em objeto JSON
						  	console.log(pessoa);//console os dados da pessoa que recebeu o click para conferencia como programador
						  	var html='<div class="dados"><div>ID: </div><div>Idade: </div><div>Login: </div><div><img src=""></div></div>';//modelo do html que sera populado com os dados do  objeto pessoa
						  	html=$(html);//converte o html para objeto json
						  	html.find("div")[0].innerHTML+=pessoa.id;//concatena na primeria div (div  [0]) apos a palavra ID: o id da pessoa
						  	html.find("div")[1].innerHTML+=pessoa.idade;//concatena na segunda div (div  [1]) apos a palavra IDADE: a idade da pessoa
						  	html.find("div")[2].innerHTML+=pessoa.login;//concatena na terceira div (div  [2]) apos a palavra LOGIN: o login da pessoa
						  	$(html.find("img")[0]).attr("src",pessoa.img);//atribui ao atributo src do elemento img o valor pessoa.img que contem a url da imagen da pesssoa
						  	console.log(html.find("img")[0]);//console para conferencia do html da tag img 
						  	console.log($(html.find("img")[0]));//console para conferencia do objeto jquery da tag img 
						  	el.parent().append(html);//inclusão no fim. abaixo aos dados ja incluidos.
						});
				}
				});
			}

			


		});
	</script>

	<style type="text/css">
		.info{/*classe  de informação define os atributos de apresentação dos dados da pessoa */
			display: inline-block;/*define a exibição inline block para os elementos ficarem lado a lado */
			padding: 5px;/*espaço interno do elemento com 5px de borda para o conteudo*/
			background-color: #c15e56;/*cor de fundo do bloco*/
			border: 1px solid black;/*borda com 1px de espessura com cor solida preta */
			margin-left: 10px/*margem de 10 px para separar os elementos*/
		}
		img{/* define altura e largura de todos elementos com a tag img*/
			width: 200px;
			height: 80px;
		}
		.btn-delete,.btn-editar{
		 	display:inline-block;
		 	cursor: pointer;
		 	background-color: #c15e56;
		 	margin-left: 20%;
		 	padding: 3px;
		 	display: none;
		}
		.btn-delete:hover,.btn-editar:hover{
			background-color:#d1a4a1;
		}
		.dados{
			/*display: none;*/
		}
		.nome{/*apresentação dos elementos com a classe nome*/
			text-decoration: none; /*remove o css anterior do texto*/
			cursor: pointer;/*define o curso como ponteiro para dar a ideia de objeto com evento de click*/
			display: block;
		}
		.cadastrar,.editar,.exclui{/*define o css inicial das classes cadastrar editar e exluir para inicio escondido*/
			display: none;/*esconde o elemento*/
			border: 1px solid black;/*borda com 1px de espessura com cor solida preta para a apresentação quando o js mostrar o elemento*/
			padding: 5px;/*espaço interno do elemento com 5px de borda para o conteudo*/
			background-color: #9c9ccd;/*cor de fundo do bloco*/
		}
		.listar{/*define o css inicial do bloco listar inicialmente visivel*/
			display: block;/*seta a visibilidade para em bloco ou seja ocupa todo o espaço disponivel*/
			border: 1px solid black;/*borda com 1px de espessura com cor solida preta */
			padding: 5px;/*espaço interno do elemento com 5px de borda para o conteudo*/
			background-color: #9c9ccd;/*cor de fundo do bloco*/
		}
		.menu{/*caracteristicas dos elementos de click do menu */
			display: inline-block;/*define a exibição inline block para os elementos ficarem lado a lado */
    		border: 1px solid black;*borda com 1px de espessura com cor solida preta */
    		background-color: #3c3cf8;/*cor de fundo do bloco*/
    		color: white;/*cor da fonte como branca para dar contraste*/ 
    		font-size: 20px;/*tamanho da fonte*/
    		padding: 4px;/*espaço interno do elemento com 4px de borda para o conteudo*/
    		cursor: pointer;/*define o curso como ponteiro para dar a ideia de objeto com evento de click*/
    		margin: -2px;/*margem de -2 px para juntar o elemento a borda*/
		}
		.menubar{/*caracteristicas da barra que fica atraz dos elementos do menu */
			background-color: #3c3cf8;*cor de fundo do bloco*/
			margin-bottom: 15px;/*margem de 15 px para separar o menu dos demais dados*/
		}
	</style>

</head>
<body>
	<div class="menubar"><!-- menu de seleção de div a ser exibida funcionalidade dada por js -->
		<div data-elemento="cadastrar" class="menu">Cadastrar</div>
		<div data-elemento="editar" class="menu">Editar</div>
		<div data-elemento="excluir" class="menu">Excluir</div>
		<div data-elemento="listar"class="menu">Listar</div>
	</div>

	<div class="msg" style="display: none;"> </div>
	
	<div class="listar">	
	</div>
	<div class="excluir">	
	</div>

	<div class="cadastrar">
			<form action="salvar.php" method="POST"><!-- formulario de cadastro ações executadas via js -->
				<div>Nome:</div>
				<input type="text" name="nome" placeholder="Nome">
				<div>Idade:</div>
				<input type="text" name="idade" placeholder="Idade">
				<div>Login:</div>
				<input type="text" name="login" placeholder="Login">
				<div>Senha</div>
				<input type="text" name="senha" placeholder="Senha">
				<div>Imagem:</div>
				<input type="file" name="img"><br>
				<input id="salvar" type="submit" name="salvar" value="Salvar">
			</form>
	</div>

	<div class="editar">
	</div>

	
<!-- codigo antigo que foi usado quando era recarregado os dados via php sem js
	<?php
		while ($pessoa=mysqli_fetch_assoc($dados)) {
	?>
	 <div class="info">
	 	 <div class="nome" data-id="<?php echo $pessoa['id'] ?>" >Nome: <?php echo $pessoa["nome"]?></div>
	 </div>
	<?php } ?>
-->

</body>

</body>
</html>