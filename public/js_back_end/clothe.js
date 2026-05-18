function setCookie(key, value, expiry) {
    var expires = new Date();
    expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
    document.cookie = key + '=' + value + ';path=/' + ';expires=' + expires.toUTCString();
}

function getCookie(key) {
    var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
    return keyValue ? keyValue[2] : null;
}

function myFunction() {
    var element = document.body;

    element.classList.toggle("dark-mode");

    var darkMode = '';
    if (element.classList.contains("dark-mode")) {
        darkMode = "dark-mode";
    }

    setCookie("darkMode", darkMode, 1);

 }
 $(document).ready(function() {
    var darkMode = getCookie('darkMode');
    var element = document.body;
    if (darkMode == 'dark-mode') {
        element.classList.toggle(darkMode);  
    }
});
 
