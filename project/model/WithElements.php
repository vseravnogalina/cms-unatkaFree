<?php namespace model;
/*
 * WithElements.php
 * 
 * Включает дополнительные элементы, которые могут зависеть от БД.
 * 
 * Copyright 2013 - 2022 Родионова Галина Евгеньевна  https://unatka.ru <gala.anita@mail.ru>
 * * license   https://www.gnu.org/licenses/gpl.html GNU GPLv3
 */
class WithElements extends WithDb
{
	private $dirscan;//Имя директории
	private $filename;//Имя файла
	protected $idar;//Номер статьи
	public $mailuser;
    public $groupuser;
    public $nicknameuser;
    public $numberuser;
    public $department;
    public $sectionin;
    public $moder;
    public $comment;

	public $passwordus;
	protected $arrblock =array(
                   "book" => "Сделать сайт самому",
                 "design" => "Веб -дизайн. Теория",
              "aboutwork" => "Заработать в сети",                
                "freeware"=> "Скачивания",
                 "payware"=> "Документация",
                     "bid"=> "Оставить заявку", 
                  "others"=> "Прочее");
		
	/* Подключаю объект WorkWithDataTest
	 * */
	public function __construct()
	{
		$this->parametrs = new WorkWithData;
		$this->param = $this->parametrs->getParam();
				if (isset($this->param[0])) 
				$this->division = $this->param[0];
				if (isset($this->param[1]) && $this->param[1] !== "")
				$this->alias = $this->param[1];
				
		$this->dirandfile = new WorkWithDir;
		
	}
    
    /* Метод arrowsForwardBack
     * Для  постраничной навигации.
     * Аргументы:$this->parametrs->getParam();
     * Возвращает массив для формирования ссылок навигации:
     * ключи массива:
     * division - текущий раздел;
     * beforealias - для статей - алиас предыдущей статьи, 
     * для Главных разделов - имя предыдущего раздела;
     * nextalias - для статей - алиас следующей статьи, 
     * для Главных раздела - имя следующего раздела.
     * Для Главной сайта - nextalias - имя первого раздела,beforealias - none,
     * Для первой статьи раздела nextalias - следующая статья, 
     * beforealias - главная раздела (имя раздела),
     * Для последней статьи раздела nextalias - имя следующего раздела,beforealias -
     * предыдущая статья.
     * Для первой статья первого раздела: nextalias - следующая статья, 
     * beforealias - ссылка на главную раздела.
     * Для последней статьи проследнего раздела:nextalias - ссылка на главную сайта,
     * beforealias - предыдущая статья.
     * Соответственно beforetitle и nexttitle - заголовки страниц.
     * */
    public function arrowsForwardBack()
    {
    //1. Определили существующие разделы БЕЗУСЛОВНО
    $arraymainpages = $this->selectMainForNav();
    
    //Найду массив ключей  array $arraymainpages['division']
    if ($arraymainpages !== null) {
		$countparts = count($arraymainpages['division']);
		$keysarraymains = array_keys($arraymainpages['division']);
		} 
    if ($keysarraymains !== null) {
		//Первый раздел
		if (isset($keysarraymains[1]))
		$firstdiv = $keysarraymains[1];
		if ($countparts > 0)
		$countnumber = ($countparts - 1);
		//Последний раздел
	    $lastdiv = $keysarraymains[$countnumber];
		}
	//Главная сайта
	if (!isset($this->division)) {
		if (isset($firstdiv)) {			
			$beforealias =0;
			$beforetitle =0;
			$afteralias = "/" . $firstdiv; 
			$aftertitle = $arraymainpages['title'][$firstdiv];
		    }
		}
	    //Главная раздела
	    if (isset($this->division)) {
			//Наименование текущего раздела в любом случае
			if ($keysarraymains !== null)
	        $currentdiv = array_search($this->division, $keysarraymains);
	        if (isset($currentdiv) && $currentdiv >0) {
	        $beforediv =  $currentdiv -1;
		    }
	         if (isset($currentdiv) && $currentdiv <$countnumber) {
	         $afterdiv = $currentdiv +1;
		     }
	        
	      
				//Нахожу список статей раздела
	            $this->table = $this->division;			
	            $arrayarrows = $this->selectAllArticlesForArrows();
	            //Для дальнейших действий приводим массив к виду нескольких простых
	            if ($arrayarrows !== null) {
			        $arraylist = $arrayarrows["list"]; 
		            $arraytitle = $arrayarrows["title"];
		            $arrayalias = $arrayarrows["alias"];
		            $arraypart = $arrayarrows["part"];
	                } else $arraylist = null;	            
	    }//isset division 
	     
	    if (isset($arraylist) && is_array($arraylist) && $arraylist !==null) {
			$countarticles =count($arraylist);
			$arraykeys = array_keys($arraylist);//$key - number 0-etc., $value -number of article
			//var_dump($arraykeys);
			//ID первой внутренней статьи указанного раздела
		    $minid = $arraykeys[0];//
	        //ID последней внутренней статьи указанного раздела
            $maxval = max($arraylist); 
            $maxid = array_search($maxval, $arraylist);
			if (isset($this->alias)) {
				$aliascurrent = array_search($this->alias, $arrayalias);
				$currentid = array_search($aliascurrent, $arraykeys);
				if ($currentid !==0) {
					$beforeid = $currentid-1;
					if (isset($beforeid) && $beforeid>0)
					$aliasbeforeid = $arraykeys[$beforeid];
					if (isset($aliasbeforeid)) {
					$beforealias = "/" . $this->division . "/" . $arrayalias[$aliasbeforeid];
					$beforetitle = $arraytitle[$aliasbeforeid];
				    }
					} else {
						$beforealias = "/" . $this->division;
					    $beforetitle = $arraymainpages['title'][$this->division];
						}
				if ($currentid !==($countarticles-1)) {
					$afterid = $currentid+1;
					$aliasafterid = $arraykeys[$afterid];
					$afteralias = "/" . $this->division . "/" . $arrayalias[$aliasafterid];
					$aftertitle = $arraytitle[$aliasafterid];
					} else {
						$aliasafterid = $maxid;//
						if ($this->division !== $lastdiv) {
							$afternamediv = $keysarraymains[$afterdiv];
						    $afteralias = "/" . $afternamediv;						
						    $aftertitle = $arraymainpages['title'][$afternamediv];
						    } else {
							    $afteralias ="/";
			                    $aftertitle = $arraymainpages['title']["site"];
			                    }
						}
				
	  
			} else {//NO alias is_array
				if (isset($this->division))
				switch($this->division) {
					case $firstdiv:
					$beforealias ="/";
			        $beforetitle = $arraymainpages['title']["site"];
			        $afteralias = "/" . $this->division . "/" .$arrayalias[$minid];
					$aftertitle = $arraytitle[$minid];
					break;
					default:
					if (isset($currentdiv) && $currentdiv >0)
			        if (isset($beforediv))
			        $beforenamediv = $keysarraymains[$beforediv];
			        $beforealias = "/" . $beforenamediv;
			        $beforetitle = $arraymainpages['title'][$beforenamediv];
			        $afteralias = "/" . $this->division . "/" .$arrayalias[$minid];
					$aftertitle = $arraytitle[$minid];
					break;
				}
				}
		} 
		if (isset($beforealias))	
		$massivarrows = array("beforealias"=>$beforealias,
		                       "beforetitle"=>$beforetitle,      
		                       "nextalias"=>$afteralias,
		                         "nexttitle"=>$aftertitle,);
		                         

        if (isset($massivarrows)) return $massivarrows;
		else return null;			
	    
	}//arrowsForwardBack
		
	
	/* Метод menuCommon()
	 * Меню для отображения сопровождающих сайт документов.
	 * Аргументы - нет.
	 * Возвращает данные для меню сопровождающих документов или null.
	 * */
	public function menuCommon()
	{
		$commonpage = $this->selectCommon();//var_dump($commonpage);
		if (is_null($commonpage)) return null;
		else {
			if (is_array($commonpage["title"]))
			return $commonpage;
			}
	}//menuCommon
 
