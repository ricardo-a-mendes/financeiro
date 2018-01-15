@extends('layouts.app')

@section('content')

	<div class="row">
		<div class="page-header">
			<h3>{{trans('account.labels.my_account')}}</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<form class="form">
				<div class="form-group">
					<label>{{trans('account.labels.name')}}</label>
					<input type="text" class="form-control" name="name" value="{{\Illuminate\Support\Facades\Auth::user()->name}}">
				</div>
				<div class="form-group">
					<label>{{trans('account.labels.email')}}</label>
					<input type="text" class="form-control" name="email" disabled value="{{\Illuminate\Support\Facades\Auth::user()->email}}">
				</div>
				<div class="form-group">
					<button class="btn btn-success" type="submit">{{trans('app.labels.save')}}</button>
					<button class="btn btn-primary" type="button">{{trans('account.labels.change_pass')}}</button>
				</div>
			</form>
		</div>
		<div class="col-md-6">
			<h4>{{trans_choice('app.labels.user', 2)}} <small><a href="{{route('provision.create')}}" data-toggle="tooltip" data-placement="top" title="{{trans('account.labels.new')}}" class="deco-none glyphicon glyphicon-plus cursor-pointer"></a></small></h4>
			<table class="table">
				<thead>
				<tr>
					<th>{{trans('account.labels.name')}}</th>
					<th>{{trans('account.labels.email')}}</th>
					<th>{{trans('app.labels.actions')}}</th>
				</tr>
				</thead>
				<tbody>
					@forelse($accountUsers as $accountUser)
						<tr>
							<td>{{$accountUser->name}}</td>
							<td>{{$accountUser->email}}</td>
							<td>
								<span class="cursor-pointer" data-user="{{$accountUser->name}}" data-category_id="{{$accountUser->id}}" data-toggle="modal" data-target="#deleteProvision">
									<span data-toggle="tooltip" data-placement="top" title="{{trans('app.labels.delete')}}" class="glyphicon glyphicon-trash"></span>
								</span>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="3">{{trans_choice('account.labels.user_not_found', 2)}}</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>

@endsection