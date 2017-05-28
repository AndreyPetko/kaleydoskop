@extends('admin.layouts.admin')




@section('content')


<section class="content-header">
	<h1>
		Обновить слайд
	</h1>
</section>


<!-- Main content -->
<section class="content">
	<div class="row">

		<div class="col-md-12">

			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Форма обновления слайда</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<form method="POST" action="" enctype="multipart/form-data" >

						<input type="hidden" name="_token" value="{{ csrf_token() }}">



						<div class="form-group">
							<label>Позиция слайда</label>
							<input type="number" class="form-control" value="@if(isset($slide->position)){{$slide->position}}@endif" name="position">
						</div>

						<div class="form-group">
							<label>Url</label>
							<input type="text" class="form-control"  value="{{$slide->url}}" name="url">
						</div>


						<div class="form-group">
							<label>Текст слайда</label>
							<textarea class="form-control" rows="3" placeholder="Введите описание товара ..." name="text">
								@if(isset($slide->text)){{$slide->text}}@endif
							</textarea>
						</div>


						@if(isset($slide->image))
						<div class="form-group">
							<div class="slide-edit-image">
								<img src="{{ url('slides_images/' . $slide->image)}}">
							</div>
						</div>
						@endif

						<div class="form-group">
							<div class="row">
								<div class="col-md-12" >
									<label>Изображения слайда</label>
									<input type="file"   name="image">
								</div>
							</div>
						</div>




						<div class="form-group add-button-page">
							<input type="submit" class="btn btn-block btn-primary btn-lg" value="Обновить">
						</div>


					</form>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<!--/.col (right) -->
	</div>
	<!-- /.row -->
</section>

@stop