
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="{{ url('/swal/sweetalert.css') }}">
	<link rel="stylesheet" href="{{ url('site/site.css') }}">
	<link href="{{ url('site/media1200.css') }}" rel="stylesheet" media="(max-width: 1200px)">
	<link href="{{ url('site/media1000.css') }}" rel="stylesheet" media="(max-width: 1000px)">
	<link href="{{ url('site/media900.css') }}" rel="stylesheet" media="(max-width: 900px)">
	<link href="{{ url('site/media750.css') }}" rel="stylesheet" media="(max-width: 750px)">
	@yield('header')
</head>
<body>


	@yield('headContent')


	<div class="sucess-cart-alert" id="sucess-cart-form">
		<div class="fast-order-title">
			<div class="fast-order-title fl">Товар добавлен в корзину</div>
		</div>

		<div class="sucess-to-cart-image fl"><img src="{{ url('site/images/add-cart-success.png') }}"></div>
		<div class="fast-order-text" id="order-text">

		</div>
		<div class="clear"></div>
		<div class="fast-order-form-row"></div>
	</div>

	<div class="sucess-cart-alert" id="full-compare-form">
		<div class="fast-order-title">
			<div class="fast-order-title fl">Список сравнений переполнен</div>
			<div class="intake-close fr success-close" ><img src="{{ url('site/images/close-photo.png') }}" alt=""></div>
		</div>

		<div class="sucess-to-cart-image fl"><img src="{{ url('site/images/icon-attention.png') }}"></div>
		
		<p style="margin:10px 0 0 90px;">Товаров в списке сравнений: 4! Удалите ненужные товары для добавления новых.</p>
		<div class="clear"></div>
		<div class="cart-buttons">

			<a href="/comparison">
				<div class="cart-add-button">
					<div class="to-cart cart-buy">
						<div class="item-buy-image">
							<img src="{{ url('site/images/icon-compare-grey.png') }}" alt="">
						</div>
						<div class="item-buy-text cart-text">
							К списку
						</div>
						<div class="item-buy-shadow cart-shadow"></div>
					</div>
				</div>
			</a>
			<div class="close-issue fr success-close">
				<div class="to-cart cart-buy cart-close" >
					<div class="item-buy-text cart-close-text">
						Закрыть
					</div>
				</div>
			</div>
		</div>
		<div class="fast-order-form-row"></div>
	</div>


	<div class="feedback-block" id="sendmail-block">
		<div class="fast-order-title">
			<div class="fast-order-title fl">Подписаться на рассылку</div>
			<div class="intake-close fr" id="sendmail-close"><img src="{{ url('site/images/close-photo.png') }}" alt=""></div>
		</div>
		<div class="fast-order-text">
			Пожалуйста, введите свой E-mail:
		</div>

		<form method="POST" action="/add-sendmail">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<div class="fast-order-form-row">
				<div class="fast-order-label fl">E-mail:</div>
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


	@if(Session::get('register')) 

	<div class="success-register" id="register-block">
		<div class="fast-order-title">
			<div class="fast-order-title fl">Регистрация</div>
			<div class="intake-close fr" id="register-close"><img src="{{ url('site/images/close-photo.png') }}" alt=""></div>
		</div>
		<div class="fast-order-text">
			Регистрация прошла успешно, теперь вы можете просматривать свои заказы <a href="/dashboard">здесь</a>
		</div>

		<div class="fast-order-form-row"></div>
	</div>

	@endif

	@if(Session::get('sub')) 

	<div class="success-register" id="sub-block">
		<div class="fast-order-title">
			<div class="fast-order-title fl">Подписка</div>
			<div class="intake-close fr" id="sub-close"><img src="{{ url('site/images/close-photo.png') }}" alt=""></div>
		</div>
		<div class="fast-order-text">
			Вы успешно подписались на рассылку, теперь последние новости будут приходить вам на почту.
		</div>

		<div class="fast-order-form-row"></div>
	</div>

	@endif


	@if(Session::get('feedback')) 

	<div class="success-register" id="feedback-res">
		<div class="fast-order-title">
			<div class="fast-order-title fl">Обратная связь</div>
			<div class="intake-close fr" id="feedback-res-close"><img src="{{ url('site/images/close-photo.png') }}" alt=""></div>
		</div>
		<div class="fast-order-text">
			Ваше сообщение отправлено, ожидайте ответа
		</div>

		<div class="fast-order-form-row"></div>
	</div>

	@endif


	@if(Session::get('callback')) 

	<div class="success-register" id="callback-res">
		<div class="fast-order-title">
			<div class="fast-order-title fl">Обратная связь</div>
			<div class="intake-close fr" id="callback-res-close"><img src="{{ url('site/images/close-photo.png') }}" alt=""></div>
		</div>
		<div class="fast-order-text">
			Вы успешно заказали обратный звонок, мы скоро с вами свяжемся
		</div>

		<div class="fast-order-form-row"></div>
	</div>

	@endif

	<div class="feedback-block" id="feedback-block">
		<div class="fast-order-title">
			<div class="fast-order-title fl">Обратная связь</div>
			<div class="intake-close fr" id="feedback-close"><img src="{{ url('site/images/close-photo.png') }}" alt=""></div>
		</div>
		<div class="fast-order-text">
			Вы можете связаться с нами, заполнив поля ниже:
		</div>

		<form method="POST" action="/send-feedback">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="fast-order-form-row">
				<div class="fast-order-label fl">Имя:</div>
				<div class="fast-order-input fl"><input type="text" name="name" @if(Auth::check()) value="{{Auth::user()->name}}" @endif></div>
			</div>
			<div class="fast-order-form-row">
				<div class="fast-order-label fl">Email:</div>
				<div class="fast-order-input fl"><input type="text" name="email" @if(Auth::check()) value="{{Auth::user()->email}}" @endif></div>
			</div>
			<div class="fast-order-form-row">
				<div class="fast-order-label fl">Сообщение:</div>
				<div class="fast-order-input fl"><textarea name="comment"></textarea></div>
			</div>
			<div class="fast-order-form-row">
				<div class="fast-order-submit fr">
					<input type="submit" value="Подтвердить">
				</div>
			</div>
		</form>
		<div class="fast-order-form-row"></div>
	</div>


	<div class="feedback-block" id="callback-block">
		<div class="fast-order-title">
			<div class="fast-order-title fl">Заказать обратный звонок</div>
			<div class="intake-close fr" id="callback-close"><img src="{{ url('site/images/close-photo.png') }}" alt=""></div>
		</div>
		<div class="fast-order-text">
			Пожалуйста, укажите номер телефона и мы в ближайшее время Вам перезвоним.
		</div>

		<form method="POST" action="/add-callback" id="callback-form">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="fast-order-form-row">
				<div class="fast-order-label fl">Имя:</div>
				<div class="fast-order-input fl"><input type="text" name="name" @if(Auth::check()) value="{{Auth::user()->name}}" @endif></div>
			</div>
			<div class="fast-order-form-row">
				<div class="fast-order-label fl">Телефон:</div>
				<div class="fast-order-input fl"><input type="text" class="phone" name="phone" @if(Auth::check()) value="{{Auth::user()->phone}}" @endif></div>
			</div>
			<div class="fast-order-form-row">
				<div class="fast-order-submit fr">
					<input type="submit" value="Подтвердить">
				</div>
			</div>
		</form>
		<div class="fast-order-form-row"></div>
	</div>

	<div class="show-images"></div>
	<div class="show-images-content">
		<div class="show-images-row">
			<div class="show-images-close fr">
				<img src="{{ url('site/images/close-photo.png') }}" alt="">
			</div>
		</div>
		<div class="show-images-row">
			<div class="show-images-left fl">
			</div>
			<div class="show-images-main fl">

			</div>
			<div class="show-images-right fr">
			</div>
		</div>

		<div class="show-images-row">
			<div class="show-images-name-block">
				<div class="show-images-pages">
					2 из 4
				</div>
				<div class="show-images-green-line"></div>
				<div class="showimages-white-line">
					<div class="show-images-name">

					</div>
				</div>
				<div class="show-images-grey-line"></div>
			</div>

		</div>
	</div>
	<div class="header-line-background"></div>
	<div class="wrapper">
		<div class="header-line">


			@if(!Auth::check() || Auth::user()->role != 'wholesaler')
			<div class="header-line-element" id="header-list-send">
				<div class="header-line-element-icon mess-img">
					<img src="{{ url('site/images/icon-mail.png') }}" alt="">
				</div>
				<div class="header-line-element-text">
					Подписаться на рассылку
				</div>
			</div>
			@endif

			<div class="header-line-element line-ml-1" id="header-list-feedback">
				<div class="header-line-element-icon">
					@if(!Auth::check() || Auth::user()->role != 'wholesaler')
					<img src="{{ url('site/images/icon-feedback.png') }}" alt="">
					@else
					<img src="{{ url('site/images/icon-mail.png') }}" alt="">
					@endif

				</div>
				<div class="header-line-element-text">
					Обратная связь
				</div>
			</div>


			@if(Auth::check() && Auth::user()->role == 'wholesaler')
			<div class="header-line-element">
				<div class="header-line-element-text">
					| Вы зашли как оптовый представитель
				</div>
			</div>
			@endif


			@if(!Auth::check() || Auth::user()->role != 'wholesaler')
			<div class="header-line-element line-ml-1 media-del-1" id="header-list-call">
				<div class="header-line-element-icon">
					<img src="{{ url('site/images/icon-call-back.png') }}" alt="">
				</div>
				<div class="header-line-element-text ">
					Заказать обратный звонок
				</div>
			</div>
			@endif

			<div class="header-line-element line-ml-2">
				<div class="header-line-element-text">
					8 096 778 74 88
				</div>
			</div>
			
			<div class="header-line-element line-ml-3">
				<div class="header-line-element-text">
					8 044 332 88 82
				</div>
			</div>


			<div class="header-line-search">
				<input type="text" placeholder="Поиск" id="searchInput">
				<div class="search-icon">
					<img src="{{ url('site/images/icon-sarch.png') }}" alt="" id="searchIcon">
				</div>
			</div>

		</div>
		<div class="clear"></div>
		<div class="header-content">
			<div class="site-logo">
				<a href="/">
					<img src="{{ url('site/images/main-logo.png') }}" alt="">
				</a>
					<a href="http://www.kaleydoskop-vishivki.com.ua">
				<div style="margin-top: 5px;" class="back-to-old">
				<img style="float: left;" src="site/images/arrow-right-c.png">
					Вернуться на старый дизайн
				
				</div>
				</a>

			</div>

			<div class="header-content-items">
				<div class="header-content-block-1">
					<div class="header-items-line-1">

						<div class="header-item">
							<div class="header-item-img">
								<img src="{{ url('site/images/icon-login-main.png') }}" alt="">
							</div>
							@if(Auth::check())
							<a href="/auth/logout">
								<div class="header-item-text">
									Выход
								</div>
							</a>
							@else
							<a href="/login">
								<div class="header-item-text">
									Вход 
								</div>
							</a>
							@endif
						</div>
						
						<div class="header-items-wall">
							<img src="{{ url('site/images/vertical-line.png') }}" alt="">
						</div>
						
						<div class="header-item">
							<div class="header-item-img">
								<img src="{{ url('site/images/icon-register.png') }}" alt="">
							</div>
							@if(Auth::check())
							<a href="/dashboard">
								<div class="header-item-text">
									Кабинет
								</div>
							</a>
							@else
							<a href="/auth/register">
								<div class="header-item-text">
									Регистрация
								</div>
							</a>
							@endif
						</div>

					</div>
					<div class="clear"></div>
					<div class="header-items-line-2">

						<a href="/wishlist">
							<div class="header-item">
								<div class="header-item-img">
									<img src="{{ url('site/images/icon-wishlist.png') }}" alt="">
								</div>   
								<div class="header-item-text">
									Желания
								</div>
							</div>
						</a>
						
						<div class="header-items-wall">
							<img src="{{ url('site/images/vertical-line.png') }}" alt="">
						</div>
						<a href="/comparison">
							<div class="header-item">
								<div class="header-item-img">
									<img src="{{ url('site/images/icon-compare.png') }}" alt="">
								</div>

								<div class="header-item-text">
									Сравнение
								</div>
							</div>
						</a>

					</div>
				</div>
				<div class="header-content-block-2">
					<div class="header-block2-line-1">
						@if(Request::url() === url('/'))
						<h1>Наборы для вышивания и рукоделия</h1>
						@else
						<h2>Наборы для вышивания и рукоделия</h2>
						@endif

						<p>Режим работы: Пн-Пт 10.00 - 18.00</p>
					</div>
					<div class="header-block2-line-2" id="open-cart">
						<div class="block2-line2-img"><img src="{{ url('site/images/icon-cart2.png') }}" alt=""></div>
						<div class="block2-line2-text">Корзина</div>
					</div>
					<div class="cart-block" id="cart-block">
						<div class="cart-border"></div>
						<div class="cart-border-yellow"></div>
						<div class="cart-block-list">

						</div>
						<div class="cart-total">
							Итого: <span class="change-color-total"></span>
						</div>

						<div class="cart-buttons">
							<a href="/cart">
								<div class="cart-add-button">
									<div class="to-cart cart-buy">
										<div class="item-buy-image">
											<img src="{{ url('site/images/icon-cart-main.png') }}" alt="">
										</div>
										<div class="item-buy-text cart-text">
											Оформить заказ
										</div>
										<div class="item-buy-shadow cart-shadow"></div>
									</div>
								</div>
							</a>
							<div class="cart-issue">
								<div class="to-cart cart-buy cart-close" id="cartClose">
									<div class="item-buy-text cart-close-text">
										Свернуть
									</div>
								</div>
							</div>
						</div>
						<div class="cart-bottom-line"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="main-menu">
			<a href="/catalog">
				<div class="main-menu-item @if($_SERVER['REQUEST_URI'] == '/catalog' || stripos($_SERVER['REQUEST_URI'], 'category')) main-menu-active @endif" id="catalog">Каталог</div>
			</a>
			<a href="/brends">
				<div class="main-menu-item @if($_SERVER['REQUEST_URI'] == '/catalog' || stripos($_SERVER['REQUEST_URI'], 'category')) main-menu-active @endif" id="catalog2">Бренды</div>
			</a>
			<a href="/new-products"><div class="main-menu-item  @if($_SERVER['REQUEST_URI'] =='/new-products') main-menu-active @endif">Новинки</div></a>
			<a href="/contacts"><div class="main-menu-item @if($_SERVER['REQUEST_URI'] =='/contacts') main-menu-active @endif">Контакты</div></a>
			<a href="/oplata-dostavka"><div class="main-menu-item main-menu-item-sm @if($_SERVER['REQUEST_URI'] =='/oplata-dostavka') main-menu-active @endif">Оплата и доставка</div></a>
			<a href="/about"></area><div class="main-menu-item main-menu-item-sm @if($_SERVER['REQUEST_URI'] == '/about') main-menu-active @endif">О компании</div></a>
			<a href="/wholesalers"><div class="main-menu-item main-menu-item-sm @if($_SERVER['REQUEST_URI'] =='/wholesalers') main-menu-active @endif">Оптовикам</div></a>
			<a href="/articles"><div class="main-menu-item @if($_SERVER['REQUEST_URI'] =='/articles') main-menu-active @endif">Статьи</div></a>
			
		</div>
		<div class="main-menu-line"></div>
		<div class="main-menu-dropdown">
			<div class="main-dropdown-top-line"></div>
			<div class="main-dropdown-list">
				<a href="/new-products">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-image">
								<img src="{{ url('site/images/icon12.png') }}" alt="">
							</div>
							<div class="main-dropdown-item-text">
								<div>
									Новинки
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>
				<a href="/category/schetnyj-krest">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-image">
								<img src="{{ url('site/images/icon1.png') }}" alt="">
							</div>
							<div class="main-dropdown-item-text">
								<div>
									Счетный крест
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>
				<a href="/category/Drugie-tehniki">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-image">
								<img src="{{ url('site/images/icon3.png') }}" alt="">
							</div>
							<div class="main-dropdown-item-text">
								<div>
									Другие техники
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>
				<a href="/category/Vyshivka-biserom">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-image">
								<img src="{{ url('site/images/icon8.png') }}" alt="">
							</div>
							<div class="main-dropdown-item-text">
								<div>
									Вышивка бисером
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>
				<a href="/category/Ikony">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-image">
								<img src="{{ url('site/images/icon2.png') }}" alt="">
							</div>
							<div class="main-dropdown-item-text">
								<div>
									Иконы
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>
				<a href="/category/Nabory-dlya-rukodeliya">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-image">
								<img src="{{ url('site/images/icon6.png') }}" alt="">
							</div>
							<div class="main-dropdown-item-text">
								<div>
									Наборы для рукоделия
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>
				<a href="/category/Nitki">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-image">
								<img src="{{ url('site/images/icon7.png') }}" alt="">
							</div>
							<div class="main-dropdown-item-text">
								<div>
									Нитки
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>
				<a href="/category/Biser">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-image">
								<img src="{{ url('site/images/icon4.png') }}" alt="">
							</div>
							<div class="main-dropdown-item-text">
								<div>
									Бисер
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>
				<a href="/category/Prinadlezhnosti">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-image">
								<img src="{{ url('site/images/icon10.png') }}" alt="">
							</div>
							<div class="main-dropdown-item-text">
								<div>
									Принадлежности
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>
				<a href="/category/Nabory-dlya-tvorchestva">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-image">
								<img src="{{ url('site/images/icon11.png') }}" alt="">
							</div>
							<div class="main-dropdown-item-text">
								<div>
									Наборы для творчества
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>
				<a href="/category/Pyalbczy-i-stanki">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-image">
								<img src="{{ url('site/images/icon14.png') }}" alt="">
							</div>
							<div class="main-dropdown-item-text">
								<div>
									Пяльцы и станки
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>
				<a href="/category/Prazdniki-i-pozdravleniya">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-image">
								<img src="{{ url('site/images/icon13.png') }}" alt="">
							</div>
							<div class="main-dropdown-item-text">
								<div>
									Праздники и поздравления
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>
				
				
				
			</div>
			<div class="main-dropdown-item button-to-all-categories">
				<a href="/catalog">
					<img src="{{ url('site/images/all-categories.png') }}">
					Все категории
				</a>
			</div>
			<div class="main-dopdown-bottom-line"></div>
		</div>

		<div class="main-menu-dropdown main-menu-dropdown-brend">
			<div class="main-dropdown-top-line"></div>
			<div class="main-dropdown-list">
				<a href="/brend-products/DIMENSIONS">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-text">
								<div>
									DIMENSIONS
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>
				<a href="/brend-products/zolotoe-runo">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-text">
								<div>
									Золотое руно
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>
				<a href="/brend-products/riolis">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-text">
								<div>
									Riolis Premium
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>
				<a href="/brend-products/sdelano-s-lyubovbyu">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-text">
								<div>
									Сделано с любовью
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>
				<a href="/brend-products/krasa-і-tvorchіstb">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-text">
								<div>
									Краса і творчість
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>
				<a href="/brend-products/russkaya-iskusnicza">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-text">
								<div>
									Русская искусница
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>
				<a href="/brend-products/plaid">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-text">
								<div>
									PLAID
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>
				<a href="/brend-products/anchor">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-text">
								<div>
									Anchor
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>
				<a href="/brend-products/BESTEX">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-text">
								<div>
									Bestex
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>
				<a href="/brend-products/chudesnaya-igla">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-text">
								<div>
									Чудесная игла
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>
				<a href="/brend-products/russkij-favorit">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-text">
								<div>
									Русский фаворит
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>
				<a href="/brend-products/kroshe">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-text">
								<div>
									Кроше
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>
				<a href="/brend-products/charіvna-mitb">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-text">
								<div>
									Чарівна мить
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>
				<a href="/brend-products/Majsterna-Vishivanka">
					<div class="main-dropdown-item">
						<div class="main-dropdown-content">
							<div class="main-dropdown-item-text">
								<div>
									Майстерна Вишиванка
								</div>
							</div>
							<div class="main-dropdown-side-border">
								<img src="{{ url('site/images/vertical-line.png') }}" alt="">
							</div>
						</div>
						<div class="main-dropdown-bottom-border">
						</div>
					</div>
				</a>

			</div>
			<div class="main-dropdown-item button-to-all-categories">
				<a href="/brends">
					<img src="{{ url('site/images/all-categories.png') }}">
					Все бренды
				</a>
			</div>
			<div class="main-dopdown-bottom-line"></div>
		</div>
		<div id="index-content">
			@yield('content')
		</div>
	</div>
	<div class="footer">
		<div class="footer-wrapper">
			<div class="footer-line-1">
				<div class="footer-logo">
					<img src="{{ url('site/images/logo-footer.png') }}" alt="">
				</div>
				<div class="footer-links">
					<div class="footer-links-item"><a href="/catalog">Каталог</a></div>
					<div class="footer-links-item"><a href="/new-products">Новинки</a></div>
					<div class="footer-links-item"><a href="#">Скидки</a></div>
					<div class="footer-links-item"><a href="/about">О компании</a></div>
					<div class="footer-links-item"><a href="/articles">Статьи</a></div>
					<div class="footer-links-item"><a href="/wholesalers">Оптовикам</a></div>
					<div class="footer-links-item"><a href="/oplata-dostavka">Оплата и доставка</a></div>
					<div class="footer-links-item" id="header-list-feedback-2"><a href="#">Обратная связь</a></div>
					<div class="footer-links-item"><a href="/contacts">Контакты</a></div>
					<div class="footer-links-item"><a href="/brends">Наши Бренды</a></div>
				</div>
			</div>
		</div>
		<div class="footer-yellow-line"></div> 
		<div class="footer-wrapper">
			<div class="copyright">
				<div class="copy-el">
					Copyright 2009-2015, Киев © Интернет-магазин Калейдоскоп Вышивки
				</div>
				<div class="copy-el">
					Создание сайта <a href="http://anastasiya-petko.com.ua" target="_blank"> AP Studio</a>
				</div>
			</div>

			<div class="footer-banners">
