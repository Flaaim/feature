<?php
  
$path = __DIR__."/folder";
 
foreach(new DirectoryIterator($path) as $file){
      if($file->isFile()){
        $arr[] = $file->getFilename();
      }
}
$randFile = $path."/".$arr[array_rand($arr)];

  include $randFile;