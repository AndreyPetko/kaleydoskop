@extends('site.layout')

@section('header')
    <link rel="stylesheet" href="{{ asset('dist/app.css') }}">
@stop

@section('content')
    <div class="mobile-menu show-mobile">
        <div class="mobile-menu-list">
            <div class="mobile-top-border"></div>
            <a href="/"><div class="mobile-menu-list-item">Главная</div></a>
            <a href="/catalog"><div class="mobile-menu-list-item">Каталог</div></a>
            <a href="/brends"><div class="mobile-menu-list-item">Бренды</div></a>
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
    <div class="mobile-header show-mobile">
        <div class="mobile-menu-button">
            <img src="{{ url('site/images/icon-menu.png') }}" alt="">
        </div>
        <div class="mobile-header-numbers">
            8 096 778 74 88 <br>
            8 044 332 88 82
        </div>
    </div>
    <div class="mobile-logo show-mobile">
        <a href="/"><img src="{{ url('site/images/logo.png') }}" alt=""></a>
    </div>
    <div class="mobile-search show-mobile">
        <div class="mobile-search-input">
            <input id="mobile-search-input">
        </div>
        <div class="mobile-search-icon" id="mobile-search">
            <img src="{{ url('/site/images/icon-sarch.png') }}">
        </div>
    </div>
    <div class="mobile-top-line show-mobile">
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

    <div class="category-content" id="root">
        <div class="category-filter fl">
            <div class="filter-header">
                ФИЛЬТР
            </div>
            <div class="filter-content">
                <div class="filter-title">
                    ЦЕНА
                </div>
                <div class="filter-price">
                    <div class="filter-from fl">
                        <span class="filter-grey">От</span> <input v-model="minPrice"> <span
                                class="filter-currency">ГРН</span>
                    </div>
                    <div class="filter-to fr">
                        <span class="filter-grey">До</span> <input v-model="maxPrice"> <span
                                class="filter-currency">ГРН</span>
                    </div>
                </div>
                <div class="filter-grey-line">
                    <img src="{{ url('site/images/filter-line.png') }}" alt="">
                </div>

                <div class="filter-title">Бренды</div>
                <div class="filter-grey-line">
                    <img src="{{ url('site/images/filter-line.png') }}" alt="">
                </div>

                <div class="filter-value" v-for="brand in brands">
                    <div class="filter-checkbox fl">
                        <input type="checkbox" @change="setCurrentBrand(brand.id)" class="attr-checkbox">
                    </div>
                    <div class="filter-value-text fl" v-text="brand.name"></div>
                </div>


                <div v-for="attribute, key in attributes">
                    <div class="filter-title" v-text="attribyteNameById(key)"></div>
                    <div class="filter-grey-line">
                        <img src="{{ url('site/images/filter-line.png') }}" alt="">
                    </div>

                    <div class="filter-value" v-for="value in attribute">
                        <div class="filter-checkbox fl">
                            <input type="checkbox" @change="setCurrentAttribute(key, value)" class="attr-checkbox">
                        </div>
                        <div class="filter-value-text fl" v-text="value"></div>
                    </div>
                </div>

                <div class="reset-filter">
                    <div class="reset-filter-img fl">
                        <img src="{{ url('site/images/refresh-icon-green.png') }}" alt="">
                    </div>
                    <div class="reset-filter-text fl" @click="resetFilter">
                        СБРОСИТЬ ФИЛЬТР
                    </div>
                </div>
            </div>
        </div>

        <div class="category-products-content fl">
            <div class="category-title" v-text="categoryName"></div>
            <div class="category-title-line">
            </div>

            <div class="subcategories-title" @click="showSubcategories = !showSubcategories">
                Перейти в подкатегорию:
                <div id="block-tria" :class="{'rotate-180': showSubcategories === true}"></div>
            </div>
            <div class="subcategories-line" v-if="showSubcategories"></div>
            <div class="subcategories-list" v-if="showSubcategories">

                <div class="subcat-item fl">
                    <a @click="setSubcategory('')">
                        <div class="subcat-image-home fl">
                            <img src="{{ url('/site/images/imagesGG60IGZZ.png') }}" alt="">
                        </div>
                        <div class="subcat-text fl" v-text="categoryName"></div>
                    </a>
                </div>

                {{--<div class="subcat-item fl">--}}
                {{--<div class="subcat-image fl">--}}
                {{--<img src="{{ url('site/images/icon-catecory-list-active.png') }}" alt="">--}}
                {{--</div>--}}
                {{--<div class="subcat-text subcat-text-active fl">--}}
                {{--123--}}
                {{--</div>--}}
                {{--</div>--}}

                <div class="subcat-item fl" v-for="subcategory in subcategories">
                    <a @click="setSubcategory(subcategory.id)">
                        <div class="subcat-image fl">
                            <img v-if="subcategory.id !== currentSubcategory"
                                 src="{{ url('site/images/icon-catecory-list.png') }}" alt="">
                            <img v-if="subcategory.id === currentSubcategory"
                                 src="{{ url('site/images/icon-catecory-list-active.png') }}" alt="">
                        </div>
                        <div class="subcat-text fl" v-text="subcategory.name"></div>
                    </a>
                </div>
            </div>

            <div class="clear"></div>

            <div class="subcat-sort-line">
                {{--<div class="grid-button fl">--}}
                    {{--<img src="{{ url('site/images/sort-tabl.png') }}" alt="">--}}
                {{--</div>--}}
                {{--<div class="line-button fl">--}}
                    {{--<img src="{{ url('site/images/sort-spisok-active.png') }}" alt="">--}}
                {{--</div>--}}

                <div class="sort-by fl">
                    <div class="sort-by-text fl">
                        Сортировать по:
                        <!-- цене -->
                        <select v-model="sortBy">
                            <option value='name'>Названию</option>
                            <option value='nameDesc'>Названию по убиванию</option>
                            <option value='price'>Цене</option>
                            <option value='priceDesc'>Цене по убиванию</option>
                        </select>
                    </div>
                    <div class="sort-by-img fl">
                    <!-- <img src="{{ url('site/images/chck-icon.png') }}" alt=""> -->
                    </div>
                </div>

                <div class="show-by fl">
                    <div class="sort-by-text fl">
                        Показывать по: 
                    </div>
                    <div class="sort-by-img fl">
                        <select v-model="perPage">
                            <option value="6">6</option>
                            <option value="12">12</option>
                            <option value="24">24</option>
                            <option value="48">48</option>
                            <option value="96">96</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="category-list">
                <div v-if="noProducts()" class="no-products">
                    По вашему запросу ничего не найдено
                </div>
                <div class="category-item fl" v-for="product in activeProducts">
                    <div class="magnifier" @click="showImage(product.image)">
                        <img src="{{ url('site/images/icon-loop.png') }}" alt="">
                    </div>
                    <a :href="getLink(product.url)">
                        <div class="item-image">
                            <img :src="getSrc(product.image)" alt="">
                        </div>
                        <div class="item-name" v-text="product.name"></div>
                    </a>
                    <div class="item-bottom-line">
                        <div class="item-price category">
                            <span v-text="product.price"></span> грн
                        </div>
                        <div class="item-heart fl" @click="addToWishlist(product, product.id, product.wish)">
                            <img v-if="!product.wish" src="{{ url('site/images/ixon-wishlist.png') }}" alt="">
                            <img v-if="product.wish" src="{{ url('site/images/ixon-wishlist-active.png') }}" alt="">
                        </div>
                        <div class="item-buy">
                            <div class="item-buy-image">
                                <img src="{{ url('site/images/icon-cart-main.png') }}" alt="">
                            </div>
                            <div class="item-buy-text" @click="addToCart(product.id)">
                                В корзину
                            </div>
                            <div class="item-buy-shadow"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pagination" v-if="noProducts() === false">
                <ul>
                    <li @click="setPage(1)"><-</li>
                    <li v-for="item in showPages" :class="{active: page === item}" @click="setPage(item)"
                        v-text="item"></li>
                    <li @click="setPage(pages)">-></li>
                    {{--<li>1</li>--}}
                    {{--<li class="pagination-active">2</li>--}}
                    {{--<li>3</li>--}}
                </ul>
            </div>
        </div>
    </div>

    <div class="mobile-footer show-mobile">

        <div class="mobile-footer-item"><a href="/catalog">Каталог</a></div>
        <div class="mobile-footer-item"><a href="/new-products">Новинки</a></div>
        <div class="mobile-footer-item"><a href="/page/skidki">Скидки</a></div>
        <div class="mobile-footer-item"><a href="/about">О компании</a></div>
        <div class="mobile-footer-item"><a href="/articles">Статьи</a></div>
        <div class="mobile-footer-item"><a href="/wholesalers">Оптовикам</a></div>
        <div class="mobile-footer-item"><a href="/oplata-dostavka">Оплата и доставка</a></div>
        <div class="mobile-footer-item"><a href="/contacts">Контакты</a></div>

    </div>

    <script src="{{ asset('dist/app.js') }}"></script>
@stop

