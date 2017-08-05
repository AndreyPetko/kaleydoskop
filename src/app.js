import Vue from 'vue';
import axios from 'axios';

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
        currentAttributes: []
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

                    vm.setActiveProducts();
                    vm.filter();
                });
        },
        getCategoryUrl() {
            return 'Schetnyj-krest';
        },
        setActiveProducts() {
            const start = this.perPage * (this.page - 1);
            this.activeProducts = this.filteredProducts.slice(start, start + this.perPage);
            document.getElementsByTagName('body')[0].scrollTop = 300;
        },
        getSrc(image) {
            return "/product_images/" + image;
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
        filter() {
            this.page = 1;
            this.filteredProducts = [];

            this.products.forEach((item, i, arr) => {
                if (item.price < parseInt(this.minPrice) || item.price > parseInt(this.maxPrice)) {
                    return;
                }

                if (this.currentSubcategory !== '' && item.subcats.indexOf(this.currentSubcategory) === -1) {
                    return;
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