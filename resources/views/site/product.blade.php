@extends('site.layout')

@section('header')
    <title>{{ $product->name }}</title>
    @if($product->description)
        <meta name="description" content="{{ strip_tags($product->description) }}">
    @endif
@stop

@section('headContent')
<div class="fast-order">
    <div class="fast-order-title">
        <div class="fast-order-title fl">Быстрый заказ</div>
        <div class="fast-order-close fl"><img src="{{ url('/site/images/close-photo.png') }}" alt=""></div>
    </div>
    <div class="clear"></div>
    <div class="fast-order-text">
        Пожайлуста, введите свои данные и мы скоро с вами свяжемся.
    </div>
    <form method="POST" action="/orders/add" id="fast-order-form">
        <input type="hidden" name="_token" value="{{ csrf_token()}}">
        <input type="hidden" name="type" value="1">
        <input type="hidden" name="product_id" value="{{$product->id}}">
        <div class="fast-order-form-row">
            <div class="fast-order-label fl">Имя:</div>
            <div class="fast-order-input fl"><input type="text" name="name" @if(Auth::check()) value="{{Auth::user()->name}}" @endif></div>
        </div>
        <div class="fast-order-form-row">
            <div class="fast-order-label fl">Телефон:</div>
            <div class="fast-order-input fl"><input type="text" name="phone" class="phone" @if(Auth::check()) value="{{Auth::user()->phone}}" @endif></div>
        </div>
        <div class="fast-order-form-row">
            <div class="fast-order-label fl">Ваш заказ:</div>
            <div class="fast-order-product fl">{{$product->name}}</div>
        </div>
        <div class="fast-order-form-row">
            <div class="fast-order-left fl">
                <div class="fast-order-label small-label fl">
                    Кол-во:
                </div>
                <div class="fast-order-small-input fl"><input name="count" type="text" value="1"  data-price="{{$product->price}}"></div>
                <div class="fast-order-count fl">
                    шт
                </div>
            </div>
            <div class="fast-order-right fr">
                <div class="fast-order-label small-label right-label fl">
                    Цена: {{$product->price}} грн
                </div>
            </div>
        </div>
        <div class="fast-order-form-row">
           <div class="fast-order-submit fr">
            <input type="submit" value="Подтвердить">
        </div>
    </div>
</form>
<div class="fast-order-form-row">
</div>
</div>

<div class="announce-the-immediate">
    <div class="fast-order-title">
        <div class="fast-order-title fl">Сообщить о поступлении</div>
        <div class="intake-close fr" id="announce-close"><img src="{{ url('site/images/close-photo.png') }}" alt=""></div>
    </div>
    <div class="fast-order-text">
        Пожайлуста, введите свои данные и мы сообщим вам о поступлении товара
    </div>
    <div class="fast-order-form-row">
        <div class="fast-order-label fl">Товар:</div>
        <div class="fast-order-product fl">{{$product->name}}</div>
    </div>
    <form method="POST" action="/add-intake-message">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="product_id" value="{{$product->id}}">
        <div class="fast-order-form-row">
            <div class="fast-order-label fl">Имя:</div>
            <div class="fast-order-input fl"><input type="text" name="name" @if(Auth::check()) value="{{Auth::user()->name}}" @endif></div>
        </div>
        <div class="fast-order-form-row">
            <div class="fast-order-label fl">Email:</div>
            <div class="fast-order-input fl"><input type="text" name="email" @if(Auth::check()) value="{{Auth::user()->email}}" @endif></div>
        </div>
        <div class="fast-order-form-row">
           <div class="fast-order-submit fr">
            <input type="submit" value="Подтвердить">
        </div>
    </div>
</form>
<div class="fast-order-form-row"></div>
</div>
@stop



@section('content')
@include('elements.breadcrumbs')



@if($product->final_active)




