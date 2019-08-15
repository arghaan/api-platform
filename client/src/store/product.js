import ProductAPI from '../api/product';

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
        items: [],
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
        ['UPDATE_PAGINATION'](state, pagination) {
            state.pagination = pagination;
        }
    },
    actions: {
        downloadProducts({commit}) {
            commit('FETCHING_PRODUCTS');
            return ProductAPI.downloadProducts()
                .then(async (res) => {
                    return commit('FETCHING_PRODUCTS_SUCCESS', {
                        'products': res.data.result,
                        'total': res.data.result.total
                    });
                })
                .catch(err => commit('FETCHING_PRODUCTS_ERROR', err));
        },
    },
}
