@extends('site.layout')

@section('header')
    <link rel="stylesheet" href="{{ asset('dist/app.css') }}">
@stop

@section('content')
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

            <div class="subcategories-title">
                Перейти в подкатегорию:
            </div>
            <div class="subcategories-line"></div>
            <div class="subcategories-list">


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
                <div class="grid-button fl">
                    <img src="{{ url('site/images/sort-tabl.png') }}" alt="">
                </div>
                <div class="line-button fl">
                    <img src="{{ url('site/images/sort-spisok-active.png') }}" alt="">
                </div>

                <div class="sort-by fl">
                    <div class="sort-by-text fl">
                        Сортировать по:
                        <!-- цене -->
                        <select id="sort-select">
                            <option value='price'>Цене</option>
                            <option value='name'>Названию</option>
                        </select>
                    </div>
                    <div class="sort-by-img fl">
                    <!-- <img src="{{ url('site/images/chck-icon.png') }}" alt=""> -->
                    </div>
                </div>

                <div class="show-by fl">
                    <div class="sort-by-text fl">
                        Показывать по: 12
                    </div>
                    <div class="sort-by-img fl">
                        <img src="{{ url('site/images/chck-icon.png') }}" alt="">
                    </div>
                </div>
            </div>

            <div class="category-list">

                <div class="category-item fl" v-for="product in activeProducts">
                    <div class="magnifier">
                        <img src="{{ url('site/images/icon-loop.png') }}" alt="">
                    </div>
                    <div class="item-image">
                        <img :src="getSrc(product.image)" alt="">
                    </div>
                    <div class="item-name" v-text="product.name">
                    </div>
                    <div class="item-bottom-line">
                        <div class="item-price category">
                            <span v-text="product.price"></span> грн
                        </div>
                        <div class="item-heart fl">
                            <img src="{{ url('site/images/ixon-wishlist.png') }}" alt="">
                        </div>
                        <div class="item-buy">
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
            </div>

            <div class="pagination">
                <ul>
                    <li v-for="item in pages" :class="{active: page === item}" @click="setPage(item)"
                        v-text="item"></li>
                    {{--<li>1</li>--}}
                    {{--<li class="pagination-active">2</li>--}}
                    {{--<li>3</li>--}}
                </ul>
            </div>
        </div>
    </div>

    <script src="{{ asset('dist/app.js') }}"></script>
@stop