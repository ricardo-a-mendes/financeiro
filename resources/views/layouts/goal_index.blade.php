@extends('layouts.app')

@section('css')
	<style type="text/css">
		.text-red {color: red;}
		.text-green {color: green;}
	</style>
@endsection
@section('content')
	<div class="row">
		<div class="page-header">
			<h3>Metas <small><a href="{{route('goal.create')}}" data-toggle="tooltip" data-placement="top" title="Nova Meta" class="deco-none glyphicon glyphicon-plus" style="cursor: pointer"></a></small></h3>
		</div>

		<table class="table table-striped">
			<thead>
			<tr>
				<th>ID</th>
				<th>Categoria</th>
				<th>Meta</th>
				<th>Específica</th>
				<th>Tipo</th>
				<th>Ações</th>
			</tr>
			</thead>
			<tbody>
			@forelse($goals as $goal)
			<tr>
				<td>{{$goal->id}}</td>
				<td><a href="{{route('category.edit', ['id' => $goal->category->id])}}">{{$goal->category->name}}</a></td>
				<td>{{Number::formatCurrency($goal->value)}}</td>
				<td>
					@if($goal->goalDate->count() > 0)
						<span class="glyphicon glyphicon-calendar cursor-pointer" data-toggle="tooltip" data-placement="right" title="Visualizar"></span>
					@else
						&nbsp;
					@endif
				</td>
				<td class="{{($goal->transactionType->unique_name === 'credit')?'text-green':'text-red'}}">{{$goal->transactionType->name}}</td>
				<td>
					<a href="{{route('account.edit', ['id' => $goal->id])}}" data-toggle="tooltip" data-placement="top" title="Editar" class="deco-none glyphicon glyphicon-pencil"></a>
					&nbsp;|&nbsp;
					<span style="cursor: pointer" data-category="{{$goal->category->name}}" data-category_id="{{$goal->id}}" data-toggle="modal" data-target="#deleteGoal">
							<span data-toggle="tooltip" data-placement="top" title="Excluir" class="glyphicon glyphicon-trash"></span>
						</span>
				</td>
			</tr>
			@empty
			<tr>
				<td colspan="4">Nenhuma meta cadastrada.</td>
			</tr>
			@endforelse
			</tbody>
		</table>

	</div>
@endsection