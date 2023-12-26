# Laravel + Vue + Docker

## 新規プロジェクトのセットアップ

以下のコマンドを順番に実行：

1. `make up` - Docker コンテナを起動
2. `make vue-install` - Vue.js をインストール
3. `make npm-i` - npm パッケージをインストール
4. `make npm-d` - npm run dev
5. `make laravel-create` - Laravel プロジェクトを作成

## 既存のプロジェクトのセットアップ

以下のコマンドを順番に実行：

1. `git clone` - リポジトリをクローン
2. `make up` - Docker コンテナを起動
3. `make npm-i` - npm パッケージをインストール
4. `make npm-d` - npm run dev
5. `laravel-install` - Laravel の依存関係をインストール
