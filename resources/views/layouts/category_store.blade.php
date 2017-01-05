@extends('layouts.app')

@section('content')
	<div class="container">
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
					<button type="submit" name="save" class="btn btn-success">Salvar</button>
					<button type="submit" name="cancel" class="btn btn-danger">Cancelar</button>
				</div>
			</form>
		</div>
	</div>
@endsection