	/* Метод forChapter()
	 * Подготавливает отображение на странице названий разделов и глав
	 * */
	protected function forChapter()
	{
			$arraymainpages = $this->selectMainForNav();
			if ($arraymainpages !== null)
			if (isset($this->division)) {
				if (array_key_exists($this->division, $this->arrblock)) 
				$namedv = $arraymainpages["title"][$this->division]; 
			if (isset($this->alias) && $this->alias !== "") {
				 $this->table = "part" . $this->division;
                 $chap = $this->selectChapter();
			     $this->table = $this->division;
			     $this->alias = $this->alias;
		         $chp = $this->selectSimpleArticlesForPage();
		         if (isset($chp))
		         $numberchapter = $chp["part"];
		         if (isset($numberchapter)) 
			     $namechapter = $chap[$numberchapter];
			 }
		 }
		 if (!isset($namechapter))
		 $namechapter = 0;
		 if (!isset($namedv))
		 $namedv = 0;
		 $arraynote =array($namedv,$namechapter);
		 if(isset($arraynote)) return $arraynote;
	}//forChapter
    
    /* Метод getTemplate
     * Возвращает массив установленных шаблонов вида, 
     * когда массив не равен нулю
     * наследует метод selectTemplates() класса WithDb
     * */
    public function getTemplate()
    {
        if ($this->selectTemplates() !== null) {
			$this->massiv = $this->selectTemplates();
			$worktemplate = $this->workingElement();
            return $worktemplate[0];
            } else return null;
    }

