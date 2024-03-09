<?php
$com=mysqli_connect("127.0.0.1","mariadaAdm","123456","pessoa");
$sql="select id,nome from pessoas";
$dados=mysqli_query($com,$sql);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Pessoas</title>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

	<script type="text/javascript">
		var ultimo=".listar";

		$(document).ready(function(){

			$(".menu").click(function(){
				el=$(this);
				dv=el.attr("data-elemento");
				dv="."+dv;
				
				$(ultimo).hide();
				$(dv).show();
				ultimo=dv;
		});

			$.ajax({
				url: "pessoa.php",
				context: document.body
				}).done(function(json){
					let pessoa=$.parseJSON(json);
					for (var i = 0; i < pessoa.length-1; i++) {
					html='<div class="info"><div class="nome" data-id="" >Nome: </div></div>';
					html=$(html);
					html.find(".nome")[0].innerHTML+=pessoa[i].nome;
					$(html.find(".nome")[0]).attr("data-id",pessoa[i].id);
					dataInclude(html.find(".nome")[0]);
					$(".listar").append(html);
					}

				});
				
			function dataInclude(el){
				$(el).click(function(){
				var el=$(this);
				let data=el.parent().find(".dados");
				console.log(data.length);
				if(data.length<1){
				var id=el.attr("data-id");
				$.ajax({
					  url: "pessoa.php?id="+id,
					  context: document.body
					}).done(function(json){
						let pessoa=$.parseJSON(json);
					  	console.log(pessoa);
					  	var html='<div class="dados"><div>ID: </div><div>Idade: </div><div>Login: </div><div><img src=""></div></div>';
					  	html=$(html);
					  	html.find("div")[0].innerHTML+=pessoa.id;
					  	html.find("div")[1].innerHTML+=pessoa.idade;
					  	html.find("div")[2].innerHTML+=pessoa.login;
					  	$(html.find("img")[0]).attr("src",pessoa.img);
					  	console.log(html.find("img")[0]);
					  	console.log($(html.find("img")[0]));
					  	el.parent().append(html);
					});
				}
				});
			}

			


		});
	</script>

	<style type="text/css">
		.info{
			display: inline-block;
			padding: 5px;
			background-color: #c15e56;
			border: 1px solid black;
			margin-left: 10px
		}
		img{
			width: 200px;
			height: 80px;
		}

		.dados{
			/*display: none;*/
		}
		.nome{
			text-decoration: none;
			cursor: pointer;
		}
		.cadastrar,.editar,.exclui{
			display: none;
			border: 1px solid black;
			padding: 5px;
			background-color: #9c9ccd;
		}
		.listar{
			display: block;
			border: 1px solid black;
			padding: 5px;
			background-color: #9c9ccd;
		}
		.menu{
			display: inline-block;
    		border: 1px solid black;
    		background-color: #3c3cf8;
    		color: white;
    		font-size: 20px;
    		padding: 4px;
    		cursor: pointer;
    		margin: -2px;
		}
		.menubar{
			background-color: #3c3cf8;
			margin-bottom: 15px;
		}
	</style>

</head>
<body>
	<div class="menubar">
		<div data-elemento="cadastrar" class="menu">Cadastrar</div>
		<div data-elemento="editar" class="menu">Editar</div>
		<div data-elemento="exclui" class="menu">Excluir</div>
		<div data-elemento="listar"class="menu">Listar</div>
	</div>
	
	<div class="listar">	
	</div>

	<div class="cadastrar">
	</div>

	<div class="editar">
	</div>

	<div class="exclui">
	</div>
<!--
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