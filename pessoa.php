<?php
	function pessoa()
	{
		if(isset($_GET["id"])){
			$id=$_GET["id"];
			$com=mysqli_connect("127.0.0.1","mariadaAdm","123456","pessoa");
			$sql="select * from pessoas where id=$id";
			$dados=mysqli_query($com,$sql);
			$dados=mysqli_fetch_assoc($dados);
			$dados=json_encode($dados);
			echo($dados);

		}else{
			$com=mysqli_connect("127.0.0.1","mariadaAdm","123456","pessoa");
			$sql="select id,nome from pessoas";
			$dados=mysqli_query($com,$sql);
			$i=0;
			while ($pessoas[$i]=mysqli_fetch_assoc($dados)) {
				$i++;
			}
			
			$dados=json_encode($pessoas);
			echo($dados);
		}
	}
pessoa();
?>