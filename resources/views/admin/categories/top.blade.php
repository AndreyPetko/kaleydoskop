@extends('admin.layouts.admin')


@section('js')
	<script src="{{ url('dist/js/select2.min.js') }}"></script>
	<script>
			$('select').select2();
	</script>
@stop


@section('content')



<section class="content-header">
	<h1>
		Добавить топ товар категории
	</h1>
</section>


<!-- Main content -->
<section class="content">
	<div class="row">

		<div class="col-md-12">

			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Форма добавления топ товара категории</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">

					<div class="row">
						<form action="/admin/category-top-add/{{$categoryId}}" method="POST">
							{{csrf_field()}}
							<div class="col-md-8">
								<select name="product_id">
									@foreach($products as $product)
										<option value="{{$product->id}}" >{{$product->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-2">
								<button class="btn btn-block btn-primary btn-flat add-product-button">Добавить</button>
							</div>
						</form>
					</div>
					<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<tbody>
						<tr>
							<th>Имя</th>
							<th>Удалить</th>
						</tr>
						@foreach($topList as $topListItem)
							<tr>
								<td>{{ $topListItem->name }}</td>
								<td><a href="">Удалить</a></td>
							</tr>
						@endforeach
					</tbody>
					</table>
			</div>
				</div>
			</div>

		</div>
	</div>
</section>


@stop