const path = require("path");

module.exports = {
    entry: "./resources/js/app.js",
    output: {
        filename: "bundle.js",
        path: path.resolve(__dirname, "public/js"),
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: "babel-loader",
                    options: {
                        presets: ["@babel/preset-env"],
                    },
                },
            },
        ],
    },
    devServer: {
        // ...
        static: {
            directory: path.join(__dirname, "public"),
            serveIndex: true,
            staticOptions: {
                extensions: ["html", "js"],
                index: ["index.html"],
                setHeaders: function (res, path, stat) {
                    res.set("Content-Type", "application/javascript");
                },
            },
        },
    },
};

// const path = require("path");

// module.exports = {
//     entry: "./resources/js/app.js",
//     output: {
//         filename: "bundle.js",
//         path: path.resolve(__dirname, "public/js"),
//     },
//     module: {
//         rules: [
//             {
//                 test: /\.js$/,
//                 exclude: /node_modules/,
//                 use: {
//                     loader: "babel-loader",
//                     options: {
//                         presets: ["@babel/preset-env"],
//                     },
//                 },
//             },
//         ],
//     },
// };

// module.exports = {
//     // ...
//     devServer: {
//       // ...
//       mimeTypes: {
//         'js': 'application/javascript',
//       },
//     },
//   };
