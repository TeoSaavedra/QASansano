@extends('templates.template1')
@section('jscontroller')
	<script src="{{ URL::asset('angular/jsControllers/questionHomeCtrl.js') }}"></script>
@endsection
@section('jsscript')
<script>
$('document').ready(function (){
	var tags = new Bloodhound({
	  	datumTokenizer: Bloodhound.tokenizers.obj.whitespace('tag'),
	  	queryTokenizer: Bloodhound.tokenizers.whitespace,
	  	prefetch: {
	  		url: 'http://qasansano.dev/tags',
	  		cache: false
	  	},
	  	remote: 'http://qasansano.dev/tags'
	});
	tags.initialize();

	var elt = $('#taginput');
	elt.tagsinput({
		itemValue: 'id',
		itemText: 'tag',
		tagClass: 'label label-success taginput-label',
		typeaheadjs: {
		    name: 'tags',
		    displayKey: 'tag',
		    source: tags.ttAdapter()
	  	}
	});
});
</script>
@endsection
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default" ng-controller="questionHomeCtrl" >
				
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-2" style="font-size: x-large;">Preguntas</div>
						<div class="col-xs-10 text-right">
							<button ng-click="switch()" type="button" class="btn btn-default"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span>    <span class="hidden-xs">Filtrar Preguntas<span></button>
							<a href="{{route('questions.create')}}" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>    <span class="hidden-xs">Nueva Pregunta<span></a>
						</div>
					</div>
				</div>
				
				<div class="panel-body">
					<div bn-slide-show="isVisible">
						<div class="row">
							<div class="form-group col-md-3">
								<label for="career">Carrera:</label>
								@if(Auth::check())
								<select ng-model="filters.career" name="career_id" class="form-control" ng-init="filters.career = '{{Auth::user()->career_id}}'">
								@else
								<select ng-model="filters.career" name="career_id" class="form-control" ng-init="filters.career = '0'">
								@endif

									<option value="0">Todas las carreras</option>
									@foreach($careers as $career)
										<option value="{{{$career->id}}}">{{{$career->name}}} ({{{$career->code}}})</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-md-5">
								<label for="pregunta">Etiquetas:</label>
								<select multiple rows="1" class="form-control taginput-home" id="taginput" ng-model="filters.tags" name="tags" placeholder="Etiquetas"/></select>
							</div>
							<div class="form-group col-md-4">
								<label class="control-label">Rango de dificultad:</label>
								<div>
	    							<rzslider rz-slider-model="filters.difficulty.min" rz-slider-high="filters.difficulty.max" rz-slider-options="slider.options"></rzslider>
	    						</div>
							</div>
						</div>
					</div>

					<div class="media question-row" ng-repeat="question in questions | filter: search as results">
						<div class="row">
							<div class="col-xs-8">
								<h4 class="media-heading"><a href="/questions/<%question.id%>"><%question.title%></a></h4>
								<p class="tags-margin-bottom">
									<a ng-click="tagAdd(tag)" class="label label-success tags-margin-left" ng-repeat="tag in question.tags">
										<%tag.tag%>
									</a>
								</p>
								<p class="info-question"><strong>Pregunta por:</strong> <samp><%question.user%></samp></p>
							</div>
							<div class="col-xs-4">
								<p>
									<span style="margin-right: 5px"><strong>Respuestas:</strong> <span style="background-color: #5cb85c;" class="badge"><%question.answers%></span></span>
									<span><strong>Dificultad:</strong> <span style="background-color: #f0ad4e;" class="badge"><%question.difficulty%></span></span>
								</p>
								<p style="margin-top: 13px;"class="info-question"><strong>Preguntado el:</strong></br><%question.created_at%></p>
							</div>
						</div>
					</div>
					<div class="media question-row" ng-if="results.length == 0">
						No hay resultados
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
@stop