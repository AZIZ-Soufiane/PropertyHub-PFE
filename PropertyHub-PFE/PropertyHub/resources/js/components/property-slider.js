document.addEventListener('alpine:init', () => {
    Alpine.data('propertySlider', (initialImages) => ({
        images: initialImages,
        current: 0,
        get total() {
            return this.images.length;
        },
        next() {
            this.current = (this.current + 1) % this.total;
        },
        prev() {
            this.current = (this.current - 1 + this.total) % this.total;
        },
        goTo(i) {
            this.current = i;
        },
        init() {
            setInterval(() => this.next(), 6000);
        }
    }));
});
