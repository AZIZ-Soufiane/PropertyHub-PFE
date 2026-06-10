document.addEventListener('alpine:init', () => {
    Alpine.data('userManager', (initialCreateModal, initialEditModal, initialEditUser) => ({
        showCreateModal: initialCreateModal,
        showViewModal: false,
        viewUser: null,
        showEditModal: initialEditModal,
        editUser: initialEditUser
    }));
});
