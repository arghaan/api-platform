import Vue from 'vue';
import VueRouter from 'vue-router';
// import store from '../store';
import Products from '../pages/Products'
import Home from '../pages/Home'
import Categories from "../pages/Categories";

Vue.use(VueRouter);

let router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/products',
            name: 'products',
            component: Products
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
