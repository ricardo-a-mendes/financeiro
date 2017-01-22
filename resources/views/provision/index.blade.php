@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="page-header">
			<h3>{{trans_choice('provision.labels.provision', 2)}} <small><a href="{{route('provision.create')}}" data-toggle="tooltip" data-placement="top" title="{{trans('provision.labels.new')}}" class="deco-none glyphicon glyphicon-plus cursor-pointer"></a></small></h3>
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
			@forelse($provisions as $provision)
			<tr>
				<td>{{$provision->id}}</td>
				<td><a data-toggle="tooltip" title="{{trans('category.labels.edit')}}" href="{{route('category.edit', ['id' => $provision->category->id])}}">{{$provision->category->name}}</a></td>
				<td>{{Number::formatCurrency($provision->value)}}</td>
				<td>
					@if($provision->provisionDate->count() > 0)
						<span class="glyphicon glyphicon-calendar cursor-pointer" data-toggle="tooltip" data-placement="right" title="Visualizar"></span>
					@else
						&nbsp;
					@endif
				</td>
				<td class="{{($provision->transactionType->unique_name === 'credit')?'text-green':'text-red'}}">{{$provision->transactionType->name}}</td>
				<td>
					<a href="{{route('provision.edit', ['id' => $provision->id])}}" data-toggle="tooltip" data-placement="top" title="{{trans('app.labels.edit')}}" class="deco-none glyphicon glyphicon-pencil"></a>
					&nbsp;|&nbsp;
					<span class="cursor-pointer" data-category="{{$provision->category->name}}" data-category_id="{{$provision->id}}" data-toggle="modal" data-target="#deleteProvision">
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