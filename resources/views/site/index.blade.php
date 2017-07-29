@extends('site.layout')

@section('header')
    <title>Наборы для вышивания в Киеве — Калейдоскоп Вышивки.</title>
    <meta description="Наборы для вышивания и рукоделия, вышивки, бисер, мулине, пяльца в интернет-магазине. Купить Риолис, Золотое Руно, DIMENSIONS, Anchor, Русский Фаворит, Чудесная Игла. Киев.">
@stop

@section('headContent')
    @if(Session::get('orderSuccess'))
        <div class="sucess-order-alert" id="sucess-order-form">
            <div class="fast-order-title">
                <div class="fast-order-title fl">Ваш заказ успешно принят</div>
                <div class="intake-close fr success-close"><img src="{{ url('site/images/close-photo.png') }}" alt="">
                </div>
            </div>
            <div class="sad" style="padding-left: 100px;">:)</div>
            <div class="fast-order-text">
                Спасибо за заказ. Мы свяжемся с Вами в ближайшее время.
            </div>
            <div class="cart-buttons">
                @if(Auth::check())
                    <a href="/dashboard">
                        <div class="cart-add-button">
                            <div class="to-cart cart-buy">
                                <div class="item-buy-image">
                                    <img src="{{ url('site/images/icon-account-wh.png') }}" alt="">
                                </div>
                                <div class="item-buy-text cart-text">
                                    Личный кабинет
                                </div>
                                <div class="item-buy-shadow cart-shadow"></div>
                            </div>
                        </div>
                    </a>
                @endif
                <div class="close-issue fr success-close">
                    <div class="to-cart cart-buy cart-close">
                        <div class="item-buy-text cart-close-text">
                            Продолжить покупки
                        </div>
                    </div>
                </div>
            </div>
            <div class="fast-order-form-row"></div>
        </div>

    @endif
@stop



