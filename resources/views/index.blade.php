@extends($extension)

@section('container')
<div class="container">
	<div class="separador-nav-bar">
		<img class="img-responsive" src="img/separador-nav-bar.jpg" alt="Imagem de ilustração">
	</div>
	<div class="quem-somos">
		<br>
		<h1 class="quem-somos-h1">Quem Somos</h1>
		<p class="quem-somos-text">Incomodados com o jeito tradicional de ensino um grupo de Jovens se questionou sobre "o que é estudar?" e "para que devemos estudar?".
		Desta reflexão surgiu a escola Tempo. A Tempo é uma escola criada por estudantes para estudantes com aulas dadas por aqueles que entendem melhor que ninguém o que é ser aluno. Utilizando-se de Ambientes Descontraídos, Técnicas Inovadoras e Professores Universitários, a Tempo oferece um jeito novo de ensinar e de aprender ;D</p>
		<br><br><br>
	</div>
	<div class="custom-slider">
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
				<li data-target="#carousel-example-generic" data-slide-to="1"></li>
				<li data-target="#carousel-example-generic" data-slide-to="3"></li>
				<li data-target="#carousel-example-generic" data-slide-to="4"></li>
			</ol>

			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<div class="item active">
					<img src="../img/slider/Tempo1.jpg" alt="...">
				</div>
				<div class="item">
					<img src="../img/slider/Tempo2.jpg" alt="...">
				</div>
				<div class="item">
					<img src="../img/slider/Tempo3.jpg" alt="...">
				</div>
				<div class="item">
					<img src="../img/slider/Tempo4.jpg" alt="...">
				</div>
			</div>

			<!-- Controls -->
			<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>		
	</div>
	<div class="custom-footer">
		<br><br><br><br><br><br>
		<div class="row">
			<div class="col-lg-6 col-sm-12">
				<h2>Endereço</h2>
				<h4>Av. Afonso Pena n:2744</h4>
				<br>
				<div id="map">
				</div>
			</div>
			<div class="col-lg-6 col-sm-12">
				<h2>Contatos</h2>
				<div class="row">
					<div class="col-xs-6">
						<i class="contato email fa fa-envelope" aria-hidden="true"> escolatempobh@gmail.com</i>
					</div>
					<div class="col-xs-6">
						<i class="contato telefone fa fa-phone-square" aria-hidden="true"> (31) 2520-9536</i>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-xs-6">
						<i class="contato whastapp fa fa-whatsapp" aria-hidden="true"> (31) 99959-1622</i>
					</div>
					<div class="col-xs-6">
						<a href="https://www.facebook.com/escolatempo" style="color: #333">
							<i class="contato face fa fa-facebook-official" aria-hidden="true"> /escolatempo</i>
						</a>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="alert alert-danger hide" id="alert-contato-div" role="alert">
						<button type="button" class="close" aria-label="Close"><span aria-hidden="true" class="close-alert">×</span></button> 
						<strong id="alert-contato-text"></strong>
					</div>
					<div class="form-area">
						<form role="form">
							<br style="clear:both">							
							<div class="form-group">
								<input type="text" class="form-control" id="email-nome" name="nome" placeholder="Nome" required>
							</div>
							<div class="form-group">
								<input type="email" class="form-control" id="email-email" name="email" placeholder="Email" required>
							</div>							
							<div class="form-group">
								<textarea class="form-control" type="textarea" id="email-mensagem" placeholder="Mensagem" maxlength="180" rows="4"></textarea>
							</div>
							<button type="button" id="email-submit" name="submit" class="btn btn-primary pull-right">Enviar</button>
						</form>
						<br><br>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@stop
