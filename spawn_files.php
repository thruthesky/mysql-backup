<?php

$cnt=0;
echo "\r\n약 50 후 부터 파일 백업을 시작합니다.";
sleep(60*50);       // 컴퓨터 부팅 50 분 후 시작한다.
sleep(5);
while ( 1 ) {
  $cnt++;
  echo "\r\n작업 파일을 {$cnt} 번째 백업 시작합니다.\r\n";
  $re = shell_exec ("php files.php");
  echo $re;
  $elaps =60*120;
  $dt = date("Y/m/d h:i", time()+$elaps);
  echo "\r\n약 $dt 에 다시 백업을 시작합니다.";
  sleep($elaps);    // 특정 시간 단위로 재 실행을 한다.
}
?>