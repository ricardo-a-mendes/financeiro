@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="page-header">
			<h3>{{trans_choice('account.labels.account', 2)}} <small><a href="{{route('account.create')}}" data-toggle="tooltip" data-placement="top" title="{{trans('account.labels.new')}}" class="deco-none glyphicon glyphicon-plus cursor-pointer"></a></small></h3>
		</div>

		<table class="table table-striped">
			<thead>
			<tr>
				<th>ID</th>
				<th>{{trans_choice('account.labels.account', 1)}}</th>
				<th>{{trans('app.labels.type')}}</th>
				<th>{{trans('app.labels.actions')}}</th>
			</tr>
			</thead>
			<tbody>
			@forelse($accounts as $account)
			<tr>
				<td>{{$account->id}}</td>
				<td>{{$account->name}}</td>
				<td>
					<!-- TODO: Replace HardCoded 'cartao_credito' -->
					@if($account->accountType->unique_name == 'cartao_credito')
						<span class="glyphicon glyphicon-credit-card"></span>
					@elseif($account->accountType->unique_name == 'conta_poupanca')
						<span class="glyphicon glyphicon-piggy-bank"></span>
					@else
						<span class="glyphicon glyphicon-usd"></span>
					@endif
					{{$account->accountType->name}}
				</td>
				<td>
					<a href="{{route('account.edit', ['id' => $account->id])}}" data-toggle="tooltip" data-placement="top" title="{{trans('app.labels.edit')}}" class="deco-none glyphicon glyphicon-pencil"></a>
					&nbsp;|&nbsp;
					<span class="cursor-pointer" data-category="{{$account->name}}" data-category_id="{{$account->id}}" data-toggle="modal" data-target="#deleteCategory">
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