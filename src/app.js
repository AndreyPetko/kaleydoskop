import Vue from 'vue';
import axios from 'axios';

new Vue({
    el: '#root',
    data: {
        products: [],
        activeProducts: [],
        perPage: 21,
        page: 1
    },
    computed: {
        pages() {
            return parseInt(this.products.length / this.perPage) + 1;
        }
    },
    methods: {
        getProducts() {
            const categoryUrl = this.getCategoryUrl();
            const url = '/filter/category-products/' + categoryUrl;
            const vm = this;

            axios.get(url)
                .then(result => {
                    vm.products = result.data;
                    vm.setActiveProducts();
                });
        },
        getCategoryUrl() {
            return 'Schetnyj-krest';
        },
        setActiveProducts() {
            const start = this.perPage * (this.page - 1);
            this.activeProducts = this.products.slice(start, start + this.perPage);
        },
        getSrc(image) {
            return "/product_images/" + image;
        },
        setPage(page) {
            this.page = page;
            this.setActiveProducts();
        }
    },
    created() {
        // this.getFilterData();
        this.getProducts();
    }
});