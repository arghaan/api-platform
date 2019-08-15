import axios from 'axios';

const config = {
    headers: {
        'X-AUTH-TOKEN': 'test_api_key',
    }
};
export default {
    async downloadCategories() {
        return axios.get('/api/ozon/category/download', config);
    },
    async getCategoryTree() {
        return axios.get('/api/category/tree', config);
    }
}
