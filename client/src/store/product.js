import ProductAPI from '../api/product';
import _ from 'lodash';

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
        items: [],
        categories: [],
        total: 0,
        pagination: {
            // itemsPerPage: 7,
            // page: 1
        }
    },
    getters: {
        isLoading(state) {
            return state.isLoading;
        },
        hasError(state) {
            return state.error !== null;
        },
        error(state) {
            return state.error;
        },
        hasProducts(state) {
            return state.items.length > 0;
        },
        products(state) {
            return state.items;
        },
        categories(state) {
            return state.categories;
        },
        total(state) {
            return state.total;
        },
        pagination(state) {
            return state.pagination;
        }
    },
    mutations: {
        ['CREATING_PRODUCT'](state) {
            state.isLoading = true;
            state.error = null;
        },
        ['CREATING_PRODUCT_SUCCESS'](state, product) {
            state.isLoading = false;
            state.error = null;
            state.items.unshift(product);
        },
        ['CREATING_PRODUCT_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error;
            state.items = [];
        },
        ['FETCHING_PRODUCTS'](state) {
            state.isLoading = true;
            state.error = null;
            state.items = [];
        },
        ['FETCHING_PRODUCTS_SUCCESS'](state, items) {
            state.isLoading = false;
            state.error = null;
            state.items = items.products;
            state.total = items.total;
        },
        ['FETCHING_PRODUCTS_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error;
            state.items = [];
            /* eslint-disable no-console */
            console.log(error);
            /* eslint-enable no-console */
        },
        ['FETCHING_CATEGORIES'](state) {
            state.isLoading = true;
            state.error = null;
            state.categories = [];
        },
        ['FETCHING_CATEGORIES_SUCCESS'](state, items) {
            // state.isLoading = false;
            state.error = null;
            state.categories = items;
        },
        ['FETCHING_CATEGORIES_ERROR'](state, error) {
            // state.isLoading = false;
            state.error = error;
            state.categories = [];
            /* eslint-disable no-console */
            console.log(error);
            /* eslint-enable no-console */
        },
        ['UPDATE_PAGINATION'](state, pagination) {
            state.pagination = pagination;
        }
    },
    actions: {
        // createProduct ({commit}, message) {
        // commit('CREATING_PRODUCT');
        // return ProductAPI.create(message)
        //     .then(res => commit('CREATING_PRODUCT_SUCCESS', res.data))
        //     .catch(err => commit('CREATING_PRODUCT_ERROR', err));
        // },
        fetchProducts({commit, state}) {
            commit('FETCHING_PRODUCTS');
            return ProductAPI.getAll()
                .then(async (res) => {
                    let products = [];
                    for (const value of res.data.result.items) {
                        await ProductAPI.get(value.product_id)
                            .then(res => {
                                let product = res.data.result;
                                product.price = _.round(product.price) + '.00';
                                let category = state.categories.filter(category => category.category_id === product.category_id)[0];
                                product.category_title = typeof category === "undefined" ? 'N/A' : category.title;
                                return products.push(product);
                            })
                            .catch(err => commit('FETCHING_PRODUCTS_ERROR', err));
                    }
                    return commit('FETCHING_PRODUCTS_SUCCESS', {
                        'products': products,
                        'total': res.data.result.total
                    });
                })
                .catch(err => commit('FETCHING_PRODUCTS_ERROR', err));
        },
        fetchCategories({commit}) {
            commit('FETCHING_CATEGORIES');
            return ProductAPI.getCategories()
                .then(res => {
                    let categories = [];
                    res.data.result.forEach(value => {
                        (function recurse(currentNode) {
                            if (currentNode.children.length === 0) {
                                categories.push({
                                    category_id: currentNode.category_id,
                                    title: currentNode.title
                                });
                                return;
                            }
                            for (let i = 0; i < currentNode.children.length; i++) {
                                recurse(currentNode.children[i]);
                            }
                        })(value);
                    });
                    return commit('FETCHING_CATEGORIES_SUCCESS', categories)
                })
                .catch(err => commit('FETCHING_CATEGORIES_ERROR', err));
        },
        async updatePagination({commit, dispatch, state}, pagination) {
            commit('UPDATE_PAGINATION', pagination);
            if (state.categories.length === 0){
                await dispatch('fetchCategories');
            }
            dispatch('fetchProducts');
        },
    },
}
