<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>R27 Creative Agency | Event & Creative Experience</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-slate-800 antialiased">

    {{-- =====================================================
        NAVBAR
    ====================================================== --}}

    <header class="fixed top-0 left-0 right-0 z-50">

        <nav class="mx-auto mt-5 max-w-7xl px-6">

            <div class="flex items-center justify-between rounded-2xl border border-white/60
                        bg-white/90 px-5 py-3 shadow-lg shadow-slate-200/30 backdrop-blur-xl">

                {{-- LOGO --}}
                <a href="/" class="flex items-center gap-3">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white">
                        <img
                            src="{{ asset('images/logo-r27.png') }}"
                            alt="R27 Creative Agency"
                            class="h-9 w-auto object-contain"
                        >
                    </div>

                    <div class="hidden sm:block">
                        <p class="text-sm font-bold tracking-wide text-slate-900">
                            R27
                        </p>

                        <p class="text-[10px] font-medium uppercase tracking-[0.18em] text-slate-400">
                            Creative Agency
                        </p>
                    </div>

                </a>


                {{-- MENU DESKTOP --}}
                <div class="hidden items-center gap-8 md:flex">

                    <a href="#home"
                       class="text-sm font-medium text-slate-600 transition hover:text-[#00a1ee]">
                        Home
                    </a>

                    <a href="#about"
                       class="text-sm font-medium text-slate-600 transition hover:text-[#00a1ee]">
                        About
                    </a>

                    <a href="#services"
                       class="text-sm font-medium text-slate-600 transition hover:text-[#00a1ee]">
                        Services
                    </a>

                    <a href="#events"
                       class="text-sm font-medium text-slate-600 transition hover:text-[#00a1ee]">
                        Events
                    </a>

                    <a href="#team"
                       class="text-sm font-medium text-slate-600 transition hover:text-[#00a1ee]">
                        Our Team
                    </a>

                    <a href="#contact"
                       class="text-sm font-medium text-slate-600 transition hover:text-[#00a1ee]">
                        Contact
                    </a>

                </div>


                {{-- AUTH BUTTON --}}
                <div class="flex items-center gap-2">

                    @guest
                        <a href="{{ route('login') }}"
                           class="rounded-xl bg-[#00a1ee] px-5 py-2.5 text-sm font-semibold text-white
                                  shadow-lg shadow-[#00a1ee]/20 transition hover:-translate-y-0.5
                                  hover:bg-[#008fd4]">
                            Sign In
                        </a>
                    @else
                        <span class="hidden text-sm font-semibold text-slate-700 sm:block">
                            {{ Auth::user()->name }}
                        </span>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold
                                           text-slate-700 transition hover:bg-slate-100">
                                Logout
                            </button>
                        </form>
                    @endguest

                </div>

            </div>

        </nav>

    </header>


    {{-- =====================================================
        HERO
    ====================================================== --}}

    <main>

        <section id="home"
                 class="relative min-h-screen overflow-hidden bg-gradient-to-br
                        from-[#f4fbff] via-white to-[#eef8ff]">

            {{-- Decorative --}}
            <div class="absolute -left-32 top-32 h-80 w-80 rounded-full
                        bg-[#00a1ee]/10 blur-3xl"></div>

            <div class="absolute -right-40 top-20 h-[500px] w-[500px] rounded-full
                        bg-blue-400/10 blur-3xl"></div>

            <div class="absolute bottom-0 left-1/3 h-40 w-40 rounded-full
                        bg-cyan-300/10 blur-3xl"></div>


            <div class="relative mx-auto flex min-h-screen max-w-7xl items-center px-6 pb-20 pt-36">

                <div class="grid w-full items-center gap-16 lg:grid-cols-2">


                    {{-- HERO TEXT --}}
                    <div>

                        <div class="mb-7 inline-flex items-center gap-2 rounded-full
                                    border border-[#00a1ee]/20 bg-white/80 px-4 py-2
                                    shadow-sm backdrop-blur">

                            <span class="h-2 w-2 rounded-full bg-[#00a1ee]"></span>

                            <span class="text-xs font-semibold uppercase tracking-[0.18em]
                                         text-[#008fd4]">
                                Smart Activation & Branding
                            </span>

                        </div>


                        <h1 class="max-w-3xl text-5xl font-bold leading-[1.05]
                                   tracking-tight text-slate-950 sm:text-6xl lg:text-7xl">

                            We Create

                            <span class="text-[#00a1ee]">
                                Creative Experiences
                            </span>

                            That Matter Impact.

                        </h1>


                        <p class="mt-7 max-w-xl text-lg leading-8 text-slate-600">
                           R27 Creative Agency mengembangkan konsep kreatif, event, 
                           activation, branding, serta berbagai program kolaboratif yang 
                           menghubungkan brand, komunitas, dan ekosistem kreatif.
                        </p>


                        <div class="mt-9 flex flex-wrap gap-4">

                            <a href="#events"
                               class="group inline-flex items-center gap-3 rounded-xl
                                      bg-[#00a1ee] px-6 py-3.5 text-sm font-semibold
                                      text-white shadow-xl shadow-[#00a1ee]/20
                                      transition hover:-translate-y-1 hover:bg-[#008fd4]">

                                Explore Our Work

                                <span class="transition group-hover:translate-x-1">
                                    →
                                </span>

                            </a>


                            <a href="#about"
                               class="inline-flex items-center rounded-xl border border-slate-200
                                      bg-white px-6 py-3.5 text-sm font-semibold text-slate-700
                                      shadow-sm transition hover:-translate-y-1 hover:border-[#00a1ee]/30
                                      hover:text-[#00a1ee]">

                                Discover R27

                            </a>

                        </div>


                        {{-- MINI STATS --}}
                        <div class="mt-12 flex flex-wrap gap-10">

                            <div>
                                <p class="text-2xl font-bold text-slate-900">
                                    2020
                                </p>

                                <p class="mt-1 text-xs text-slate-500">
                                    Established
                                </p>
                            </div>


                            <div class="h-10 w-px bg-slate-200"></div>


                            <div>
                                <p class="text-2xl font-bold text-slate-900">
                                    Creative
                                </p>

                                <p class="mt-1 text-xs text-slate-500">
                                    Solutions
                                </p>
                            </div>


                            <div class="h-10 w-px bg-slate-200"></div>


                            <div>
                                <p class="text-2xl font-bold text-slate-900">
                                    Collaborative
                                </p>

                                <p class="mt-1 text-xs text-slate-500">
                                    Approach
                                </p>
                            </div>

                        </div>

                    </div>


                    {{-- HERO VISUAL --}}
                    <div class="relative hidden lg:block">

                        <div class="relative mx-auto aspect-[4/5] max-w-[500px]">

                            {{-- Main card --}}
                            <div class="absolute inset-8 overflow-hidden rounded-[2.5rem]
                                        bg-gradient-to-br from-[#00a1ee] via-[#159de1]
                                        to-[#5b6ee1] shadow-2xl shadow-[#00a1ee]/20">

                                <div class="absolute -right-20 -top-20 h-64 w-64
                                            rounded-full border-[50px] border-white/10">
                                </div>

                                <div class="absolute -bottom-24 -left-24 h-72 w-72
                                            rounded-full bg-white/10">
                                </div>


                                <div class="relative flex h-full flex-col justify-between p-10">

                                    <div>
                                        <p class="text-xs font-semibold uppercase
                                                  tracking-[0.25em] text-white/70">
                                            R27 Creative Agency
                                        </p>

                                        <h2 class="mt-5 text-5xl font-bold leading-tight text-white">
                                            Ideas.
                                            <br>
                                            Creative.
                                            <br>
                                            Impact.
                                        </h2>
                                    </div>


                                    <div>
                                        <div class="mb-4 h-px w-full bg-white/20"></div>

                                        <p class="text-sm leading-6 text-white/75">
                                            Turning creative ideas into meaningful experiences 
                                            through events, activation, branding, and collaboration.
                                        </p>
                                    </div>

                                </div>

                            </div>


                            {{-- Floating card --}}
                            <div class="absolute -left-2 top-24 rounded-2xl border border-white
                                        bg-white/95 p-5 shadow-2xl backdrop-blur-xl">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-11 w-11 items-center justify-center
                                                rounded-xl bg-[#eaf8ff] text-[#00a1ee]">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke-width="1.8"
                                             stroke="currentColor"
                                             class="h-5 w-5">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M3 6.75A2.25 2.25 0 015.25 4.5h13.5A2.25 2.25 0 0121 6.75v10.5a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 17.25V6.75z" />

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M3 8.25h18M8 4.5v3.75M16 4.5v3.75" />

                                        </svg>

                                    </div>

                                    <div>
                                        <p class="text-xs text-slate-400">
                                            Creative Solutions
                                        </p>

                                        <p class="text-sm font-bold text-slate-900">
                                            Event & Activation
                                        </p>
                                    </div>

                                </div>

                            </div>


                            {{-- Bottom floating card --}}
                            <div class="absolute -bottom-2 right-0 rounded-2xl
                                        border border-white bg-white/95 px-5 py-4
                                        shadow-2xl backdrop-blur-xl">

                                <p class="text-xs text-slate-400">
                                    Our Philosophy
                                </p>

                                <p class="mt-1 text-sm font-bold text-slate-900">
                                    Creative. Collaborative. Impactful.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
            ABOUT R27
        ====================================================== --}}

<section id="about" class="bg-white py-28">

    <div class="mx-auto max-w-7xl px-6">

        {{-- MAIN ABOUT --}}
        <div class="grid gap-16 lg:grid-cols-[0.8fr_1.2fr]">

            {{-- LEFT --}}
            <div>

                <span class="text-xs font-bold uppercase tracking-[0.25em] text-[#00a1ee]">
                    About R27
                </span>

                <h2 class="mt-4 text-4xl font-bold leading-tight tracking-tight text-slate-950 sm:text-5xl">
                    Creating ideas that
                    <span class="text-[#00a1ee]">
                        move people.
                    </span>
                </h2>

            </div>


            {{-- RIGHT --}}
            <div>

                <p class="text-lg leading-8 text-slate-600">
                    R27 Creative Agency merupakan bagian dari ekosistem
                    kreatif yang mengembangkan berbagai program melalui
                    event, activation, branding, dan kolaborasi kreatif.
                </p>

                <p class="mt-5 leading-7 text-slate-500">
                    R27 mengembangkan konsep dan program yang dapat
                    menghubungkan brand, institusi, komunitas, serta
                    berbagai stakeholder melalui pengalaman kreatif
                    yang relevan dengan kebutuhan audiens.
                </p>


                {{-- HIGHLIGHT CARDS --}}
                <div class="mt-8 grid gap-4 sm:grid-cols-2">

                    {{-- CARD 01 --}}
                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-6">

                        <p class="text-2xl font-bold text-[#00a1ee]">
                            01
                        </p>

                        <h3 class="mt-3 font-bold text-slate-900">
                            Creative & Strategic
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Mengembangkan ide, konsep, dan strategi kreatif
                            berdasarkan kebutuhan program, brand, dan
                            audiens.
                        </p>

                    </div>


                    {{-- CARD 02 --}}
                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-6">

                        <p class="text-2xl font-bold text-[#00a1ee]">
                            02
                        </p>

                        <h3 class="mt-3 font-bold text-slate-900">
                            Collaboration
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Menghubungkan berbagai pihak melalui kolaborasi
                            antara brand, pemerintah, institusi pendidikan,
                            komunitas, dan ekosistem kreatif.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


        {{-- =====================================================
            SERVICES
        ====================================================== --}}

        <section id="services" class="bg-[#f7fbfe] py-28">

            <div class="mx-auto max-w-7xl px-6">

                <div class="max-w-2xl">

                    <span class="text-xs font-bold uppercase tracking-[0.25em]
                                text-[#00a1ee]">
                        Our Services
                    </span>

                    <h2 class="mt-4 text-4xl font-bold tracking-tight
                            text-slate-950 sm:text-5xl">

                        Creative solutions for
                        <span class="text-[#00a1ee]">
                            meaningful experiences.
                        </span>

                    </h2>

                </div>


                <div class="mt-14 grid gap-5 md:grid-cols-2 lg:grid-cols-3">


                    {{-- SERVICE 1 --}}
                    <div class="group rounded-3xl border border-slate-100 bg-white p-8
                                shadow-sm transition duration-300 hover:-translate-y-2
                                hover:shadow-xl hover:shadow-[#00a1ee]/10">

                        <div class="flex h-14 w-14 items-center justify-center
                                    rounded-2xl bg-[#eaf8ff] text-[#00a1ee]">

                            <span class="text-xl font-bold">
                                01
                            </span>

                        </div>

                        <h3 class="mt-7 text-xl font-bold text-slate-900">
                            Creative Agency
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-slate-500">
                            Mengembangkan ide dan konsep kreatif untuk menghasilkan
                            program yang relevan dengan kebutuhan brand, audiens,
                            dan tujuan komunikasi.
                        </p>

                    </div>


                    {{-- SERVICE 2 --}}
                    <div class="group rounded-3xl border border-slate-100 bg-white p-8
                                shadow-sm transition duration-300 hover:-translate-y-2
                                hover:shadow-xl hover:shadow-[#00a1ee]/10">

                        <div class="flex h-14 w-14 items-center justify-center
                                    rounded-2xl bg-[#eaf8ff] text-[#00a1ee]">

                            <span class="text-xl font-bold">
                                02
                            </span>

                        </div>

                        <h3 class="mt-7 text-xl font-bold text-slate-900">
                            Venue Activation
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-slate-500">
                            Mengembangkan konsep dan aktivitas kreatif untuk
                            menghidupkan ruang komersial maupun ruang publik
                            melalui pengalaman yang menarik bagi audiens.
                        </p>

                    </div>


                    {{-- SERVICE 3 --}}
                    <div class="group rounded-3xl border border-slate-100 bg-white p-8
                                shadow-sm transition duration-300 hover:-translate-y-2
                                hover:shadow-xl hover:shadow-[#00a1ee]/10">

                        <div class="flex h-14 w-14 items-center justify-center
                                    rounded-2xl bg-[#eaf8ff] text-[#00a1ee]">

                            <span class="text-xl font-bold">
                                03
                            </span>

                        </div>

                        <h3 class="mt-7 text-xl font-bold text-slate-900">
                            City Branding
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-slate-500">
                            Mengembangkan konsep kreatif yang mengangkat identitas,
                            potensi lokal, budaya, serta karakter sebuah kota
                            melalui program dan aktivitas yang strategis.
                        </p>

                    </div>


                    {{-- SERVICE 4 --}}
                    <div class="group rounded-3xl border border-slate-100 bg-white p-8
                                shadow-sm transition duration-300 hover:-translate-y-2
                                hover:shadow-xl hover:shadow-[#00a1ee]/10">

                        <div class="flex h-14 w-14 items-center justify-center
                                    rounded-2xl bg-[#eaf8ff] text-[#00a1ee]">

                            <span class="text-xl font-bold">
                                04
                            </span>

                        </div>

                        <h3 class="mt-7 text-xl font-bold text-slate-900">
                            Event Planner & Consultant
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-slate-500">
                            Membantu merancang konsep, strategi, dan arah sebuah
                            event agar memiliki tujuan serta pengalaman yang jelas
                            bagi audiens.
                        </p>

                    </div>


                    {{-- SERVICE 5 --}}
                    <div class="group rounded-3xl border border-slate-100 bg-white p-8
                                shadow-sm transition duration-300 hover:-translate-y-2
                                hover:shadow-xl hover:shadow-[#00a1ee]/10">

                        <div class="flex h-14 w-14 items-center justify-center
                                    rounded-2xl bg-[#eaf8ff] text-[#00a1ee]">

                            <span class="text-xl font-bold">
                                05
                            </span>

                        </div>

                        <h3 class="mt-7 text-xl font-bold text-slate-900">
                            Event Organizer
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-slate-500">
                            Mendukung pelaksanaan dan pengelolaan event mulai dari
                            persiapan hingga eksekusi agar program dapat berjalan
                            secara terstruktur dan sesuai konsep.
                        </p>

                    </div>


                    {{-- SERVICE 6 --}}
                    <div class="group rounded-3xl border border-slate-100 bg-white p-8
                                shadow-sm transition duration-300 hover:-translate-y-2
                                hover:shadow-xl hover:shadow-[#00a1ee]/10">

                        <div class="flex h-14 w-14 items-center justify-center
                                    rounded-2xl bg-[#eaf8ff] text-[#00a1ee]">

                            <span class="text-xl font-bold">
                                06
                            </span>

                        </div>

                        <h3 class="mt-7 text-xl font-bold text-slate-900">
                            Design & Digital Agency
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-slate-500">
                            Mengembangkan kebutuhan desain dan digital sebagai
                            bagian dari komunikasi kreatif untuk mendukung
                            identitas serta program yang dijalankan.
                        </p>

                    </div>

                </div>

            </div>

        </section>

        @php
            $publishedGalleries = \App\Models\Gallery::query()->where('status', 'published')->latest()->take(6)->get();
            $activeSponsors = \App\Models\Sponsor::query()->whereIn('status', ['active', 'published'])->orderBy('tier')->latest()->get();
        @endphp

        @if ($activeSponsors->isNotEmpty())
            <section class="bg-white py-24">
                <div class="mx-auto max-w-7xl px-6">
                    <div class="mb-10 text-center">
                        <span class="text-xs font-bold uppercase tracking-[0.25em] text-[#00a1ee]">Our Partners</span>
                        <h2 class="mt-4 text-4xl font-bold tracking-tight text-slate-950 sm:text-5xl">
                            Trusted by
                            <span class="text-[#00a1ee]">brands and communities</span>
                        </h2>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach ($activeSponsors as $sponsor)
                            <div class="flex h-28 items-center justify-center rounded-2xl border border-slate-200 bg-slate-50 p-5 shadow-sm">
                                @if ($sponsor->logo)
                                    <img src="{{ asset('storage/' . $sponsor->logo) }}" alt="{{ $sponsor->name }}" class="max-h-16 max-w-full object-contain">
                                @else
                                    <span class="text-lg font-bold text-slate-700">{{ $sponsor->name }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @if ($publishedGalleries->isNotEmpty())
            <section id="gallery" class="bg-[#f7fbfe] py-28">
                <div class="mx-auto max-w-7xl px-6">
                    <div class="mb-10 max-w-2xl">
                        <span class="text-xs font-bold uppercase tracking-[0.25em] text-[#00a1ee]">
                            Gallery
                        </span>
                        <h2 class="mt-4 text-4xl font-bold tracking-tight text-slate-950 sm:text-5xl">
                            Moments from our
                            <span class="text-[#00a1ee]">
                                latest work.
                            </span>
                        </h2>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                        @foreach ($publishedGalleries as $gallery)
                            <article class="overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm">
                                <div class="h-72 overflow-hidden bg-slate-100">
                                    <img src="{{ asset('storage/' . $gallery->file_path) }}" alt="{{ $gallery->title ?? 'Gallery image' }}" class="h-full w-full object-cover transition duration-500 hover:scale-105">
                                </div>
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-slate-900">{{ $gallery->title }}</h3>
                                    @if ($gallery->description)
                                        <p class="mt-3 text-sm leading-6 text-slate-500">{{ $gallery->description }}</p>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

    {{-- =====================================================
        EVENTS
    ====================================================== --}}

    <section id="events" class="bg-white py-28">

        <div class="mx-auto max-w-7xl px-6">

            {{-- HEADER --}}
            <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end">

                <div>

                    <span class="text-xs font-bold uppercase tracking-[0.25em] text-[#00a1ee]">
                        Our Experiences
                    </span>

                    <h2 class="mt-4 text-4xl font-bold tracking-tight text-slate-950 sm:text-5xl">
                        Events we've
                        <span class="text-[#00a1ee]">
                            brought to life.
                        </span>
                    </h2>

                </div>

                <p class="max-w-md text-sm leading-7 text-slate-500">
                    Berbagai program dan pengalaman kreatif yang hadir melalui
                    kolaborasi, komunitas, event, dan pengembangan ekosistem kreatif.
                </p>

            </div>


            {{-- EVENT GRID --}}
            <div class="mt-14 grid gap-6 md:grid-cols-2 lg:grid-cols-3">


                {{-- EVENT 1 --}}
                <article class="group overflow-hidden rounded-3xl border border-slate-100
                                bg-white shadow-sm transition duration-300
                                hover:-translate-y-2 hover:shadow-xl">

                    <div class="h-64 overflow-hidden bg-[#eaf8ff]">

                        <img
                            src="{{ asset('images/events/digigame.jpg') }}"
                            alt="Digigame"
                            class="h-full w-full object-cover transition duration-500
                                group-hover:scale-105"
                        >

                    </div>

                    <div class="p-7">

                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-[#00a1ee]">
                            Creative Program
                        </span>

                        <h3 class="mt-3 text-2xl font-bold text-slate-900">
                            Digigame
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-slate-500">
                            Program yang berkaitan dengan pengembangan kreativitas,
                            teknologi, game, dan ekosistem digital.
                        </p>

                    </div>

                </article>


                {{-- EVENT 2 --}}
                <article class="group overflow-hidden rounded-3xl border border-slate-100
                                bg-white shadow-sm transition duration-300
                                hover:-translate-y-2 hover:shadow-xl">

                    <div class="h-64 overflow-hidden bg-[#eaf8ff]">

                        <img
                            src="{{ asset('images/events/akademi-kampung-kb.jpg') }}"
                            alt="Akademi Kampung KB"
                            class="h-full w-full object-cover transition duration-500
                                group-hover:scale-105"
                        >

                    </div>

                    <div class="p-7">

                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-[#00a1ee]">
                            Community Program
                        </span>

                        <h3 class="mt-3 text-2xl font-bold text-slate-900">
                            Akademi Kampung KB
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-slate-500">
                            Program yang melibatkan kolaborasi dan pengembangan
                            masyarakat melalui pendekatan kreatif.
                        </p>

                    </div>

                </article>


                {{-- EVENT 3 --}}
                <article class="group overflow-hidden rounded-3xl border border-slate-100
                                bg-white shadow-sm transition duration-300
                                hover:-translate-y-2 hover:shadow-xl">

                    <div class="h-64 overflow-hidden bg-[#eaf8ff]">

                        <img
                            src="{{ asset('images/events/pasti-preneur.jpg') }}"
                            alt="Pasti Preneur"
                            class="h-full w-full object-cover transition duration-500
                                group-hover:scale-105"
                        >

                    </div>

                    <div class="p-7">

                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-[#00a1ee]">
                            Entrepreneurship
                        </span>

                        <h3 class="mt-3 text-2xl font-bold text-slate-900">
                            Pasti Preneur
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-slate-500">
                            Program yang berhubungan dengan pengembangan
                            kewirausahaan dan potensi pelaku kreatif.
                        </p>

                    </div>

                </article>


                {{-- EVENT 4 --}}
                <article class="group overflow-hidden rounded-3xl border border-slate-100
                                bg-white shadow-sm transition duration-300
                                hover:-translate-y-2 hover:shadow-xl">

                    <div class="h-64 overflow-hidden bg-[#eaf8ff]">

                        <img
                            src="{{ asset('images/events/cimahi-campernik.jpg') }}"
                            alt="Cimahi Campernik"
                            class="h-full w-full object-cover transition duration-500
                                group-hover:scale-105"
                        >

                    </div>

                    <div class="p-7">

                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-[#00a1ee]">
                            City Program
                        </span>

                        <h3 class="mt-3 text-2xl font-bold text-slate-900">
                            Cimahi Campernik
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-slate-500">
                            Program yang mengangkat kreativitas dan potensi
                            daerah melalui kegiatan dan pengalaman kreatif.
                        </p>

                    </div>

                </article>


                {{-- EVENT 5 --}}
                <article class="group overflow-hidden rounded-3xl border border-slate-100
                                bg-white shadow-sm transition duration-300
                                hover:-translate-y-2 hover:shadow-xl">

                    <div class="h-64 overflow-hidden bg-[#eaf8ff]">

                        <img
                            src="{{ asset('images/events/west-java-belt.jpg') }}"
                            alt="West Java Belt"
                            class="h-full w-full object-cover transition duration-500
                                group-hover:scale-105"
                        >

                    </div>

                    <div class="p-7">

                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-[#00a1ee]">
                            City Branding
                        </span>

                        <h3 class="mt-3 text-2xl font-bold text-slate-900">
                            West Java Belt
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-slate-500">
                            Inisiatif yang berkaitan dengan pengembangan identitas,
                            potensi, dan kreativitas Jawa Barat.
                        </p>

                    </div>

                </article>


                {{-- EVENT 6 --}}
                <article class="group overflow-hidden rounded-3xl border border-slate-100
                                bg-white shadow-sm transition duration-300
                                hover:-translate-y-2 hover:shadow-xl">

                    <div class="h-64 overflow-hidden bg-[#eaf8ff]">

                        <img
                            src="{{ asset('images/events/mercedez-carnaval.jpg') }}"
                            alt="Mercedez Carnaval"
                            class="h-full w-full object-cover transition duration-500
                                group-hover:scale-105"
                        >

                    </div>

                    <div class="p-7">

                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-[#00a1ee]">
                            Festival
                        </span>

                        <h3 class="mt-3 text-2xl font-bold text-slate-900">
                            Mercedez Carnaval
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-slate-500">
                            Program festival dan aktivitas kreatif yang menghadirkan
                            pengalaman bagi audiens dan komunitas.
                        </p>

                    </div>

                </article>


                {{-- EVENT 7 --}}
                <article class="group overflow-hidden rounded-3xl border border-slate-100
                                bg-white shadow-sm transition duration-300
                                hover:-translate-y-2 hover:shadow-xl">

                    <div class="h-64 overflow-hidden bg-[#eaf8ff]">

                        <img
                            src="{{ asset('images/events/sangkuriang-festival.jpg') }}"
                            alt="Sangkuriang Festival"
                            class="h-full w-full object-cover transition duration-500
                                group-hover:scale-105"
                        >

                    </div>

                    <div class="p-7">

                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-[#00a1ee]">
                            Festival
                        </span>

                        <h3 class="mt-3 text-2xl font-bold text-slate-900">
                            Sangkuriang Festival
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-slate-500">
                            Festival yang menghadirkan unsur kreativitas,
                            budaya, komunitas, dan pengalaman publik.
                        </p>

                    </div>

                </article>


                {{-- EVENT 8 --}}
                <article class="group overflow-hidden rounded-3xl border border-slate-100
                                bg-white shadow-sm transition duration-300
                                hover:-translate-y-2 hover:shadow-xl">

                    <div class="h-64 overflow-hidden bg-[#eaf8ff]">

                        <img
                            src="{{ asset('images/events/batikday.jpg') }}"
                            alt="Batikday"
                            class="h-full w-full object-cover transition duration-500
                                group-hover:scale-105"
                        >

                    </div>

                    <div class="p-7">

                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-[#00a1ee]">
                            Culture & Creative
                        </span>

                        <h3 class="mt-3 text-2xl font-bold text-slate-900">
                            Batikday
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-slate-500">
                            Program yang mengangkat budaya dan kreativitas
                            melalui partisipasi masyarakat dan komunitas.
                        </p>

                    </div>

                </article>


                {{-- EVENT 9 --}}
                <article class="group overflow-hidden rounded-3xl border border-slate-100
                                bg-white shadow-sm transition duration-300
                                hover:-translate-y-2 hover:shadow-xl">

                    <div class="h-64 overflow-hidden bg-[#eaf8ff]">

                        <img
                            src="{{ asset('images/events/curious-people.jpg') }}"
                            alt="Curious People"
                            class="h-full w-full object-cover transition duration-500
                                group-hover:scale-105"
                        >

                    </div>

                    <div class="p-7">

                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-[#00a1ee]">
                            Creative Community
                        </span>

                        <h3 class="mt-3 text-2xl font-bold text-slate-900">
                            Curious People
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-slate-500">
                            Program yang mempertemukan kreativitas, komunitas,
                            dan berbagai gagasan dalam ekosistem kreatif.
                        </p>

                    </div>

                </article>


                {{-- EVENT 10 --}}
                <article class="group overflow-hidden rounded-3xl border border-slate-100
                                bg-white shadow-sm transition duration-300
                                hover:-translate-y-2 hover:shadow-xl">

                    <div class="h-64 overflow-hidden bg-[#eaf8ff]">

                        <img
                            src="{{ asset('images/events/ge krafts-jabar-gebrakan.jpg') }}"
                            alt="GEKRAFS Jabar Gebrakan"
                            class="h-full w-full object-cover transition duration-500
                                group-hover:scale-105"
                        >

                    </div>

                    <div class="p-7">

                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-[#00a1ee]">
                            Creative Economy
                        </span>

                        <h3 class="mt-3 text-2xl font-bold text-slate-900">
                            GEKRAFS Jabar Gebrakan
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-slate-500">
                            Program yang berkaitan dengan pengembangan dan
                            penguatan ekosistem ekonomi kreatif.
                        </p>

                    </div>

                </article>


            </div>

        </div>

    </section>


        {{-- =====================================================
            TEAM
        ====================================================== --}}

        <section id="team" class="bg-[#f7fbfe] py-28">

            <div class="mx-auto max-w-7xl px-6">

                {{-- HEADER --}}
                <div class="max-w-2xl">

                    <span class="text-xs font-bold uppercase tracking-[0.25em] text-[#00a1ee]">
                        The People Behind
                    </span>

                    <h2 class="mt-4 text-4xl font-bold tracking-tight text-slate-950 sm:text-5xl">
                        Our
                        <span class="text-[#00a1ee]">
                            Team.
                        </span>
                    </h2>

                    <p class="mt-5 max-w-xl leading-7 text-slate-500">
                        The people behind R27 Creative Agency and the creative
                        work we develop together.
                    </p>

                </div>


                {{-- TEAM PHOTO --}}
                <div class="mt-14">

                    <div class="overflow-hidden rounded-3xl bg-white shadow-sm">

                        <img
                            src="{{ ('images/team.jpeg') }}"
                            alt="R27 Creative Agency Team"
                            class="h-auto w-full object-contain"
                        >

                    </div>

                </div>


                {{-- BOD --}}
                <div class="mt-20">

                    <div class="max-w-2xl">

                        <span class="text-xs font-bold uppercase tracking-[0.25em] text-[#00a1ee]">
                            BOD & Creative Leadership
                        </span>

                        <h3 class="mt-4 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
                            The People Behind
                            <span class="text-[#00a1ee]">
                                R27.
                            </span>
                        </h3>

                    </div>


                    {{-- ONE BOD PHOTO --}}
                    <div class="mt-10">

                        <div class="overflow-hidden rounded-3xl bg-white shadow-sm">

                            <img
                                src="{{ ('images/bod.jpeg') }}"
                                alt="R27 Creative Agency Board and Creative Leadership"
                                class="h-auto w-full object-contain"
                            >

                        </div>


                        {{-- BOD INFORMATION --}}
                        <div class="relative mx-auto max-w-5xl">

                            {{-- Nama Rindy --}}
                            <div class="absolute left-[18%] top-0 text-left">
                                <h4 class="text-xl font-bold text-slate-900">
                                    Rindy
                                </h4>

                                <p class="mt-1 text-sm font-medium text-[#00a1ee]">
                                    Commissioner
                                </p>
                            </div>


                            {{-- Nama Indra --}}
                            <div class="absolute right-[18%] top-0 text-left">
                                <h4 class="text-xl font-bold text-slate-900">
                                    Indra Setiyadi
                                </h4>

                                <p class="mt-1 text-sm font-medium text-[#00a1ee]">
                                    Creative Director
                                </p>
                            </div>

                        </div>

                        <div class="h-20"></div>

                        </div>

                    </div>

                </div>

            </div>

        </section>



        {{-- =====================================================
            CTA / CONTACT
        ====================================================== --}}

        <section id="contact" class="relative overflow-hidden bg-[#0d2940] py-28">

            {{-- DECORATION --}}
            <div class="absolute -right-32 -top-32 h-96 w-96 rounded-full
                        bg-[#00a1ee]/20 blur-3xl"></div>

            <div class="absolute -bottom-40 -left-20 h-96 w-96 rounded-full
                        bg-blue-500/10 blur-3xl"></div>


            <div class="relative mx-auto max-w-7xl px-6">

                <div class="grid items-center gap-12 lg:grid-cols-2">


                    {{-- LEFT --}}
                    <div>

                        <span class="text-xs font-bold uppercase tracking-[0.25em]
                                    text-[#45c7ff]">
                            Let's Collaborate
                        </span>

                        <h2 class="mt-5 text-4xl font-bold leading-tight
                                tracking-tight text-white sm:text-5xl">

                            Let's build
                            <span class="text-[#45c7ff]">
                                meaningful experiences.
                            </span>

                        </h2>

                    </div>


                    {{-- RIGHT --}}
                    <div>

                        <p class="leading-8 text-slate-300">
                            R27 Creative Agency terbuka untuk kolaborasi dalam
                            pengembangan event, creative program, activation,
                            branding, dan berbagai inisiatif kreatif.
                        </p>

                        <p class="mt-5 leading-8 text-slate-300">
                            Ceritakan kebutuhan dan ide yang ingin kamu kembangkan
                            bersama R27.
                        </p>


                        {{-- CONTACT BUTTON --}}
                        <div class="mt-8">

                            <a
                                href="#"
                                class="inline-flex items-center gap-3 rounded-full
                                    bg-[#00a1ee] px-6 py-3 text-sm font-bold
                                    text-white transition duration-300
                                    hover:bg-[#008fd4]"
                            >

                                Get in Touch

                                <span class="text-lg">
                                    →
                                </span>

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        </main>


        {{-- =====================================================
            FOOTER
        ====================================================== --}}

        <footer class="bg-[#081d2d] py-12">

            <div class="mx-auto max-w-7xl px-6">

                <div class="flex flex-col gap-8 md:flex-row md:items-center
                            md:justify-between">


                    {{-- BRAND --}}
                    <div>

                        <p class="text-lg font-bold text-white">
                            R27 Creative Agency
                        </p>

                        <p class="mt-2 text-sm text-slate-500">
                            Creative Agency & Event Partner
                        </p>

                    </div>


                    {{-- NAVIGATION --}}
                    <div class="flex flex-wrap gap-6 text-sm text-slate-400">

                        <a href="#about"
                        class="transition hover:text-white">
                            About
                        </a>

                        <a href="#services"
                        class="transition hover:text-white">
                            Services
                        </a>

                        <a href="#events"
                        class="transition hover:text-white">
                            Events
                        </a>

                        <a href="#team"
                        class="transition hover:text-white">
                            Team
                        </a>

                        <a href="#contact"
                        class="transition hover:text-white">
                            Contact
                        </a>

                    </div>

                </div>


                {{-- DIVIDER --}}
                <div class="my-8 h-px bg-white/10"></div>


                {{-- BOTTOM --}}
                <div class="flex flex-col gap-3 text-xs text-slate-500
                            md:flex-row md:items-center md:justify-between">

                    <p>
                        © {{ date('Y') }} R27 Creative Agency.
                        All rights reserved.
                    </p>

                    <p>
                        Creative. Collaborative. Meaningful.
                    </p>

                </div>

            </div>

        </footer>

</body>

</html>