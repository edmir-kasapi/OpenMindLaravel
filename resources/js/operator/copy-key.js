
$(document).ready(function(){

    $(document).on('click', '#copy-token', function (e){

        e.preventDefault;
        copyToken();

    });

    function copyToken() {
    const token = document.getElementById('access-token').value;
    const successMessage = document.getElementById('copy-success');

    navigator.clipboard.writeText(token).then(() => {
        successMessage.classList.remove('d-none');

        setTimeout(() => {
            successMessage.classList.add('d-none');
        }, 3000);
    });
}

});





