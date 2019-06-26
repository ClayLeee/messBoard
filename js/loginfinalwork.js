$(document).ready(function () {
    $('#login__submit').on('click', function(e) {

        e.preventDefault();

        let username = document.querySelector('[name=username]');
        let password = document.querySelector('[name=password]');

        if(chkRequired(username) && chkRequired(password)) {
            $.ajax({
                type: 'POST',
                url: 'logintest.php',
                data: {
                    username: $('#login__username').val(),
                    password: $('#login__password').val()
                },
                error: xhr => {
                    alert('Ajax request 發生錯誤');
                },
                success: res => {
                    //console.log(res);

                    if( res === 'pass' ) {
                        document.location.href = 'index.php';
                    }
                    if( res === 'error') {
                        showWarning('', '您的帳號或密碼似乎有錯誤!請重新輸入!');
                    }
                },       
            })
        } else {
            if(!chkRequired(username)) showWarning(username,'以下皆為必填項目');
            if(!chkRequired(password)) showWarning(password,'以下皆為必填項目');
        }
    });
    $('.close').on('click', function() {
        document.location.href = 'login.php';
    });
})

function chkRequired(field) {
    if(field.value === '') return false;
    else return true;
}

function showWarning(field, warningText) {
    $('.warning').text(warningText);
    $('#login__alert').css('visibility', 'visible');
}