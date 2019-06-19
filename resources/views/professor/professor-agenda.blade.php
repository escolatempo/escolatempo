@extends($body)

@section('container')	
<div class="col-xs-12">
	<div id="calendar"></div>
</div>

@foreach ($professor->disponibilidade as $disponibilidade)
<div class="professor_disponibilidade">
	<input type="hidden" name="disponibilidade_id" class="disponibilidade_id" value="{{$disponibilidade->id}}">
	<input type="hidden" name="disponibilidade_dia" class="disponibilidade_dia" value="{{$disponibilidade->dia}}">
	<input type="hidden" name="disponibilidade_horario" class="disponibilidade_horario" value="{{$disponibilidade->horario}}">
</div>
@endforeach

@foreach ($professor->agendado as $agendado)
<div class="professor_agendado">
	<input type="hidden" name="agendado_id" class="agendado_id" value="{{$agendado->id}}">
	<input type="hidden" name="agendado_dia" class="agendado_dia" value="{{$agendado->dia}}">
	<input type="hidden" name="agendado_horario" class="agendado_horario" value="{{$agendado->horario}}">
	<input type="hidden" name="agendado_status" class="agendado_status" value="{{$agendado->status}}">	
	<input type="hidden" name="agendado_nome_aluno" class="agendado_nome_aluno" value="{{$agendado->aluno->user->nome}}">
</div>
@endforeach

<div class="modal fade" id="addDisponibilidadeModal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Adicionar Disponibilidade</h4>
				<br>
				<div class="alert alert-danger disponibilidade-alert hide" role="alert">
					<button type="button" class="close close-alert"><span>×</span></button> 
					<strong class="disponibilidade-alert-message"></strong>
				</div>
				
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-6">
						<label class="hide" id="minhaAgenda_listaDePeriodos">Horários Selecionados</label>
						<div class="col-xs-12">
							<ul id="minhaAgenda_periodosSelecionados">
								<!-- All created 'periodos' will be here -->
							</ul>
						</div>
						<p>Selecione os horários que você deseja adicionar</p>
						<div class="row">
							<div class="col-xs-6">
								<label>Início</label>
								<select class="horariosSelect form-control" id="minhaAgenda_horariosInicio">
									<!-- select2 vai carregar as opções aqui -->
								</select>
							</div>
							<div class="col-xs-6">
								<label>Fim</label>
								<select class="horariosSelect form-control" id="minhaAgenda_horariosFim">
									<!-- select2 vai carregar as opções aqui -->
								</select>
							</div>
						</div>        		
						<br>
						<button class="btn btn-success btn-sm" id="minhaAgenda_adicionarPeriodo">Adicionar Horário</button>
					</div>
					<div class="col-xs-6">
						<label>Selecione os meses ou um período para repetir essa disponibilidade</label>
						<select class="select form-control" id="minhaAgenda_formaRepeticao">
							<option>Meses</option>
							<option>Período</option>
						</select>
						<div class="col-xs-12" id="minhaAgenda_meses">
							<h3>Meses</h3>
							<p>Marque os meses que deseja repetir essa disponibilidade</p>
							<div class="row">
								<div class="col-xs-4">
									<label><input type="checkbox" name="janeiro" value="1">Janeiro</label>
								</div>
								<div class="col-xs-4">
									<label><input type="checkbox" name="fevereiro" value="2">Fevereiro</label>
								</div>
								<div class="col-xs-4">
									<label><input type="checkbox" name="marco" value="3">Março</label>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-4">
									<label><input type="checkbox" name="abril" value="4">Abril</label>
								</div>
								<div class="col-xs-4">
									<label><input type="checkbox" name="maio" value="5">Maio</label>
								</div>
								<div class="col-xs-4">
									<label><input type="checkbox" name="junho" value="6">Junho</label>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-4">
									<label><input type="checkbox" name="julho" value="7">Julho</label>
								</div>
								<div class="col-xs-4">
									<label><input type="checkbox" name="agosto" value="8">Agosto</label>
								</div>
								<div class="col-xs-4">
									<label><input type="checkbox" name="setembro" value="9">Setembro</label>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-4">
									<label><input type="checkbox" name="outubro" value="10">Outubro</label>
								</div>
								<div class="col-xs-4">
									<label><input type="checkbox" name="novembro" value="11">Novembro</label>
								</div>
								<div class="col-xs-4">
									<label><input type="checkbox" name="dezembro" value="12">Dezembro</label>
								</div>
							</div>
						</div>
						<div class="col-xs-12 hide" id="minhaAgenda_periodo">
							<h3>Perído</h3>
							<div class="row">
								<div class="col-xs-6">
									<label for="">De: </label>
									<input class="form-control" type="text" name="" id="minhaAgenda_inicioPeriodo" placeholder="DD/MM/YYYY">
								</div>
								<div class="col-sm-6">
									<label for="">A:</label>
									<input class="form-control" type="text" name="" id="minhaAgenda_fimPeriodo" placeholder="DD/MM/YYYY">
								</div>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-xs-12" id="minhaAgenda_diasDaSemana">
						<label>Dias da semana</label>
						<br>
						<p>Marque os dias de semana que deseja repetir essa disponibilidade</p>    			
						<label class="checkbox-inline"><input type="checkbox" value="1">Segundas</label>
						<label class="checkbox-inline"><input type="checkbox" value="2">Terças</label>
						<label class="checkbox-inline"><input type="checkbox" value="3">Quartas</label>
						<label class="checkbox-inline"><input type="checkbox" value="4">Quintas</label>
						<label class="checkbox-inline"><input type="checkbox" value="5">Sextas</label>
						<label class="checkbox-inline"><input type="checkbox" value="6">Sábados</label>
					</div>
				</div>     
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="minhaAgenda_adicionarDisponibilidade">Adicionar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal" id="minhaAgenda_closeModal">Fechar</button>
			</div>
		</div>
	</div>
</div>

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

<div class="modal fade" id="disponivelModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<input type="hidden" name="disponibilidadeId" id="disponibilidadeId" value="">
				<label id="disponivelText"></label>				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger hidden" id="confirmeCancelamentoDisponibilidade">Confirmar Cancelamento</button>
				<button type="button" class="btn btn-danger" id="cancelarDisponibilidade">Cancelar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>
@endsection