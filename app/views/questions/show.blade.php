@extends('templates.template1')
@section('jscontroller')
	<script src="{{ URL::asset('angular/jsControllers/questionShowCtrl.js') }}"></script>
	<script src="{{ URL::asset('angular/jsControllers/recomendationCtrl.js') }}"></script>
@endsection
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10" ng-controller="questionShowCtrl">
			<div class="panel panel-default">
				
				<div class="panel-body">
					<div ng-init="recommend.id = {{{$question->id}}}"class="page-header no-margin-top">
						<h4>{{$question->title}}
						@foreach($tags as $tag)
							<span ng-init="recommend.tags.push({{{$tag->id}}})" class="label label-success">{{$tag->tag}}</span>
						@endforeach
						</h4>
					</div>
					<div class="row">
						<div class="col-xs-2 col-md-1">
						<label class="difficulty-label">Dificultad:</label>
						<p class="difficulty-number"><%difficulty%></p>
						@if(Auth::check())
							<button ng-click="open()" type="submit" class="btn btn-warning btn-xs">Calificar</button>
						@endif
						</div>
						<div class="col-xs-10 col-md-11">
							<p ng-init="question = '{{{$question->question}}}'" class="preview" markdown-to-html="question"></p>
						</div>
					</div>
					<blockquote class="blockquote-reverse blockquote-custom">
							<p><em>Preguntado por:</em> <samp>{{$user['email']}}</samp></p>
							<footer>Preguntado el: {{date('l d \d\e F \d\e\l Y \a \l\a\s H:i:s',strtotime($question->created_at))}}</footer>
					</blockquote>
				</div>

			</div>
			
			<h4>Respuestas:</h4>

			<div ng-repeat="answer in answers | orderBy: ['correct','-votes'] as results" class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-2 col-md-1">
							@if(Auth::check())
							<p class="vote-button"><a ng-click="vote(answer.id,1)"><span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span></a></p>
							@endif
							<p class="vote-count"><strong><%answer.votes%></strong></p>
							@if(Auth::check())
							<p class="vote-button"><a ng-click="vote(answer.id,-1)"><span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span></a></p>
							@endif
							@if(Auth::check() && Auth::id() == $user['id'])
							<p class="vote-button"><a ng-click="correct(answer.id)"><span class="glyphicon glyphicon-ok" ng-class="answer.correct == 1 ? 'correct' : 'correct-btn'" aria-hidden="true"></span></a></p>
							@endif
							@if(Auth::id() != $user['id'])
							<p class="vote-button" ng-if="answer.correct == 1"><a ng-click=""><span class="glyphicon glyphicon-ok correct" aria-hidden="true"></span></a></p>
							@endif
						</div>
						<div class="col-md-11">
							<p class="preview" markdown-to-html="answer.answer"></p>
							<blockquote class="blockquote-reverse blockquote-custom">
								<p><em>Usuario:</em> <samp><%answer.email%></samp></p>
								<footer>Fecha: <%answer.created_at%></footer>
						</blockquote>
						</div>
					</div>
				</div>
			</div>
			<div ng-if="results.length == 0" class="panel panel-default">
				<div class="panel-body">
					No hay respuestas.
				</div>
			</div>

			@if(Auth::check() && Auth::id() != $user['id'])
			<div class="panel panel-default">
				<div class="panel-heading">
					<div>Tu Respuesta:</div>
				</div>
				<div class="panel-body">
					<ul class="nav nav-tabs nav-justified" role="tablist">
						<li role="presentation" class="active"><a data-target="#edit" aria-controls="edit" role="tab" data-toggle="tab">Editar</a></li>
						<li role="presentation"><a data-target="#preview" aria-controls="preview" role="tab" data-toggle="tab">Vista Previa</a></li>
					</ul>
					<div class="tab-content editor-border">
					    <div role="tabpanel" class="tab-pane active" id="edit">
					    	<div class="form-group">
							    <textarea class="form-control editor" id="pregunta" rows="10" name="question" placeholder="Respuesta" ng-model="myanswer"></textarea>
							</div>
					    </div>
					    <div role="tabpanel" class="tab-pane" id="preview">
					    	<p ng-if="myanswer" class="preview" markdown-to-html="myanswer"></p>
					    </div>
					</div>
					<div class="form-group editor-margin pull-right">
						<button ng-click="ok()" type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>     Enviar Respuesta</button>
					</div>
				</div>
			</div>
			@endif

		</div>

		@if(Auth::check())
		<script type="text/ng-template" id="myModalContent.html">
		    <div class="modal-header">
		    	<button type="button" class="close" ng-click="cancel()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title">¿Cual es la dificultad de esa pregunta?</h4>
		    </div>
		    <div class="modal-body">
		    	<p>Selecciona la dificultad de esta pregunta, siendo 1 la mas fácil y 5 la mas difícil.<p>
		    	<form name="CrateTagForm" method="post">
		    		<div class="form-group">
						<label class="control-label">Dificultad:</label>
						<rzslider rz-slider-model="difficulty" rz-slider-options="{floor: 1,ceil: 5,showTicksValues: true}"></rzslider>
					</div>
			    </form>
		    </div>
		    <div class="modal-footer">
		        <button class="btn btn-primary" type="button" ng-click="ok()">Calificar</button>
		        <button class="btn btn-default" type="button" ng-click="cancel()">Cancelar</button>
		    </div>
		</script>
		@endif

		<div class="col-md-2" ng-controller="recommendationCtrl">
			<div class="panel panel-default">
				<div class="panel-heading">Recomendaciones</div>
				<div class="panel-body">
					<div class="media question-row" ng-repeat="question in questions | filter: all as results_all">
						<p class=""><a href="/questions/<%question.id%>"><%question.title%></a></p>
						<p><strong>Dificultad:</strong> <span style="background-color: #f0ad4e;" class="badge"><%question.difficulty%></span></p>
						<p class="tags-margin-bottom">
							<span class="label label-success tags-margin-left" ng-repeat="tag in question.tags">
								<%tag.tag%>
							</span>
						</p>
					</div>
					<div class="media question-row" ng-if="results_all.length == 0">
						No hay resultados
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">Recomendaciones por Etiquetas</div>
				<div class="panel-body">
					<div class="media question-row" ng-repeat="question in questions | filter: by_tags as results_tags">
						<p class=""><a href="/questions/<%question.id%>"><%question.title%></a></p>
						<p><strong>Dificultad:</strong> <span style="background-color: #f0ad4e;" class="badge"><%question.difficulty%></span></p>
						<p class="tags-margin-bottom">
							<span class="label label-success tags-margin-left" ng-repeat="tag in question.tags">
								<%tag.tag%>
							</span>
						</p>
					</div>
					<div class="media question-row" ng-if="results_tags.length == 0">
						No hay resultados
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">Recomendaciones por Dificultad</div>
				<div class="panel-body">
					<div class="media question-row" ng-repeat="question in questions | filter: by_diff as results_diff">
						<p class=""><a href="/questions/<%question.id%>"><%question.title%></a></p>
						<p><strong>Dificultad:</strong> <span style="background-color: #f0ad4e;" class="badge"><%question.difficulty%></span></p>
						<p class="tags-margin-bottom">
							<span class="label label-success tags-margin-left" ng-repeat="tag in question.tags">
								<%tag.tag%>
							</span>
						</p>
					</div>
					<div class="media question-row" ng-if="results_diff.length == 0">
						No hay resultados
					</div>
			</div>
		</div>
	</div>
</div>
@endsection