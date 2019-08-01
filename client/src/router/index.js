import Vue from 'vue';
import VueRouter from 'vue-router';
// import store from '../store';
// import Articles from '../pages/Articles'
import ProductList from '../pages/ProductList'

Vue.use(VueRouter);

let router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/ozon',
            name: 'ozon',
            component: ProductList
        }
    ],
});


export default router;
