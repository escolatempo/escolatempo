@extends($extension)

@section('container')
<div class="container">
	<div class="row" style="margin-top: 50px;">	
		<div class="col-xs-4 col-xs-offset-4 well">
			<form method="POST" action="/submit-nova-senha">
				{!! csrf_field() !!}
			  <h4 class="text-center">Nova Senha</h4>
			  <hr>				
			  <div class="form-group">
			  	<label for="email" class="sr-only">Email</label>
			  	<input name="email" type="email" id="user_email" class="form-control" value="{{$email}}" readonly>
			  </div>
			  <div class="form-group">			  	
			  	<input name="token" type="hidden" id="user_token" class="form-control" value="{{$token}}" readonly>
			  </div>
			  <div class="form-group">
			  	<label for="nova-senha" class="sr-only">Senha</label>
			  	<input name="password" type="password" id="nova-senha" class="form-control" placeholder="Nova Senha" required>			  	
			  	<label for="confirmacao-senha" class="sr-only">Confirmação Senha</label>
			  	<input name="confirmation-password" type="password" id="confirmacao-senha" class="form-control" placeholder="Confirmação Senha" required>
			  </div>			  
			  <button class="btn btn-lg btn-primary btn-block" type="submit" id="submit-btn-nova-senha">Enviar</button>
			</form>
		</div>
	</div>
</div> 
@stop