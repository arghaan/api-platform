import ProductAPI from '../api/product';

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
        products: [],
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
            // return state.items.length > 0;
        },
        products(state) {
            return state.products;
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
            state.products.unshift(product);
        },
        ['CREATING_PRODUCT_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error;
            state.products = [];
        },
        ['FETCHING_PRODUCTS'](state) {
            state.isLoading = true;
            state.error = null;
            state.products = [];
        },
        ['FETCHING_PRODUCTS_SUCCESS'](state, products) {
            state.isLoading = false;
            state.error = null;
            state.products = products;
            state.total = products.total;
        },
        ['FETCHING_PRODUCTS_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error;
            state.products = [];
            /* eslint-disable no-console */
            console.log(error);
            /* eslint-enable no-console */
        },
        ['UPDATE_PAGINATION'](state, pagination) {
            state.pagination = pagination;
        }
    },
    actions: {
        getProducts({commit}) {
            commit('FETCHING_PRODUCTS');
            return ProductAPI.getProducts()
                .then(async (res) => {
                    return commit('FETCHING_PRODUCTS_SUCCESS', res.data);
                })
                .catch(err => {
                    console.log(err);
                    commit('FETCHING_PRODUCTS_ERROR', err)
                });
        },
        updatePagination(){

        }
    },
}
