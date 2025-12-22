# AIBASE 開発環境構築手順

## 概要

AIBASEは、ITフリーランスエンジニア向けの案件・求人サイトです。

- **フレームワーク**: Laravel 8.x
- **フロントエンド**: Vue 3 + Laravel Mix
- **データベース**: MySQL

---

## 必要な環境

### PHPバージョン

| 環境 | バージョン | 備考 |
|------|-----------|------|
| 要件 | PHP 7.3 〜 8.1 | composer.jsonで `"php": "^7.3\|^8.0"` と定義 |
| 推奨 | PHP 8.0 | 安定性とパフォーマンスのバランス |
| 本番(ロリポップ) | PHP 7.4 | `/usr/local/bin/php7.4` |

### Node.js / npm

| ツール | 推奨バージョン | 確認済みバージョン |
|--------|---------------|-------------------|
| Node.js | 14.x 以上 | v24.11.1 |
| npm | 6.x 以上 | 11.6.2 |

### Composer

| ツール | 要件 |
|--------|------|
| Composer | 2.x 必須（1.xでは動作しない） |

---

## ローカル開発環境構築

### 1. リポジトリのクローン

```bash
git clone <repository-url>
cd aibase
```

### 2. 環境設定ファイルの作成

```bash
cp .env.example .env
```

`.env` を編集してローカル環境に合わせて設定：

```env
APP_NAME=AIBASE
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aibase
DB_USERNAME=root
DB_PASSWORD=root
```

### 3. Composerパッケージのインストール

```bash
composer install
```

### 4. アプリケーションキーの生成

```bash
php artisan key:generate
```

### 5. データベースのマイグレーション

```bash
php artisan migrate
php artisan db:seed  # 初期データを投入する場合
```

### 6. npmパッケージのインストール

```bash
npm install --legacy-peer-deps
```

> **注意**: `--legacy-peer-deps` オプションが必要です（vue-swalとVue 3の依存関係競合のため）

### 7. アセットのビルド

```bash
# 開発用（ウォッチモード）
npm run dev

# または開発用（ウォッチ＋自動リビルド）
npm run build

# 本番用（最適化）
npm run production
```

### 8. ストレージリンクの作成

```bash
php artisan storage:link
```

### 9. 開発サーバーの起動

```bash
php artisan serve
```

ブラウザで http://localhost:8000 にアクセス

---

## 本番環境デプロイ（ロリポップ）

### サーバー情報

| 項目 | 値 |
|------|-----|
| ドメイン | tec-aibase.com |
| PHPバージョン | 7.4 |
| PHPパス | `/usr/local/bin/php7.4` |
| プロジェクトパス | `/home/users/2/lolipop.jp-8265154f15388014/web/aibase` |

### デプロイ手順

#### 1. ローカルでアセットをビルド

```bash
npm run production
```

#### 2. Gitでプッシュ

```bash
git add .
git commit -m "Build assets for production"
git push
```

#### 3. サーバーでプル

```bash
cd /home/users/2/lolipop.jp-8265154f15388014/web/aibase
git pull
```

#### 4. 環境設定

```bash
cp .env.product.dev .env
```

#### 5. Composerインストール（初回のみ）

```bash
/usr/local/bin/php7.4 composer.phar install --optimize-autoloader --no-dev
```

#### 6. マイグレーション

```bash
/usr/local/bin/php7.4 artisan migrate
```

#### 7. キャッシュ設定

```bash
/usr/local/bin/php7.4 artisan config:cache
/usr/local/bin/php7.4 artisan route:cache
/usr/local/bin/php7.4 artisan view:cache
```

#### 8. ストレージリンク作成

```bash
/usr/local/bin/php7.4 artisan storage:link
```

#### 9. パーミッション設定

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

---

## データベース設定

### ローカル開発

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aibase
DB_USERNAME=root
DB_PASSWORD=root
```

### 本番環境（ロリポップ）

```env
DB_CONNECTION=mysql
DB_HOST=mysql321.phy.lolipop.lan
DB_PORT=3306
DB_DATABASE=<作成したDB名>
DB_USERNAME=<DBユーザー名>
DB_PASSWORD=<DBパスワード>
```

---

## ログイン情報（開発用）

| ロール | URL | メール | パスワード |
|--------|-----|--------|-----------|
| システム管理者 | /system/login | system@gmail.com | 12345678 |
| 管理者 | /admin/login | admin@gmail.com | 12345678 |
| ユーザー | /login | user@gmail.com | 12345678 |

---

## トラブルシューティング

### npm install でエラーが出る

```bash
npm install --legacy-peer-deps
```

### Composer でエラーが出る（ロリポップ）

Composer 2.x が必要です。プロジェクト内の `composer.phar` を使用：

```bash
/usr/local/bin/php7.4 composer.phar install
```

### 定数の二重定義エラー

`config/constants.php` の定数定義に `defined()` チェックが入っているか確認。

### Carbonエラー

Carbonパッケージを更新：

```bash
composer update nesbot/carbon --with-dependencies
```

---

## ディレクトリ構成（主要）

```
aibase/
├── app/                    # アプリケーションコード
│   ├── Http/Controllers/   # コントローラー
│   ├── Mail/               # メールクラス
│   └── ...
├── config/                 # 設定ファイル
├── database/               # マイグレーション、シーダー
├── public/                 # 公開ディレクトリ（ドキュメントルート）
│   ├── css/                # ビルドされたCSS
│   ├── js/                 # ビルドされたJS
│   └── ...
├── resources/
│   ├── js/                 # Vueコンポーネント
│   ├── sass/               # SCSSファイル
│   └── views/              # Bladeテンプレート
├── routes/                 # ルート定義
├── storage/                # ログ、キャッシュ、アップロード
├── .env.example            # 環境設定サンプル
├── .env.dev                # 開発環境設定
├── .env.product.dev        # 本番環境設定
├── composer.json           # PHP依存関係
├── package.json            # Node.js依存関係
└── webpack.mix.js          # Laravel Mix設定
```

---

## 更新履歴

| 日付 | 内容 |
|------|------|
| 2025-12-22 | 初版作成。ATSUMARE → AIBASE 改名対応 |
