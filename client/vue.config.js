module.exports = {
    devServer: {
        proxy: {
            '^/api/': {
                target: 'http://api.syrius.local',
                ws: true,
                changeOrigin: true
            },
            '^/ozon-api/': {
                target: 'http://api-seller.ozon.ru:80',
                ws: true,
                changeOrigin: true
            }
        },
        disableHostCheck: true,
        public: 'syrius.local',
        port: '8000'
    }
};
