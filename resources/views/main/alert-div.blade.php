<div class="alert hidden" id="alert-id" role="alert">
	<button type="button" class="close" aria-label="Close"><span aria-hidden="true" class="close-alert">×</span></button> 
	<strong id="alert-strong"> </strong>
</div>
@if(!empty($message))
	<div class="alert {{$alertClass}}" id="alert-controller" role="alert">
		<button type="button" class="close" aria-label="Close"><span aria-hidden="true" class="close-alert">×</span></button> 
		<strong id="alert-strong-controller"> {{$message}} </strong>
	</div>
@endif