<div class="product-content">

    <div class="product-block fl">

        <div class="product-block-top">
            @if($product->new)
            <div class="new-item">
                <img src="{{ url('/site/images/new_item.png') }}">
            </div>
            @endif
            <div class="product-slider fl">
                <div class="product-slider-current-image" data-productid="{{$product->id}}">
                    @if(isset($images[0]))
                    <img src="/product_images/{{$images[0]->url}}">
                    @else
                    <img src="{{ url('site/images/zaglushka.png') }}" alt="">
                    @endif
                </div>
                @if(count($images) != 1)
                <div class="product-slider-list">
                    @foreach($images as $image)
                    <div class="product-slider-list-item fl">
                        <img src="/product_images/{{$image->url}}">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="product-info fl">
                <div class="product-title @if(!$category) product-title-full @endif">
                    <h1>{{$product->name}}</h1>
                </div>
                <div class="product-title-line"></div>

                <div class="product-main-attrs-list">
                    <div class="product-main-attr">
                       <p> Производитель: @if($product->brendName) {{$product->brendName}} @else Производитель не указан @endif</p>
                    </div>
                    <div class="product-main-attr">
                        <p>Артикул: {{$product->article}}</p>
                    </div>
                </div>

                <div class="product-avail-intake">

                    <div class="product-avail fl">
                        @if($product->quantity > 2)
                        <div class="product-avail-image fl">
                            <img src="{{ url('site/images/add-cart-success.png') }}" alt="">
                        </div>
                        <div class="product-avail-text fl">
                            Есть в наличии
                        </div>
                        @else

                        @if($product->quantity == 0)
                        <div class="product-avail-image fl">
                            <img src="{{ url('site/images/icon-disavailability.png') }}" alt="">
                        </div>
                        <div class="product-avail-text fl">
                            Нет в наличии
                        </div>
                        @else
                        <div class="product-avail-image fl">
                            <img src="{{ url('site/images/icon-availability-attantion.png') }}" alt="">
                        </div>
                        <div class="product-avail-text fl">
                            Заканчивается
                        </div>

                        @endif
                        @endif
                    </div>


                    @if($product->quantity == 0)
                    <div class="product-intake fl">
                        <div class="product-intake-image  fl" >
                         <img src="{{ url('site/images/icon-mail-pr.png') }}" alt=""> 
                     </div>
                     <div class="product-intake-text fl">
                        Сообщить о поступлении
                    </div>
                </div>
                @endif
            </div>



            <div class="product-price">
                <div class="price-text fl">
                    Цена:
                </div>
                <div class="price-value fl">
                    {{$product->price}} грн
                </div>
            </div>


            @if($product->quantity != 0)
            <div class="product-count">
                <div class="product-count-text fl">
                    Кол-во:
                </div>
                <div class="product-count-input fl">
                    <input type="text" value="1" id="product_count">
                </div>
                <div class="product-count-text-2 fl">
                    шт
                </div>
            </div>


            <div class="clear"></div>

            <div class="product-buttons">
                <div class="product-add-to-cart fl" data-productid="{{$product->id}}">
                    <div class="product-add-content">
                        <div class="product-add-image fl">
                            <img src="{{ url('site/images/icon-cart.png') }}" alt="">
                        </div>
                        <div class="product-add-text fl">
                            В корзину
                        </div>
                    </div>
                    <div class="product-add-line"></div>
                </div>

                <div class="product-fast-order fl">
                    <div class="product-fast-order-content">
                        <div class="product-order-image fl">
                            <img src="{{ url('site/images/icon-fast-order.png') }}" alt="">
                        </div>
                        <div class="product-order-text fl">
                            Быстрый заказ
                        </div>
                    </div>
                    <div class="product-order-line"></div>
                </div>
            </div>
            @endif
            <div class="clear"></div>
            <div class="products-bottom-buttons">
                <div class="products-add-to-wishlist fl" data-productid="{{$product->id}}">
                    <div class="products-wishlist-img fl">
                        @if($product->wish)
                        <img src="{{ url('site/images/ixon-wishlist-active.png') }}" alt="">
                        @else
                        <img src="{{ url('site/images/ixon-wishlist.png') }}" alt="">
                        @endif
                    </div>
                    <div class="products-wishlidt-text fl">
                        @if($product->wish)
                        Убрать из желаний
                        @else
                        Добавить в желания
                        @endif
                    </div>
                </div>
                <div class="products-bottom-buttons-border fl"></div>
                <div class="products-comparison fl" data-productid="{{$product->id}}">
                    <div class="products-comparison-img fl">
                        @if($product->comp)
                        <img src="{{ url('site/images/icon-compare.png') }}" alt="">
                        @else
                        <img src="{{ url('/site/images/icon-compare-grey.png') }}">
                        @endif
                    </div>
                    <div class="products-comparison-text fl">
                        @if($product->comp)
                        Убрать из сравнений
                        @else
                        Добавить в сравнения
                        @endif
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="other-info">
        <div class="products-menu">
            <div class="products-menu-items products-menu-item-active fl" id="product-description">
                Описание
            </div>
            <div class="products-menu-items fl" id="product-rewiews">
                Отзывы({{$countReviews}})
            </div>
        </div>

        <div class="products-attributes-list @if(!$category) products-attributes-list-full @endif">
            <!-- @foreach($attributes as $attribute) -->
            <!-- @if(!empty($attribute->value)) -->
            <!-- <div class="products-attribute-item"> -->
            <!-- <strong>{{$attribute->name}}:</strong> {{$attribute->value}} -->
            <!-- </div> -->
            <!-- @endif -->
            <!-- @endforeach -->
            <div class="products-attribute-item">
                <!-- <strong>Описание:</strong> -->
                @if($product->description)
                {!! $product->description !!}
                @else
                Описание товара отсутствует
                @endif
            </div>
        </div>

        <div class="product-reviews">
            <div class="reviews-list">
                @if($reviews)
                @foreach($reviews as $review)

                <div class="review">
                    <div class="review-name @if($review->name == 'Admin') admin-review @endif">{{$review->name}}</div>
                    <div class="review-text @if($review->name == 'Admin') admin-review-text @endif ">
                        {!!$review->text!!}
                    </div>
                    <div class="review-date">{{$review->date}}</div>
                    <div class="review-border"></div>
                </div>
                @endforeach
                <div class="next-reviews">
                    @if($prev)
                    <a href="{{$prev}}">&lt;</a>
                    @endif
                    @if($next)
                    <a href="{{$next}}">&gt;</a>
                    @endif
                </div>

                @else
                <div class="no-comments">
                    Еще нет комментариев к этому товару
                </div>
                @endif
            </div>

            @if(!Auth::check() || Auth::user()->role == 'retail' || Auth::user()->role == 'admin' || Auth::user()->role == 'ander')
            <div class="reviews-form">
                <form action="/add-review" method="POST" id="add-review">
                    <input type="hidden" value="{{$product->id}}" name="product_id">
                    <input type="hidden" value="{{csrf_token()}}" name="_token">
                    <div class="reviews-form-title">Написать отзыв</div>
                    <div class="reviews-form-content">
                        <div class="reviews-form-line">
                            <div class="reviews-form-item">
                                <div class="reviews-form-text fl">Имя*:</div>
                                <div class="reviews-form-input fl"><input type="text" name="name"></div>
                            </div>
                        </div>
                        <div class="reviews-form-line">
                            <div class="reviews-form-item">
                                <div class="reviews-form-text fl">Email:</div>
                                <div class="reviews-form-input fl"><input type="text" name="email"></div>
                            </div>
                        </div>
                        <div class="reviews-form-line">
                            <div class="reviews-form-item">
                                <div class="reviews-form-text fl">Сообшение*:</div>
                                <div class="reviews-form-input reviews-form-textarea fl">
                                    <textarea name="text"></textarea>
                                </div>
                                <div class="reviews-form-submit"><button>Отправить</button></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>

