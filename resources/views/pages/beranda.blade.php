@extends('layouts.app')

<style>
.divider-responsive {
    position: relative;
    padding-left: 1%;
}

.divider-responsive::before {
    content: '';
    position: absolute;
    background-color: #22c55e;
    z-index: 0;
    transition: all 0.3s ease;
}

@media (max-width: 767px) {
    .divider-responsive {
        position: relative;
        min-height: 100px;
    }

    .divider-responsive::before {
        top: 40%;
        left: 5%;
        width: 90%;
        height: 2px;
        transform: translateY(-50%);
    }

    .divider-responsive > div:first-child {
        padding-bottom: 3rem;
    }

    .divider-responsive > div:last-child {
        padding-top: 3rem;
    }
}

@media (min-width: 768px) {
    .divider-responsive::before {
        top: 0;
        left: 50%;
        width: 2px;
        height: 100%;
        transform: translateX(-50%);
    }
}

.hero-fixed {
    background-attachment: fixed;
    background-size: cover;
    background-position: center;
}

/* Animasi untuk fade + slide saat scroll */
.section-scroll {
    opacity: 0;
    transform: translateY(60px);
    transition: all 1s ease;
}

.section-scroll.visible {
    opacity: 1;
    transform: translateY(0);
}
</style>

@section('content')
    <!-- Hero -->
    <section class="relative h-[650px] hero-fixed" style="background-image: url('{{ asset('assets/img/forest1.jpg') }}')">
        <div class="absolute inset-0 bg-opacity-60"></div>
        <div class="relative z-10 max-w-4xl mx-auto h-full flex flex-col items-center justify-center text-center px-4">
            <h1 class="text-white text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                <span class="block">Abadikan Kenangan Indahmu</span>
                <span class="block text-green-400 typed-text"></span>
            </h1>
            <p class="mt-6 text-white text-lg md:text-xl max-w-2xl">Abadikan, bagikan, dan hidupkan kembali momen-momen paling berharga Anda di alam bersama For-Rest.</p>
            <div class="mt-8 flex flex-col sm:flex-row gap-4">
                <a href="{{ route('create.memori') }}" class="bg-white text-green-700 hover:bg-green-100 font-semibold py-3 px-6 rounded-full transition-all duration-300 shadow-lg flex items-center justify-center">
                    <span class="mr-2">+</span> Mulai Perjalananmu
                </a>
                <a href="#featured-memories" class="border-2 border-white text-white hover:bg-white hover:text-black font-semibold py-3 px-6 rounded-full transition-all duration-300 flex items-center justify-center">
                    <span class="mr-2">▶</span> Lihat dalam Aksi
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Memories -->
    <section id="featured-memories" class="py-16 bg-green-50 section-scroll">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Kenangan Unggulan</h2>
                <p class="mt-4 text-xl text-gray-600 max-w-3xl mx-auto">Pengalaman tak terlupakan dari penjelajah alam yang menginspirasi</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($memories as $memory)
                    <a href="{{ route('memories.show', $memory->id) }}" class="tilt-card relative rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition duration-300 group block">
                        <img src="{{ $memory->image }}" alt="{{ $memory->title }}" class="w-full h-72 object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                        <div class="absolute top-4 left-4 z-10">
                            <span class="text-white text-xs font-semibold px-3 py-1 rounded-full">
                                {{ $memory->category->name ?? 'Uncategorized' }}
                            </span>
                        </div>
                        <div class="absolute bottom-0 left-0 w-full px-4 py-4 text-white z-10 bg-gradient-to-t from-black/70 via-black/30 to-transparent">
                            <h3 class="text-lg font-semibold truncate">{{ $memory->title }}</h3>
                            <p class="text-sm text-gray-300 mb-1">By {{ $memory->author }} • {{ \Carbon\Carbon::parse($memory->trip_date)->diffForHumans() }}</p>
                            <div class="flex items-center gap-1 text-xs text-gray-300">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a6 6 0 016 6c0 4.418-6 10-6 10S4 12.418 4 8a6 6 0 016-6zm0 3a3 3 0 100 6 3 3 0 000-6z" clip-rule="evenodd"/></svg>
                                <span>{{ $memory->location }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-12 text-center">
                <a href="{{ route('memori') }}" class="inline-flex items-center px-6 py-3 text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700">                  
                    Lihat Lebih Banyak Kenangan <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Category Section -->
    <section class="py-16 section-scroll">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Jelajahi berdasarkan Kategori</h2>
                <p class="mt-4 text-xl text-gray-600 max-w-3xl mx-auto">Temukan kenangan perjalanan berdasarkan kategori.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($categories as $category)
                    <a href="{{ route('memories.byCategory', $category->slug) }}" class="group tilt-card">
                        <div class="relative h-64 rounded-lg overflow-hidden">
                            <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
                            <div class="absolute bottom-0 left-0 p-4">
                                <h3 class="text-white font-bold text-lg">{{ $category->name }}</h3>
                                <p class="text-gray-200 text-sm">memories</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA -->
<section class="py-20 bg-cover bg-center bg-no-repeat text-white text-center section-scroll"
         style="background-image: url('{{ asset('assets/img/forest.jpg') }}');">
    <div class="px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-extrabold mb-6 drop-shadow-md">Bagikan Kisah Perjalanan Anda</h2>
            <p class="text-xl mb-8 max-w-3xl mx-auto drop-shadow">Setiap perjalanan di alam memiliki kisah yang unik. Bagikan pengalaman Anda dan berikan inspirasi kepada orang lain.</p>
            <a href="{{ route('create.memori') }}">
                <button class="bg-white text-green-800 hover:bg-green-100 px-8 py-4 rounded-lg font-bold text-lg transition duration-300 shadow-md">
                    Mulai Ciptakan Kenangan
                </button>
            </a>
        </div>
    </div>
</section>



    <!-- Community Timeline Section -->
    <section id="tentangkami" class="py-16 bg-white section-scroll">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="divider-responsive grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
                <!-- Left -->
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Temukan Komunitas Petualang Sejati</h2>
                    <p class="text-gray-700 mb-6">Bergabunglah dalam ekosistem yang hidup, tempat di mana semangat eksplorasi dan kecintaan pada alam dipertemukan.</p>

                    <!-- Info Box -->
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="text-green-600 text-2xl"><i class="fas fa-users"></i></div>
                            <div>
                                <h3 class="text-lg font-semibold">Komunitas Dinamis</h3>
                                <p class="text-gray-600 text-sm">Bertukar cerita, pengalaman, dan inspirasi bersama sesama pecinta alam.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="text-yellow-600 text-2xl"><i class="fas fa-info-circle"></i></div>
                            <div>
                                <h3 class="text-lg font-semibold">Siapa Kami?</h3>
                                <p class="text-gray-600 text-sm">Kami adalah tim yang didorong oleh rasa ingin tahu dan cinta terhadap keindahan alam.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="text-indigo-600 text-2xl"><i class="fas fa-bullseye"></i></div>
                            <div>
                                <h3 class="text-lg font-semibold">Visi & Misi</h3>
                                <p class="text-gray-600 text-sm">Menghubungkan individu melalui perjalanan otentik dan pengalaman alam yang bermakna.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right -->
                <div class="relative z-10">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-900">Komunitas Aktif</h2>
                        <p class="mt-4 text-xl text-gray-600 max-w-3xl mx-auto">Bergabunglah dengan komunitas pecinta hutan dan berbagi informasi perjalanan.</p>
                    </div>
                    <div class="grid grid-cols-1 gap-8">
                        @foreach($communities as $community)
                            <div class="tilt-card bg-white rounded-lg shadow-md hover:shadow-lg overflow-hidden transition-shadow duration-300">
                                <img src="{{ asset('storage/' . $community->image) }}" alt="{{ $community->name }}" class="w-full h-48 object-cover">
                                <div class="p-6">
                                    <h3 class="text-xl font-semibold">{{ $community->name }}</h3>
                                    <p class="text-gray-600 text-sm">{{ $community->description }}</p>
                                    <a href="{{ route('communities.index', $community->id) }}" class="text-green-600 hover:text-green-700">Bergabunglah dengan Komunitas</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-12 text-center">
                        <a href="{{ route('communities.index') }}" class="inline-flex items-center px-6 py-3 text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700">      
                            Lihat Semua Komunitas <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- JavaScript --}}
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.7.2/dist/vanilla-tilt.min.js"></script>
    <script>
        new Typed(".typed-text", {
            strings: ["Forest Adventures", "Wildlife Stories", "Outdoor Memories"],
            typeSpeed: 70,
            backSpeed: 50,
            loop: true,
            showCursor: false
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener("click", function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute("href"))?.scrollIntoView({ behavior: "smooth" });
            });
        });

        // IntersectionObserver for animation
        const scrollSections = document.querySelectorAll('.section-scroll');
        const sectionObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    sectionObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.2 });

        scrollSections.forEach(section => {
            sectionObserver.observe(section);
        });

        // Tilt cards
        VanillaTilt.init(document.querySelectorAll(".tilt-card"), {
            max: 10,
            speed: 400,
            glare: true,
            "max-glare": 0.3
        });
    </script>
@endsection
