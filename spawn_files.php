<?php

$cnt=0;
echo "\r\n�� 50 �� ���� ���� ����� �����մϴ�.";
sleep(60*50);       // ��ǻ�� ���� 50 �� �� �����Ѵ�.
sleep(5);
while ( 1 ) {
  $cnt++;
  echo "\r\n�۾� ������ {$cnt} ��° ��� �����մϴ�.\r\n";
  $re = shell_exec ("php files.php");
  echo $re;
  $elaps =60*120;
  $dt = date("Y/m/d h:i", time()+$elaps);
  echo "\r\n�� $dt �� �ٽ� ����� �����մϴ�.";
  sleep($elaps);    // Ư�� �ð� ������ �� ������ �Ѵ�.
}
?>