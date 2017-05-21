@extends('site.layout')

@section('header')

@stop


@section('content')
@include('elements.breadcrumbs')
<div class="clear"></div>

<div id="subcategory-katalog">
    <div class="clear"></div>

    <div class="subcategories-list">

    </div>
    <div class="clear"></div>
    <div id="close-subcategory">Свернуть <img src="{{ url('site/images/icon-arrow.png') }}"></div>

</div>

<div class="category-content">
    <div class="category-katalog-content">
        <div class="category-title">
            <h1>Категории</h1>
        </div>
        <div class="category-title-line">
        </div>


        @foreach($catalog as $catalogItem)
        <input type="hidden" id="category-{{$catalogItem->id}}" value="{{$catalogItem->url}}">
        <div class="category-pre">
            <a href="/category/{{$catalogItem->url}}">
                @if($catalogItem->image)
                <img src="{{ url('/category_images/' . $catalogItem->image) }}">
                @else
                <img src="{{ url('site/images/IMG_9745-450x300.png') }}" alt="">
                @endif
                <a href="/category/{{$catalogItem->url}}"><div class="category-pre-title">{{$catalogItem->name}}</div></a>
                <div class="category-pre-info">
                    <p>Товаров:{{$catalogItem->countProducts}}<br> От 0 до 
                        @if($catalogItem->maxPrice)
                        {{$catalogItem->maxPrice}}
                        @else
                        0
                        @endif
                        грн
                    </p>
                    <div class="category-button" data-categoryid="{{$catalogItem->id}}">
                        Подкатегории
                    </div>
                </div>

            </a>
        </div>
        @endforeach


        <div class="clear"></div>

    </div>

</div>

@stop

@section('mobile')
@include('elements.breadcrumbs')


<div id="subcategory-katalog-mobile">
    <div class="clear"></div>
    <div class="subcategories-list-mobile">
    </div>
    <div class="clear"></div>
    <div id="close-subcategory-mobile">Свернуть <img src="{{ url('site/images/icon-arrow.png') }}"></div>
</div>

<div class="category-title">
    <h1>Категории</h1>
</div>
<div class="category-title-line">
</div>

@foreach($catalog as $catalogItem)
<input type="hidden" id="category-{{$catalogItem->id}}" value="{{$catalogItem->url}}">
<div class="category-pre-mobile">
    <a href="/category/{{$catalogItem->url}}">
        @if($catalogItem->image)
        <img src="{{ url('/category_images/' . $catalogItem->image) }}">
        @else
        <img src="{{ url('site/images/IMG_9745-450x300.png') }}" alt="">
        @endif
        <a href="/category/{{$catalogItem->url}}"><div class="category-pre-title-mobile">{{$catalogItem->name}}</div></a>
        <div class="category-pre-info">
            <p>Товаров:{{$catalogItem->countProducts}}<br> От 0 до 
                @if($catalogItem->maxPrice)
                {{$catalogItem->maxPrice}}
                @else
                0
                @endif
                грн
            </p>
            <div class="category-button-mobile" data-categoryid="{{$catalogItem->id}}">Подкатегории</div>
        </div>

    </a>
    <div class="clear"></div>
</div>
@endforeach
<div class="clear"></div>
@stop