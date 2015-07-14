<?php
/**
 *
 * 
 *
 * @사용법
 *  
 *  1. DOS 쉘에서 실행되도록 files.bat 파일을 시작 프로그램에 등록 시킨다.
 *
 *
 *  - $inc 배열 변수의 각 요소에 복사를 할 전체 경로를 기록한다. 이 때, 드라이브 명이 2 바이트로 c: 또는 D: 와 같이 기록되어야한다.
 *
 *    주의: 복사가 재귀 호출되지 않도록 복사되는 $dir_target 의 하위 경로를 $inc 에 기록하지 말 것.
 *
 *
 */
error_reporting(E_ALL ^ E_NOTICE);
 
$count_files = 0;
$dir_targets = array("c:\\backup", "f:\\backup");                          // 복사할 저장소(들)


$exc = array("file", "files", "tmp", "Debug", "Release");
$inc = array("E:\\work");
/*
$inc = array(
    "E:\\work\\계정,결제,은행 정보",
    "E:\\work\\회사 업무",
    "E:\\work\\돈을 사용한 내역을 기록",
    "E:\\work\\lab",
    "E:\\work\\workdocs",
    "E:\\work\\www",
    "E:\\work\\내 문서"
);
*/
/*
,
    "E:\\work\\Office Softwares"
*/

foreach ( $inc as $dir ) {
  getfiles($dir);
}

echo "\r\nfiles $count_files\n";


function doFile($file_src) {
  
  global $dir_targets;
  foreach ( $dir_targets as $t ) copy_if( $file_src, $t);
}

function copy_if( $file_src, $dir_target ) {

  elaps();                            // CPU 에 부하를 주지 않도록 적당한 시간 만큼 쉰다.
  
  $file_path = substr($file_src, 2);
  $pp = pathinfo($file_path);
  
  
  $dir = "$dir_target$pp[dirname]";
  $file_dst = "$dir\\$pp[basename]";
  
  
  // 파일 크기가 틀리면 복사를 한다.
  $size_src = filesize ( $file_src );
  $size_dst = @filesize ( $file_dst );
  
  
                                                                                //echo "$size_src: file_src:$file_src\n";
                                                                                //echo "$size_dst: file_dst:$file_dst\n";
  if ( !file_exists($file_dst) || $size_src != $size_dst ) {
    copyFile($file_src, $file_dst);
  }
}


function elaps()
{
  usleep(1000);
}

function dirnameEx($f)
{
  $findme1 = '/';
  $findme2 = "\\";
  
  $pos1 = strrpos($f, $findme1);
  $pos2 = strrpos($f, $findme2);
  
  
  if ( $pos1 === false && $pos2 === false ) return $f;
  // echo "pos2:$pos2\n";
  if ( $pos1 ) return substr($f, 0, $pos1);
  if ( $pos2 ) return substr($f, 0, $pos2);
  return $f;
}
function copyFile($s, $d)
{
                                                            //echo "d=$d\n";
  $d = str_replace("/", "\\", $d);
                                                            //$pp = pathinfo($d);
                                                            //print_r($pp);
                                                            // echo "dirnameEx: ".dirnameEx($d)."\n";
                                                            
                                                            //echo "dirname = $pp[dirname]\n";
  $dir = dirnameEx($d);
                                                            //  echo "dir:$dir\n";
  $rc = @mkdir($dir, 0777, true);
  if ( empty($rc) ) echo "";
  if (!copy($s, $d)) {
    echo "\n$s 를 $d 로 복사하는데 실패했습니다...\n";
  }
  else echo "c ";
}



function getFiles($directory, $recursive=TRUE)
{
  global $count_files, $exc;
  
  $d = str_replace("/", "\\", $directory);
  $dirs = explode("\\", $d);
  foreach ( $dirs as $ex ) {
    if ( in_array($ex, $exc) ) {
      echo "\nexc: $d 디렉토리는 백업되지 않습니다.\n";
      return;
    }
  }
  

	if($dir = opendir($directory)) {  // 디렉토리 오픈

  	// Add the files
  	while($file = readdir($dir)) {
  		if($file != "." && $file != ".." && $file[0] != '.') {    // 파일이 존재 하는가?
  		  
  			
  			if(is_dir($directory . "/" . $file)) {            // 현제 파일이 디렉토리면 재귀 함수 호출을 통해 전체 파일을 리스트한다.
  				getFiles($directory . "/" . $file);
  			}
  			else {                                            // 디렉토리가 아니라 파일이면 파일에 대한 작업을 한다.
  			  $count_files ++;
  				$file_src = "$directory/$file";
  				doFile($file_src);
  			}
  		} // eo if 파일이 존재 하는가?
  		
  	} // eo while
  	
  	// Finish off the function
  	closedir($dir);
	} // eo if
}


?>