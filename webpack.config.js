/**
 * External dependencies
 */
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );
const WebpackRTLPlugin = require( 'webpack-rtl-plugin' );
const path = require( 'path' );

/**
 * WordPress dependencies
 */
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const isProduction = defaultConfig.mode === 'production';

const config = {
	...defaultConfig,
	plugins: [
		...defaultConfig.plugins,
		new WebpackRTLPlugin( {
			suffix: '-rtl',
			minify: isProduction ? { safe: true } : false,
		} ),
		new MiniCssExtractPlugin(),
	],
	module: {
		...defaultConfig.module,
		rules: [
			...defaultConfig.module.rules,
			{
				test: /.svg$/,
				issuer: /\.js$/,
				use: [
					{
						loader: 'svg-react-loader',
					},
				],
			},
			{
				test: /\.(png|jpe?g|gif)$/,
				issuer: /\.js$/,
				use: [
					{
						loader: 'file-loader',
						options: {
							name: 'images/[name].[ext]',
							publicPath: '../',
						},
						loader: 'base64-inline-loader',
					},
				],
			},
			{
				test: /\.s?css$/,
				use: [
					{
						loader: MiniCssExtractPlugin.loader,
						options: {
							hmr: ! isProduction,
						},
					},
					'css-loader',
					'postcss-loader',
					'sass-loader',
				],
			},
		],
	},
};

module.exports = [

	{
		...config,
		entry: {
			blocks: './packages/blocks/index.js',
			public: './assets/src/js/public/public.js',
		},
		output: {
			path: path.resolve( __dirname, './assets/dist/' ),
		}
	},

];

