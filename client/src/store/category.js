import CategoryAPI from '../api/category';
import _ from 'lodash';

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
        message: null,
        categories: null,
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
        message(state){
            return state.message;
        },
        categories(state){
            return state.categories;
        }
    },
    mutations: {
        ['DOWNLOADING_CATEGORIES'](state) {
            state.isLoading = true;
            state.error = null;
        },
        ['DOWNLOADING_CATEGORIES_SUCCESS'](state) {
            state.isLoading = false;
            state.error = null;
        },
        ['DOWNLOADING_CATEGORIES_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error;
            /* eslint-disable no-console */
            console.log(error);
            /* eslint-enable no-console */
        },
        ['GETTING_CATEGORIES'](state) {
            state.isLoading = true;
            state.error = null;
            state.categories = [];
        },
        ['GETTING_CATEGORIES_SUCCESS'](state, items) {
            state.isLoading = false;
            state.error = null;
            state.categories = items;
        },
        ['GETTING_CATEGORIES_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error;
            state.categories = [];
            /* eslint-disable no-console */
            console.log(error);
            /* eslint-enable no-console */
        },
    },
    actions: {
        downloadCategories({commit, state}) {
            commit('DOWNLOADING_CATEGORIES');
            return CategoryAPI.downloadCategories()
                .then(res => {
                    state.message = res;
                    return commit('DOWNLOADING_CATEGORIES_SUCCESS')
                })
                .catch(err => commit('DOWNLOADING_CATEGORIES_ERROR', err));
        },

        getCategoryTree({commit}){
            commit('GETTING_CATEGORIES');
            return CategoryAPI.getCategoryTree()
                .then(res => {
                    return commit('GETTING_CATEGORIES_SUCCESS', res.data);
                })
                .catch(err => commit('GETTING_CATEGORIES_ERROR', err))
        }
    },
}
