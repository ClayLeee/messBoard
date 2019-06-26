$(document).ready(function () {
    $('#register__submit').on('click', function(e) {

        e.preventDefault();

        let username = document.querySelector('[name=username]');
        let password = document.querySelector('[name=password]');
        let nickname = document.querySelector('[name=nickname]');

        if(chkRequired(username) && chkRequired(password) && chkRequired(nickname)) {
            $.ajax({
                type: 'POST',
                url: 'registertest.php',
                dataType: 'json',
                data: {
                    username: $('#register__username').val(),
                    password: $('#register__password').val(),
                    nickname: $('#register__nickname').val()
                },
                error: xhr => {
                    alert('Ajax request 發生錯誤');
                },
                success: res => {
                    // console.log(res);

                    if( res === 'pass' ) {
                        document.location.href = 'index.php';
                    }
                    if( res === 'repeat') {
                        showWarning('', 'Username已有人使用!請重新輸入!');
                    }
                    if( res === 'error') {
                        showWarning('', '系統錯誤!請輸入有效字元!');
                    }
                },       
            })
        } else {
            if(!chkRequired(username)) showWarning(username,'以下皆為必填項目');
            if(!chkRequired(password)) showWarning(password,'以下皆為必填項目');
            if(!chkRequired(nickname)) showWarning(nickname,'以下皆為必填項目');
        }
    });
    $('.close').on('click', function() {
        document.location.href = 'register.php';
    });
})

function chkRequired(field) {
    if(field.value === '') return false;
    else return true;
}

function showWarning(field, warningText) {
    $('.warning').text(warningText);
    $('#register__alert').css('visibility', 'visible');
}