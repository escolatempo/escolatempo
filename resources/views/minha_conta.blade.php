@extends($body)

@section('container')	
<div class="col-xs-12">
	<h4>Informações do Usuario</h4>
	<hr>
	<div class="col-xs-8">
		<input type="hidden" name="user_type" id="minhaConta_UserType" value="{{$user->user->user_type}}">
		<label>Nome</label>
		<div class="row">
			<div class="col-xs-6">
				<input class="form-control" type="text" name="nome" id="minhaConta_nome" value="{{$user->user->nome}}" placeholder="Nome">
			</div>
			<div class="col-xs-6">
				<input class="form-control" type="text" name="sobrenome" id="minhaConta_sobreNome" value="{{$user->user->sobrenome}}" placeholder="sobrenome">
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-12">
				<label>Email</label>
				<input class="form-control" disabled type="email" name="email" id="minhaConta_email" value="{{$user->user->email}}">
			</div>			
		</div>
		<div id="minhaConta_materiasDiv" class="hidden">
			<hr>
			<div class="row">
				<div class="col-xs-6">
					<label>Minhas Materias</label>
					<select class="materiasSelect form-control" multiple="multiple" id="minhaConta_materias">
						<!-- select2 vai carregar as opções aqui -->
					</select>			
					@foreach($user->materia as $materia)
						<input class="materias-id" type="hidden" name="materia-id" value="{{$materia->materia_id}}">
					@endforeach
				</div>
			</div>
		</div>
		<hr>

		<button class="btn btn-default" id="btnMudarSenha">Mudar senha</button>		
		<br>
		<div class="hide" id="mudarSenha">
			<div class="row">
				<div class="col-xs-6">
					<label for="">Nova Senha</label>
					<div class="row">
						<div class="col-xs-12">
							<input type="password" class="form-control" id="minhaConta_novaSenha" placeholder="" name="novaSenha">
						</div>
					</div>
				</div>
			</div>

			<br>

			<div class="row">
				<div class="col-xs-6">
					<label for="">Confirmar Senha</label>
					<div class="row">
						<div class="col-xs-12">
							<input type="password" class="form-control" id="minhaConta_confirmacaoSenha" placeholder="" name="confirmacaoSenha">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="alert alert-danger" role="alert" id="alertaConfirmacao">	
								<strong id="messagemDeAlerta">Confirme a Senha</strong>
							</div>
						</div>
					</div>
				</div>
			</div>

			<br>

			<div class="row">
				<div class="col-xs-6">
					<label for="">Senha Antiga</label>
					<div class="row">
						<div class="col-xs-12">
							<input type="password" class="form-control" id="minhaConta_senhaAntiga" placeholder="" name="senhaAntiga">
						</div>
					</div>
				</div>
			</div>
		</div>

		<br>

		<div class="row">
			<div class="col-xs-4">
				<button class="btn btn-primary btn-block" type="submit" id="minhaConta_submitBtn">Salvar</button>
			</div>
		</div>

	</div>
</div>	
@endsection