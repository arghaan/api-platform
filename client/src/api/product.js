import axios from 'axios';

const config = {
    headers: {
        'X-AUTH-TOKEN': 'test_api_key',
    }
};
export default {
    downloadProducts() {
        return axios.get('/api/ozon/product/download', config);
    },
}
