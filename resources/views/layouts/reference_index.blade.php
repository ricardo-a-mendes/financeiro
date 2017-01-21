@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="page-header">
			<h3>{{trans_choice('reference.labels.reference', 2)}}</h3>
		</div>

		<table class="table table-striped">
			<thead>
			<tr>
				<th>ID</th>
				<th>{{trans_choice('reference.labels.reference', 1)}}</th>
				<th>{{trans_choice('category.labels.category', 1)}}</th>
				<th>{{trans('app.labels.actions')}}</th>
			</tr>
			</thead>
			<tbody>
			@forelse($references as $reference)
				<tr>
					<td>{{$reference->id}}</td>
					<td>{{$reference->description}}</td>
					<td>{{$reference->category->name}}</td>
					<td>
						<a href="{{route('reference.edit', ['id' => $reference->id])}}" data-toggle="tooltip" data-placement="top" title="{{trans('app.labels.edit')}}" class="deco-none glyphicon glyphicon-pencil"></a>
						&nbsp;|&nbsp;
						<span class="cursor-pointer" data-reference="{{$reference->description}}" data-reference_id="{{$reference->id}}" data-toggle="modal" data-target="#deleteReference">
							<span data-toggle="tooltip" data-placement="top" title="{{trans('app.labels.delete')}}" class="glyphicon glyphicon-trash"></span>
						</span>
					</td>
				</tr>
			@empty
				<tr>
					<td colspan="4">Nenhuma Referência cadastrada.</td>
				</tr>
			@endforelse
			</tbody>
		</table>

	</div>

	<!-- Modal Delete Reference -->
	<div class="modal fade" id="deleteReference" tabindex="-1" role="dialog" aria-labelledby="deleteReferenceLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form id="formDestroy" class="form " method="post" action="{{route('reference.destroy', ['referenceID' => ''])}}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Confirmação de exclusão da referência.</h4>
					</div>
					<div class="modal-body"></div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-danger">Excluir</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection
@section('js')
	<script type="text/javascript" src="{{asset('js/bootstrap/modal.js')}}"></script>
	<script type="text/javascript">
		$(function(){
			//Modal for Dete Reference
			$('#deleteReference').on('show.bs.modal', function (event) {
				var span = $(event.relatedTarget) // Span that triggered the modal
				var reference = span.data('reference') // Extract info from data-* attributes
				var reference_id = span.data('reference_id') // Extract info from data-* attributes

				var modal = $(this);
				var formDestroy = modal.find('form#formDestroy');
				modal.find('.modal-body').html('Deseja excluir a referencia "' + reference + '"?');

				var url_cation = formDestroy.attr('action') + '/' + reference_id;
				formDestroy.attr('action', url_cation);

			}).modal({'backdrop': 'static', 'show': false});
		});
	</script>
@endsection