const webpack = require("webpack");
const path = require("path");
const Copy = require("copy-webpack-plugin");
const Workbox = require("workbox-webpack-plugin");

module.exports = function (_env, argv) {
  const APP_NAME = argv.name ?? "app";
  const IS_PRODUCTION = argv.mode === "production";
  const IS_WATCHING = argv.watch === "yes";

  return {
    mode: IS_PRODUCTION ? "production" : "development",
    watch: IS_WATCHING,
    entry: "./src/scripts/index.ts",
    output: {
      filename: "bundle.min.js",
      path: path.resolve(__dirname, "public"),
      clean: !IS_PRODUCTION,
    },
    module: {
      rules: [
        {
          test: /\.tsx?$/,
          use: "ts-loader",
          exclude: /node_modules/,
        },
        {
          test: /\.(sa|c|sc)ss$/,
          exclude: /node_modules/,
          type: "asset/resource",
          generator: {
            filename: "bundle.min.css",
          },
          use: [
            {
              loader: "sass-loader",
              options: {
                implementation: require.resolve("sass"),
                sassOptions: {
                  outFile: "bundle.min.css",
                  outputStyle: IS_PRODUCTION ? "compressed" : "expanded",
                  sourceComments: !IS_PRODUCTION,
                  sourceMap: !IS_PRODUCTION,
                  omitSourceMapUrl: !IS_PRODUCTION,
                  sourceMapEmbed: !IS_PRODUCTION,
                  //indentedSyntax: !IS_PRODUCTION,
                },
              },
            },
          ],
        },
      ],
    },
    resolve: {
      extensions: [".tsx", ".ts", ".js"],
    },
    plugins: [
      new Copy({
        patterns: [
          {
            from: path.resolve(__dirname, "src/img"),
            to: "img",
          },
          {
            from: path.resolve(__dirname, "src", "favicon.ico"),
          },
          {
            from: path.resolve(__dirname, "src", "robots.txt"),
          },
          {
            from: path.resolve(__dirname, "src", ".htaccess"),
          },
          {
            from: path.resolve(__dirname, "src", "index.php"),
          },
        ],
      }),
      new Workbox.GenerateSW({
        mode: IS_PRODUCTION ? "production" : "development",
        cacheId: "pwa",
        swDest: "service-worker.js",
        navigateFallback: "/",
        clientsClaim: true,
        skipWaiting: true,
        cleanupOutdatedCaches: true,
        offlineGoogleAnalytics: true,
        sourcemap: !IS_PRODUCTION,
        include: [],
        runtimeCaching: [
          {
            urlPattern: !IS_PRODUCTION
              ? "/^(?![sS])/"
              : /^http(s?)([:\/\\]+)(\w+).(\w+)([\/\w-]+)$/,
            handler: "NetworkFirst",
            options: {
              cacheName: APP_NAME.toLowerCase() + "-pages",
              expiration: {
                maxEntries: 10,
              },
            },
          },
          {
            urlPattern: /([\/:.\w]+)([.])(?:js|css|webmanifest|html|txt)(.)?/,
            handler: "CacheFirst",
            options: {
              cacheName:
                APP_NAME +
                "-" +
                (IS_PRODUCTION ? "production" : "development").toLowerCase(),
            },
          },
          {
            urlPattern: /([\/:.\w]+)([.])(?:txt|png|jpg|jpeg|webp|svg)(.)?/,
            handler: "CacheFirst",
            options: {
              cacheName: APP_NAME.toLowerCase() + "-images",
            },
          },
          {
            urlPattern: new RegExp("https://fonts.(googleapis|gstatic).com"),
            handler: "CacheFirst",
            options: {
              cacheName: APP_NAME.toLowerCase() + "-google-fonts",
            },
          },
        ],
        additionalManifestEntries: [],
      }),
    ],
  };
};
