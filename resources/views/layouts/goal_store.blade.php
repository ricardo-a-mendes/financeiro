@extends('layouts.app')

@section('content')
	<div class="row">
		<form method="post" action="{{$route}}">
			<div class="form-group">
				<label for="exampleInputEmail1">Meta</label>
				<input type="text" class="form-control" id="meta" name="value" placeholder="Meta" value="{{$goal->value}}">
				<input type="hidden" name="id" value="{{$goal->id}}">
				{{ csrf_field() }}
				{{ method_field($method) }}
			</div>
			<div class=" form-group">
				<button type="submit" name="save" value="save" class="btn btn-success">Salvar</button>
				<a href="{{route('goal.index')}}" class="btn btn-danger">Cancelar</a>
			</div>
		</form>
	</div>

@endsection