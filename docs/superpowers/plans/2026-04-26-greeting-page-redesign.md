# greetingページ リデザイン 実装プラン

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** `greeting.blade.php` をTailwind CSS v4でスタイリングし、グラデーション背景＋ガラス風フォーム＋チャットバブル一覧のデザインに刷新する。

**Architecture:** 変更は `src/resources/views/greeting.blade.php` 1ファイルのみ。`@vite` ディレクティブでTailwind CSSを読み込み、既存のBladeテンプレート構造（`@forelse`、`@csrf`）はそのまま維持しながらクラスを付け替える。

**Tech Stack:** Laravel 13.x / Blade テンプレート / Tailwind CSS v4（`@tailwindcss/vite` プラグイン）

---

## ファイルマップ

| 操作 | パス |
|------|------|
| Modify | `src/resources/views/greeting.blade.php` |
| Create (test) | `src/tests/Feature/GreetingPageTest.php` |

---

### Task 1: greetingページのFeatureテストを書く

**Files:**
- Create: `src/tests/Feature/GreetingPageTest.php`

- [ ] **Step 1: テストファイルを作成する**

`src/tests/Feature/GreetingPageTest.php` を以下の内容で作成する：

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GreetingPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_greeting_page_returns_ok(): void
    {
        $response = $this->get('/greeting');

        $response->assertStatus(200);
    }

    public function test_greeting_page_contains_form(): void
    {
        $response = $this->get('/greeting');

        $response->assertSee('name="name"', false);
        $response->assertSee('name="message"', false);
        $response->assertSee('type="submit"', false);
    }

    public function test_greeting_page_shows_empty_state_when_no_greetings(): void
    {
        $response = $this->get('/greeting');

        $response->assertSee('まだあいさつがありません');
    }
}
```

- [ ] **Step 2: テストを実行して失敗することを確認する（現時点ではパスが期待値）**

コンテナ内で実行：
```bash
php artisan test tests/Feature/GreetingPageTest.php
```

期待: 3テストすべてPASS（現在のビューはHTMLとして正しく動作しているため）。この時点でPASSすることを確認しておくことで、リデザイン後も壊れていないことを担保できる。

- [ ] **Step 3: コミットする**

```bash
git add src/tests/Feature/GreetingPageTest.php
git commit -m "test: greetingページのFeatureテストを追加"
```

---

### Task 2: greeting.blade.php をリデザインする

**Files:**
- Modify: `src/resources/views/greeting.blade.php`

- [ ] **Step 1: ファイルを以下の内容に丸ごと置き換える**

```blade
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>あいさつ</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col items-center px-4 py-10"
      style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%)">

    {{-- ヘッダー --}}
    <div class="text-center mb-8">
        <h1 class="text-3xl font-extrabold text-white tracking-tight">✉️ あいさつページ</h1>
        <p class="text-white/60 text-sm mt-1">みんなで一言あいさつしよう</p>
    </div>

    {{-- フォームカード --}}
    <div class="w-full max-w-md bg-white/15 backdrop-blur-lg border border-white/20 rounded-2xl p-6 mb-8">
        <p class="text-xs font-bold text-white/70 uppercase tracking-widest mb-4">あいさつを送る</p>
        <form action="/greeting" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-xs font-semibold text-white/60 mb-1">名前</label>
                <input type="text" id="name" name="name" placeholder="名前を入力"
                       class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2.5 text-white placeholder-white/40 text-sm focus:outline-none focus:border-white/50">
            </div>
            <div class="mb-5">
                <label for="message" class="block text-xs font-semibold text-white/60 mb-1">メッセージ</label>
                <input type="text" id="message" name="message" placeholder="あいさつを入力"
                       class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2.5 text-white placeholder-white/40 text-sm focus:outline-none focus:border-white/50">
            </div>
            <button type="submit"
                    class="w-full bg-white text-purple-700 font-bold rounded-xl py-3 text-sm hover:bg-white/90 transition-colors">
                ✉ 送信する
            </button>
        </form>
    </div>

    {{-- 区切り --}}
    <div class="w-full max-w-md flex items-center gap-3 mb-6">
        <div class="flex-1 h-px bg-white/20"></div>
        <span class="text-xs font-semibold text-white/40">あいさつ一覧</span>
        <div class="flex-1 h-px bg-white/20"></div>
    </div>

    {{-- チャットバブル一覧 --}}
    <div class="w-full max-w-md flex flex-col gap-3">
        @forelse ($greetings as $greeting)
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-full bg-white/25 border-2 border-white/30 flex-shrink-0 flex items-center justify-center text-sm font-bold text-white">
                    {{ mb_substr($greeting->name, 0, 1) }}
                </div>
                <div class="bg-white/15 border border-white/20 rounded-tl-none rounded-2xl px-4 py-2.5 flex-1">
                    <p class="text-xs font-bold text-white/90 mb-0.5">{{ $greeting->name }}</p>
                    <p class="text-sm text-white">{{ $greeting->message }}</p>
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-white/40 text-sm border border-dashed border-white/20 rounded-2xl">
                まだあいさつがありません。
            </div>
        @endforelse
    </div>

</body>
</html>
```

- [ ] **Step 2: テストを実行してPASSすることを確認する**

コンテナ内で実行：
```bash
php artisan test tests/Feature/GreetingPageTest.php
```

期待: 3テストすべてPASS

- [ ] **Step 3: ブラウザで目視確認する**

`docker-compose up -d` でコンテナが起動している状態で `http://localhost/greeting` にアクセスし、以下を確認：
- グラデーション背景が表示される
- フォームカードがガラス風に表示される
- あいさつを投稿するとチャットバブル形式で一覧に表示される

※ Viteの開発サーバー（`npm run dev`）が起動していない環境では、`composer setup` でビルド済みアセットを使用すること。

- [ ] **Step 4: コミットする**

```bash
git add src/resources/views/greeting.blade.php
git commit -m "feat: greetingページをグラデーション+チャットバブルデザインにリデザイン"
```
