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

window.Alpine = Alpine
Alpine.start()