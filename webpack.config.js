const webpack = require("webpack");
const path = require("path");

const CopyPlugin = require("copy-webpack-plugin");
const WorkboxPlugin = require("workbox-webpack-plugin");

process.env.APP_VERSION = require("./package.json").version;

module.exports = {
  mode: "production", //development production
  watch: false,
  entry: {
    index: "./src/scripts/index.js",
  },
  module: {
    rules: [
      {
        test: /\.scss$/,
        use: [
          {
            loader: "file-loader",
            options: {
              name: "bundle.min.css",
            },
          },
          {
            loader: "sass-loader",
            options: {
              implementation: require("sass"),
              sourceMap: true,
              sassOptions: {
                outputStyle: "compressed",
              },
            },
          },
        ],
      },
    ],
  },
  plugins: [
    new webpack.DefinePlugin({
      "process.env.ASSET_PATH": "public/",
    }),
    new CopyPlugin({
      patterns: [
        { from: "./src/index.php" },
        { from: "./src/robots.txt" },
        { from: "./src/.htaccess" },
        { from: "./src/m.webmanifest" },
        { from: "./src/favicon.ico" },
        { from: "./src/img", to: "img" },
      ],
    }),
    new WorkboxPlugin.GenerateSW({
      clientsClaim: true,
      skipWaiting: true,
      sourcemap: false,
      include: [/\.(?:html|css)$/],
    }),
  ],
  output: {
    filename: "bundle.js",
    path: path.resolve(__dirname, "public/"),
    clean: true,
  },
};
