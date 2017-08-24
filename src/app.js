import Vue from 'vue';
import axios from 'axios';
import './helper';

new Vue({
    el: '#root',
    data: {
        products: [],
        filteredProducts: [],
        activeProducts: [],
        perPage: 21,
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
        currentBrands: []
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
            this.activeProducts = this.filteredProducts.slice(start, start + this.perPage);
            document.getElementsByTagName('body')[0].scrollTop = 300;
        },
        getSrc(image) {
            return `/product_images/${image}`;
        },
        setPage(page) {
            this.page = page;
            this.setActiveProducts();
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
        filter() {
            const needFilterByAttribute = this.currentAttributes.length !== 0;
            const needFilterByBrand = this.currentBrands.length !== 0;
            let addProduct;
            this.page = 1;
            this.filteredProducts = [];


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
                        if(brand === item.brand) {
                            addProduct = true;
                        }
                    });

                    if (addProduct === false) {
                        return;
                    }
                }


                this.filteredProducts.push(item);
            });

            this.setActiveProducts();
        }
    },
    created() {
        this.getData();
    }
});