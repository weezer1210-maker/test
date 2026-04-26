<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>あいさつ</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
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
                <div class="bg-white/15 border border-white/20 rounded-2xl rounded-tl-none px-4 py-2.5 flex-1">
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
