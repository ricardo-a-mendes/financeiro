@extends('layouts.app')

@section('content')

	<div class="row">
		<div class="page-header">
			<h3>Categorias <small><a href="{{route('category.create')}}" data-toggle="tooltip" data-placement="top" title="Nova Categoria" class="deco-none glyphicon glyphicon-plus" style="cursor: pointer"></a></small></h3>
		</div>

		<table class="table table-striped">
			<thead>
			<tr>
				<th>ID</th>
				<th>Categoria</th>
				<th>Ações</th>
			</tr>
			</thead>
			<tbody>
			@forelse($categories as $category)
				<tr>
					<td>{{$category->id}}</td>
					<td>{{$category->description}}</td>
					<td>
						<a href="{{route('category.edit', ['id' => $category->id])}}" data-toggle="tooltip" data-placement="top" title="Editar" class="deco-none glyphicon glyphicon-pencil"></a>
						&nbsp;|&nbsp;
						<span style="cursor: pointer" data-category="{{$category->description}}" data-category_id="{{$category->id}}" data-toggle="modal" data-target="#deleteCategory">
							<span data-toggle="tooltip" data-placement="top" title="Excluir" class="glyphicon glyphicon-trash"></span>
						</span>
					</td>
				</tr>
			@empty
				<tr>
					<td colspan="3">Nenhuma categoria cadastrada.</td>
				</tr>
			@endforelse
			</tbody>
		</table>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="deleteCategory" tabindex="-1" role="dialog" aria-labelledby="deleteCategory">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form id="formDestroy" class="form " method="post" action="{{route('category.destroy', ['categoryID' => ''])}}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Confirmação de exclusão de categoria.</h4>
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
			//Modal for Dete a Category
			$('#deleteCategory').on('show.bs.modal', function (event) {
				var span = $(event.relatedTarget) // Span that triggered the modal
				var category = span.data('category') // Extract info from data-* attributes
				var category_id = span.data('category_id') // Extract info from data-* attributes

				var modal = $(this);
				var formDestroy = modal.find('form#formDestroy');
				modal.find('.modal-body').html('Deseja excluir a categoria "' + category + '"?');

				var url_cation = formDestroy.attr('action') + '/' + category_id;
				formDestroy.attr('action', url_cation);

			}).modal({'backdrop': 'static', 'show': false});
		});
	</script>
@endsection