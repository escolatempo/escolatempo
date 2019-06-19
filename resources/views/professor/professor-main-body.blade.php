@include ('main/head')
<div class="container">
	@include ('nav-bars/professor-nav-bar')
	<br><br><br>
</div>
<div class="container">
@include ('main/alert-div')
	@yield('container')
</div>
@include ('main/footer')