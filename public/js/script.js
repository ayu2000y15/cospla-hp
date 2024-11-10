document.addEventListener('DOMContentLoaded', function() {
    const header = document.getElementById('header');
    const menuToggle = document.querySelector('.menu-toggle');
    const mainNav = document.querySelector('.main-nav');
    let lastScrollTop = 0;

    // ハンバーガーメニューの開閉
    menuToggle.addEventListener('click', function() {
        mainNav.classList.toggle('active');
        this.setAttribute('aria-expanded', this.getAttribute('aria-expanded') === 'true' ? 'false' : 'true');
    });

    // スクロール時のヘッダー表示/非表示
    window.addEventListener('scroll', function() {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        if (scrollTop > lastScrollTop) {
            header.classList.add('hidden');
        } else {
            header.classList.remove('hidden');
        }
        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    }, false);

    // ウィンドウサイズ変更時の処理
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            mainNav.classList.remove('active');
            menuToggle.setAttribute('aria-expanded', 'false');
        }
    });

    // スライドショーの機能
    let slideIndex = 1;
    showSlides(slideIndex);

    // 次/前のコントロール
    window.plusSlides = function(n) {
        showSlides(slideIndex += n);
    }

    // サムネイルイメージコントロール
    window.currentSlide = function(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        let i;
        let slides = document.getElementsByClassName("slide");
        let dots = document.getElementsByClassName("dot");
        if (n > slides.length) {slideIndex = 1}
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.opacity = "0";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex-1].style.opacity = "1";
        dots[slideIndex-1].className += " active";
    }

    // 自動スライドショー
    setInterval(function() {
        plusSlides(1);
    }, 5000);

});

function checkSubmit(){
    if(confirm('送信しますか？')){ 
        return true; 
    }else{
        alert('キャンセルされました'); 
        return false; 
    }
}
