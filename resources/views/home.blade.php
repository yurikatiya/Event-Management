<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>PT R27 Creative Agency</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-950 text-slate-100 antialiased">
        <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(59,130,246,0.25),transparent_35%),linear-gradient(180deg,#020817_0%,#0f172a_100%)]">
            <header class="mx-auto max-w-7xl px-6 py-6 lg:px-8">
                <nav class="flex items-center justify-between rounded-full border border-white/10 bg-white/5 px-5 py-3 backdrop-blur-sm">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-600 text-sm font-bold text-white">R</div>
                        <div>
                            <p class="text-sm font-semibold tracking-[0.2em] text-white/80">PT R27</p>
                            <p class="text-xs text-slate-300">Creative Agency</p>
                        </div>
                    </div>

                    <div class="hidden items-center gap-8 text-sm text-slate-200 md:flex">
                        <a href="#tentang" class="transition hover:text-white">Tentang</a>
                        <a href="#layanan" class="transition hover:text-white">Layanan</a>
                        <a href="#event" class="transition hover:text-white">Event</a>
                        <a href="#kontak" class="transition hover:text-white">Kontak</a>
                    </div>

                    <a href="{{ route('login') }}" class="rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-blue-600/30 transition hover:bg-blue-500">
                        Masuk Portal
                    </a>
                </nav>
            </header>

            <main class="mx-auto max-w-7xl px-6 pb-20 pt-8 lg:px-8">
                <section class="grid items-center gap-10 pb-20 pt-8 lg:grid-cols-[1.1fr_0.9fr] lg:pt-16">
                    <div>
                        <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-blue-400/30 bg-blue-500/10 px-3 py-1.5 text-xs font-medium text-blue-200">
                            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                            Trusted by modern brands
                        </div>

                        <h1 class="max-w-xl text-4xl font-black leading-tight tracking-[-0.06em] text-white sm:text-5xl lg:text-6xl">
                            Menciptakan <span class="text-blue-400">event</span> yang berkesan.
                        </h1>

                        <p class="mt-6 max-w-xl text-lg leading-8 text-slate-300">
                            Kami adalah agensi kreatif digital yang membantu brand, komunitas, dan perusahaan merancang pengalaman event yang strategis, terukur, dan tidak terlupakan.
                        </p>

                        <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                            <a href="#event" class="rounded-full bg-white px-6 py-3 text-center text-sm font-semibold text-slate-900 transition hover:bg-slate-200">
                                Lihat Event
                            </a>
                            <a href="#kontak" class="rounded-full border border-white/15 bg-white/5 px-6 py-3 text-center text-sm font-semibold text-white transition hover:bg-white/10">
                                Konsultasi Gratis
                            </a>
                        </div>

                        <div class="mt-10 grid max-w-lg grid-cols-3 gap-4">
                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                                <p class="text-2xl font-bold text-white">120+</p>
                                <p class="mt-1 text-xs uppercase tracking-[0.2em] text-slate-400">Event</p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                                <p class="text-2xl font-bold text-white">18</p>
                                <p class="mt-1 text-xs uppercase tracking-[0.2em] text-slate-400">Brand</p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                                <p class="text-2xl font-bold text-white">4.9</p>
                                <p class="mt-1 text-xs uppercase tracking-[0.2em] text-slate-400">Rating</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="absolute -left-10 top-10 h-40 w-40 rounded-full bg-blue-500/20 blur-3xl"></div>
                        <div class="absolute -right-6 bottom-6 h-40 w-40 rounded-full bg-indigo-500/20 blur-3xl"></div>

                        <div class="relative overflow-hidden rounded-[2rem] border border-white/10 bg-white/5 p-5 shadow-[0_30px_80px_rgba(59,130,246,0.2)] backdrop-blur-xl">
                            <div class="rounded-[1.5rem] bg-slate-900 p-5">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Campaign</p>
                                        <h2 class="mt-2 text-2xl font-bold text-white">R27 Summit 2026</h2>
                                    </div>
                                    <span class="rounded-full bg-emerald-500/15 px-2.5 py-1 text-xs font-medium text-emerald-300">Live</span>
                                </div>

                                <div class="mt-6 space-y-4">
                                    <div class="rounded-2xl border border-white/10 bg-slate-800 p-4">
                                        <div class="flex items-center justify-between text-sm text-slate-300">
                                            <span>Audience growth</span>
                                            <span class="font-semibold text-white">+48%</span>
                                        </div>
                                        <div class="mt-3 h-2.5 rounded-full bg-slate-700">
                                            <div class="h-2.5 w-[78%] rounded-full bg-blue-500"></div>
                                        </div>
                                    </div>

                                    <div class="grid gap-4 sm:grid-cols-2">
                                        <div class="rounded-2xl border border-white/10 bg-slate-800 p-4">
                                            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Registrasi</p>
                                            <p class="mt-3 text-3xl font-bold text-white">1.8k</p>
                                        </div>
                                        <div class="rounded-2xl border border-white/10 bg-slate-800 p-4">
                                            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Sponsors</p>
                                            <p class="mt-3 text-3xl font-bold text-white">28</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="layanan" class="py-20">
                    <div class="mb-12 text-center">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-300">Our services</p>
                        <h2 class="mt-4 text-3xl font-bold text-white sm:text-4xl">Solusi event dari konsep sampai eksekusi</h2>
                    </div>

                    <div class="grid gap-6 md:grid-cols-3">
                        <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                            <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-500/15 text-lg text-blue-300">01</div>
                            <h3 class="text-xl font-semibold text-white">Brand Experience</h3>
                            <p class="mt-3 text-sm leading-7 text-slate-300">
                                Membangun identitas event yang kuat untuk meningkatkan engagement dan awareness brand.
                            </p>
                        </div>

                        <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                            <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-500/15 text-lg text-blue-300">02</div>
                            <h3 class="text-xl font-semibold text-white">Production</h3>
                            <p class="mt-3 text-sm leading-7 text-slate-300">
                                Penjadwalan, logistik, kebutuhan teknis, dan koordinasi eksekusi event secara profesional.
                            </p>
                        </div>

                        <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                            <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-500/15 text-lg text-blue-300">03</div>
                            <h3 class="text-xl font-semibold text-white">Digital Campaign</h3>
                            <p class="mt-3 text-sm leading-7 text-slate-300">
                                Strategi promosi dan integrasi digital yang membantu audiens datang, terlibat, dan kembali.
                            </p>
                        </div>
                    </div>
                </section>

                <section id="event" class="py-20">
                    <div class="mb-12 flex items-end justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-300">Featured event</p>
                            <h2 class="mt-4 text-3xl font-bold text-white sm:text-4xl">Event yang sedang kami bangun</h2>
                        </div>
                        <a href="{{ route('login') }}" class="hidden text-sm font-medium text-blue-300 hover:text-white md:inline-block">Lihat portal →</a>
                    </div>

                    <div class="grid gap-6 lg:grid-cols-3">
                        <div class="overflow-hidden rounded-3xl border border-white/10 bg-white/5">
                            <div class="h-48 bg-[linear-gradient(135deg,#1d4ed8,#0f172a)]"></div>
                            <div class="p-6">
                                <p class="text-sm text-blue-300">Business Event</p>
                                <h3 class="mt-2 text-2xl font-semibold text-white">R27 Summit</h3>
                                <p class="mt-3 text-sm leading-7 text-slate-300">Konferensi bisnis dan networking untuk ekosistem brand modern.</p>
                            </div>
                        </div>

                        <div class="overflow-hidden rounded-3xl border border-white/10 bg-white/5">
                            <div class="h-48 bg-[linear-gradient(135deg,#0f172a,#1e293b)]"></div>
                            <div class="p-6">
                                <p class="text-sm text-blue-300">Community</p>
                                <h3 class="mt-2 text-2xl font-semibold text-white">Creative Night</h3>
                                <p class="mt-3 text-sm leading-7 text-slate-300">Festival kreatif dengan showcase, workshop, dan kolaborasi komunitas.</p>
                            </div>
                        </div>

                        <div class="overflow-hidden rounded-3xl border border-white/10 bg-white/5">
                            <div class="h-48 bg-[linear-gradient(135deg,#1d4ed8,#60a5fa)]"></div>
                            <div class="p-6">
                                <p class="text-sm text-blue-300">Launch Event</p>
                                <h3 class="mt-2 text-2xl font-semibold text-white">Product Launch</h3>
                                <p class="mt-3 text-sm leading-7 text-slate-300">Pameran produk yang dirancang untuk menciptakan pengalaman brand yang kuat.</p>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

            <footer id="kontak" class="border-t border-white/10 bg-slate-950/80">
                <div class="mx-auto flex max-w-7xl flex-col gap-6 px-6 py-8 text-sm text-slate-300 md:flex-row md:items-center md:justify-between lg:px-8">
                    <div>
                        <p class="font-semibold text-white">PT R27 Creative Agency</p>
                        <p class="mt-1">Membawa ide menjadi pengalaman yang berdampak.</p>
                    </div>
                    <div class="flex items-center gap-6">
                        <a href="#tentang" class="transition hover:text-white">Tentang</a>
                        <a href="#layanan" class="transition hover:text-white">Layanan</a>
                        <a href="{{ route('login') }}" class="transition hover:text-white">Portal</a>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