<!-- 
				<script type="text/javascript" language="javascript"><!--
					function BM_Draw(oBM_STAT){
						document.write('<table cellpadding="0" cellspacing="0" border="0" style="display:inline;margin-right:4px;"><tr><td><div style="margin:0px;padding:0px;font-size:1px;width:88px;"><div style="background:url(\'http://i.bigmir.net/cnt/samples/diagonal/b60_top.gif\') no-repeat bottom;"> </div><div style="font:10px Tahoma;background:url(\'http://i.bigmir.net/cnt/samples/diagonal/b60_center.gif\');"><div style="text-align:center;"><a href="http://www.bigmir.net/" target="_blank" style="color:#0000ab;text-decoration:none;font:10px Tahoma;">bigmir<span style="color:#ff0000;">)</span>net</a></div><div style="margin-top:3px;padding: 0px 6px 0px 6px;color:#426ed2;"><div style="float:left;font:10px Tahoma;">'+oBM_STAT.hosts+'</div><div style="float:right;font:10px Tahoma;">'+oBM_STAT.hits+'</div></div><br clear="all"/></div><div style="background:url(\'http://i.bigmir.net/cnt/samples/diagonal/b60_bottom.gif\') no-repeat top;"> </div></div></td></tr></table>');
					}

				</script>
				<script type="text/javascript" language="javascript"><!--
					bmN=navigator,bmD=document,bmD.cookie='b=b',i=0,bs=[],bm={o:1,v:16900002,s:16900002,t:0,c:bmD.cookie?1:0,n:Math.round((Math.random()* 1000000)),w:0};
					for(var f=self;f!=f.parent;f=f.parent)bm.w++;
						try{if(bmN.plugins&&bmN.mimeTypes.length&&(x=bmN.plugins['Shockwave Flash']))bm.m=parseInt(x.description.replace(/([a-zA-Z]|\s)+/,''));
					else for(var f=3;f<20;f++)if(eval('new ActiveXObject("ShockwaveFlash.ShockwaveFlash.'+f+'")'))bm.m=f}catch(e){;}
					try{bm.y=bmN.javaEnabled()?1:0}catch(e){;}
					try{bmS=screen;bm.v^=bm.d=bmS.colorDepth||bmS.pixelDepth;bm.v^=bm.r=bmS.width}catch(e){;}
					r=bmD.referrer.slice(7);if(r&&r.split('/')[0]!=window.location.host){bm.f=escape(r);bm.v^=r.length}
					bm.v^=window.location.href.length;for(var x in bm) if(/^[ovstcnwmydrf]$/.test(x)) bs[i++]=x+bm[x];
					bmD.write('<sc'+'ript type="text/javascript" language="javascript" src="http://c.bigmir.net/?'+bs.join('&')+'"></sc'+'ript>');

				</script>
				<noscript>
					<a href="http://www.bigmir.net/" target="_blank"><img src="http://c.bigmir.net/?v16900002&s16900002&t2" width="88" height="31" alt="bigmir)net TOP 100" title="bigmir)net TOP 100" border="0" /></a>
				</noscript>
				<a href="http://www.i.ua/" target="_blank" onclick="this.href='http://i.ua/r.php?144160';" title="Rated by I.UA">
					<script type="text/javascript" language="javascript"><!--
						iS='<img src="http://r.i.ua/s?u144160&p65&n'+Math.random();
						iD=document;if(!iD.cookie)iD.cookie="b=b; path=/";if(iD.cookie)iS+='&c1';
						iS+='&d'+(screen.colorDepth?screen.colorDepth:screen.pixelDepth)
						+"&w"+screen.width+'&h'+screen.height;
						iT=iD.referrer.slice(7);iH=window.location.href.slice(7);
						((iI=iT.indexOf('/'))!=-1)?(iT=iT.substring(0,iI)):(iI=iT.length);
						if(iT!=iH.substring(0,iI))iS+='&f'+escape(iD.referrer.slice(7));
						iS+='&r'+escape(iH);
						iD.write(iS+'" border="0" width="88" height="31" />');
					</script></a>
					<script type="text/javascript">
						my_id = 120864;
						my_width = 88;
						my_height = 31;
						my_alt = "MyCounter - счётчик и статистика (посетителей и хитов сегодня)";
					</script>
					<script type="text/javascript"
					src="http://scripts.mycounter.ua/counter2.0.js">
				</script>

				<script id="top100Counter" type="text/javascript" src="http://counter.rambler.ru/top100.jcn?2756718"></script>
				<noscript>
					<a href="http://top100.rambler.ru/navi/2756718/">
						<img src="http://counter.rambler.ru/top100.cnt?2756718" alt="Rambler's Top100" border="0" />
					</a>

				</noscript>
				<script type="text/javascript">
					document.write("<a href='http://www.liveinternet.ru/click' "+
						"target=_blank><img src='//counter.yadro.ru/hit?t14.6;r"+
						escape(document.referrer)+((typeof(screen)=="undefined")?"":
							";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
								screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
						";"+Math.random()+
						"' alt='' title='LiveInternet: показано число просмотров за 24"+
						" часа, посетителей за 24 часа и за сегодня' "+
						"border='0' width='88' height='31'><\/a>")
				</script><script type="text/javascript">

				var _gaq = _gaq || [];
				_gaq.push(['_setAccount', 'UA-33865176-1']);
				_gaq.push(['_trackPageview']);

				(function() {
					var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
					ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
				})();

			</script><a href="http://www.online.ua/" target="_blank"> <img src="http://i.online.ua/catalog/logo/
			32.png" alt="Украина онлайн" border="0" width="88" height="31"> </a> -->

		</div>
	</div>
	<div class="footer-fence"></div>
</div>
<div class="mobile-wrapper">
	<div class="mobile-menu">
		<div class="mobile-menu-list">
			<div class="mobile-top-border"></div>
			<a href="/"><div class="mobile-menu-list-item">Главная</div></a>
			<a href="/catalog"><div class="mobile-menu-list-item">Каталог</div></a>
			<a href="/about"><div class="mobile-menu-list-item">О компании</div></a>
			<a href="/wholesalers"><div class="mobile-menu-list-item">Оптовикам</div></a>
			<a href="/oplata-dostavka"><div class="mobile-menu-list-item">Оплата и доставка</div></a>
			<a href="/contacts"><div class="mobile-menu-list-item">Контакты</div></a>
			<div class="mobile-menu-list-item" id="mobile-white-menu-button">Пользователю</div>
		</div>
		<div class="mobile-white-menu-list">
			<div class="mobile-white-menu-item" id="send-mail-mobile">Подписаться на рассылку</div>
			<div class="mobile-white-menu-item" id="feedback-mobile">Обратная связь</div>
			<div class="mobile-white-menu-item" id="callback-mobile">Заказать обратный звонок</div>
			<a href="/wishlist"><div class="mobile-white-menu-item">Желания</div></a>
			
		</div>
	</div>
	<div class="mobile-header">
		<div class="mobile-menu-button">
			<img src="{{ url('site/images/icon-menu.png') }}" alt="">
		</div>
		<div class="mobile-header-numbers">
			8 096 778 74 88 <br>
			8 044 332 88 82
		</div>
	</div>
	<div class="mobile-logo">
		<a href="/"><img src="{{ url('site/images/logo.png') }}" alt=""></a>
	</div>
	<div class="mobile-search">
		<div class="mobile-search-input">
			<input id="mobile-search-input"></input>
		</div>
		<div class="mobile-search-icon" id="mobile-search">
			<img src="{{ url('/site/images/icon-sarch.png') }}">
		</div>
	</div>
	<div class="mobile-top-line">
		@if(!Auth::check())
		<a href="/login">
			<div class="mobile-top-element">
				<div class="mobile-top-image">
					<img src="{{ url('site/images/icon-login.png') }}" alt="">
				</div>
				<div class="mobile-top-text">
					Вход
				</div>
			</div>
		</a>
		<a href="/auth/register">
			<div class="mobile-top-element mobile-top-register">
				<div class="mobile-top-image">
					<img src="{{ url('site/images/icon-registr.png') }}" alt="">
				</div>
				<div class="mobile-top-text">
					Регистрация
				</div>
			</div>
		</a>
		@else
		<a href="/auth/logout">
			<div class="mobile-top-element">
				<div class="mobile-top-image">
					<img src="{{ url('site/images/icon-login.png') }}" alt="">
				</div>
				<div class="mobile-top-text">
					Выход
				</div>
			</div>
		</a>
		<a href="/dashboard">
			<div class="mobile-top-element mobile-top-register">
				<div class="mobile-top-image">
					<img src="{{ url('site/images/icon-registr.png') }}" alt="">
				</div>
				<div class="mobile-top-text">
					Кабинет
				</div>
			</div>
		</a>
		@endif
		<a href="/cart">
			<div class="mobile-top-element mobile-top-right">
				<div class="mobile-top-image">
					<img src="{{ url('site/images/icon-cart.png') }}" alt="">
				</div>
				<div class="mobile-top-text">
					Корзина
				</div>
			</div>
		</a>
	</div>

	@yield('mobile')

	<div class="mobile-footer">

		<div class="mobile-footer-item"><a href="/catalog">Каталог</a></div>
		<div class="mobile-footer-item"><a href="/new-products">Новинки</a></div>
		<div class="mobile-footer-item"><a href="#">Скидки</a></div>
		<div class="mobile-footer-item"><a href="/about">О компании</a></div>
		<div class="mobile-footer-item"><a href="/articles">Статьи</a></div>
		<div class="mobile-footer-item"><a href="/wholesalers">Оптовикам</a></div>
		<div class="mobile-footer-item"><a href="/oplata-dostavka">Оплата и доставка</a></div>
		<div class="mobile-footer-item"><a href="/contacts">Контакты</a></div>
		
	</div>
</div>
</div>


<script src="{{ url('/site/url.js') }}"></script>
<script src="{{url('/site/jquery.js')}}"></script>
<script src="{{ url('dist/js/jquery.validate.min.js') }}"></script>
<script src="{{ url('/swal/sweetalert.min.js') }}"></script>
<script src="{{ url('site/functions.js') }}"></script>
<script src="{{ url('site/site.js') }}"></script>
<script src="{{ url('site/validate.js')}}"></script>
<script src="{{ url('site/jmask.js')}}"></script>
<script src="{{url('/site/owl-carousel/owl.carousel.js')}}"></script>
<link rel="stylesheet" href="{{ url('site/owl-carousel/owl.carousel.css') }}">
<link rel="stylesheet" href="{{ url('site/owl-carousel/owl.theme.default.css') }}">


@yield('js')
</body>

</html>