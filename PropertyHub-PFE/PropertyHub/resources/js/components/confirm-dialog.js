document.addEventListener('alpine:init', () => {
    Alpine.store('confirm', {
        show: false,
        message: '',
        callback: null,

        ask(message, cb) {
            this.message = message;
            this.callback = cb;
            this.show = true;
        },

        proceed() {
            if (typeof this.callback === 'function') {
                this.callback();
            }
            this.reset();
        },

        cancel() {
            this.reset();
        },

        reset() {
            this.show = false;
            this.message = '';
            this.callback = null;
        },
    });
});
