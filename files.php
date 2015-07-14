<?php
/**
 *
 * 
 *
 * @����
 *  
 *  1. DOS ������ ����ǵ��� files.bat ������ ���� ���α׷��� ��� ��Ų��.
 *
 *
 *  - $inc �迭 ������ �� ��ҿ� ���縦 �� ��ü ��θ� ����Ѵ�. �� ��, ����̺� ���� 2 ����Ʈ�� c: �Ǵ� D: �� ���� ��ϵǾ���Ѵ�.
 *
 *    ����: ���簡 ��� ȣ����� �ʵ��� ����Ǵ� $dir_target �� ���� ��θ� $inc �� ������� �� ��.
 *
 *
 */
error_reporting(E_ALL ^ E_NOTICE);
 
$count_files = 0;
$dir_targets = array("c:\\backup", "f:\\backup");                          // ������ �����(��)


$exc = array("file", "files", "tmp", "Debug", "Release");
$inc = array("E:\\work");
/*
$inc = array(
    "E:\\work\\����,����,���� ����",
    "E:\\work\\ȸ�� ����",
    "E:\\work\\���� ����� ������ ���",
    "E:\\work\\lab",
    "E:\\work\\workdocs",
    "E:\\work\\www",
    "E:\\work\\�� ����"
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

  elaps();                            // CPU �� ���ϸ� ���� �ʵ��� ������ �ð� ��ŭ ����.
  
  $file_path = substr($file_src, 2);
  $pp = pathinfo($file_path);
  
  
  $dir = "$dir_target$pp[dirname]";
  $file_dst = "$dir\\$pp[basename]";
  
  
  // ���� ũ�Ⱑ Ʋ���� ���縦 �Ѵ�.
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
    echo "\n$s �� $d �� �����ϴµ� �����߽��ϴ�...\n";
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
      echo "\nexc: $d ���丮�� ������� �ʽ��ϴ�.\n";
      return;
    }
  }
  

	if($dir = opendir($directory)) {  // ���丮 ����

  	// Add the files
  	while($file = readdir($dir)) {
  		if($file != "." && $file != ".." && $file[0] != '.') {    // ������ ���� �ϴ°�?
  		  
  			
  			if(is_dir($directory . "/" . $file)) {            // ���� ������ ���丮�� ��� �Լ� ȣ���� ���� ��ü ������ ����Ʈ�Ѵ�.
  				getFiles($directory . "/" . $file);
  			}
  			else {                                            // ���丮�� �ƴ϶� �����̸� ���Ͽ� ���� �۾��� �Ѵ�.
  			  $count_files ++;
  				$file_src = "$directory/$file";
  				doFile($file_src);
  			}
  		} // eo if ������ ���� �ϴ°�?
  		
  	} // eo while
  	
  	// Finish off the function
  	closedir($dir);
	} // eo if
}


?>