    /* Метод menuDivision()
     * Меню разделов для отображения, вместо id статьи
     * введен перевод заголовка на транслит.
     * Входит в метод viewSimpleMenu(), class ViewPage
     * Ссылка 
     * index.php?route=(division)/page(alias) приводится в htaccess к виду 
     * domain/(division)/page(alias)
     * Аргументы: 
     * $articles = $this->getArticleDivision()
     * Возвращает данные для меню всех разделов для отображения на сайте, разбитое по главам
     * с ключами статьи в виде перевода на транслит заголовка
     * Возвращает null, если метод не выполнен
     * */
     protected function menuDivision()
     {		
         if (isset($this->division))
				$this->table = $this->division;
                $articles = $this->selectAllArticlesForMenu(); 
        
         if (isset($this->division))
				 $this->table = "part" . $this->division;
                 $chap = $this->selectChapter();
  
         if (is_array($articles))
         foreach($articles as $keys => $value) { //keys - title, etc., value - array
            if ($keys === "title")
            foreach($value as $k => $v) {//k - number of chapter , v -array
            foreach($v as $key => $val) { //$key - alias of article, val - value
			$aboutchapter = $chap[$k];		
			$workarr[$aboutchapter][$key] = $val;
		    }
		    }
	    }
        if (isset($workarr)) return $workarr;
        else return null;
    }//menuDivision
    
	/* Метод menuMain();
	 * Подготовка данных для отображения главного меню 
	 * (метод viewMainMenu(), viewSimpleMenu() класс ViewPage).
	 * */
	protected function menuMain()
	{		
		 if (is_null($this->selectMainForNav())) {
            return null;
            } else { 
                $mainarticles = $this->selectMainForNav();
                } 
         if ($mainarticles) {
			 $linkarray = array(); 
			 foreach ($mainarticles["title"] as $k => $v) {//$k - division
				 $linkarray["text"][$k] = $v;
				 $linkarray["link"][$k] = $k;
			 }
			 
           } 
           return $linkarray;   
	}//MenuMain
               
    /* Метод workingElement
     * Отображает массив подключенных элементов.
     * 
     * Аргументы: massiv - массив всех установленных элементов указанного вида.
     * Возвращает массив подключенных элементов:
     * ключ - номер позиции элемента, для шаблонов вида - 0, для 
     * модулей - числа.
     * значение - имя подключенного элемента.
     * Если подключенные элементы отсутствуют, возвращает null
     * */
    protected function workingElement()
    {
        $nmassk = array();$nmassv = array();

        if ($this->massiv["activation"]) {
            foreach($this->massiv["activation"] as $k => $vactiv) {
                if ($vactiv === 1) {
                    $nmassk[] = $this->massiv["pos"][$k];
                    $nmassv[] = $this->massiv["title"][$k];
                }
            }
        }
        
            if ($nmassk !== null && $nmassv !==null) {
            $nmass = array_combine($nmassk, $nmassv);
            } else $nmass =null;
        if ($nmass !== null) {
            return $nmass;
            } else return null;
    }//workingElement
	
	

	
	/* Модуль скачиваний
	 * Сканируем директорию загрузок
	 * Отделяем файлы от папок
	 * Собираем массив с ключами dir и file
	 * Передаем массив
	 * */
	 protected function buttonDownload()
	 {
		 /* 1. Сканируем директорию downloads/ в зависимости от параметров адресной строки
		  * 2. Находим файлы файлы
		  */
		
		/* Если это скачивание с внутренней страницы раздела,
		 * файлы должны лежать в папке с именем раздела,
		 * Если это главная страница раздела,
		 * файлы должны лежать в папке downloads под именем main_имя раздела.
		 * Находим файл для скачивания, определяем его имя и расширение,
		 * копируем файл в папку /downloads/copy, переименовываем и отдаем на 
		 * скачивание*/
		if ($this->param !== null) {
			if (isset($this->division)) {
			if (isset($this->alias) && $this->alias !== "") {
				if (is_dir("downloads")) 
				if (is_dir("downloads/" .$this->division)) {
			$this->dirandfile->dirscan ="downloads/".$this->division;
			$secondresult = $this->dirandfile->scanDirectory();
			if ($secondresult !== null)
			foreach($secondresult as $key => $val) {
				$findname = $a[$key] = pathinfo("/downloads/$this->division/$val");
				if ($findname["filename"] === $this->alias) {
				$nameload = $findname["basename"];
				$exload = $findname["extension"];
				$namefile = $this->division . "/" . $nameload;
			    }
				}
			    }
			    } else {
					if (is_dir("downloads")) 
				    if (is_dir("downloads/main")) {
						$this->dirandfile->dirscan ="downloads/main";
			            $secondresult = $this->dirandfile->scanDirectory();
			            if ($secondresult !== null)
			            foreach($secondresult as $key => $val) {
				        $findname = $a[$key] = pathinfo("/downloads/main/$val");
				        if ($findname["filename"] === $this->division) {
				        $nameload = $findname["basename"];
				        $exload = $findname["extension"];
				        $namefile = "main/" . $nameload;
					    }
				    }
					}
				    } 
			    }
			}
			
		
		if (isset($nameload)) {
			$date = date("Y-m-d");
			$newnamefile = $date. $nameload;
			$filesforload = array($nameload, $newnamefile,$namefile);
			 
		} //var_dump($filesforload);
		if (isset($filesforload))
		return $filesforload;
		else return null;
	 }//buttonDownload

}//WithElements
