
document.addEventListener('livewire:init', () => {
    Livewire.on('close-modal', () => {
        const modalElement = document.getElementById('modal-add-user');
        const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
        modal?.hide();
    });

    Livewire.on('show-success-message', (event) => {
        showToast('success', event.message);
    });

    Livewire.on('show-error-message', (event) => {
        showToast('error', event.message);
    });
});





