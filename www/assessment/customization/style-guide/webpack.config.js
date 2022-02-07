/* globals require, __dirname */
const path = require('path');
const webpack = require('webpack');
const autoprefixer = require('autoprefixer');

const appDir = path.resolve(__dirname, 'src/');
const distDir = path.resolve(__dirname, 'dist/');

module.exports = {
    context: appDir,
    mode: 'development',
    devtool: 'eval-source-map',
    entry: {
        app: './index.js',
    },
    watchOptions: {
        ignored: ['node_modules'],
        aggregateTimeout: 300,
        poll: true,
    },
    output: {
        path: distDir,
        filename: '[name].js',
        chunkLoadingGlobal: 'GACStyleGuide',
        devtoolModuleFilenameTemplate: 'gac://[resource-path]',
        devtoolFallbackModuleFilenameTemplate: 'gac://[resource-path]?[contenthash]',
    },
    plugins: [
        new webpack.ProgressPlugin()
    ],
    resolve: {
        modules: [
            path.resolve(__dirname, 'src'),
            'node_modules',
        ],
        extensions: ['.jsx', '.js'],
    },
    optimization: {
        splitChunks: {
            // include all types of chunks
            chunks: 'all',
            minChunks: 3,
            automaticNameDelimiter: '~',
            cacheGroups: {
                vendors: {
                    test: /[\\/]node_modules[\\/]/,
                    priority: -10,
                },
            },
        },
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: [{
                    loader: 'babel-loader',
                    options: {
                        presets: [
                            '@babel/preset-env', '@babel/preset-react'
                        ],
                        plugins: [
                            'lodash',
                            '@babel/plugin-transform-react-jsx',
                            '@babel/plugin-proposal-class-properties',
                            '@babel/plugin-proposal-object-rest-spread',
                        ],
                    }
                }   ],
            },
            {
                test: /\.scss$/i,
                use: [
                    'style-loader',
                    'css-loader',
                    'sass-loader',
                    {
                        loader: 'postcss-loader',
                        options: {
                            postcssOptions: {
                                plugins: [
                                    autoprefixer,
                                ],
                            },
                        },
                    }
                ],
            },
        ],
    },
};