</div>
@if($category)
<div class="products-right-sidebar fr">
    <div class="products-sidebar-header">
        {{$category->name}}:
    </div>
    <div class="products-sidebar-subcategory-list">
        @foreach($subcategories as $subcategory)
        <div class="products-sidebar-subcategory">
            <div class="products-sidebar-subcategory-image fl">
                <img src="{{ url('site/images/list-type.png') }}" alt="">
            </div>
            <div class="products-sidebar-subcategory-name fl">
                <a href="/category/{{$category->url}}?subcategory={{$subcategory->id}}">{{$subcategory->name}}</a>
            </div>
        </div>
        @endforeach

    </div>

    <div class="products-sidebar-grey-line"></div>
    <div class="products-sidebar-pay">
        <div class="products-sidebar-pay-img fl">
            <img src="{{ url('site/images/icon-pay.png') }}" alt="">
        </div>
        <div class="products-sidebar-pay-text fl">
            Оплата
        </div>
    </div>
    <div class="products-sidebar-grey-line"></div>

    <div class="products-pay-text">
        @if(Auth::check() && Auth::user()->role == 'wholesaler')
        {!!$text->getItem('oplataOpt')!!}
        @else
        {!!$text->getItem('oplata')!!}
        @endif
    </div>

    <div class="products-sidebar-grey-line"></div>
    <div class="products-sidebar-pay">
        <div class="products-sidebar-pay-img fl">
            <img src="{{ url('site/images/icon-dlivery.png') }}" alt="">
        </div>
        <div class="products-sidebar-pay-text fl">
            Доставка
        </div>
    </div>
    <div class="products-sidebar-grey-line"></div>

    <div class="products-pay-text">
        @if(Auth::check() && Auth::user()->role == 'wholesaler')
        {!!$text->getItem('dostavkaOpt')!!}
        @else
        {!!$text->getItem('dostavka')!!}
        @endif
    </div>

