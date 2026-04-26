# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## 概要

PHP 8.3 + nginx + MySQL による Laravel 13.x の Docker 開発環境。`src/` に Laravel プロジェクトが配置される。

## Docker 操作

```bash
# 開発環境起動・停止
docker-compose up -d
docker-compose down
docker-compose down -v  # ボリューム（DB）も削除

# コンテナに入る
docker-compose exec app bash

# 本番環境（Aurora MySQL 使用、ローカル DB なし）
docker-compose -f docker-compose.yml -f docker-compose.prod.yml up -d
```

## よく使うコマンド（コンテナ内で実行）

```bash
# 初回セットアップ（install → .env → key:generate → migrate → npm build）
composer setup

# テスト実行
composer test
# 単一テストファイル
php artisan test tests/Feature/ExampleTest.php

# コードフォーマット（Laravel Pint）
./vendor/bin/pint

# マイグレーション
php artisan migrate
php artisan migrate:fresh --seed

# Artisan コマンド全般
php artisan <command>
```

## アーキテクチャ

- **コンテナ構成**: `app`（PHP-FPM:9000）、`web`（nginx:80）、`db`（MySQL:3306）
- **ボリューム**: `./src` → コンテナ内 `/data`（app・web 共通マウント）
- **nginx**: `/data/public` をルートとし、`.php` リクエストを `app:9000` へ fastcgi プロキシ
- **フロントエンド**: Vite + Tailwind CSS v4。ポート 5173 をホストに公開

## Tailwind CSS v4 + Docker の注意点

コンテナ外からの HMR アクセスのため `vite.config.js` に以下の設定が必要：

```js
server: {
  host: "0.0.0.0",
  port: 5173,
  strictPort: true,
  hmr: { host: "localhost", port: 5173 },
}
```

## 環境変数

`.env.example`（リポジトリルート）をコピーして `.env` を作成。`src/.env` は Laravel 自体の設定。

本番環境では `DB_HOST`・`DB_PORT` を Aurora MySQL のエンドポイントに変更する（`docker-compose.prod.yml` で上書き）。
