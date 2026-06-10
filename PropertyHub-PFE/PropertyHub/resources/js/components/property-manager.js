document.addEventListener('alpine:init', () => {
    Alpine.data('propertyManager', (initialCreateModal) => ({
        showCreateModal: initialCreateModal,
        showReviewModal: false,
        reviewProperty: null,
        reviewAction: '',
        reviewNote: ''
    }));
});
