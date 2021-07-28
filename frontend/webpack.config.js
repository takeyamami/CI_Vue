
const path = require("path");

module.exports = {
  // エントリポイントのファイル
  entry: "./src/index.js",
  output: {
    // 出力先のディレクトリ
    path: path.resolve(__dirname, "./dist"),
    // 出力ファイル名
    filename: "bundle.js",
  },
  devServer: {
    // webpackの扱わないファイル(HTMLや画像など)が入っているディレクトリ
    contentBase: path.resolve(__dirname, "public"),
  },
};