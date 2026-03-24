<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - IKM Juara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #0f172a; /* Slate 900 untuk kontras glassmorphism */
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .input-glass {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        .input-glass:focus {
            border-color: #6366f1;
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 overflow-hidden">

    <div class="absolute top-0 left-0 w-full h-full -z-10">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-indigo-600/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-amber-500/10 rounded-full blur-[120px]"></div>
    </div>

    <div class="w-full max-w-md relative">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-black italic tracking-tighter text-white uppercase">
                IKM<span class="text-amber-500">JUARA</span>
            </h2>
            <p class="text-[10px] font-bold tracking-[0.3em] text-slate-400 mt-2 uppercase">Secure Administrator Portal</p>
        </div>

        <div class="glass-card rounded-[40px] p-10 relative overflow-hidden">
            <div class="mb-8 text-center relative z-10">
                <h1 class="text-xl font-bold text-white">Selamat Datang</h1>
                <p class="text-xs text-slate-400 font-medium mt-1">Silakan masuk dengan akun Anda</p>
            </div>

            @if(session('error'))
                <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-2xl text-xs font-bold text-center animate-pulse">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5 relative z-10">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Username</label>
                    <div class="relative">
                        <input type="text" name="username" required autofocus
                            class="w-full input-glass rounded-2xl px-5 py-4 text-sm font-bold text-white outline-none placeholder:text-slate-600"
                            placeholder="admin">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full input-glass rounded-2xl px-5 py-4 text-sm font-bold text-white outline-none placeholder:text-slate-600"
                        placeholder="bolodewo44">
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-bold text-sm shadow-xl shadow-indigo-900/20 hover:bg-indigo-500 transition duration-300 transform hover:-translate-y-1 active:scale-95 uppercase tracking-wider">
                        Masuk Ke Panel
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-8 text-center space-y-4">
            <p class="text-[10px] text-slate-600 font-medium italic">
                &copy; 2026 Pemerintah Kota Madiun. All rights reserved. / Developed by Bidang Perindustrian.
            </p>
        </div>
    </div>

</body>
</html>