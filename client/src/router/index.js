import Vue from 'vue';
import VueRouter from 'vue-router';
// import store from '../store';
import Articles from '../pages/Articles'
import ProductList from '../pages/ProductList'
import Home from '../pages/Home'
import Categories from "../pages/Categories";

Vue.use(VueRouter);

let router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/ozon/product/list',
            name: 'ozon_product_list',
            component: ProductList
        },
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/categories',
            name: 'categories',
            component: Categories
        },
    ],
});


export default router;
