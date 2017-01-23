@extends('layouts.app')

@section('content')

	<form method="post" action="{{$route}}">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="account">{{trans_choice('account.labels.account', 1)}}</label>
					<input type="text" class="form-control" id="account" name="account" placeholder="{{trans_choice('account.labels.account', 1)}}" value="{{$account->name}}">
					<input type="hidden" name="id" value="{{$account->id}}">
					{{ csrf_field() }}
					{{ method_field($method) }}
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="type">{{trans('account.labels.type')}}</label>
					<select name="type" class="form-control">
						<option value="invalid_option">{{trans('app.labels.select')}}</option>
						@foreach($accountTypes as $accountTypeId => $accountType)
							<option {{($accountTypeId == $account->accountType->id)?'selected':''}} value="{{$accountTypeId}}">{{trans('account.'.$accountType)}}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class=" form-group">
					<button type="submit" name="save" value="save" class="btn btn-success">{{trans('app.labels.save')}}</button>
					<a href="{{route('account.index')}}" class="btn btn-danger">{{trans('app.labels.cancel')}}</a>
				</div>
			</div>
		</div>
	</form>

@endsection