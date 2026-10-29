<!-- NAVBAR -->
<!-- <nav class="fixed w-full top-0 z-50 py-3 px-5 bg-white/10 backdrop-blur-md"> -->
<nav class="fixed left-0 right-0 mx-auto w-[90%] max-w-6xl z-50 py-3 px-6 md:px-10 bg-white/10 backdrop-blur-md shadow-md rounded-md">

    <div class="flex w-full flex-wrap justify-between">
    <div class="flex justify-center w-[15dvh] max-w-[50dvh]">
        <img 
            src="images/mirota.png" 
            alt="PT Mirota KSM" 
            class="w-full h-auto"
        />
    </div>

    <div class="flex flex-col justify-center md:hidden" >
        <button class="bg-green p-2 rounded-lg" @click="open = !open">
            <svg class="size-5"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 6H20M4 12H20M4 18H20" stroke="#F5EB29" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>    
        </button>
    </div>

    <div x-show="open" x-transition class="absolute top-full w-full left-0 z-5">
        <ul class="w-full bg-green text-white p-2 text-right">
            <li><a href="">Tentang</a></li>
            <li><a href="#hadiah">Hadiah</a></li>
            <li><a href="#cara-ikut">Cara Ikut</a></li>
            <li><a href="#syarat-ketentuan">Syarat dan Ketentuan</a></li>
        </ul>
    </div>

    <ul class="hidden md:flex text-[1.5dvh] lg:text-[2.5dvh] text-green font-bold items-center gap-6">
        <li><a href="" class="hover:text-yellow-400 active:text-yellow-600">Tentang</a></li>
        <li><a href="#hadiah" class="hover:text-yellow-400 active:text-yellow-600">Hadiah</a></li>
        <li><a href="#cara-ikut" class="hover:text-yellow-400 active:text-yellow-600">Cara Ikut</a></li>
        <li><a href="#syarat-ketentuan" class="hover:text-yellow-400 active:text-yellow-600">Syarat dan Ketentuan</a></li>
    </ul>
    </div>
</nav>

