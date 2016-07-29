@extends('templates.template1')
@section('jscontroller')
	<script src="{{ URL::asset('angular/jsControllers/editorCtrl.js') }}"></script>
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

	elt.on('itemAdded', function(event) {
	  	tags.initialize(true);
	});
});
</script>
@endsection
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				
				<div class="panel-heading">
					<div style="font-size:x-large;">Haz una pregunta</div>
				</div>
				
				<div class="panel-body" ng-controller="editorCtrl">  
					<form ng-form-commit name="QuestionForm" method="post" action="{{route('questions.store')}}">
						<div class="form-group">
						    <label for="titulo">Titulo:</label>
						    <input type="text" class="form-control" id="titulo" name="title" placeholder="Titulo">
					  	</div>
						<ul class="nav nav-tabs nav-justified" role="tablist">
						  <li role="presentation" class="active"><a href="#edit" aria-controls="edit" role="tab" data-toggle="tab">Editar</a></li>
						  <li role="presentation"><a href="#preview" aria-controls="preview" role="tab" data-toggle="tab">Vista Previa</a></li>
						</ul>

						<div class="tab-content editor-border">
						    <div role="tabpanel" class="tab-pane active" id="edit">
						    	<div class="form-group">
								    <label for="pregunta">Pregunta:</label>
								    <textarea class="form-control editor" id="pregunta" rows="10" name="question" placeholder="Pregunta" ng-model="mymarkdown"></textarea>
								</div>
						    </div>
						    <div role="tabpanel" class="tab-pane" id="preview">
						    	<p ng-if="mymarkdown" class="preview" markdown-to-html="mymarkdown"></p>
						    </div>
						</div>
						<div class="form-group editor-margin">
							<label for="pregunta">Etiquetas:</label>
							<div class="input-group">
								<input type="text" class="form-control taginput" id="taginput" ng-model="selected_tags" name="tags"placeholder="Etiquetas"/>
								<span class="input-group-btn">
									<button type="button" class="btn btn-default" ng-click="open()"><span class="glyphicon glyphicon-tag" aria-hidden="true"></span><span class="hidden-xs">     Nueva Etiqueta</span></button>
								</span>
							</div>
						</div>

						<div class="form-group editor-margin pull-right">
							<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>     Enviar Pregunta</button>
						</div>
					</form>
				</div>

				<script type="text/ng-template" id="myModalContent.html">
				    <div class="modal-header">
				    	<button type="button" class="close" ng-click="cancel()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title">Agrega una nueva etiqueta</h4>
				    </div>
				    <div class="modal-body">
				    	<form name="CrateTagForm" method="post" ng-init="new_tag.career = '0'">
				    		<div class="form-group">
								<label for="tag">Etiqueta:</label>
								<input ng-model="new_tag.tag" type="text" class="form-control" id="tag" placeholder="Etiqueta">
							</div>
							<div class="form-group">
								<label for="career">Carrera:</label>
								<select ng-model="new_tag.career" name="career_id" class="form-control">
									<option value="0" selected>Todas las carreras</option>
									@foreach($careers as $career)
										<option value="{{{$career->id}}}">{{{$career->name}}} ({{{$career->code}}})</option>
									@endforeach
								</select>
							</div>
					    </form>
				    </div>
				    <div class="modal-footer">
				        <button class="btn btn-primary" type="button" ng-click="ok()">Agregar</button>
				        <button class="btn btn-default" type="button" ng-click="cancel()">Cancelar</button>
				    </div>
				</script>

			</div>
		</div>
	</div>
</div>
@endsection