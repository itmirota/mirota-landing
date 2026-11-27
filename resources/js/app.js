import Alpine from 'alpinejs'

Alpine.data('visitGallery', (slides) => ({
    slides,
    items: [],          // daftar slide yang dirender (bisa digandakan agar loop mulus)
    perView: 1,
    step: 0,            // lebar satu slide (px)
    x: 0,               // posisi geser (px)
    animate: true,
    busy: false,
    cur: 0,             // indeks foto asli yang paling kiri
    lightbox: null,
    timer: null,
    tx: 0,
    duration: 500,

    init() {
        this.$nextTick(() => {
            this.measure()
            this.start()
        })
    },
    destroy() {
        this.stop()
    },

    measure() {
        const w = window.innerWidth
        const pv = w >= 1024 ? 3 : w >= 640 ? 2 : 1
        const changed = pv !== this.perView
        this.perView = pv
        this.step = this.$refs.viewport.clientWidth / pv
        if (changed || !this.items.length) this.build()
    },

    build() {
        const n = this.slides.length
        if (!n) return
        const copies = Math.ceil((this.perView + n + 1) / n)
        const items = []
        for (let c = 0; c < copies; c++) {
            this.slides.forEach((s, i) => items.push({ uid: c + '-' + i, orig: i, ...s }))
        }
        this.animate = false
        this.x = 0
        this.cur = 0
        this.items = items
    },

    slide(dir, n = 1) {
        if (this.busy || !this.slides.length) return
        this.busy = true
        const N = this.slides.length
        this.start() // reset hitungan autoplay setelah klik manual

        if (dir > 0) {
            this.animate = true
            this.x = n * this.step
            setTimeout(() => {
                this.animate = false
                this.items.push(...this.items.splice(0, n))
                this.x = 0
                this.cur = (this.cur + n) % N
                this.busy = false
            }, this.duration + 20)
        } else {
            this.animate = false
            this.items.unshift(...this.items.splice(-n, n))
            this.x = n * this.step
            this.$nextTick(() => requestAnimationFrame(() => requestAnimationFrame(() => {
                this.animate = true
                this.x = 0
                this.cur = (((this.cur - n) % N) + N) % N
                setTimeout(() => { this.busy = false }, this.duration + 20)
            })))
        }
    },
    next(n = 1) { this.slide(1, n) },
    prev(n = 1) { this.slide(-1, n) },

    go(i) {
        const N = this.slides.length
        const f = (i - this.cur + N) % N
        if (!f) return
        const b = N - f
        f <= b ? this.next(f) : this.prev(b)
    },

    swipe(e) {
        const dx = e.changedTouches[0].clientX - this.tx
        if (Math.abs(dx) > 50) dx < 0 ? this.next() : this.prev()
    },

    start() {
        this.stop()
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return
        this.timer = setInterval(() => {
            if (this.lightbox === null) this.next()
        }, 3500)
    },
    stop() {
        clearInterval(this.timer)
    },

    open(i) { this.lightbox = i },
    close() { this.lightbox = null },
    lbNext() { this.lightbox = (this.lightbox + 1) % this.slides.length },
    lbPrev() { this.lightbox = (this.lightbox - 1 + this.slides.length) % this.slides.length },
}))

Alpine.data('heroBanner', (count) => ({
    i: 0,
    n: count,
    timer: null,
    tx: 0,

    init() { this.play() },
    destroy() { this.stop() },

    go(k) { this.i = (k + this.n) % this.n },
    next() { this.go(this.i + 1) },
    prev() { this.go(this.i - 1) },

    play() {
        this.stop()
        if (this.n < 2 || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return
        this.timer = setInterval(() => this.next(), 6000)
    },
    stop() { clearInterval(this.timer) },

    swipe(e) {
        const dx = e.changedTouches[0].clientX - this.tx
        if (Math.abs(dx) > 50) dx < 0 ? this.next() : this.prev()
    },
}))

window.Alpine = Alpine
Alpine.start()
// ── Indikator loading saat pindah halaman ──
(() => {
    const bar = document.getElementById('page-progress');
    const loader = document.getElementById('page-loader');
    if (!bar && !loader) return;

    let timer = null;
    let safety = null;
    let showLoader = null;

    const reset = () => {
        clearInterval(timer);
        clearTimeout(safety);
        clearTimeout(showLoader);
        if (loader) loader.classList.remove('is-active');
        if (bar) {
            bar.classList.remove('is-active');
            bar.style.width = '0';
        }
    };

    const start = () => {
        reset();

        if (bar) {
            let width = 8;
            bar.classList.add('is-active');
            bar.style.width = width + '%';

            // Merambat pelan mendekati 90%, lalu menunggu halaman baru terbuka.
            timer = setInterval(() => {
                width += (90 - width) * 0.08;
                bar.style.width = width + '%';
            }, 200);
        }

        // Simbol infinity baru muncul jika pemuatan agak lama (tidak berkedip di halaman cepat).
        if (loader) {
            showLoader = setTimeout(() => loader.classList.add('is-active'), 250);
        }

        // Pengaman: kalau navigasi batal atau tak selesai, semuanya hilang sendiri.
        safety = setTimeout(reset, 15000);
    };

    document.addEventListener('click', (event) => {
        if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;

        const link = event.target.closest('a[href]');
        if (!link || link.target === '_blank' || link.hasAttribute('download')) return;

        const url = new URL(link.href, location.href);
        if (!/^https?:$/.test(url.protocol)) return;            // mailto:, tel:
        if (url.origin !== location.origin) return;             // tautan ke situs lain
        if (url.pathname === location.pathname && url.search === location.search) return; // #bagian di halaman sama

        start();
    });

    // Pengiriman formulir (hanya jika tidak dibatalkan oleh validasi di browser).
    document.addEventListener('submit', (event) => {
        if (!event.defaultPrevented) start();
    });

    // Saat kembali lewat tombol Back, pastikan tidak ada yang tertinggal.
    window.addEventListener('pageshow', reset);
})();