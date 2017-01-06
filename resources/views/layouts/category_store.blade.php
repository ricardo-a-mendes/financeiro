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

	<div class="row">
		<form method="post" action="{{$route}}">
			<div class="form-group">
				<label for="exampleInputEmail1">Categoria</label>
				<input type="text" class="form-control" id="category" name="category" placeholder="Categoria" value="{{$category->description}}">
				<input type="hidden" name="id" value="{{$category->id}}">
				{{ csrf_field() }}
				{{ method_field($method) }}
			</div>
			<div class=" form-group">
				<button type="submit" name="save" value="save" class="btn btn-success">Salvar</button>
				<a href="{{route('category.index')}}" class="btn btn-danger">Cancelar</a>
			</div>
		</form>
	</div>

@endsection