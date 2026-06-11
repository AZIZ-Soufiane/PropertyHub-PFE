document.addEventListener('alpine:init', () => {
    Alpine.data('categoryManager', () => ({
        showModal: false,
        editing: false,
        editId: null,
        formName: '',
        formActive: true,

        openCreateModal() {
            this.editing = false;
            this.editId = null;
            this.formName = '';
            this.formActive = true;
            this.showModal = true;
        },

        openEditModal(id, name, active) {
            this.editing = true;
            this.editId = id;
            this.formName = name;
            this.formActive = active;
            this.showModal = true;
        }
    }));
});
