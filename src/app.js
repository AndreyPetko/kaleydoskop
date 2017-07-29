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
        categoryName: ''
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
        }
    },
    methods: {
        getProducts() {
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
        filter() {
            this.filteredProducts = [];

            this.products.forEach((item, i, arr) => {
                if(item.price < parseInt(this.minPrice) || item.price > parseInt(this.maxPrice)) {
                    return;
                }

                this.filteredProducts.push(item);
            });

            this.setActiveProducts();
        }
    },
    created() {
        this.getProducts();
    }
});