@extends($body)

@section('container')

<div class="col-xs-12">
	<div id="calendar"></div>
</div>
<input type="hidden" name="aulas" value="{{$aulas}}" id="aulas">

<div class="modal fade" id="agendadoModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<input type="hidden" name="agendadoId" id="agendadoId" value="">				
				<br>
				<label>Observações: </label>
				<textarea disabled="disabled" class="form-control" id="observacoes"></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger hidden" id="confirmeCancelamento">Confirmar Cancelamento</button>
				<button type="button" class="btn btn-danger" id="cancelarAgendado">Cancelar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>

@endsection