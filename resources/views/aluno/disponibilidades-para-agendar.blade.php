@extends($body)
@section('container')
	<div>
		<div id="calendar"></div>
	</div>
	<input type="hidden" name="" class="disponibilidades-para-agendar" value="{{$disponibilidades}}">
	<input type="hidden" name="" id="materiaId" value="{{$materiaId}}">
	<input type="hidden" name="" id="materiaNome" value="{{$materiaNome}}">

	<div class="modal fade" id="agendarAulaModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="col-xl-8">
						<select class="agendamentoSelect form-control">
							
						</select>
						<br>
						<label>Se quiser deixe uma observação para o professor.</label>
						<textarea class="form-control" rows="5" name="observacao" id="observacao"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="agendar_aula">Agendar</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
				</div>
			</div>
		</div>
	</div>
@endSection