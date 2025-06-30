const path = require('path');
const glob = require('glob');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const MiniCssExtractPlugin  = require('mini-css-extract-plugin');

module.exports = (env, argv) => {
  const isProd = argv.mode === 'production';

  // 1) Bazowe entry
  const entries = {
    scripts: path.resolve(__dirname, 'resources/js/scripts.js'),
    styles:  path.resolve(__dirname, 'resources/scss/styles.scss'),
  };

  // 2) Automatyczne wykrywanie bloków JS
  glob.sync('blocks/*/index.js', { cwd: __dirname }).forEach(relPath => {
    const name = path.basename(path.dirname(relPath)); 
    entries[name] = path.resolve(__dirname, relPath);
  });


  return {
    entry: entries,
    output: {
      filename: 'js/[name].js',
      path: path.resolve(__dirname, 'assets'),
      publicPath: '',
    },
    module: {
      rules: [
        {
          test: /\.m?js$/,
          exclude: /node_modules/,
          use: {
            loader: 'babel-loader',
            options: { presets: ['@babel/preset-env'] },
          },
        },
        {
          test: /\.(sa|sc|c)ss$/,
          use: [
            MiniCssExtractPlugin.loader,
            {
              loader: 'css-loader',
              options: {
                importLoaders: 2,
                modules: {
                  auto: true,
                  localIdentName: isProd
                    ? '[hash:base64]'
                    : '[path][name]__[local]',
                },
              },
            },
            {
              loader: 'postcss-loader',
              options: {
                postcssOptions: {
                  plugins: [ require('autoprefixer')() ],
                },
              },
            },
            'sass-loader',
          ],
        },
      ],
    },
    plugins: [
      new CleanWebpackPlugin({
        cleanOnceBeforeBuildPatterns: [
          path.resolve(__dirname, 'assets/js'),
          path.resolve(__dirname, 'assets/css'),
        ],
      }),
      new MiniCssExtractPlugin({
        filename: 'css/[name].css',
      }),
    ],
    // watch całego katalogu blocks oraz resources/scss i resources/js
    watchOptions: {
      ignored: /node_modules/,
      aggregateTimeout: 300,
      poll: 1000,
    },
    devtool: isProd ? false : 'source-map',
  };
};
