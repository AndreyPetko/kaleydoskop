import Vue from 'vue';
import axios from 'axios';
import './helper';
import LocationParser from '../src/services/LocationParser';

new Vue({
    el: '#root',
    data: {
        products: [],
        filteredProducts: [],
        activeProducts: [],
        perPage: 24,
        page: 1,
        minPrice: 0,
        maxPrice: 100000,
        subcategories: [],
        categoryName: '',
        currentSubcategory: '',
        attributes: [],
        attributesList: [],
        currentAttributes: [],
        brands: [],
        currentBrands: [],
        sortBy: 'name',
        showImageBlock: true,
        showSubcategories: true,
        offset: 5
    },
    computed: {
        pages() {
            let countPages = parseInt(this.filteredProducts.length / this.perPage);

            if (this.filteredProducts.length % this.perPage !== 0) {
                countPages += 1;
            }

            return countPages;
        },
        showPages() {
            let finishAdd = this.pages - this.page <= this.offset ? this.offset * 2 - (this.pages - this.page) : this.offset;
            let add = this.page <= this.offset ? this.offset * 2 - this.page : this.offset;

            let start = this.page - finishAdd < 1 ? 1 : this.page - finishAdd;
            let stop = this.page + add > this.pages ? this.pages : this.page + add;

            let pages = [];

            for (let i = start; i <= stop; i++) {
                pages.push(i);
            }

            return pages;
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
        getType() {
            let url = window.location.href;
            let arr = url.split('/');
            if(arr[3] === 'brend-products') {
                return 'brend';
            }

            return 'category';
        },
        getData() {
            const categoryUrl = this.getCategoryUrl();

            const type = this.getType();
            const url = '/filter/category-data/' + categoryUrl + '/' + type;
            const vm = this;

            return axios.get(url)
                .then(result => {
                    const data = result.data;


                    vm.categoryName = data.name;
                    vm.products = data.products;
                    vm.filteredProducts = data.products;
                    vm.subcategories = data.subcategories;
                    vm.attributes = data.attributes;
                    vm.attributesList = data.attributesList;
                    vm.brands = data.brands;

                    vm.currentSubcategory = this.getSubcategoryId();
                    vm.setActiveProducts();
                    vm.filter();
                })
                .catch(result => {
                   console.log(result);
                });
        },
        addToWishlist(product, id, wish) {
            axios.get(`/ajax/add-wish/?productid=${id}`)
                .then(() => {
                    product.wish = !wish;
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
            let categoryUrl = arr[arr.length - 1];

            return categoryUrl.split('?')[0];
        },
        getSubcategoryId() {
            let tmp = [];
            let result = '';
            window.location.search
                .substr(1)
                .split("&")
                .forEach(function (item) {
                    tmp = item.split("=");
                    if (tmp[0] === 'subcategory') result = decodeURIComponent(tmp[1]);
                });

            return parseInt(result);
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
        noProducts() {
            return !this.notLoad() && this.activeProducts.length === 0;
        },
        notLoad() {
            return this.products.length === 0;
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
            let currentAttrs = {};

            this.currentAttributes.forEach((item, i, list) => {
                if (typeof currentAttrs[item.id] === 'undefined') {
                    currentAttrs[item.id] = [];
                }

                currentAttrs[item.id].push(item.value);
            });

            const attrCount = Object.keys(currentAttrs).length;

            this.products.forEach((item, i, arr) => {
                if (item.price < parseInt(this.minPrice) || item.price > parseInt(this.maxPrice)) {
                    return;
                }

                if (this.currentSubcategory !== '' && item.subcats.indexOf(this.currentSubcategory) === -1) {
                    return;
                }

                if (needFilterByAttribute) {
                    addProduct = false;
                    let approveAttrCount = 0;


                    for (let index in currentAttrs) {
                        let addAttr = false;

                        if (!currentAttrs.hasOwnProperty(index)) {
                            return;
                        }

                        let attr = currentAttrs[index];

                        attr.forEach((attrValue, i, arr) => {
                            Object.keys(item.attributes).forEach((attributeId, k, productsAttrs) => {
                                const value = item.attributes[attributeId];

                                if (index === attributeId && attrValue === value) {
                                    addAttr = true;
                                }
                            })
                        });

                        if (addAttr === true) {
                            approveAttrCount++;
                        }
                    }

                    if (approveAttrCount === attrCount) {
                        addProduct = true;
                    }

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
        this.getData().then(() => {
            const subcategory = LocationParser.get('subcategory');
            if(subcategory === null) {
                return;
            }

            this.currentSubcategory = parseInt(subcategory);
            LocationParser.clearParams();
        });
    }
});