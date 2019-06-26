$(document).ready(function () {
    //.on()能做到動態事件綁定
    $('.container-fluid').on('click', e => {
        //讓textarea輸入的文字POST到資料庫過程變成ajax
        var text = $(e.target).parent().parent().next();
        if( chkRequired(text) ) {
            if( $(e.target).hasClass('comment__edited')) {
                var content = $(e.target).parent().parent().next().val();
                var comment_id = $(e.target).parent().parent().next().next().text();
                console.log(content);
                console.log(comment_id);
                $.ajax({
                    type: "POST",
                    url: "modify.php",
                    dataType: "json",
                    data: {
                        content: $(e.target).parent().parent().next().val(),
                        comment_id: $(e.target).parent().parent().next().next().text()
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alert(XMLHttpRequest.status);
                        alert(XMLHttpRequest.readyState);
                        alert(textStatus);
                    },
                    success: res => {
                        // console.log(res);
                        if( res === 'modified' ) {
                            // JQ沒有內建變更outerHTML程式，因此用prop獲取outerHTML再更改
                            text.prop('outerHTML' , `<div class="comment__content text-light">${htmlspecialchars(text.val())}</div>`);

                            e.target.innerText = "編輯";
                            e.target.className = "comment__edit btn btn-outline-info";
                        }
                    }
                })
            }
        }

       //按下編輯之後，讓文字顯示區塊變成textarea
       if( $(e.target).hasClass('comment__edit') ) {
            var content = e.target.parentNode.parentNode.nextElementSibling;
            var newTextArea = document.createElement('textarea');
            //顯示留言區塊轉換成textarea
            newTextArea.className = "comment__textarea";
            newTextArea.innerText = content.innerText;
            content.outerHTML = newTextArea.outerHTML;
            e.target.innerText = "完成";
            e.target.className = "comment__edited btn btn-outline-info";
        }
        //刪除處理
        if( $(e.target).hasClass('comment__delete') ) {
            var content =  e.target.parentNode.parentNode.nextElementSibling;
            var comment_id = content.nextElementSibling;

            if( chkRequired(content)) {
                let req = new XMLHttpRequest();

                req.onload = () => {
                    if ( req.status >= 200 && req.status < 400 ) {
                        if( req.responseText === 'deleted') {
                            $(e.target).parent().parent().parent().remove();
                        }
                    }
                }
                req.open('POST', 'delete.php', true);
                req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded' );
                //post send去delete.php的資訊
                req.send('comment_id=' + comment_id.innerText);
            }
        }
    })

    //登出處理
    $('.hyperlink__logout').on('click', () => {

		document.location.href = 'logout.php';

    })

    //留言及子留言處理
    $('.container-fluid').on('click','.board__form-submit', function(e) {

        e.preventDefault();

        if($(e.target).prev().prev().children().val() === '') {
            alert('請輸入留言內容');
        } else {
            $.ajax({
                type: 'POST',
                url: 'insert.php',
                data: {
                    parent_id: $(e.target).prev().val(),
                    content: $(e.target).prev().prev().children().val()
                },
                success: res => {
                    // console.log(res);

                    var resText = JSON.parse(res);
                    var nickname = htmlspecialchars(resText.nickname);
                    var username = htmlspecialchars(resText.username);
                    var created_at = resText.created_at;
                    var content = htmlspecialchars($(e.target).prev().prev().children().val());
                    var comment_id = resText.comment_id;

                    var primary_comment_nickname = $(e.target).parent('.comment').children('.comment__header').children('.comment__author').text;

                    // console.log("nickname:" + nickname);

                    // console.log("primary_cmmt_nickname:" + primary_cmmt_nickname);

                    if( e.target.className === 'board__form-submit main_button btn btn-info'){

						$('div.board__comments').children('div.comment:first').before(`
							<div class="comment col-lg-6 col-sm-10 mx-auto mb-2 bg-secondary jumbotron">
								<!--  顯示主留言 START  -->
								<div class="comment__header">
                                    <div class="comment__author text-light">${username}(${nickname})</div>
                                    <div class="comment__timestamp text-light">${created_at}</div>
                                    <div class="comment__edit-delete">
								        <button type="button" class="comment__edit btn btn-outline-info">編輯</button><span>   </span><button type="button" class="comment__delete btn btn-outline-info">刪除</button>
									</div>
								</div>
                                <div class="comment__content text-light">${content}</div>
                                <div class="comment__id">${comment_id}</div>
                                <!--  顯示子留言串 START  -->
                                <div class="board__subcomments">
                                <!--   子留言的撰寫框 START  -->
                                    <div class="board__form">
                                        <div class="board__form-author text-info">${username}(${nickname})，在底下發表您的意見</div>
                                        <div class="board__form-textarea">
                                            <textarea name="content" placeholder="留言內容" required></textarea>
                                        </div>
                                        <input type="hidden" name="parent_id" value="${comment_id}" />
                                        <button type='submit' name='submit' class='board__form-submit sub_button btn btn-info'>送出</button>
                                    </div>
                                </div>
                            </div>`
                        )
                    } else if( e.target.className === 'board__form-submit sub_button btn btn-info'){
                        $(e.target).parent().before(`
                            <div class="comment">
                                <div class="comment__header">
                                    <div class="comment__author text-light">${username}(${nickname})</div>
                                    <div class="comment__timestamp text-light">${created_at}</div>
                                    <div class="comment__edit-delete">
                                    <button type="button" class="comment__edit btn btn-outline-info">編輯</button><span>   </span><button type="button" class="comment__delete btn btn-outline-info">刪除</button>
                                    </div>
                                </div>
                                <div class="comment__content text-light">${content}</div>
                                <div class="comment__id">${comment_id}</div>
                            </div>`
                        )
                    }
                    $(e.target).prev().prev().children().val('');
                },
            });
        };
    })
});

function chkRequired( field ){
	if( field.value === '') return false;
	else return true;
}

// 自行設定JS版本的 htmlspecialchars
var htmlspecialchars = function (string, quote_style) {
    string = string.toString();

    string = string.replace(/&/g, '&amp;');
    string = string.replace(/</g, '&lt;');
    string = string.replace(/>/g, '&gt;');

    if (quote_style == 'ENT_QUOTES') {
        string = string.replace(/"/g, '&quot;');
        string = string.replace(/\'/g, '&#039;');
    } else if (quote_style != 'ENT_NOQUOTES') {
        string = string.replace(/"/g, '&quot;');
    }

    return string;
}