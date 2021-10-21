Livewire.on('alert', () => {
    setTimeout(function () {
        document.getElementById('alert').style.display = "none";
    }, 3000);
});
