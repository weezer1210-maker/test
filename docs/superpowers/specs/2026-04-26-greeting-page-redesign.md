# greetingページ リデザイン仕様

## 概要

`resources/views/greeting.blade.php` にTailwind CSS v4 を用いたスタイリングを施し、グラデーション背景＋ガラス風フォーム＋チャットバブル一覧のデザインに刷新する。

## スタイル方針

- **背景**: 紫〜青のグラデーション（`#667eea` → `#764ba2`）で画面全体を覆う
- **フォームカード**: 半透明ガラス風（`bg-white/15 backdrop-blur-lg`）、白文字ラベル、白い送信ボタン
- **あいさつ一覧**: 名前の頭文字をアバターとしたチャットバブル形式

## コンポーネント構成

### ページヘッダー
- タイトル「✉️ あいさつページ」を中央配置、白文字・太字
- サブテキスト「みんなで一言あいさつしよう」をやや透明な白で表示

### フォームカード
- `backdrop-blur` + `bg-white/15` + `border border-white/20` + `rounded-2xl` でガラスカード
- 「名前」「メッセージ」の2フィールド（`input` タグ）
- 送信ボタン: `bg-white text-purple-700 w-full rounded-xl font-bold`

### 区切り線
- `---あいさつ一覧---` の区切りをdivider形式で表示

### チャットバブル一覧
- 各エントリに名前の頭文字アバター（`rounded-full bg-white/25`）＋バブル（`bg-white/15 rounded-tl-none rounded-2xl`）
- 名前を太字小文字で表示し、メッセージを下段に配置
- `@forelse` でデータなし時は「まだあいさつがありません」をdashed borderのボックスで表示

## 実装スコープ

- 変更ファイル: `src/resources/views/greeting.blade.php` のみ
- `@vite(['resources/css/app.css', 'resources/js/app.js'])` を `<head>` に追加してTailwindを読み込む
- 新規ファイル・ルート・モデルの追加なし
- JavaScriptなし

## 制約

- Tailwind CSS v4（`@tailwindcss/vite` プラグイン経由）を使用
- コンテナ内でViteがビルド済みの場合は `build/manifest.json` 経由で配信される
- ダークモード対応は今回スコープ外
