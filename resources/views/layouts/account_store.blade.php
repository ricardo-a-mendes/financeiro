@extends('layouts.app')

@section('content')
	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<form method="post" action="{{$route}}">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="account">Conta</label>
					<input type="text" class="form-control" id="account" name="account" placeholder="Conta"
						   value="{{$account->name}}">
					<input type="hidden" name="id" value="{{$account->id}}">
					{{ csrf_field() }}
					{{ method_field($method) }}
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="type">Tipo da Conta</label>
					<select name="type" class="form-control">
						<option value="invalid_option">Selecione</option>
						@foreach($accountTypes as $accountTypeId => $accountType)
							<option {{($accountTypeId == $account->accountType->id)?'selected':''}} value="{{$accountTypeId}}">{{$accountType}}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class=" form-group">
					<button type="submit" name="save" value="save" class="btn btn-success">Salvar</button>
					<a href="{{route('account.index')}}" class="btn btn-danger">Cancelar</a>
				</div>
			</div>
		</div>
	</form>

@endsection