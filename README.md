# 實現PHP和AJAX的留言板

這是我第一次實作使用PHP與AJAX的初階留言板，摸索了一段時間才讓所有功能可以正常運作，為了當作學習筆記，所以記下一些寫code時特別需要注意的地方。

## 前端
------------
* 前端使用AJAX與後端傳遞資訊，包含留言、編輯、刪除部分。並且除了後端，前端也用htmlspecialchars()防禦XSS攻擊，讓渲染效果能達成一致。
* css框架使用bootstrap，加上[Bootswatch](https://bootswatch.com)的Sketchy主題。
* 使用JQuery取代原本在練習的Vanilla JS。

## 後端
------------
### 使用prepared statement存取MySQL資料庫
為了預防SQL injection攻擊，所以用prepared statement取代原始的MySQLi object-orinted，如此一來，執行SQL時，以底下的code為例，username永遠都會被當作參數處理，而不會變成整個語句中的一部份。

```$stmt = $conn->prepare("SELECT username, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$username = $_POST['username'];
$stmt->execute();

登入系統
* 使用session驗證user登入。
* 資料庫內的密碼用password_hash()加密處理再存入資料庫，使用者登入時，使用password_verify()比對密碼與資料庫是否相同。
