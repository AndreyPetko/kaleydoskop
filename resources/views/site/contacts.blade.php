@extends('site.layout')


@section('header')
    <title>Наборы для вышивания в Киеве — Калейдоскоп Вышивки.</title>
    <meta description="Наборы для вышивания и рукоделия, вышивки, бисер, мулине, пяльца в интернет-магазине. Купить Риолис, Золотое Руно, DIMENSIONS, Anchor, Русский Фаворит, Чудесная Игла. Киев.">
@stop

@section('content')
@include('elements.breadcrumbs')
<div class="category-title"><h1>Контакты</h1></div>
 <div class="category-title-line">
        </div>

        <div class="txt-block">Вы можете связаться с нами любым удобным для вас способом</div>
        <div class="info">
            <div class="info-text">Телефоны</div>
            <div class="info-text">
                <div class="numbers">{{$contacts['phone1']}} &nbsp;&nbsp;&nbsp;&nbsp; {{$contacts['phone2']}}</div>
            </div>
            <div class="info-text">E-mail</div>
            <div class="info-text">
                <p class="your-attachment">Ваши предложения, вопросы, пожелания:</p>
                <p class="e-mail">{{$contacts['email']}}</p>
            </div>
            <div class="info-text">Время работы</div>
            <div class="info-text">
                <div class="row shop">
                    <div class="cell real-shop">Магазин</div>
                    <div class="cell inet-shop">Интернет-магазин</div>
                </div>
                <div class="row friday">
                    <div class="cell friday0">пн-пт: с 10 до 18</div>
                    <div class="cell friday1">пн-пт: с 10 до 18</div>
                </div>
                <div class="row saturday">
                    <div class="cell saturday0">сб-вс: с 10 до 18</div>
                    <div class="cell saturday1">сб-вс: выходные</div>
                </div>
            </div>
        </div>
        <div class="feedback">
           <form action="/send-feedback" method="POST" id="feedback-form">
           <input type="hidden" value="{{csrf_token()}}" name="_token">
            <div class="row">
                <div class="cellFeedB"></div>
                <div class="cellFeedB">
                    <div class="feedback-title">Форма обратной связи</div>
                </div>
            </div>
            <div class="row">
                <div class="cellFeedB"></div>
                <div class="cellFeedB feedback-text">Вы можете оправить письмо администратору интернет-магазина</div>
            </div>
            
            <div class="row">
                <div class="cellFeedB label-col1"><label for="feedback-user-name">Имя:</label></div>
                <div class="cellFeedB input-col2">
                    <input type="text" id="feedback-user-name" name="name" @if(Auth::check()) value="{{Auth::user()->name}}" @endif>
                </div>
            </div>
            <div class="row">
                <div class="cellFeedB label-col1"><label for="feedback-mail">Email:</label></div>
                <div class="cellFeedB input-col2">
                    <input type="text" id="feedback-mail"  name="email" @if(Auth::check()) value="{{Auth::user()->email}}" @endif>
                </div>
            </div>
            <div class="row">
                <div class="cellFeedB label-col1"><label id="label-msg" for="feedback-msg">Сообщение:</label></div>
                <div class="cellFeedB input-col2">
                    <textarea id="feedback-msg" name="comment" rows="10" cols="48"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="cellFeedB"></div>
                <div class="cellFeedB feedBack-button">
                    <input id="submit-btn" type="submit" value="Отправить" name="feedback-submit">
                </div>
            </div>
            </form>
        </div>
        <div class="map">
            <div class="map-title">Карта проезда</div>
            <div class="map-img" id="map_canvas">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2536.833706724954!2d30.593588915293832!3d50.518660890329365!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40d4d10ed7903877%3A0xddd3e1d9ecb5f042!2z0LLRg9C70LjRhtGPINCg0LDQtNGD0L3RgdGM0LrQsCwgMi8xOCwg0JrQuNGX0LI!5e0!3m2!1sru!2sua!4v1504343158285" width="100%" height="100%" frameborder="0" crollwheel="false" style="border:0" allowfullscreen></iframe>
                
            </div>
        </div>

@stop


@section('mobile')
@include('elements.breadcrumbs')
<div class="category-title">
            <h1>Контакты</h1>
        </div>
        <div class="category-title-line">
        </div>
     <div class="info-mobile">
            <div class="info-text">Телефоны</div>
            <div class="info-text">
                <div class="numbers">(044) 332-88-82 &nbsp;&nbsp;&nbsp;&nbsp; (096) 778-74-88</div>
            </div>
            <div class="info-text">E-mail</div>
            <div class="info-text">
                <p class="your-attachment">Ваши предложения, вопросы, пожелания:</p>
                <p class="e-mail">info@kaleydoskop-vishivki.com.ua</p>
            </div>
            <div class="info-text">Режим работы</div>
            <div class="info-text">
                <div class="row shop">
                    <div class="cell real-shop">Магазин</div>
                    <div class="cell inet-shop">Интернет-магазин</div>
                </div>
                <div class="row friday">
                    <div class="cell friday0">пн-пт - с 10:00 до 18:00</div>
                    <div class="cell friday1">пн-пт - с 10:00 до 18:00</div>
                </div>
                <div class="row saturday">
                    <div class="cell saturday0">сб-вс - с 10:00 до 18:00</div>
                    <div class="cell saturday1">сб-вс - выходной</div>
                </div>
            </div>
        </div>
          <div class="feedback-mobile">
           <form action="/send-feedback" method="POST">
           <input type="hidden" value="{{csrf_token()}}" name="_token">
          
                    <div class="feedback-title-mobile">Форма обратной связи</div>
     
            <div class="row-mobile">
          
                    <input type="text" id="feedback-user-name-mobile" placeholder="Имя" name="name">
            
            </div>
            <div class="row-mobile">
             
                    <input type="text" id="feedback-mail-mobile" placeholder="Email"  name="email">
          
            </div>
           
                    <textarea id="feedback-msg-mobile" name="message" placeholder="Сообщение"  rows="10" cols="48"></textarea>
            
            </div>
            <div class="row-mobile">
                <div class="cellFeedB"></div>
                <div class="cellFeedB feedBack-button">
                    <input id="submit-btn-mobile" type="submit" value="Отправить" name="feedback-submit">
                </div>
            </div>
            </form>
         <div class="map">
            <div class="map-title">Карта проезда</div>
            <div class="map-img" id="map_canvas" onClick="style.pointerEvents='none'">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d634.6484357834133!2d30.4961228!3d50.4859064!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0000000000000000%3A0x989c34f6756d25a4!2z0KHQn9CUINCa0YPQu9C40Lo!5e0!3m2!1sru!2sua!4v1453466131738" width=100% height=100%s frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
@stop