@extends('templates.template1')
@section('jscontroller')
	<script src="{{ URL::asset('angular/jsControllers/signinCtrl.js') }}"></script>
@endsection
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading"><strong>Registrate</strong></div>

				<div class="panel-body" ng-app="QASapp" ng-controller="SignInCtrl">
					<div class="row">
						<div class=" col-md-12 col-md-offset-2">
							<form class="form-horizontal" action="{{route('users.store')}}" method="post">
								<div class="form-group form-group-lg">
									<div class="row">
										<div class="col-sm-4 margin-bottom">
				      						<input type="name" name="fname" class="form-control" id="inputName" placeholder="Nombre" ng-model="fname">
				    					</div>
				    					<div class="col-sm-4">
				      						<input type="lname" name="lname" class="form-control" id="inputLName" placeholder="Apellido" ng-model="lname">
				    					</div>
			    					</div>
			    				</div>
			    				<div class="form-group form-group-lg">
			    					<div class="row">
										<div class="col-sm-8">
											<select name="career_id" class="form-control">
												@foreach($careers as $career)
													<option value="{{{$career->id}}}">{{{$career->name}}} ({{{$career->code}}})</option>
												@endforeach
											</select>
				    					</div>
				    				</div>
			    				</div>
			    				<div class="form-group form-group-lg">
			    					<div class="row">
										<div class="col-sm-8">
				      						<input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email" ng-model="email">
				    					</div>
				    				</div>
			    				</div>
			    				<div class="form-group form-group-lg">
			    					<div class="row">
										<div class="col-sm-8">
				      						<input type="password" name="passwd" class="form-control" id="inputPasswd" placeholder="Password" ng-model="passwd">
				    					</div>
				    				</div>
			    				</div>
			    				<div class="form-group form-group-lg">
			    					<div class="row">
										<div class="col-sm-6">
			      							<input type="password" class="form-control" id="inputEmail" placeholder="Confirmar Password" ng-model="passwd2">
			    						</div>
			    						<div class="col-md-offset-6">
			    							<button type="submit" class="btn btn-success btn-lg" ng-disabled="incomplete">
										  		<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Aceptar
											</button>
										</div>
			    					</div>
			    				</div>
							</form>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
@endsection