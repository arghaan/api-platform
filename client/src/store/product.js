import ProductAPI from '../api/product';

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
        items: [],
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
            state.items = items;
        },
        ['FETCHING_PRODUCTS_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error;
            state.items = [];
        },
    },
    actions: {
        // createProduct ({commit}, message) {
        // commit('CREATING_PRODUCT');
        // return ProductAPI.create(message)
        //     .then(res => commit('CREATING_PRODUCT_SUCCESS', res.data))
        //     .catch(err => commit('CREATING_PRODUCT_ERROR', err));
        // },
        fetchProducts({commit}) {
            commit('FETCHING_PRODUCTS');
            return ProductAPI.getAll()
                .then(async (res) => {
                    let products = [];
                    for (const value of res.data.result) {
                        await ProductAPI.get(value.product_id)
                            .then(res => products.push(res.data.result))
                            .catch(err => commit('FETCHING_PRODUCTS_ERROR', err));
                    }
                    return commit('FETCHING_PRODUCTS_SUCCESS', products);
                })
                .catch(err => commit('FETCHING_PRODUCTS_ERROR', err));
        },
    },
}
