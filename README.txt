#��{PHP�MAJAX���d���O#
=============
�o�O�ڲĤ@����@�ϥ�PHP�PAJAX���춥�d���O�A�N���F�@�q�ɶ��~���Ҧ��\��i�H���`�B�@�A���F��@�ǲߵ��O�A�ҥH�O�U�@�Ǽgcode�ɯS�O�ݭn�`�N���a��C

##�e��
------------
* �e�ݨϥ�AJAX�P��ݶǻ���T�A�]�t�d���B�s��B�R�������C�åB���F��ݡA�e�ݤ]��htmlspecialchars()���mXSS�����A����V�ĪG��F���@�P�C
* css�ج[�ϥ�bootstrap�A�[�W[Bootswatch](https://bootswatch.com)��Sketchy�D�D�C
*�ϥ�JQuery���N�쥻�b�m�ߪ�Vanilla JS�C

##���
------------
###�ϥ�prepared statement�s��MySQL��Ʈw
���F�w��SQL injection�����A�ҥH��prepared statement���N��l��MySQLi object-orinted�A�p���@�ӡA����SQL�ɡA�H���U��code���ҡAusername�û����|�Q��@�ѼƳB�z�A�Ӥ��|�ܦ���ӻy�y�����@�����C

```$stmt = $conn->prepare("SELECT username, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$username = $_POST['username'];
$stmt->execute();```

###�n�J�t��
*�ϥ�session����user�n�J�C
*��Ʈw�����K�X��password_hash()�[�K�B�z�A�s�J��Ʈw�A�ϥΪ̵n�J�ɡA�ϥ�password_verify()���K�X�P��Ʈw�O�_�ۦP�C


