import Vue from 'vue';
import axios from 'axios';
import './helper';

new Vue({
    el: '#root',
    data: {
        products: [],
        filteredProducts: [],
        activeProducts: [],
        perPage: 24,
        page: 1,
        minPrice: 0,
        maxPrice: 1000,
        subcategories: [],
        categoryName: '',
        currentSubcategory: '',
        attributes: [],
        attributesList: [],
        currentAttributes: [],
        brands: [],
        currentBrands: [],
        sortBy: 'name',
        showImageBlock: true
    },
    computed: {
        pages() {
            return parseInt(this.filteredProducts.length / this.perPage) + 1;
        }
    },
    watch: {
        minPrice(val, oldVal) {
            this.filter();
        },
        maxPrice(val, oldVal) {
            this.filter();
        },
        currentSubcategory(val, oldVal) {
            this.filter();
        },
        currentAttributes(val, oldVal) {
            this.filter();
        },
        currentBrands(val, oldVal) {
            this.filter();
        },
        perPage(val, oldVal) {
            this.filter();
        },
        sortBy(val, oldVal) {
            const {field, desc} = this.getSortFieldAndDesc(val);
            this.sortProducts(field, desc);
        }
    },
    methods: {
        getData() {
            const categoryUrl = this.getCategoryUrl();
            const url = '/filter/category-data/' + categoryUrl;
            const vm = this;

            axios.get(url)
                .then(result => {
                    const data = result.data;

                    vm.name = data.name;

                    vm.products = data.products;
                    vm.filteredProducts = data.products;
                    vm.subcategories = data.subcategories;
                    vm.attributes = data.attributes;
                    vm.attributesList = data.attributesList;
                    vm.brands = data.brands;

                    vm.setActiveProducts();
                    vm.filter();
                });
        },
        addToWishlist(product, id, wish) {
            axios.get(`/ajax/add-wish/?productid=${id}`)
                .then(() => {
                    product.wish = !wish;
                    // if(wish === false) {
                    //     swal('Товар успешно список желаний');
                    // } else {
                    //     swal('Товар успешно убран из списка желаний');
                    // }
                });
        },
        showImage(image) {
            document.querySelector('.show-images').style.display = 'block';
            document.querySelector('.show-images-content').style.display = 'block';

            let imageItem = document.createElement('img');
            imageItem.src = this.getSrc(image);

            document.querySelector('.show-images-main').innerHTML = '';
            document.querySelector('.show-images-main').appendChild(imageItem);

            document.querySelector('.show-images-right').style.display = 'none';
            document.querySelector('.show-images-left').style.display = 'none';
            document.querySelector('.show-images-name-block').style.display = 'none';
        },
        addToCart(id) {
            axios.get(`/ajax/add-to-cart/?id=${id}`)
                .then(() => {
                    swal('Товар успешно добавлен в корзину');
                });
        },
        getLink(url) {
            return `/product/${url}`;
        },
        resetFilter() {
            this.currentAttributes = [];
            this.currentBrands = [];

            let list = document.querySelectorAll('.filter-checkbox input');

            [].forEach.call(list, function (item) {
                item.checked = false;
            });
        },
        getCategoryUrl() {
            let url = window.location.href;
            let arr = url.split('/');

            return arr[arr.length - 1];
        },
        setActiveProducts() {
            const start = this.perPage * (this.page - 1);
            this.activeProducts = this.filteredProducts.slice(parseInt(start), parseInt(start) + parseInt(this.perPage));
        },
        getSrc(image) {
            if (image === null) {
                return '/site/images/zaglushka.png';
            }

            return `/product_images/${image}`;
        },
        setPage(page) {
            this.page = page;
            this.setActiveProducts();
            document.getElementsByTagName('body')[0].scrollTop = 300;
        },
        setSubcategory(id) {
            this.currentSubcategory = id;
        },
        attribyteNameById(id) {
            return this.attributesList[id];
        },
        setCurrentAttribute(attributeId, value) {
            if (event.target.checked) {
                this.currentAttributes.push({
                    id: attributeId,
                    value: value
                });
            } else {
                this.currentAttributes.forEach((item, i, arr) => {
                    if (item.value === value && item.id === attributeId) {
                        this.currentAttributes.splice(i, 1);
                    }
                });
            }
        },
        setCurrentBrand(brandId) {
            if (event.target.checked) {
                this.currentBrands.push(brandId);
            } else {
                this.currentBrands.remove(brandId);
            }
        },
        getSortFieldAndDesc(val = null) {
            if (val === null) {
                val = this.sortBy;
            }

            let descString = val.slice(-4);
            let desc = descString === 'Desc';
            let field;

            if (desc === false) {
                field = val;
            } else {
                field = val.substring(0, val.length - 4);
            }

            return {
                'field': field,
                'desc': desc
            };
        },
        filter() {
            const needFilterByAttribute = this.currentAttributes.length !== 0;
            const needFilterByBrand = this.currentBrands.length !== 0;
            let addProduct;
            this.page = 1;
            let filterProducts = [];

            this.products.forEach((item, i, arr) => {
                if (item.price < parseInt(this.minPrice) || item.price > parseInt(this.maxPrice)) {
                    return;
                }

                if (this.currentSubcategory !== '' && item.subcats.indexOf(this.currentSubcategory) === -1) {
                    return;
                }

                if (needFilterByAttribute) {
                    addProduct = false;

                    this.currentAttributes.forEach((attr, j, attrs) => {
                        Object.keys(item.attributes).forEach((attributeId, k, productsAttrs) => {
                            const value = item.attributes[attributeId];
                            if (attr.id === attributeId && attr.value === value) {
                                addProduct = true;
                            }
                        })
                    });

                    if (addProduct === false) {
                        return;
                    }
                }

                if (needFilterByBrand) {
                    addProduct = false;

                    this.currentBrands.forEach((brand, k, brands) => {
                        if (brand === item.brand) {
                            addProduct = true;
                        }
                    });

                    if (addProduct === false) {
                        return;
                    }
                }

                filterProducts.push(item);
            });

            this.filteredProducts = filterProducts;

            let {field, desc} = this.getSortFieldAndDesc();
            this.sortProducts(field, desc);

            this.setActiveProducts();
        },
        sortProducts(field, desc) {
            let products = this.filteredProducts;

            if (desc === false) {
                products.sort((a, b) => {
                    return (a[field] > b[field]) ? 1 : ((b[field] > a[field]) ? -1 : 0);
                });
            } else {
                products.sort((a, b) => {
                    return (a[field] < b[field]) ? 1 : ((b[field] < a[field]) ? -1 : 0);
                });
            }

            this.filteredProducts = products;

            this.setActiveProducts();
        }
    },
    created() {
        this.getData();
    }
});