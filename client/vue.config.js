module.exports = {
    devServer: {
        proxy: {
            '^/api': {
                target: 'api.localhost',
                ws: true,
                changeOrigin: true
            },
        },
        disableHostCheck: true
    }
};