</div>
@endif
</div>








@if($withProducts)
<div class="main-title">
    С этим товаром также берут
</div>
<div class="main-title-line"></div>

<div class="main-items-list">
    @foreach($withProducts as $withProduct)
    <div class="main-item">
     <div class="magnifier" data-productid="{{$withProduct->id}}">
         <img src="{{ url('site/images/icon-loop.png') }}" alt="">
     </div>
     <div class="item-image">
         <a href="/product/{{$withProduct->url}}">
             @if($withProduct->category_id == 39) 
             <img src="{{ url('site/images/IMG_9745-450x300.png') }}">
             @else
             @if($withProduct->image == '')
             <img src="{{ url('site/images/zaglushka.png') }}">
             @else
             <img src="{{ url('product_images/' . $withProduct->image) }}" alt="">
             @endif
             @endif
         </a>
     </div>
     <a href="/product/{{$withProduct->url}}">
        <div class="item-name">
            @if($withProduct->quantity > 2)
            <div class="availability"><img src="/site/images/add-cart-success.png" alt="">Есть в наличии</div>
            @else
            @if($withProduct->quantity == 0)
            <div class="availability"><img src="/site/images/icon-disavailability.png" alt="">Нет в наличии</div>
            @else
            <div class="availability"><img src="/site/images/icon-availability-attantion.png" alt="">Заканчивается</div>
            @endif
            @endif
            {{$withProduct->name}}
        </div>
    </a>
    <div class="item-bottom-line">
        <div class="item-price">
            @if(Auth::check() && (Auth::user()->role == 'wholesaler' || Auth::user()->role == 'ander') && isset($withProduct->wholesale_price) )
            {{$withProduct->wholesale_price}} грн
            @else
            {{$withProduct->price}} грн
            @endif
        </div>
        <div class="item-buy" data-productid="{{$withProduct->id}}">
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
@endif

<!-- если не активен -->
@else

<div class="disabled-product">
    Этот товар недоступен
</div>

@endif

@if($watched)
<div class="main-title you-watch">
    Вы смотрели
</div>
<div class="main-title-line"></div>

<div class="main-items-list">
    @foreach($watched as $watchItem)
    @if($product->id != $watchItem->id)
    <div class="main-item">
     <div class="magnifier" data-productid='{{$watchItem->id}}'>
         <img src="{{ url('site/images/icon-loop.png') }}" alt="">
     </div>
     <div class="item-image">
         <a href="/product/{{$watchItem->url}}">
          @if($watchItem->category_id == 39) 
          <img src="{{ url('site/images/IMG_9745-450x300.png') }}">
          @else
          @if($watchItem->image == '')
          <img src="{{ url('site/images/zaglushka.png') }}">
          @else
          <img src="{{ url('product_images/' . $watchItem->image) }}" alt="">
          @endif
          @endif
      </a>
  </div>
  <a href="/product/{{$watchItem->url}}">
     <div class="item-name">
       @if($watchItem->quantity > 2)
       <div class="availability"><img src="/site/images/add-cart-success.png" alt="">Есть в наличии</div>
       @else
       @if($watchItem->quantity == 0)
       <div class="availability"><img src="/site/images/icon-disavailability.png" alt="">Нет в наличии</div>
       @else
       <div class="availability"><img src="/site/images/icon-availability-attantion.png" alt="">Заканчивается</div>
       @endif
       @endif
       {{$watchItem->name}}
   </div>
