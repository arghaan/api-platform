import axios from 'axios';
import apiConfig from '../../api.config';
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
    getAll () {
        return axios.get(apiConfig.url + 'v1/products/list', config);
    },
    get (productID) {
        // console.log(productID);
        return axios.post(apiConfig.url + 'v1/product/info', {"product_id": productID}, config)
    },
}
