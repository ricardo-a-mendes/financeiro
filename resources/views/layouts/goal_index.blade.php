@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="page-header">
			<h3>{{trans_choice('provision.labels.provision', 2)}} <small><a href="{{route('goal.create')}}" data-toggle="tooltip" data-placement="top" title="{{trans('provision.labels.new')}}" class="deco-none glyphicon glyphicon-plus cursor-pointer"></a></small></h3>
		</div>

		<table class="table table-striped">
			<thead>
			<tr>
				<th>ID</th>
				<th>{{trans_choice('category.labels.category', 1)}}</th>
				<th>{{trans_choice('provision.labels.provision', 1)}}</th>
				<th>{{trans('app.labels.specific')}}</th>
				<th>{{trans('app.labels.type')}}</th>
				<th>{{trans('app.labels.actions')}}</th>
			</tr>
			</thead>
			<tbody>
			@forelse($goals as $goal)
			<tr>
				<td>{{$goal->id}}</td>
				<td><a data-toggle="tooltip" title="{{trans('category.labels.edit')}}" href="{{route('category.edit', ['id' => $goal->category->id])}}">{{$goal->category->name}}</a></td>
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
					<a href="{{route('goal.edit', ['id' => $goal->id])}}" data-toggle="tooltip" data-placement="top" title="{{trans('app.labels.edit')}}" class="deco-none glyphicon glyphicon-pencil"></a>
					&nbsp;|&nbsp;
					<span class="cursor-pointer" data-category="{{$goal->category->name}}" data-category_id="{{$goal->id}}" data-toggle="modal" data-target="#deleteGoal">
						<span data-toggle="tooltip" data-placement="top" title="{{trans('app.labels.delete')}}" class="glyphicon glyphicon-trash"></span>
					</span>
				</td>
			</tr>
			@empty
			<tr>
				<td colspan="4">{{trans('app.messages.no_items_found')}}</td>
			</tr>
			@endforelse
			</tbody>
		</table>

	</div>
@endsection