@section('content')

    {{--@if(!Auth::check() || Auth::user()->role == 'retail')--}}
        <!-- <div class="slider-block"> -->
        <div class="owl-carousel">
            @foreach($mainSlides as $slide)
            {{dump($slide)}}
                <div class="slider-image ">
                    <!--   slider-image -->
                    <a href="{{ $slide->slideUrl }}">
                        <img src="{{ url('slides_images/' . $slide->image) }}" alt="">
                    </a>
                </div>
            @endforeach
        </div>


    {{--@endif--}}

    <div class="main-title">
        Каталог
    </div>
    <div class="main-title-line"></div>
    <div id="subcategory-katalog">
        <div class="clear"></div>

        <div class="subcategories-list">

        </div>
        <div class="clear"></div>
        <div id="close-subcategory">Свернуть <img src="{{ url('site/images/icon-arrow.png') }}"></div>

    </div>

    @foreach($catalog as $catalogItem)
        <input type="hidden" id="category-{{$catalogItem->id}}" value="{{$catalogItem->url}}">
        <div class="category-pre category-pre-index">
            <a href="/category/{{$catalogItem->url}}">
                @if($catalogItem->image)
                    <img src="{{ url('/category_images/' . $catalogItem->image) }}">
                @else
                    <img src="{{ url('site/images/IMG_9745-450x300.png') }}" alt="">
                @endif
                <a href="/category/{{$catalogItem->url}}">
                    <div class="category-pre-title">{{$catalogItem->name}}</div>
                </a>
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



    <div class="main-title">
        Рекомендуем
    </div>
    <div class="main-title-line"></div>


    @if(isset($recProducts))

        <div class="main-items-list">
            @foreach($recProducts as $recProduct)
                <div class="main-item">

                    @if($recProduct->new)
                        <div class="new-item">
                            <img src="{{ url('/site/images/new_item.png') }}">
                        </div>
                    @endif


                    <div class="magnifier" data-productid="{{$recProduct->id}}">
                        <img src="{{ url('site/images/icon-loop.png') }}" alt="">
                    </div>
                    <div class="item-image">
                        @if($recProduct->image)
                            <a href="/product/{{$recProduct->url}}">
                                <img src="{{ url('product_images/' . $recProduct->image) }}">
                            </a>
                        @else
                            <a href="/product/{{$recProduct->url}}">
                                <img src="{{ url('site/images/zaglushka.png') }}" alt="">
                            </a>
                        @endif
                    </div>
                    <a href="/product/{{$recProduct->url}}">
                        <div class="item-name">
                            @if($recProduct->quantity > 2)
                                <div class="availability"><img src="/site/images/add-cart-success.png" alt="">Есть в
                                    наличии
                                </div>
                            @else
                                @if($recProduct->quantity == 0)
                                    <div class="availability"><img src="/site/images/icon-disavailability.png" alt="">Нет
                                        в наличии
                                    </div>
                                @else
                                    <div class="availability"><img src="/site/images/icon-availability-attantion.png"
                                                                   alt="">Заканчивается
                                    </div>
                                @endif
                            @endif
                            {{$recProduct->name}}
                        </div>
                    </a>
                    <div class="item-bottom-line">
                        <div class="item-price">
                            {{$recProduct->price}} грн
                        </div>
                        <div class="item-buy" data-productid="{{$recProduct->id}}">
                            <div class="item-buy-image">
                                <img src="{{ url('site/images/icon-cart-main.png') }}" alt="">
                            </div>
                            <div class="item-buy-text">
                                В корзину
                            </div>
                            <div class="item-buy-shadow"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="show-more">
            <div class="show-more-content">
                <div class="show-less-text">
                    Свернуть
                </div>
                <div class="show-more-text" id="show-rec">
                    Показать больше
                </div>
                <div class="show-more-image">
                    <img src="{{ url('site/images/icon-arrow.png') }}" alt="">
                </div>
            </div>
        </div>


    @endif


    <div class="main-title">
        Новинки
    </div>
    <div class="main-title-line"></div>


    <div class="main-items-list">

        @foreach($newProducts as $newProduct)
            <div class="main-item">
                @if($newProduct->new)
                    <div class="new-item">
                        <img src="{{ url('/site/images/new_item.png') }}">
                    </div>
                @endif

                <div class="magnifier" data-productid="{{$newProduct->id}}">
                    <img src="{{ url('site/images/icon-loop.png') }}" alt="">
                </div>
                <div class="item-image">
                    @if($newProduct->image)
                        <a href="/product/{{$newProduct->url}}">
                            @if($newProduct->category_id == 39)
                                <img src="{{ url('site/images/IMG_9745-450x300.png') }}">
                            @else
                                <img src="{{ url('product_images/' . $newProduct->image) }}">
                            @endif
                        </a>
                    @else
                        <a href="/product/{{$newProduct->url}}">
                            <img src="{{ url('site/images/zaglushka.png') }}" alt="">
                        </a>
                    @endif
                </div>
                <a href="/product/{{$newProduct->url}}">
                    <div class="item-name">
                        @if($newProduct->quantity > 2)
                            <div class="availability"><img src="/site/images/add-cart-success.png" alt="">Есть в наличии
                            </div>
                        @else
                            @if($newProduct->quantity == 0)
                                <div class="availability"><img src="/site/images/icon-disavailability.png" alt="">Нет в
                                    наличии
                                </div>
                            @else
                                <div class="availability"><img src="/site/images/icon-availability-attantion.png"
                                                               alt="">Заканчивается
                                </div>
                            @endif
                        @endif
                        {{$newProduct->name}}
                    </div>
                </a>
                <div class="item-bottom-line">
                    <div class="item-price">
                        {{$newProduct->price}} грн
                    </div>
                    <div class="item-buy" data-productid="{{$newProduct->id}}">
                        <div class="item-buy-image">
                            <img src="{{ url('site/images/icon-cart-main.png') }}" alt="">
                        </div>
                        <div class="item-buy-text">
                            В корзину
                        </div>
                        <div class="item-buy-shadow"></div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    <div class="show-more">
        <div class="show-more-content">
            <div class="show-less-text">
                Свернуть
            </div>
            <div class="show-more-text">
                Показать больше
            </div>
            <div class="show-more-image">
                <img src="{{ url('site/images/icon-arrow.png') }}" alt="">
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <!-- <div class="our-brands">
  Наши бренды
</div>
<div class="left-brands-slider" id="slide-arow-sm-l">
  <img src="{{ url('site/images/arrow-sm2.png') }}" alt="">
</div>
<div class="right-brands-slider" id="slide-arow-sm-r">
  <img src="{{ url('site/images/arrow-sm.png') }}" alt="">
</div>
<div class="brands-slider">
  <div class="brands-images">
    @foreach($brends as $brend)
        <div class="brands-image">
          <a href="/brend-products/{{$brend->url}}">
        <img src="{{ url('brends_images/' . $brend->logo) }}" alt="">
      </a>
    </div>
    @endforeach
            </div>
          </div> -->
    <div class="index-txt">
        <h2>{{ $mainTitle }}</h2>
        <p>{!! $mainText !!}</p>
    </div>

@stop

@section('mobile')

    <div class="mobile-yellow-line"></div>
    <div id="subcategory-katalog">
        <div class="clear"></div>

        <div class="subcategories-list">

        </div>
        <div class="clear"></div>
        <div id="close-subcategory">Свернуть <img src="{{ url('site/images/icon-arrow.png') }}"></div>

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
                <a href="/category/{{$catalogItem->url}}">
                    <div class="category-pre-title-mobile">{{$catalogItem->name}}</div>
                </a>
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
    <div class="index-txt">
        <h2>{{ $mainTitle }}</h2>
        <p>{!! $mainText !!}</p>
    </div>
@stop

