$(document).ready(function() {
    WindowWidth = $(window).width();
        //var slides = @json($car1);
        //var slidesToShow = Math.min(slides.length,4);
        //var slides = $("#ford").val()
        //var slidesToShow = Math.min(slides,4);
    if (WindowWidth > 991){
        $('.autoplay').slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            arrows: false,
            autoplay: true,
            autoplaySpeed: 1000,
            rtl: true,
            cssEase: 'Linear',
            pauseOnHover: true,
            //cssEase: 'cubic-bezier(0.600, -0.280, 0.735, 0.045)',
        });
    }
    else if (WindowWidth > 767 && WindowWidth < 992){
        $('.autoplay').slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: false,
            autoplay: true,
            autoplaySpeed: 1000,
            rtl: true,
          });
    }
    else if (WindowWidth > 575 && WindowWidth < 768){
        $('.autoplay').slick({
            infinite: true,
            slidesToShow: 2,
            slidesToScroll: 1,
            arrows: false,
            autoplay: true,
            autoplaySpeed: 1000,
            rtl: true,
          });
    }
    else if (WindowWidth < 576){
        $('.autoplay').slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            autoplay: true,
            autoplaySpeed: 1000,
            rtl: true,
          });
    }
 })
$(document).ready(function() {
    WindowWidth = $(window).width();
    if (WindowWidth > 991){
        $('.multiple-items').slick({
            infinite: true,
            arrows: true,
            slidesToShow: 4,
            slidesToScroll: 4,
            swipeToSlide: true,
            prevArrow:'.Arrow_prev',
            nextArrow:'.Arrow_next',
            speed: 500,
            
          });
      }
    else if (WindowWidth > 767 && WindowWidth < 992){
        $('.multiple-items').slick({
            infinite: true,
            arrows: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            swipeToSlide: true,
            prevArrow:'.Arrow_prev',
            nextArrow:'.Arrow_next',
            speed: 500,
            
          });
      }
    else if (WindowWidth > 575 && WindowWidth < 768){
        $('.multiple-items').slick({
            infinite: true,
            arrows: true,
            slidesToShow: 2,
            slidesToScroll: 2,
            swipeToSlide: true,
            prevArrow:'.Arrow_prev',
            nextArrow:'.Arrow_next',
            speed: 500,
            
          });
      }
    else if (WindowWidth < 576){
        $('.multiple-items').slick({
            infinite: true,
            arrows: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            swipeToSlide: true,
            prevArrow:'.Arrow_prev',
            nextArrow:'.Arrow_next',
            speed: 500,
            
          });
      }
 })

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