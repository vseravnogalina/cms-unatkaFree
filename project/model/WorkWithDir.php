<?php namespace model;
/*
 * WorkWithDir.php
 * 
 * Работа с файлами и директориями
 * 
 * Copyright 2013 - 2022 Родионова Галина Евгеньевна  https://unatka.ru <gala.anita@mail.ru>
 * 
 */

class WorkWithDir
{
	public $dirscan;//Имя директории
	public $scip=array('.','..');//Вспомогательный элемент
	     
    /* Метод scanDirectory
     * Сканирование директории.
     * Аргументы:
     * dirscan - сканируемая директория,
     * scip - вспомогательный массив для удаления точек.
     * Возвращает массив файлов и папок директории.
     * Возвращает false при ошибке.
     * */
    public function scanDirectory()
    {
        //Если существует указанная директория и она не пуста, сканируем ее
        if (file_exists($this->dirscan)) {
            if (!empty($this->dirscan))
            $arrprel=scandir($this->dirscan);
            //В цикле удаляем лишнее в результате сканирования, получаем массив имен файлов
            foreach($arrprel as $prel) {
                if (!in_array($prel,$this->scip)) {
                    $arr[]=$prel;
                    }
                }
                //Возвращаем результат сканирования 
                if (isset($arr)) return  $arr;
                //else return false;
            }  
    } //scandirectory()   
    
        
  /* Метод baseFile
      * Получение базового имени файла без расширения.
      * Аргументы:
      * $this->filename - полное имя файла
      * Возвращает имя файла без расширения.
      * Возвращает false при ошибке.
      * */
     public function baseFile() 
     {
         $ext=$this->extenFile();
         $bsfile=basename($this->filename,".$ext");        
         if (isset($bsfile)) return $bsfile;
         else return false;
     }//end baseFile()
     
   /* Метод extenFile
     * Получение расширения файла через функцию pathinfo,
     * Включен в метод baseFile
     * Аргументы:
     * $this->filename - имя файла, расширение которого нужно получить 
     * Возвращает расширение указанного файла.
     * */
    public function extenFile()
    {
        if ($this->filename) {
        $puth=pathinfo($this->filename);
        $ext=$puth["extension"];
        }
        if (isset($ext)) return $ext;
        else return false;
     } //end extenFile()                  
}//WorkWithDir
