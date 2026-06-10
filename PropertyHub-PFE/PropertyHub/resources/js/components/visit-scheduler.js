document.addEventListener('alpine:init', () => {
    Alpine.data('visitScheduler', (propertyId, availableSlotsUrl) => ({
        date: '',
        slots: [],
        loading: false,
        propertyId: propertyId,
        availableSlotsUrl: availableSlotsUrl,
        async fetchSlots() {
            if (!this.date) {
                this.slots = [];
                return;
            }
            this.loading = true;
            try {
                const res = await fetch(`${this.availableSlotsUrl}?property_id=${this.propertyId}&date=${this.date}`);
                const data = await res.json();
                this.slots = data.slots ?? [];
            } catch {
                this.slots = [];
            }
            this.loading = false;
        }
    }));
});
