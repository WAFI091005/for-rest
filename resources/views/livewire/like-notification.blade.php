<div 
    x-data="{ show: @entangle('showNotification') }" 
    x-show="show"
    x-init="
        window.addEventListener('hide-notification', e => {
            setTimeout(() => show = false, e.detail.timeout);
        });
    "
    class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow z-50"
    style="display: none;"
>
    Artikel berhasil di-like!
</div>
