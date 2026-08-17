<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Login — R2/7 Creative Agency
    </title>


    {{-- Google Font --}}
    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >


    {{-- Laravel Vite --}}
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body>


<div
    class="
        login-page
        relative
        min-h-screen
        overflow-hidden
        px-5
        py-8
        sm:px-8
        lg:px-12
    "
>


    {{-- =====================================================
         BACKGROUND DECORATION
    ====================================================== --}}

    <div class="bg-circle bg-circle-one"></div>

    <div class="bg-circle bg-circle-two"></div>



    {{-- =====================================================
         MAIN WRAPPER
    ====================================================== --}}

    <main
        class="
            relative
            z-10
            mx-auto
            flex
            min-h-[calc(100vh-4rem)]
            w-full
            max-w-[1180px]
            items-center
            justify-center
        "
    >


        {{-- =================================================
             TWO PANEL CONTAINER
        ================================================== --}}

        <div
            class="
                relative
                grid
                w-full
                items-center
                md:grid-cols-[1.05fr_0.95fr]
            "
        >


            {{-- =================================================
                 LEFT BRAND PANEL
            ================================================== --}}

            <section
                class="
                    brand-panel
                    relative
                    z-20
                    min-h-[570px]
                    overflow-hidden
                    rounded-[28px]
                    p-8
                    text-white
                    sm:p-10
                    lg:p-12
                    md:mr-[-50px]
                "
            >


                {{-- Abstract shapes --}}

                <div
                    class="
                        abstract-shape
                        abstract-one
                    "
                ></div>


                <div
                    class="
                        abstract-shape
                        abstract-two
                    "
                ></div>


                <div
                    class="
                        abstract-shape
                        abstract-three
                    "
                ></div>



                {{-- Decorative circles --}}

                <div
                    class="
                        absolute
                        right-[-100px]
                        top-[80px]
                        h-[280px]
                        w-[280px]
                        rounded-full
                        border
                        border-white/20
                    "
                ></div>


                <div
                    class="
                        absolute
                        right-[-50px]
                        top-[130px]
                        h-[180px]
                        w-[180px]
                        rounded-full
                        border
                        border-white/15
                    "
                ></div>



                <div
                    class="
                        relative
                        z-10
                        flex
                        h-full
                        min-h-[500px]
                        flex-col
                    "
                >


                    {{-- =========================================
                         LOGO
                    ========================================== --}}

                    <div
                        class="
                            flex
                            items-center
                            justify-between
                        "
                    >

                        <div
                            class="
                                logo-box
                                rounded-2xl
                                px-4
                                py-3
                            "
                        >

                            <img
                                src="{{ asset('image/logo-r27.png') }}"
                                alt="R2/7 Creative Agency"
                                class="
                                    h-12
                                    w-auto
                                    max-w-[190px]
                                    object-contain
                                "
                            >

                        </div>


                        <div
                            class="
                                hidden
                                text-right
                                sm:block
                            "
                        >

                            <p
                                class="
                                    text-[9px]
                                    font-bold
                                    uppercase
                                    tracking-[0.3em]
                                    text-white/60
                                "
                            >
                                Creative Agency
                            </p>

                            <p
                                class="
                                    mt-1
                                    text-xs
                                    font-semibold
                                    text-white
                                "
                            >
                                R27
                            </p>

                        </div>

                    </div>



                    {{-- =========================================
                         HERO TEXT
                    ========================================== --}}

                    <div
                        class="
                            mt-auto
                            max-w-[500px]
                            pb-8
                            pt-20
                        "
                    >

                        <p
                            class="
                                mb-5
                                text-[10px]
                                font-bold
                                uppercase
                                tracking-[0.32em]
                                text-white/70
                            "
                        >
                            Creative Event Management
                        </p>


                        <h1
                            class="
                                text-4xl
                                font-extrabold
                                leading-[1.02]
                                tracking-[-0.045em]
                                sm:text-5xl
                                lg:text-[58px]
                            "
                        >

                            We create

                            <br>

                            <span
                                class="text-[#102a43]"
                            >
                                moments
                            </span>

                            <br>

                            that matter.

                        </h1>



                        {{-- =====================================
                             SMALL INFO CARD
                        ====================================== --}}

                        <div
                            class="
                                floating
                                mt-8
                                flex
                                w-fit
                                items-center
                                gap-3
                                rounded-2xl
                                border
                                border-white/20
                                bg-white/10
                                px-4
                                py-3
                                backdrop-blur-md
                            "
                        >

                            <div
                                class="
                                    flex
                                    h-10
                                    w-10
                                    items-center
                                    justify-center
                                    rounded-xl
                                    bg-white
                                    text-[#00a1ee]
                                "
                            >

                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                >

                                    <rect
                                        x="3"
                                        y="5"
                                        width="18"
                                        height="16"
                                        rx="3"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                    />

                                    <path
                                        d="M8 3V7"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                        stroke-linecap="round"
                                    />

                                    <path
                                        d="M16 3V7"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                        stroke-linecap="round"
                                    />

                                    <path
                                        d="M3 10H21"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                    />

                                </svg>

                            </div>


                            <div>

                                <p
                                    class="
                                        text-xs
                                        font-bold
                                    "
                                >
                                    Event Workspace
                                </p>

                                <p
                                    class="
                                        mt-0.5
                                        text-[10px]
                                        text-white/60
                                    "
                                >
                                    Plan · Create · Manage
                                </p>

                            </div>

                        </div>

                    </div>



                    {{-- =========================================
                         FOOTER
                    ========================================== --}}

                    <div
                        class="
                            border-t
                            border-white/15
                            pt-5
                        "
                    >

                        <div
                            class="
                                flex
                                items-center
                                justify-between
                            "
                        >

                            <p
                                class="
                                    text-[10px]
                                    text-white/50
                                "
                            >
                                © {{ date('Y') }} R2/7 Creative Agency
                            </p>


                            <p
                                class="
                                    text-[10px]
                                    text-white/50
                                "
                            >
                                Creative · Digital · Events
                            </p>

                        </div>

                    </div>

                </div>

            </section>



            {{-- =================================================
                 RIGHT LOGIN CARD
            ================================================== --}}

            <section
                class="
                    login-card
                    relative
                    z-10
                    min-h-[530px]
                    rounded-[28px]
                    border
                    border-white
                    bg-white
                    px-7
                    py-12
                    md:pl-[95px]
                    md:pr-12
                    lg:px-[105px]
                    lg:py-14
                "
            >


                <div
                    class="
                        mx-auto
                        w-full
                        max-w-[360px]
                    "
                >


                    {{-- =========================================
                         LOGIN HEADER
                    ========================================== --}}

                    <div class="mb-8">

                        <div
                            class="
                                mb-5
                                flex
                                items-center
                                gap-2
                            "
                        >

                            <span
                                class="
                                    h-2
                                    w-2
                                    rounded-full
                                    bg-[#00a1ee]
                                "
                            ></span>


                            <span
                                class="
                                    text-[10px]
                                    font-bold
                                    uppercase
                                    tracking-[0.25em]
                                    text-[#00a1ee]
                                "
                            >
                                Member Access
                            </span>

                        </div>


                        <h2
                            class="
                                text-3xl
                                font-extrabold
                                tracking-[-0.04em]
                                text-[#102a43]
                            "
                        >
                            Hello!
                        </h2>

                    </div>



                    {{-- =========================================
                         STATUS MESSAGE
                    ========================================== --}}

                    @if (session('status'))

                        <div
                            class="
                                mb-5
                                rounded-xl
                                border
                                border-green-200
                                bg-green-50
                                px-4
                                py-3
                                text-xs
                                text-green-700
                            "
                        >
                            {{ session('status') }}
                        </div>

                    @endif



                    {{-- =========================================
                         LOGIN FORM
                    ========================================== --}}

                    <form
                        method="POST"
                        action="{{ route('login') }}"
                    >

                        @csrf



                        {{-- EMAIL --}}

                        <div class="mb-5">

                            <label
                                for="email"
                                class="
                                    mb-2
                                    block
                                    text-[10px]
                                    font-bold
                                    uppercase
                                    tracking-wider
                                    text-slate-500
                                "
                            >
                                Email
                            </label>


                            <div class="relative">

                                <span
                                    class="
                                        pointer-events-none
                                        absolute
                                        left-4
                                        top-1/2
                                        -translate-y-1/2
                                        text-slate-300
                                    "
                                >

                                    <svg
                                        class="h-4 w-4"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                    >

                                        <rect
                                            x="3"
                                            y="5"
                                            width="18"
                                            height="14"
                                            rx="2"
                                            stroke="currentColor"
                                            stroke-width="1.6"
                                        />

                                        <path
                                            d="M3 7L12 13L21 7"
                                            stroke="currentColor"
                                            stroke-width="1.6"
                                        />

                                    </svg>

                                </span>


                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    placeholder="you@company.com"
                                    class="
                                        login-input
                                        h-13
                                        w-full
                                        rounded-xl
                                        border
                                        border-slate-200
                                        bg-slate-50
                                        pl-11
                                        pr-4
                                        text-sm
                                        text-[#102a43]
                                        placeholder:text-slate-300
                                    "
                                />

                            </div>


                            @error('email')

                                <p
                                    class="
                                        mt-2
                                        text-xs
                                        text-red-500
                                    "
                                >
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>



                        {{-- PASSWORD --}}

                        <div class="mb-5">

                            <div
                                class="
                                    mb-2
                                    flex
                                    items-center
                                    justify-between
                                "
                            >

                                <label
                                    for="password"
                                    class="
                                        text-[10px]
                                        font-bold
                                        uppercase
                                        tracking-wider
                                        text-slate-500
                                    "
                                >
                                    Password
                                </label>


                                @if (Route::has('password.request'))

                                    <a
                                        href="{{ route('password.request') }}"
                                        class="
                                            text-[10px]
                                            font-semibold
                                            text-[#00a1ee]
                                            hover:text-[#008fd4]
                                        "
                                    >
                                        Forgot?
                                    </a>

                                @endif

                            </div>


                            <div class="relative">

                                <span
                                    class="
                                        pointer-events-none
                                        absolute
                                        left-4
                                        top-1/2
                                        -translate-y-1/2
                                        text-slate-300
                                    "
                                >

                                    <svg
                                        class="h-4 w-4"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                    >

                                        <rect
                                            x="4"
                                            y="10"
                                            width="16"
                                            height="11"
                                            rx="2"
                                            stroke="currentColor"
                                            stroke-width="1.6"
                                        />

                                        <path
                                            d="M8 10V7C8 4.8 9.8 3 12 3C14.2 3 16 4.8 16 7V10"
                                            stroke="currentColor"
                                            stroke-width="1.6"
                                        />

                                    </svg>

                                </span>


                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="Enter your password"
                                    class="
                                        login-input
                                        h-13
                                        w-full
                                        rounded-xl
                                        border
                                        border-slate-200
                                        bg-slate-50
                                        pl-11
                                        pr-12
                                        text-sm
                                        text-[#102a43]
                                        placeholder:text-slate-300
                                    "
                                />


                                {{-- SHOW PASSWORD --}}

                                <button
                                    type="button"
                                    onclick="togglePassword()"
                                    class="
                                        absolute
                                        right-3
                                        top-1/2
                                        -translate-y-1/2
                                        rounded-lg
                                        p-2
                                        text-slate-300
                                        transition
                                        hover:bg-[#eaf8ff]
                                        hover:text-[#00a1ee]
                                    "
                                >

                                    <svg
                                        id="eye-open"
                                        class="h-4 w-4"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                    >

                                        <path
                                            d="M2 12C2 12 5.5 5 12 5C18.5 5 22 12 22 12C22 12 18.5 19 12 19C5.5 19 2 12 2 12Z"
                                            stroke="currentColor"
                                            stroke-width="1.6"
                                        />

                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="3"
                                            stroke="currentColor"
                                            stroke-width="1.6"
                                        />

                                    </svg>


                                    <svg
                                        id="eye-closed"
                                        class="hidden h-4 w-4"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                    >

                                        <path
                                            d="M3 3L21 21"
                                            stroke="currentColor"
                                            stroke-width="1.6"
                                            stroke-linecap="round"
                                        />

                                        <path
                                            d="M2 12C2 12 5.5 5 12 5C18.5 5 22 12 22 12C22 12 18.5 19 12 19C5.5 19 2 12 2 12Z"
                                            stroke="currentColor"
                                            stroke-width="1.6"
                                        />

                                    </svg>

                                </button>

                            </div>


                            @error('password')

                                <p
                                    class="
                                        mt-2
                                        text-xs
                                        text-red-500
                                    "
                                >
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>



                        {{-- REMEMBER --}}

                        <div class="mb-7">

                            <label
                                class="
                                    flex
                                    cursor-pointer
                                    items-center
                                    gap-2.5
                                "
                            >

                                <input
                                    type="checkbox"
                                    name="remember"
                                    class="
                                        h-4
                                        w-4
                                        rounded
                                        border-slate-300
                                        text-[#00a1ee]
                                        focus:ring-[#00a1ee]
                                    "
                                >

                                <span
                                    class="
                                        text-xs
                                        text-slate-500
                                    "
                                >
                                    Keep me signed in
                                </span>

                            </label>

                        </div>



                        {{-- =====================================
                             LOGIN BUTTON
                        ====================================== --}}

                        <button
                            type="submit"
                            class="
                                login-button
                                flex
                                h-13
                                w-full
                                items-center
                                justify-center
                                gap-3
                                rounded-xl
                                text-sm
                                font-bold
                                text-white
                            "
                        >

                            <span>
                                Login
                            </span>


                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                            >

                                <path
                                    d="M5 12H19"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                />

                                <path
                                    d="M13 6L19 12L13 18"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />

                            </svg>

                        </button>

                    </form>



                    {{-- =========================================
                         BOTTOM
                    ========================================== --}}

                    <div
                        class="
                            mt-8
                            border-t
                            border-slate-100
                            pt-5
                            text-center
                        "
                    >

                        <p
                            class="
                                text-[10px]
                                leading-5
                                text-slate-400
                            "
                        >

                            Secure access ·
                            Your workspace is protected.

                        </p>

                    </div>

                </div>

            </section>

        </div>

    </main>

</div>



{{-- =========================================================
     SHOW / HIDE PASSWORD
========================================================== --}}

<script>

function togglePassword() {

    const password =
        document.getElementById('password');

    const eyeOpen =
        document.getElementById('eye-open');

    const eyeClosed =
        document.getElementById('eye-closed');


    if (password.type === 'password') {

        password.type = 'text';

        eyeOpen.classList.add('hidden');

        eyeClosed.classList.remove('hidden');

    } else {

        password.type = 'password';

        eyeOpen.classList.remove('hidden');

        eyeClosed.classList.add('hidden');

    }

}

</script>


</body>

</html>