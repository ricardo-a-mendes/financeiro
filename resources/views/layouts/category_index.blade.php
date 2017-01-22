@extends('layouts.app')

@section('content')

	<div class="row">
		<div class="page-header">
			<h3>{{trans_choice('category.labels.category', 2)}} <small><a href="{{route('category.create')}}" data-toggle="tooltip" data-placement="top" title="{{trans('category.labels.new')}}" class="deco-none glyphicon glyphicon-plus cursor-pointer"></a></small></h3>
		</div>

		<table class="table table-striped">
			<thead>
			<tr>
				<th>ID</th>
				<th>{{trans_choice('category.labels.category', 1)}}</th>
				<th>{{trans('app.labels.actions')}}</th>
			</tr>
			</thead>
			<tbody>
			@forelse($categories as $category)
				<tr>
					<td>{{$category->id}}</td>
					<td>{{$category->name}}</td>
					<td>
						<a href="{{route('category.edit', ['id' => $category->id])}}" data-toggle="tooltip" data-placement="top" title="{{trans('app.labels.edit')}}" class="deco-none glyphicon glyphicon-pencil"></a>
						&nbsp;|&nbsp;
						<span class="cursor-pointer" data-category="{{$category->name}}" data-category_id="{{$category->id}}" data-toggle="modal" data-target="#deleteCategory">
							<span data-toggle="tooltip" data-placement="top" title="{{trans('app.labels.edit')}}" class="glyphicon glyphicon-trash"></span>
						</span>
					</td>
				</tr>
			@empty
				<tr>
					<td colspan="3">{{trans('app.messages.no_items_found')}}</td>
				</tr>
			@endforelse
			</tbody>
		</table>
	</div>

	<!-- Modal Delete Category -->
	<div class="modal fade" id="deleteCategory" tabindex="-1" role="dialog" aria-labelledby="deleteCategory">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form id="formDestroy" class="form " method="post" action="{{route('category.destroy', ['categoryID' => ''])}}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">{{trans('app.labels.delete_confirmation', ['itemToConfirm' => trans_choice('category.labels.category', 1)])}}.</h4>
					</div>
					<div class="modal-body"></div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-danger">{{trans('app.labels.delete')}}</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">{{trans('app.labels.close')}}</button>
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
			//Modal for Delete a Category
			$('#deleteCategory').on('show.bs.modal', function (event) {
				var span = $(event.relatedTarget) // Span that triggered the modal
				var category = span.data('category') // Extract info from data-* attributes
				var category_id = span.data('category_id') // Extract info from data-* attributes

				var modal = $(this);
				var formDestroy = modal.find('form#formDestroy');
				modal.find('.modal-body').html('{{trans('app.messages.delete_confirmation')}} "' + category + '"?');

				var url_cation = formDestroy.attr('action') + '/' + category_id;
				formDestroy.attr('action', url_cation);

			}).modal({'backdrop': 'static', 'show': false});
		});
	</script>
@endsection