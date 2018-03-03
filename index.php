<?php
require_once ("Num2word.php");
$Num2word = new \Num2word;
echo $Num2word->convert(123);
echo $Num2word->convert(3000000020);
echo $Num2word->convert(54654564);
echo $Num2word->convert(-1545);
echo $Num2word->convert(0);
echo $Num2word->convert(0000000001);
echo $Num2word->convert(9999999999999999);
echo $Num2word->convert('abc');
?>
