@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="page-header">
				<h3>Categorias <small><span data-toggle="tooltip" data-placement="top" title="Nova Categoria" class="glyphicon glyphicon-plus" style="cursor: pointer"></span></small></h3>
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
						<td><span data-toggle="tooltip" data-placement="top" title="Editar" class="glyphicon glyphicon-pencil"></span> | <span data-toggle="tooltip" data-placement="top" title="Excluir" class="glyphicon glyphicon-trash"></span></td>
					</tr>
				@empty
					<tr>
						<td colspan="3">Nenhuma categoria cadastrada.</td>
					</tr>
				@endforelse
				</tbody>
			</table>
		</div>
	</div>
@endsection