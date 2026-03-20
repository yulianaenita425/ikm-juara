<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - IKM Juara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-900 flex items-center justify-center min-h-screen p-6">
    
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-indigo-600/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-purple-600/20 rounded-full blur-[120px]"></div>
    </div>

    <div class="w-full max-w-md bg-white/10 backdrop-blur-xl border border-white/10 p-10 rounded-[40px] shadow-2xl">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-black text-white italic tracking-tighter mb-2 uppercase">IKM<span class="text-yellow-500">JUARA</span></h1>
            <p class="text-slate-400 text-sm font-semibold tracking-widest uppercase">Admin Central Control</p>
        </div>

        <form action="/admin/dashboard" method="GET" class="space-y-6">
            <div>
                <label class="block text-xs font-bold text-slate-300 uppercase tracking-widest mb-3">Username</label>
                <input type="text" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" placeholder="Masukkan username...">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-300 uppercase tracking-widest mb-3">Password</label>
                <input type="password" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" placeholder="••••••••">
            </div>
            
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-indigo-500/30 transition-all transform active:scale-95">
                MASUK KE DASHBOARD
            </button>
        </form>

        <div class="mt-8 text-center">
            <a href="/" class="text-xs text-slate-500 hover:text-white transition uppercase font-bold tracking-widest">← Kembali ke Website Utama</a>
        </div>
    </div>

</body>
</html>