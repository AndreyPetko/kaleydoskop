@extends('site.layout')


@section('content')
@include('elements.breadcrumbs')

<div class="clear"></div>



<div class="category-content">

	<div class="category-katalog-content">
		<div class="category-title">
			<h1>Бренды</h1>
		</div>
		<div class="category-title-line">
		</div>
		@foreach($brends as $brend)
		<a href="/brend-products/{{$brend->url}}">
			<div class="brend-item fl">
				<div class="brend-image">
					<img src="{{ url('brends_images/' . $brend->logo)}}">
				</div>
				<div class="brend-name">
					{{$brend->name}}
				</div>
			</a>
			<div class="brend-descr">
				<p>{!!$brend->preview!!}</p>
			</div>
	<div class="brend-href">
		<a href="/brend/{{$brend->url}}">
	О бренде
		</a>
		</div>
			<div class="item-buy" >
		<a href="/brend-products/{{$brend->url}}">
			<div class="item-buy-text2"> Выбрать товар</div>
		</a>
		</div>
		</div>

		@endforeach

		<div class="clear"></div>
	</div>


</div>


@stop


@section('mobile')
@include('elements.breadcrumbs')
<div class="category-content">
	<div class="category-katalog-content">
		<div class="category-title">
			<h1>Бренды</h1>
		</div>
		<div class="category-title-line">
		</div>
		@foreach($brends as $brend)
		<a href="/brend/{{$brend->url}}">
			<div class="brend-item-mobile fl">
				<div class="brend-image-mobile">
					<img src="{{ url('brends_images/' . $brend->logo)}}">
				</div>
				<div class="brend-name-mobile">
					{{$brend->name}}
				</div>
				<div class="brend-descr-mobile">
					<p>{!!$brend->preview!!}</p>
				</div>
			</div>
		</a>
		@endforeach
	</div>
</div>
@stop