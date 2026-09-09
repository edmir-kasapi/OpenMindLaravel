export function showToast(type, message)
{
    let toast;
    let messageElement;

    if(type === 'success')
    {
        toast = document.getElementById('success-toast');
        messageElement = document.getElementById('success-toast-text');
    }
    else
    {
        toast = document.getElementById('error-toast');
        messageElement = document.getElementById('error-toast-text');
    }

    messageElement.textContent = message;

    const bsToast = bootstrap.Toast.getOrCreateInstance(toast,{
        delay: 4000
    });

    bsToast.show();
}
