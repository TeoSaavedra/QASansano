<!DOCTYPE html>
<html lang="en" ng-app="QASapp">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>QASansano</title>

	<!-- JQUERY -->
	<script src="{{ URL::asset('vendor/jquery/jquery-1.11.3.js') }}"></script>
	
	<!-- BOOTSTRAP -->
	<link rel="stylesheet" href="{{ URL::asset('bootstrap/css/bootstrap.css') }}">
	<script src="{{ URL::asset('bootstrap/js/bootstrap.js') }}"></script>
	
	<!-- ANGULARJS -->
	<script src="{{ URL::asset('vendor/angularjs/angular.js') }}"></script>
	<script src="{{ URL::asset('vendor/angularjs/angular-sanitize.js') }}"></script>
	<script src="{{ URL::asset('vendor/angularjs/angular-animate.js') }}"></script>
	
	<!-- SHOWDOWN -->
	<script src="{{ URL::asset('vendor/showdownjs/showdown.js') }}"></script>
	<script src="{{ URL::asset('vendor/showdownjs/ng-showdown.js') }}"></script>
	
	<!-- CSS -->
	<link rel="stylesheet" href="{{ URL::asset('css/main.css') }}">

	<!-- ANGULARJS APP -->
	<script src="{{ URL::asset('angular/QASapp.js') }}"></script>
	<script src="{{ URL::asset('angular/jsControllers/logCtrl.js') }}"></script>
	@yield('jscontroller')

	<!-- BOOTSTRAP-TAGSINPUT -->
	<script src="{{ URL::asset('vendor/typeahead/typeahead.js') }}"></script>
	<link rel="stylesheet" href="{{ URL::asset('vendor/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('vendor/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css') }}">
	<script src="{{ URL::asset('vendor/bootstrap-tagsinput/bootstrap-tagsinput-angular.js') }}"></script>
	<script src="{{ URL::asset('vendor/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>

	<!-- UI BOOTSTRAP -->
	<script src="{{ URL::asset('vendor/ui-bootstrap/ui-bootstrap-tpls-1.0.0.js') }}"></script>

	<!-- ANGULARJS-SLIDER -->
	<script src="{{ URL::asset('vendor/angularjs-slider/rzslider.js') }}"></script>
	<link rel="stylesheet" href="{{ URL::asset('vendor/angularjs-slider/rzslider.css') }}">


	<!-- Fonts -->
	{{-- <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css"> --}}

	@yield('jsscript')
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/"><strong>QAS</strong>ansano</a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
		        <ul class="nav navbar-nav navbar-right">
		        	@if(Auth::check())
		        		<li>
		        			<a>
		        			<span class="glyphicon glyphicon-user glyphicon-lg" aria-hidden="true"></span><span class="navbar-option">{{Auth::user()->email}}</span>
		        			</a>
		        		</li>
			        	<li>
			          		<a href="{{route('logout')}}">
			          			<span class="glyphicon glyphicon-log-out glyphicon-lg" aria-hidden="true"></span><span class="navbar-option">Cerrar Sesión</span>
			          		</a>
			          	</li>
			         @else
			          	<li>
			          		<a href="" data-toggle="modal" data-target="#LogInModal">
			          			<span class="glyphicon glyphicon-log-in glyphicon-lg" aria-hidden="true"></span><span class="navbar-option">Iniciar Sesión</span>
			          		</a>
			          	</li>
			          	<li>
			          		<a href="{{route('register')}}">
			          			<span class="glyphicon glyphicon-user glyphicon-lg" aria-hidden="true"></span><span class="navbar-option">Registrate</span>
			          		</a>
			          	</li>
			        @endif
		        </ul>
			</div>
		</div>
	</nav>
	@if(!Auth::check())
		<div class="modal fade" id="LogInModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  	<div class="modal-dialog modal-sm" role="document">
		    	<div class="modal-content" ng-controller="logCtrl">
		    		<form ng-form-commit name="LogInForm" method="post" action="{{route('login')}}">
			      		<div class="modal-header modal-header-custom">
			        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        		<h4 class="modal-title" id="myModalLabel">Iniciar Sesión</h4>
			      		</div>
				      	<div class="modal-body modal-body">
				        	<div class="form-group">
			              		<input type="text" name="email" ng-model="email" class="form-control form-group-custom" id="email" placeholder="Email" autofocus>
			            	</div>
			            	<div class="form-group no-margin-bottom">
			              		<input type="password" name="password" ng-model="passwd" class="form-control form-group-custom" id="pwd" placeholder="Contraseña">
			            	</div>  
				      	</div>
				      	<div class="modal-footer modal-footer-custom">
				        	<button ng-submit="ok(LogInForm)" ng-click="ok(LogInForm)" class="btn btn-primary">Ingresar</button>
				      	</div>
				     </form>
		    	</div>
		  	</div>
		</div>
	@endif

	@yield('content')

</body>
</html>