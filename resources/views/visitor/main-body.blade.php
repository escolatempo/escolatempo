@include ('main/head')
<div class="container">
	@include ('nav-bars/visitor-nav-bar')
	@include ('main/alert-div')	
</div>
<br><br><br>
@yield('container')

@include ('main/footer')