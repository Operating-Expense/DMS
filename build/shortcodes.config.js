const baseConfig = require('./_basic.config')();
const path = require('path');
const glob = require('glob');
let dir = path.resolve();

const pathTo = dir.replace(/\\/g, '/') + '/app/Shortcodes/';
//read all styles.scss from shortcodes
const stylesArray = glob.sync(pathTo + '**/assets/style.scss');

let assetsObject = stylesArray.reduce((acc, item) => {
	let name = item.replace(pathTo, '');
	name = name.replace('/assets/style.scss', '');
	acc[name] = new Array(item);
	return acc;
}, {});

//read all scripts.js from shortcodes
const scriptsArray = glob.sync(pathTo + '**/assets/scripts.js');
scriptsArray.reduce((acc, item) => {

	let name = item.replace(pathTo, '');
	name = name.replace('/assets/scripts.js', '');
	if (Array.isArray(assetsObject[name]) === true) {
		assetsObject[name].push(item);
	} else {
		assetsObject[name] = new Array(item);
	}
}, {});

// include the css extraction and minification plugins
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

baseConfig.plugins.push(
	new MiniCssExtractPlugin({
		filename: './dist/css/shortcode-[name].css'
	})
);
baseConfig.output = {
	path: dir,
	filename: './dist/js/shortcode-[name].min.js'
};


const fs = require('fs');
console.log('@@@@@@@@@@@@@@@@@@@@1111');	
if (process.env.SYNC === "true" && fs.existsSync('./build/browser-sync.config.js') && !process.isBrowserSyncAdded) {
	console.log('@@@@@@@@@@@@@@@@@@@@2222');
	const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
	const config = require('./browser-sync.config');
	
	baseConfig.plugins.push(new BrowserSyncPlugin(config));
	process.isBrowserSyncAdded = true;
}

module.exports = Object.assign(
	{
		name: 'shortcodes',
		entry: assetsObject,
	},
	baseConfig
);
