<section class="relative h-screen flex items-center">

    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="{{ asset('images/building.jpg') }}" 
             class="w-full h-full object-cover" 
             alt="Hero Image">
    </div>

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/50 bg-opacity-50"></div>

    <!-- Content -->
    <div class="relative container mx-auto px-6">
        <div class="max-w-xl text-white">

            <h1 class="text-4xl md:text-6xl font-bold leading-none">
                Produsen Susu Bubuk Berkualitas Tinggi
            </h1>

            <p class="mt-4 text-lg text-gray-200">
                Solusi maklon susu bubuk dengan standar produksi modern, aman, dan terpercaya.
            </p>

            <div class="mt-6 flex gap-4">
                <a href="/produk" class="bg-blue-600 px-6 py-3 rounded-lg hover:bg-blue-700">
                    Lihat Produk
                </a>

                <a href="/maklon" class="border border-white px-6 py-3 rounded-lg hover:bg-white hover:text-black">
                    Konsultasi Maklon
                </a>
            </div>

        </div>
    </div>

</section>

<section class="bg-gray-50">
    <div class="container mx-auto px-6 py-16 flex flex-col md:flex-row items-center">
        
        <!-- Text -->
        <div class="md:w-1/2 space-y-6">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 leading-tight">
                Produsen Susu Bubuk Berkualitas Tinggi
            </h1>

            <p class="text-lg text-gray-600">
                PT. Mirota KSM menghadirkan solusi maklon susu bubuk dengan standar produksi modern, aman, dan terpercaya.
            </p>

            <div class="flex gap-4">
                <a href="/produk" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                    Lihat Produk
                </a>

                <a href="/maklon" class="border border-blue-600 text-blue-600 px-6 py-3 rounded-lg hover:bg-blue-50">
                    Konsultasi Maklon
                </a>
            </div>
        </div>

        <!-- Image -->
        <div class="md:w-1/2 mt-10 md:mt-0">
            <img src="/images/building.jpg" alt="PT Mirota KSM" class="w-full">
        </div>

    </div>
</section>