document.addEventListener("DOMContentLoaded", function () {
    const header = document.getElementById("header");
    const menuToggle = document.querySelector(".menu-toggle");
    // モバイル用のナビゲーションを正しく選択
    const mobileNav = document.getElementById("main-nav-mobile");
    let lastScrollTop = 0;

    // ハンバーガーメニューの開閉
    if (menuToggle && mobileNav) {
        menuToggle.addEventListener("click", function () {
            // style.display を直接切り替える
            const isMenuOpen = mobileNav.style.display === "flex";
            mobileNav.style.display = isMenuOpen ? "none" : "flex";
            this.setAttribute("aria-expanded", !isMenuOpen);
        });
    }

    // スクロール時のヘッダー表示/非表示
    window.addEventListener(
        "scroll",
        function () {
            let scrollTop =
                window.pageYOffset || document.documentElement.scrollTop;
            if (scrollTop > lastScrollTop) {
                header.classList.add("hidden");
            } else {
                header.classList.remove("hidden");
            }
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        },
        false
    );

    // ウィンドウサイズ変更時の処理
    window.addEventListener("resize", function () {
        if (window.innerWidth > 768) {
            if (mobileNav) mobileNav.style.display = "none";
            if (menuToggle) menuToggle.setAttribute("aria-expanded", "false");
        }
    });

    // --- スライドショー機能の修正 ---
    const slidesContainer = document.querySelector(".slideshow-container");
    if (slidesContainer) {
        let slideIndex = 1;
        const slides = document.getElementsByClassName("slide");
        const dots = document.getElementsByClassName("dot");

        function showSlides(n) {
            if (n > slides.length) {
                slideIndex = 1;
            }
            if (n < 1) {
                slideIndex = slides.length;
            }

            for (let i = 0; i < slides.length; i++) {
                slides[i].classList.add("hidden", "opacity-0");
            }
            for (let i = 0; i < dots.length; i++) {
                dots[i].classList.remove("active");
            }

            slides[slideIndex - 1].classList.remove("hidden");
            // 少し遅れてopacityを1にすることでフェードイン効果を出す
            setTimeout(() => {
                slides[slideIndex - 1].classList.remove("opacity-0");
            }, 10);
            dots[slideIndex - 1].classList.add("active");
        }

        // グローバルスコープに関数を設定
        window.plusSlides = function (n) {
            showSlides((slideIndex += n));
        };
        window.currentSlide = function (n) {
            showSlides((slideIndex = n));
        };

        // 初期表示
        showSlides(slideIndex);

        // 自動スライドショー
        setInterval(function () {
            plusSlides(1);
        }, 5000);
    }
    // --- スライドショー機能の修正ここまで ---
});

function checkSubmit() {
    if (confirm("送信しますか？")) {
        return true;
    } else {
        alert("キャンセルされました");
        return false;
    }
}
