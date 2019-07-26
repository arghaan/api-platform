import Vue from 'vue'
import Vuex from 'vuex'
import ProductModule from './product'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        product: ProductModule
    }
})
