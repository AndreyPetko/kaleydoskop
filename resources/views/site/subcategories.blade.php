@extends('site.layout')


@section('header')
    <title>{{ $category->name }} купить в интернет-магазине Калейдоскоп Вышивки</title>
    <meta name="description" content="Купить {{ $category->name }} в интернет-магазине Калейдоскоп Вышивки c доставкой
     по Киеву и Украине. Низкие цены, большой ассортимент. Риолис, Золотое Руно, DIMENSIONS, Anchor,
     Русский Фаворит, Чудесная Игла.">
@stop

@section('content')
        <div class="category-title mt10">
            {{$category->name}}
        </div>
        <div class="category-title-line">
        </div>

        <div class="category-description">
            {!! $category->description !!}
        </div>
        <ul class="subcat-total-list">
            @foreach($subcategories as $subcategory)
                <li><a href="/subcategory/{{$subcategory->url}}">{{ $subcategory->name }}</a></li>
            @endforeach
        </ul>
@stop
@section('mobile')
 <div class="category-title mt10">
            {{$category->name}}
        </div>
        <div class="category-title-line">
        </div>

        <div class="category-description">
            {!! $category->description !!}
        </div>
        <ul class="subcat-total-list">
            @foreach($subcategories as $subcategory)
                <li><a href="/subcategory/{{$subcategory->url}}">{{ $subcategory->name }}</a></li>
            @endforeach
        </ul>
@stop