document.addEventListener('alpine:init', () => {
    Alpine.data('propertyEditor', (initialEditModal) => ({
        showEditModal: initialEditModal,
        deletedImages: []
    }));
});
