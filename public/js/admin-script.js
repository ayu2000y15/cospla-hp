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

});

//タブ切り替えの動き
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');

            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));

            this.classList.add('active');
            document.getElementById(tabId).classList.add('active');

            // アクティブタブの情報を全てのフォームに追加
            document.querySelectorAll('form').forEach(form => {
                let input = form.querySelector('input[name="active_tab"]');
                if (!input) {
                    input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'active_tab';
                    form.appendChild(input);
                }
                input.value = tabId;
            });
        });
    });
});


function checkSubmit(type){
    if(confirm(type.concat('しますか？'))){ 
        return true; 
    }else{
        return false; 
    }
}

function checkSubmit(action) {
    return confirm(action ? `この${itemName}を${action}してもよろしいですか？` : 'この操作を実行してもよろしいですか？');
}

function resetForm() {
    document.getElementById('adminForm').reset();
    document.getElementById('ITEM_ID').value = '';
    document.getElementById('EXE_ID').value = submitExeId;
    document.getElementById('submitBtn').textContent = '登録';
}

window.addEventListener('scroll', function() {
    var backToTopButton = document.querySelector('.back-to-top');
    if (window.pageYOffset > 300) {
        backToTopButton.style.display = 'block';
    } else {
        backToTopButton.style.display = 'none';
    }
});