</a>
<div class="item-bottom-line">
    <div class="item-price">
        {{$watchItem->price}} грн
    </div>
    <div class="item-buy" data-productid="{{$watchItem->id}}">
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
@endif
@endforeach

</div>

@endif

@stop



@section('mobile')
@include('elements.breadcrumbs')


<div class="product-title-mobile">
    {{$product->name}}
</div>
<div class="product-title-line"></div>

<div class="product-slider-current-image-mobile" data-productid="{{$product->id}}">
    @if(isset($images[0]))
    <img src="/product_images/{{$images[0]->url}}">
    @else
    <img src="{{ url('site/images/zaglushka.png') }}" alt="">
    @endif
</div>
<div class="product-slider-list">

 @if(count($images) != 1)
 <div class="product-slider-list">
    @foreach($images as $image)
    <div class="product-slider-list-item fl">
        <img src="/product_images/{{$image->url}}">
    </div>
    @endforeach
</div>
@endif
</div>


<div class="product-main-attrs-list fl">
    <div class="product-main-attr">
        Производитель: {{$product->brendName}}
    </div>
    <div class="product-main-attr">
        Артикул: {{$product->article}}
    </div>
</div>

<div class="product-avail-intake-mobile">

    <div class="product-avail fr">
        <div class="product-avail-text fl">
            Нет в наличии
        </div>
    </div>
    <br>

    <div class="product-intake-mobile fr">

     <div class="product-intake-text fl">
        Сообщить о поступлении
    </div>
</div>
</div>


<div class="product-price">
    <div class="price-text fl">
        Цена:
    </div>
    <div class="price-value fl">
        {{$product->price}} грн
    </div>
</div>

<div class="product-count">
    <div class="product-count-text fl">
        Кол-во:
    </div>
    <div class="product-count-input fl">
        <input type="text" value="1" id="product_count">
    </div>
    <div class="product-count-text-2 fl">
        шт
    </div>
</div>
<div class="clear"></div>
<div class="product-buttons">
    <div class="product-add-to-cart fl" data-productid="{{$product->id}}">
        <div class="product-add-content">
            <div class="product-add-image fl">
                <img src="{{ url('site/images/icon-cart.png') }}" alt="">
            </div>
            <div class="product-add-text-mobile fl">
                В корзину
            </div>
        </div>

    </div>

    <div class="product-fast-order fl">
        <div class="product-fast-order-content">
            <div class="product-order-image fl">
                <img src="{{ url('site/images/icon-fast-order.png') }}" alt="">
            </div>
            <div class="product-order-text-mobile fl">
                Быстрый заказ
            </div>
        </div>

    </div>
