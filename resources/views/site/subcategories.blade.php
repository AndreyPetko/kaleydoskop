@extends('site.layout')


@section('header')
    <title>{{ $category->name }}</title>
    <meta name="description" content="{{ strip_tags($category->description) }}">
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