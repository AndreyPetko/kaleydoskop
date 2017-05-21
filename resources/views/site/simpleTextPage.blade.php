@extends('site.layout')


@section('header')
	<title>Наборы для вышивания в Киеве — Калейдоскоп Вышивки.</title>
	<meta description="Наборы для вышивания и рукоделия, вышивки, бисер, мулине, пяльца в интернет-магазине. Купить Риолис, Золотое Руно, DIMENSIONS, Anchor, Русский Фаворит, Чудесная Игла. Киев.">
@stop

@section('content')
@include('elements.breadcrumbs')

<div class="category-content">
	<div class="category-title">
		{{$title}}
	</div>
	<div class="category-title-line"></div>

	<div class="oplata-dostavka-content">
		{!! $textVar !!}
	</div>
</div>
@stop
@section('mobile')
@include('elements.breadcrumbs')

<div class="category-content">
	<div class="category-title">
		{{$title}}
	</div>
	<div class="category-title-line"></div>

	<div class="oplata-dostavka-content">
		{!! $textVar !!}
	</div>
</div>
@stop