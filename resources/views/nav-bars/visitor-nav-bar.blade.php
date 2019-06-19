<div class="container">	
	<div class="row">
		<div class="col-xs-12">
			<nav class="navbar custom-nav-bar">
				<div class="navbar-header col-xs-3 col-xs-offset-2">
					<a class="navbar-brand" href="/"><img class="img-responsive custom-logo" src="img/logo.png" alt="logomarca"></a>
				</div>
				<div class="collapse navbar-collapse custom-nav-bar-body" id="navbar-icons">
					<ul class="nav navbar-nav col-xs-7">
						<li><a class="navbar-icon custom-navbar-icon" href="#" id="sobre-nos">Sobre nós</a></li>
						<li><a class="navbar-icon custom-navbar-icon" href="#" id="fotos">Fotos</a></li>
						<li><a class="navbar-icon custom-navbar-icon" href="#" id="contato">Contato</a></li>
						<li class="dropdown custom-navbar-icon" id="link_area_do_aluno">
							<a class="custom-navbar-icon dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Área do aluno</a>
							<ul class="dropdown-menu login-dropdown">
								<form method="POST" action="#">
									<h4 class="text-center">Login</h4>
									<div class="alert alert-danger hide" role="alert" id="logindAlert" role="alert">
										<button type="button" id="closeAlert" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<strong id="alertLoginPassword">Usuário ou senha inválido</strong>
									</div>
									<li role="separator" class="divider"></li>
									<label class="control-label">Email</label>
									<input type="email" name="email" class="form-control" id="email">

									<label class="control-label">Senha</label>
									<input type="password" name="password" class="form-control" id="password">
									<a href="#" style="font-size: 1.3rem;" id="esqueci-senha">Esqueci minha senha</a>
									<br>
									<button class="btn btn-primary" id="login-btn" type="submit">Login</button>
									<button class="btn btn-success" id="cadastrar-btn-modal">Cadastrar</button>
								</form>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</div>
	</div>
	<div class="modal fade" id="signUpModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Cadastro
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</h3>
				</div>
				<div class="modal-body sign-up-modal">
					<label class="control-label">Email</label>
					<input type="email" name="email" class="form-control" id="signUpEmail">
					<label class="control-label">Senha</label>
					<input type="password" name="password" class="form-control" id="signUpPassword">
					<label class="control-label">Confirme a Senha</label>
					<input type="password" name="confirmPassword" class="form-control" id="signUpConfirmPassword">
					<div class="alert alert-danger hide" role="alert" id="passwordAlert" role="alert">
						<strong id="alertMessagePassword">Por favor escolha uma senha e confirme</strong>
					</div>
					<br>
					<label class="inline"><h4>Cadastrar como: </h4></label>
					<select class="inline form-control" id="typeOfUser" name="user_type">
						<option value="aluno" id="aluno">Aluno</option>
						<option value="professor" id="professor">Professor</option>
					</select>
				</div>
				<div class="modal-footer">   	
					<button type="button" class="btn btn-primary disabled" id="cadastrar-btn">Cadastrar</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="senhaModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Esqueci a senha
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</h3>
				</div>
				<div class="modal-body">
					<label class="control-label">Email</label>
					<input type="email" name="email" class="form-control" id="emailEsqueciSenha">
				</div>
				<div class="modal-footer">   	
					<button type="button" class="btn btn-primary" id="sendPassword">Enviar a senha</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>