</div>
<div class="clear"></div>
<div class="products-bottom-buttons">
    <div class="products-add-to-wishlist fl" data-productid="{{$product->id}}">
        <div class="products-wishlist-img fl">
            @if($product->wish)
            <img src="{{ url('site/images/ixon-wishlist-active.png') }}" alt="">
            @else
            <img src="{{ url('site/images/ixon-wishlist.png') }}" alt="">
            @endif
        </div>
        <div class="products-wishlidt-text-mobile fl">
            @if($product->wish)
            Убрать из желаний
            @else
            Добавить в желания
            @endif
        </div>
    </div>

        <!-- <div class="products-comparison fl" data-productid="{{$product->id}}">
            <div class="products-comparison-img fl">
                @if($product->comp)
                <img src="{{ url('site/images/icon-compare.png') }}" alt="">
                @else
                <img src="{{ url('/site/images/icon-compare-grey.png') }}">
                @endif
            </div>
            <div class="products-comparison-text-mobile fl">
                @if($product->comp)
                 Убрать из сравнений
                 @else
                 Добавить в сравнения
                 @endif
            </div>
        </div> -->
    </div>
    <div class="clear"></div>
    <div class="products-menu">
        <div class="products-menu-items products-menu-item-active fl" id="product-description-mobile">
            Описание
        </div>
        <div class="products-menu-items fl" id="product-rewiews-mobile">
            Отзывы({{$countReviews}})
        </div>
    </div>

    <div class="products-attributes-list">
        @foreach($attributes as $attribute)
        @if(!empty($attribute->value))
        <div class="products-attribute-item">
            <strong>{{$attribute->name}}:</strong> {{$attribute->value}}
        </div>
        @endif
        @endforeach
        <div class="products-attribute-item">
            <strong>Описание:</strong>
            {!! $product->description !!}
        </div>
    </div>
    <div class="product-reviews">
        <div class="reviews-list">
            @if($reviews)
            @foreach($reviews as $review)
            <div class="review">
                <div class="review-name">{{$review->name}}</div>
                <div class="review-text">
                    {{$review->text}}
                </div>
                <div class="review-date">{{$review->date}}</div>
                <div class="review-border"></div>
            </div>
            @endforeach
            <div class="next-reviews">
                @if($prev)
                <a href="{{$prev}}">&lt;</a>
                @endif
                @if($next)
                <a href="{{$next}}">&gt;</a>
                @endif
            </div>

            @else
            <div class="no-comments">
                Еще нет комментариев к этому товару
            </div>
            @endif
        </div>
        <div class="reviews-form">
            <form action="/add-review" method="POST" id="add-review">
                <input type="hidden" value="{{$product->id}}" name="product_id">
                <input type="hidden" value="{{csrf_token()}}" name="_token">
                <div class="reviews-form-title">Написать отзыв</div>
                <div class="reviews-form-content">
                    <div class="reviews-form-line">
                        <div class="reviews-form-item">
                            <div class="reviews-form-text fl">Имя*:</div>
                            <div class="reviews-form-input fl"><input type="text" name="name"></div>
                        </div>
                    </div>
                    <div class="reviews-form-line">
                        <div class="reviews-form-item">
                            <div class="reviews-form-text fl">Email:</div>
                            <div class="reviews-form-input fl"><input type="text" name="email"></div>
                        </div>
                    </div>
                    <div class="reviews-form-line">
                        <div class="reviews-form-item">
                            <div class="reviews-form-text fl">Сообшение*:</div>
                            <div class="reviews-form-input reviews-form-textarea fl">
                                <textarea name="text"></textarea>
                            </div>
                            <div class="reviews-form-submit"><button>Отправить</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @if($withProducts)
    <div class="main-title">
        С этим товаром также берут
    </div>
    <div class="main-title-line"></div>

    <div class="main-items-list">
        @foreach($withProducts as $withProduct)
        <div class="main-item-mobile">
         <div class="item-image-mobile">
             <a href="/product/{{$withProduct->url}}">
              @if($withProduct->category_id == 39) 
              <img src="{{ url('site/images/IMG_9745-450x300.png') }}">
              @else
              @if($withProduct->image == '')
              <img src="{{ url('site/images/zaglushka.png') }}">
              @else
              <img src="{{ url('product_images/' . $withProduct->image) }}" alt="">
              @endif
              @endif
          </a>
      </div>
      <a href="/product/{{$withProduct->url}}">
        <div class="item-name-mobile">
            {{$withProduct->name}}
        </div>
    </a>
    <div class="item-bottom-line">
        <div class="item-price">
            {{$withProduct->price}} грн
        </div>
        <div class="item-buy" data-productid="{{$withProduct->id}}">
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
@endif



@if($watched)
<div class="main-title you-watch">
    Вы смотрели
</div>
<div class="main-title-line"></div>

<div class="main-items-list">
    @foreach($watched as $watchItem)
    @if($product->id != $watchItem->id)
    <div class="main-item-mobile">

     <div class="item-image-mobile">
         <a href="/product/{{$watchItem->url}}">
             @if($watchItem->category_id == 39) 
             <img src="{{ url('site/images/IMG_9745-450x300.png') }}">
             @else
             @if($watchItem->image == '')
             <img src="{{ url('site/images/zaglushka.png') }}">
             @else
             <img src="{{ url('product_images/' . $watchItem->image) }}" alt="">
             @endif
             @endif
         </a>
     </div>
     <a href="/product/{{$watchItem->url}}">
         <div class="item-name-mobile">
            {{$watchItem->name}}
        </div>
    </a>
    <div class="item-bottom-line">
        <div class="item-price">
            {{$watchItem->price}} грн
        </div>
        <div class="item-buy" data-productid="{{$watchItem->id}}">
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
@endif
@endforeach

</div>

@endif
@stop