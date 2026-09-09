document.addEventListener('livewire:init', () => {

    Livewire.on('show-modal', (event) => {
        const modalElement = document.getElementById(event.modalId);
        const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
        modal?.show();
    });

    Livewire.on('hide-modal', (event) => {
        const modalElement = document.getElementById(event.modalId);
        const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
        modal?.hide();
    });

});
