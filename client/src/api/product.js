import axios from 'axios';
import apiConfig from '../../api.config';
import store from "../store/index";

const config = {
    headers: {
        'Client-Id': apiConfig.clientId,
        'Api-Key': apiConfig.apiKey,
        'Content-Type': apiConfig.contentType
    }
};
export default {
    // create (message) {
    // return axios.post(
    //     '/api/post/create',
    //     {
    //         message: message,
    //     }
    // );
    // },
    getAll() {
        const data = {
            page: store.getters['product/pagination'].page,
            page_size: store.getters['product/pagination'].itemsPerPage,
        };
        return axios.post(apiConfig.url + 'v1/product/list', data, config);
    },
    get(productID) {
        return axios.post(apiConfig.url + 'v1/product/info', {"product_id": productID}, config)
    },
    async getCategories() {
        return axios.post(apiConfig.url + 'v1/category/tree', {}, config);
    }
}
