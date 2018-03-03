<?php
require_once ("num2word.php");
$num2word = new Num2word;
echo $num2word->convert(123);
echo "<br>";
echo $num2word->convert(3000000020);
echo "<br>";
echo $num2word->convert(54654564);
echo "<br>";
echo $num2word->convert(-1545);
echo "<br>";
echo $num2word->convert(0);
echo "<br>";
echo $num2word->convert(0000000001);
echo "<br>";
echo $num2word->convert(9999999999999999);
echo "<br>";
echo $num2word->convert('abc');
echo "<br>";
?>
