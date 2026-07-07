<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - Sasak Sade</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-gradient-to-br from-[#061a40] via-[#082354] to-[#0d3f63] text-white">
    <div class="flex min-h-screen items-center justify-center px-4 py-10">
        <div class="grid w-full max-w-6xl grid-cols-1 gap-8 overflow-hidden rounded-[2rem] bg-white/10 shadow-2xl shadow-[#00000080] backdrop-blur-xl ring-1 ring-white/10 lg:grid-cols-[0.95fr_0.85fr]">
            <div class="hidden flex-col justify-between bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.12),_transparent_45%),linear-gradient(180deg,_#082354_0%,_#061a40_100%)] px-8 py-10 text-white lg:flex">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-[#81c784]">Admin Dashboard</p>
                    <h2 class="mt-6 text-5xl font-semibold">Kelola Wisata Sasak Sade</h2>
                    <p class="mt-5 max-w-lg text-sm text-[#c8d5ff]">Akses cepat untuk mengelola paket wisata, event, galeri, dan pesanan booking. Pastikan data desa wisata selalu terbarui.</p>
                </div>
                <div class="space-y-4 rounded-[1.75rem] border border-white/10 bg-white/10 p-6">
                    <div class="flex items-center gap-3 rounded-2xl bg-white/5 p-4">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#81c784]/20 text-[#81c784]">1</div>
                        <div>
                            <p class="text-sm font-semibold">Manajemen Paket</p>
                            <p class="text-xs text-[#c8d5ff]">Tambahkan, edit, dan hapus paket wisata.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 rounded-2xl bg-white/5 p-4">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#81c784]/20 text-[#81c784]">2</div>
                        <div>
                            <p class="text-sm font-semibold">Booking & Pesanan</p>
                            <p class="text-xs text-[#c8d5ff]">Tinjau riwayat booking dan status pembayaran.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 rounded-2xl bg-white/5 p-4">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#81c784]/20 text-[#81c784]">3</div>
                        <div>
                            <p class="text-sm font-semibold">Galeri & Event</p>
                            <p class="text-xs text-[#c8d5ff]">Perbarui tampilan desa wisata lebih cepat.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-8 py-10 sm:px-10 lg:px-12 lg:py-14">
                <div class="mb-8 text-center lg:text-left">
                    <p class="text-sm uppercase tracking-[0.3em] text-[#81c784]">Halaman Admin</p>
                    <h1 class="mt-4 text-4xl font-semibold text-white">Masuk ke Panel Admin</h1>
                    <p class="mt-3 max-w-xl text-sm text-[#c8d5ff]">Masukkan email dan kata sandi admin Anda untuk mengelola konten dan booking desa wisata.</p>
                </div>

                @if($errors->any())
                    <div class="mb-6 rounded-[1.5rem] border border-red-200 bg-red-50 p-4 text-sm text-red-700 text-left text-black">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
                    @csrf
                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-white">Email Admin</span>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-3xl border border-white/20 bg-white/10 px-4 py-3 text-sm text-white shadow-sm ring-1 ring-white/10 placeholder:text-white/50 focus:border-[#81c784] focus:outline-none focus:ring-2 focus:ring-[#81c784]/20" required>
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-white">Kata Sandi</span>
                        <input type="password" name="password" class="w-full rounded-3xl border border-white/20 bg-white/10 px-4 py-3 text-sm text-white shadow-sm ring-1 ring-white/10 placeholder:text-white/50 focus:border-[#81c784] focus:outline-none focus:ring-2 focus:ring-[#81c784]/20" required>
                    </label>
                    <div class="text-right">
                        <a href="{{ route('password.request') }}" class="text-sm font-semibold text-white underline">Lupa kata sandi?</a>
                    </div>
                    <button type="submit" class="w-full rounded-full bg-[#81c784] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-[#00000040] hover:bg-[#6aa76c]">Masuk Admin</button>
                </form>

                <p class="mt-6 text-center text-sm text-[#c8d5ff] lg:text-left">Bukan admin? <a href="{{ route('login') }}" class="font-semibold text-white underline">Kembali ke login pengguna</a></p>
            </div>
        </div>
    </div>
</body>
</html>
