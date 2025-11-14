const path = require('path');

module.exports = {
  entry: {
    // pintura: '@pqina/pintura',
    // filePondPlugin: '@pqina/filepond-plugin-image-editor',
    pintura: './resources/main.js'
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, 'public/js'),
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env'],
          },
        },
      },
    ],
  },
};