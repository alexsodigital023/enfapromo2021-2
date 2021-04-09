<?php

namespace App\Mutators\Storage;
use Storage;

trait Spaces{
  function resolvePath($filename){
    $path=property_exists($this,"_storagePath")?trim(preg_replace('/[^\da-z\/]/i', '_',$this->_storagePath),' /'):"";
    return trim(sprintf('%s/%s',$path,$filename),"/");
  }
  function saveFile($filename,$data){
    return Storage::disk('do_spaces')->put($this->resolvePath($filename),$data);
  }
  function prependFile($filename,$data){
    return Storage::disk('do_spaces')->prepend($this->resolvePath($filename),$data);
  }
  function appendFile($filename,$data){
    return Storage::disk('do_spaces')->append($this->resolvePath($filename),$data);
  }
  function getFile($filename){
    return Storage::disk('do_spaces')->get($this->resolvePath($filename));
  }
  function listFiles($directoryname='/'){
    return Storage::disk('do_spaces')->files($this->resolvePath($directoryname));
  }
  function listAllFiles($directoryname='/'){
    return Storage::disk('do_spaces')->allFiles($this->resolvePath($directoryname));
  }
  function listFolders($directoryname='/'){
    return Storage::disk('do_spaces')->directories($this->resolvePath($directoryname));
  }
  function listAllFolders($directoryname='/'){
    return Storage::disk('do_spaces')->allDirectories($this->resolvePath($directoryname));
  }
  function createFolder($directoryname){
    return Storage::disk('do_spaces')->makeDirectory($this->resolvePath($directoryname));
  }
  function deleteFolder($directoryname){
    return Storage::disk('do_spaces')->deleteDirectory($this->resolvePath($directoryname));
  }
  function deleteFile($filename){
    return Storage::disk('do_spaces')->delete($this->resolvePath($filename));
  }
  function getFileSize($filename){
    return Storage::disk('do_spaces')->size($this->resolvePath($filename));
  }
  function getFileLastModified($filename){
    return Storage::disk('do_spaces')->lastModified($this->resolvePath($filename));
  }
  function fileExists($filename){
    return Storage::disk('do_spaces')->has($this->resolvePath($filename));
  }
  function copyFile($filename,$destination){
    return Storage::disk('do_spaces')->copy($this->resolvePath($filename),$destination);
  }
  function moveFile($filename,$destination){
    return Storage::disk('do_spaces')->move($this->resolvePath($filename),$destination);
  }
  function temporaryUrl($filename,$time=5){
    return Storage::disk('do_spaces')->temporaryUrl($this->resolvePath($filename), now()->addMinutes($time));
  }
}