<!DOCTYPE HTML>
<html lang="pt-br">  
    <head>  
        <meta charset="utf-8">
        <title>Jorge Mendes - Listar com JavaScript</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="style.css">
    </head>
    <body>
		<div class="container">
			
			<p>
				<button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#addUsuarioModal">
					Cadastrar
				</button>
			</p>
			<div class="listuser">
			<h2>Lista de Usuários Cadastrados</h2>
			</div>
			<span id="msg"></span>
            <span id="conteudo"></span><br><br><br>
		</div>
		
		<div id="visulUsuarioModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="visulUsuarioModalLabel">Detalhes do Usuário</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<span id="visul_usuario"></span>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-info" data-dismiss="modal">Fechar</button>
					</div>
				</div>
			</div>
		</div>
		
		<div id="addUsuarioModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="addUsuarioModalLabel">Cadastrar Usuário</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form method="post" id="insert_form">
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Nome</label>
								<div class="col-sm-10">
									<input name="nome" type="text" class="form-control" id="nome" placeholder="Nome completo">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Telefone</label>
								<div class="col-sm-10">
									<input name="telefone" type="text" class="form-control" id="telefone" placeholder="Telefone">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Email</label>
								<div class="col-sm-10">
									<input name="email" type="email" class="form-control" id="email" placeholder="Seu melhor E-mail">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-10">
									<input type="submit" name="CadUser" id="CadUser" value="Cadastrar" class="btn btn-outline-success">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		
		<script>
			var qnt_result_pg = 50; //quantidade de registro por página
			var pagina = 1; //página inicial
			$(document).ready(function () {
				listar_usuario(pagina, qnt_result_pg); //Chamar a função para listar os registros
			});
			
			function listar_usuario(pagina, qnt_result_pg){
				var dados = {
					pagina: pagina,
					qnt_result_pg: qnt_result_pg
				}
				$.post('listar_usuario.php', dados , function(retorna){
					//Subtitui o valor no seletor id="conteudo"
					$("#conteudo").html(retorna);
				});
			}
			
			$(document).ready(function(){
				$(document).on('click','.view_data', function(){
					var user_id = $(this).attr("id");
					//alert(user_id);
					//Verificar se há valor na variável "user_id".
					if(user_id !== ''){
						var dados = {
							user_id: user_id
						};
						$.post('visualizar.php', dados, function(retorna){
							//Carregar o conteúdo para o usuário
							$("#visul_usuario").html(retorna);
							$('#visulUsuarioModal').modal('show'); 
						});
					}
				});
				
				$('#insert_form').on('submit', function(event){
					event.preventDefault();
					//Receber os dados do formulário
					var dados = $("#insert_form").serialize();
					$.post("cadastrar.php", dados, function (retorna){
						if(retorna){
							//Alerta de cadastro realizado com sucesso
							$("#msg").html('<div class="alert alert-success" role="alert">Usuário cadastrado com sucesso!</div>');
							
							//Limpar os campo
							$('#insert_form')[0].reset();
							
							//Fechar a janela modal cadastrar
							$('#addUsuarioModal').modal('hide');
							
							listar_usuario(1, 50);
						}else{
							
						}
						
					});
				});
			});
		</script>
    </body>
</html>
