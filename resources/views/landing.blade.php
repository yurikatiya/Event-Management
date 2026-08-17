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

                    <a href="#contact"
                       class="text-sm font-medium text-slate-600 transition hover:text-[#00a1ee]">
                        Contact
                    </a>

                </div>


                {{-- AUTH BUTTON --}}
                <div class="flex items-center gap-2">

                    <a href="{{ route('login') }}"
                       class="hidden rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-700
                              transition hover:bg-slate-100 sm:block">
                        Sign In
                    </a>

                    <a href="{{ route('login') }}"
                       class="rounded-xl bg-[#00a1ee] px-5 py-2.5 text-sm font-semibold text-white
                              shadow-lg shadow-[#00a1ee]/20 transition
                              hover:-translate-y-0.5 hover:bg-[#008fd4]">
                        Sign Up
                    </a>

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
                                Experiences
                            </span>

                            That Matter.

                        </h1>


                        <p class="mt-7 max-w-xl text-lg leading-8 text-slate-600">
                            R27 Creative Agency menghadirkan konsep kreatif,
                            event, activation, branding, serta pengalaman digital
                            yang dirancang untuk membuat setiap momen lebih
                            bermakna dan berkesan.
                        </p>


                        <div class="mt-9 flex flex-wrap gap-4">

                            <a href="#events"
                               class="group inline-flex items-center gap-3 rounded-xl
                                      bg-[#00a1ee] px-6 py-3.5 text-sm font-semibold
                                      text-white shadow-xl shadow-[#00a1ee]/20
                                      transition hover:-translate-y-1 hover:bg-[#008fd4]">

                                Explore Our Events

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
                                    Based Approach
                                </p>
                            </div>


                            <div class="h-10 w-px bg-slate-200"></div>


                            <div>
                                <p class="text-2xl font-bold text-slate-900">
                                    Impact
                                </p>

                                <p class="mt-1 text-xs text-slate-500">
                                    Driven
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
                                            Events.
                                            <br>
                                            Impact.
                                        </h2>
                                    </div>


                                    <div>
                                        <div class="mb-4 h-px w-full bg-white/20"></div>

                                        <p class="text-sm leading-6 text-white/75">
                                            Turning creative ideas into meaningful
                                            experiences through activation,
                                            branding and events.
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
                                            Experience
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
            ABOUT
        ====================================================== --}}

        <section id="about" class="bg-white py-28">

            <div class="mx-auto max-w-7xl px-6">

                <div class="grid gap-16 lg:grid-cols-[0.8fr_1.2fr]">

                    <div>

                        <span class="text-xs font-bold uppercase tracking-[0.25em]
                                     text-[#00a1ee]">
                            About R27
                        </span>

                        <h2 class="mt-4 text-4xl font-bold leading-tight
                                   tracking-tight text-slate-950 sm:text-5xl">

                            Creating ideas that
                            <span class="text-[#00a1ee]">
                                move people.
                            </span>

                        </h2>

                    </div>


                    <div>

                        <p class="text-lg leading-8 text-slate-600">
                            R27 Creative Agency hadir dengan pendekatan kreatif
                            yang menggabungkan strategi, ide, komunikasi, dan
                            eksekusi untuk menghasilkan pengalaman yang relevan
                            bagi audiens.
                        </p>

                        <p class="mt-5 leading-7 text-slate-500">
                            Berangkat dari semangat Smart Activation & Branding,
                            kami mengembangkan berbagai kebutuhan kreatif mulai
                            dari event planning, event organizing, venue activation,
                            city branding hingga design dan digital experience.
                        </p>


                        <div class="mt-8 grid gap-4 sm:grid-cols-2">

                            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-6">
                                <p class="text-2xl font-bold text-[#00a1ee]">
                                    01
                                </p>

                                <h3 class="mt-3 font-bold text-slate-900">
                                    Creative Thinking
                                </h3>

                                <p class="mt-2 text-sm leading-6 text-slate-500">
                                    Mengubah ide menjadi konsep yang memiliki
                                    karakter dan tujuan.
                                </p>
                            </div>


                            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-6">
                                <p class="text-2xl font-bold text-[#00a1ee]">
                                    02
                                </p>

                                <h3 class="mt-3 font-bold text-slate-900">
                                    Meaningful Experience
                                </h3>

                                <p class="mt-2 text-sm leading-6 text-slate-500">
                                    Membuat event dan activation yang meninggalkan
                                    kesan bagi audiens.
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
                        What We Do
                    </span>

                    <h2 class="mt-4 text-4xl font-bold tracking-tight
                               text-slate-950 sm:text-5xl">
                        Creative solutions for
                        <span class="text-[#00a1ee]">
                            real impact.
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
                            Pengembangan konsep kreatif dan strategi komunikasi
                            untuk kebutuhan brand dan campaign.
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
                            Event Planner & Consultant
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-slate-500">
                            Merancang event dari konsep, strategi hingga
                            pengalaman yang ingin dibangun.
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
                            Event Organizer
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-slate-500">
                            Eksekusi event secara terstruktur dengan perhatian
                            terhadap detail dan pengalaman pengunjung.
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
                            Venue Activation
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-slate-500">
                            Menghidupkan ruang melalui konsep activation yang
                            interaktif dan relevan.
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
                            City Branding
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-slate-500">
                            Membangun identitas dan pengalaman kota melalui
                            kreativitas, budaya dan potensi lokal.
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
                            Design & Digital
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-slate-500">
                            Mengembangkan kebutuhan visual dan digital untuk
                            memperkuat komunikasi sebuah brand.
                        </p>

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
            EVENTS
        ====================================================== --}}

        <section id="events" class="bg-white py-28">

            <div class="mx-auto max-w-7xl px-6">

                <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end">

                    <div>

                        <span class="text-xs font-bold uppercase tracking-[0.25em]
                                     text-[#00a1ee]">
                            Our Experiences
                        </span>

                        <h2 class="mt-4 text-4xl font-bold tracking-tight
                                   text-slate-950 sm:text-5xl">
                            Events we've
                            <span class="text-[#00a1ee]">
                                brought to life.
                            </span>
                        </h2>

                    </div>

                    <p class="max-w-md text-sm leading-7 text-slate-500">
                        Setiap event memiliki cerita, audiens dan tujuan yang
                        berbeda. Kami menghadirkan pengalaman yang dirancang
                        berdasarkan kebutuhan tersebut.
                    </p>

                </div>


                <div class="mt-14 grid gap-6 md:grid-cols-2 lg:grid-cols-3">


                    {{-- EVENT 1 --}}
                    <article class="group overflow-hidden rounded-3xl border border-slate-100
                                    bg-white shadow-sm transition duration-300
                                    hover:-translate-y-2 hover:shadow-xl">

                        <div class="relative h-64 overflow-hidden bg-gradient-to-br
                                    from-[#00a1ee] to-[#5b6ee1]">

                            <div class="absolute -right-16 -top-16 h-48 w-48
                                        rounded-full bg-white/10"></div>

                            <div class="absolute -bottom-20 -left-10 h-48 w-48
                                        rounded-full bg-white/10"></div>

                            <div class="relative flex h-full flex-col justify-end p-7">

                                <span class="text-xs font-semibold uppercase
                                             tracking-[0.2em] text-white/70">
                                    Creative Program
                                </span>

                                <h3 class="mt-2 text-3xl font-bold text-white">
                                    Digigame
                                </h3>

                            </div>

                        </div>

                        <div class="p-7">

                            <p class="text-sm leading-7 text-slate-500">
                                Program kreatif yang menggabungkan teknologi,
                                komunitas dan pengalaman digital untuk
                                menghadirkan aktivitas yang menarik bagi audiens.
                            </p>

                            <div class="mt-6 flex items-center justify-between">

                                <span class="text-xs font-semibold text-[#00a1ee]">
                                    Creative Activation
                                </span>

                                <span class="text-slate-300">
                                    →
                                </span>

                            </div>

                        </div>

                    </article>


                    {{-- EVENT 2 --}}
                    <article class="group overflow-hidden rounded-3xl border border-slate-100
                                    bg-white shadow-sm transition duration-300
                                    hover:-translate-y-2 hover:shadow-xl">

                        <div class="relative h-64 overflow-hidden bg-gradient-to-br
                                    from-[#159de1] to-[#09b9d4]">

                            <div class="absolute -right-20 -top-10 h-56 w-56
                                        rounded-full border-[40px] border-white/10"></div>

                            <div class="relative flex h-full flex-col justify-end p-7">

                                <span class="text-xs font-semibold uppercase
                                             tracking-[0.2em] text-white/70">
                                    Creativepreneur
                                </span>

                                <h3 class="mt-2 text-3xl font-bold text-white">
                                    Creativepreneur
                                </h3>

                            </div>

                        </div>

                        <div class="p-7">

                            <p class="text-sm leading-7 text-slate-500">
                                Program yang mendorong kreativitas, kewirausahaan
                                dan pengembangan potensi generasi muda melalui
                                industri kreatif.
                            </p>

                            <div class="mt-6 flex items-center justify-between">

                                <span class="text-xs font-semibold text-[#00a1ee]">
                                    Creative Economy
                                </span>

                                <span class="text-slate-300">
                                    →
                                </span>

                            </div>

                        </div>

                    </article>


                    {{-- EVENT 3 --}}
                    <article class="group overflow-hidden rounded-3xl border border-slate-100
                                    bg-white shadow-sm transition duration-300
                                    hover:-translate-y-2 hover:shadow-xl">

                        <div class="relative h-64 overflow-hidden bg-gradient-to-br
                                    from-[#5b6ee1] to-[#00a1ee]">

                            <div class="absolute -bottom-20 -right-10 h-60 w-60
                                        rounded-full bg-white/10"></div>

                            <div class="relative flex h-full flex-col justify-end p-7">

                                <span class="text-xs font-semibold uppercase
                                             tracking-[0.2em] text-white/70">
                                    Community
                                </span>

                                <h3 class="mt-2 text-3xl font-bold text-white">
                                    Community Activation
                                </h3>

                            </div>

                        </div>

                        <div class="p-7">

                            <p class="text-sm leading-7 text-slate-500">
                                Menghadirkan ruang kolaborasi bersama komunitas,
                                kampus, sekolah, UMKM dan berbagai stakeholder
                                untuk menciptakan dampak yang lebih luas.
                            </p>

                            <div class="mt-6 flex items-center justify-between">

                                <span class="text-xs font-semibold text-[#00a1ee]">
                                    Collaboration
                                </span>

                                <span class="text-slate-300">
                                    →
                                </span>

                            </div>

                        </div>

                    </article>

                </div>

            </div>

        </section>


        {{-- =====================================================
            CTA
        ====================================================== --}}

        <section id="contact" class="relative overflow-hidden bg-[#0d2940] py-28">

            <div class="absolute -right-32 -top-32 h-96 w-96 rounded-full
                        bg-[#00a1ee]/20 blur-3xl"></div>

            <div class="absolute -bottom-40 -left-20 h-96 w-96 rounded-full
                        bg-blue-500/10 blur-3xl"></div>


            <div class="relative mx-auto max-w-7xl px-6">

                <div class="grid items-center gap-10 lg:grid-cols-2">

                    <div>

                        <span class="text-xs font-bold uppercase tracking-[0.25em]
                                     text-[#45c7ff]">
                            Let's Create Something
                        </span>

                        <h2 class="mt-5 text-4xl font-bold leading-tight
                                   tracking-tight text-white sm:text-5xl">

                            Have an idea?

                            <span class="text-[#45c7ff]">
                                Let's make it happen.
                            </span>

                        </h2>

                    </div>


                    <div>

                        <p class="leading-7 text-slate-300">
                            Dari sebuah ide sederhana hingga sebuah event besar,
                            R27 siap membantu merancang pengalaman yang kreatif,
                            relevan dan memiliki dampak.
                        </p>

                        <a href="{{ route('login') }}"
                           class="mt-7 inline-flex items-center gap-3 rounded-xl
                                  bg-white px-6 py-3.5 text-sm font-bold
                                  text-[#008fd4] transition hover:-translate-y-1
                                  hover:bg-[#eaf8ff]">

                            Enter Event Management

                            <span>
                                →
                            </span>

                        </a>

                    </div>

                </div>

            </div>

        </section>

    </main>


    {{-- =====================================================
        FOOTER
    ====================================================== --}}

    <footer class="bg-[#081d2d] py-10">

        <div class="mx-auto flex max-w-7xl flex-col gap-6 px-6 md:flex-row
                    md:items-center md:justify-between">

            <div>

                <p class="font-bold text-white">
                    R27 Creative Agency
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    Smart Activation & Branding
                </p>

            </div>


            <p class="text-xs text-slate-500">
                © {{ date('Y') }} R27 Creative Agency. All rights reserved.
            </p>

        </div>

    </footer>

</body>

</html>