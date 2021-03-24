// On page load or when changing themes, best to add inline in `head` to avoid FOUC
var htmlElem = document.getElementsByTagName('html')[0];
var toggleDarkModeElem = document.getElementById('toggleDarkMode');

window.onload = setDarkMode;

function setDarkMode(){
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)){
        htmlElem.classList.add('dark');
        toggleDarkModeElem.checked = true;
        localStorage.setItem('theme', 'dark');
    } else {
        htmlElem.classList.remove('dark');
        toggleDarkModeElem.checked = false;
        localStorage.setItem('theme', 'light');
    }
}

toggleDarkModeElem.addEventListener('change', function(){
    if(this.checked){
        localStorage.theme = 'dark';
    }else{
        localStorage.theme = 'light';
    }
    setDarkMode();
});

