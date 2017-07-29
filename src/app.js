import Vue from 'vue';
import axios from 'axios';

Vue.config.delimiters = ['<%', '%>'];

new Vue({
    el: '#root',
    data: {
        products: [],
        activeProducts: []
    },
    computed: {
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
            this.activeProducts = this.products.slice(0, 21);
        },
        getSrc(image) {
            return "/product_images/" + image;
        }
    },
    created() {
        // this.getFilterData();
        this.getProducts();
    }
});