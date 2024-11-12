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

//ファイルアップロードのチェック
function updateFileNames(input) {
    const filesDiv = document.getElementById('selected-files');
    filesDiv.innerHTML = '';
    if (input.files && input.files.length > 0) {
        const fileList = document.createElement('ul');
        fileList.className = 'file-list';
        for (let i = 0; i < input.files.length; i++) {
            const li = document.createElement('li');
            const file = input.files[i];
            const fileSize = (file.size / 1024 / 1024).toFixed(2); // サイズをMBに変換
            if (!file.type.startsWith('image/')) {
                li.textContent = `${file.name} - エラー: 画像ファイルではありません`;
                li.style.color = 'red';
                hasError = true;
            } else if (fileSize > 5) {
                li.textContent = `${file.name} (${fileSize} MB) - エラー: ファイルサイズが5MBを超えています`;
                li.style.color = 'red';
                hasError = true;
            } else {
                li.textContent = `${file.name} (${fileSize} MB)`;
            }
            fileList.appendChild(li);
        }
        filesDiv.appendChild(fileList);
    }
}


// Image Preview Modal
function openImagePreview(imgSrc) {
    const modal = document.getElementById('imagePreviewModal');
    const modalImg = document.getElementById('previewImage');
    modal.style.display = 'block';
    modalImg.src = imgSrc;
}

const modal = document.getElementById('imagePreviewModal');
const span = document.getElementsByClassName('close')[0];

span.onclick = function() {
    modal.style.display = 'none';
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}