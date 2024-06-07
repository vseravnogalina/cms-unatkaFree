<?php namespace model;
/*
 * WithDb.php
 * 
 * Создать таблицу, создать запись в таблице, выбрать запись в таблице, удалить запись
 * из таблицы, удалить таблицу.
 * Предварительно создается база данных и ее пользователь. * 
 * Copyright 2013 - 2022 Родионова Галина Евгеньевна  https://unatka.ru <gala.anita@mail.ru>
 * * license   https://www.gnu.org/licenses/gpl.html GNU GPLv3
 * 
 */
class WithDb extends Connect
{
    public $mailus;
    public $parametrs;
	protected $param;
	protected $mailuser;
	protected $alias;//алиас заголовка статьи
	protected $division;//Наименование раздела на англ.
	protected $table;//Имя таблицы БД
	protected $oper;//имя страницы для комментариев
	
	function __construct()
	{
		/* Параметры адресной строки*/
		$this->parametrs = new WorkWithData; 
		$this->param = $this->parametrs->getParam();
				if (isset($this->param[0])) 
				$this->division = $this->param[0];
				if (isset($this->param[1]) && $this->param[1] !== "")
				$this->alias = $this->param[1];			           
	}
	
	/* Метод controlString()
     * Проверка записей на существование.
     * 
     * Аргументы:
     * table - имя таблицы
     * Возвращает true
     * если записей нет - возвращает null*/
    protected function controlString()
    {
		$this->table;
        //Указываем кодировку вывода данных из СУБД
        $this->mysqli->query('SET NAMES "utf8"');
        //Проверяем существует ли таблица с указанным именем 
        if ($tableis = !$this->mysqli->query('SELECT id FROM '.$this->table.' ORDER BY id LIMIT 1')) {
        return false;//Нет записей
        } else return true;  
    }//controlString
	
	 /* Метод controlTable
     * Проверяет существование таблицы.
     * 
     * Аргументы: 
     * db - имя базы данных
     * table - имя таблицы
     * Возвращает true
     * При неудаче возвращает false
     * */        
    protected function controlTable()
    {
        $this->mysqli->query('SET NAMES "utf8"');
        if ($tableisBD = $this->mysqli->query(
            'SHOW TABLES FROM '.$this->db.' LIKE "'.$this->table.'"')) { 
        while($row = $tableisBD->fetch_array()) {
            $tbls = $row[0];
        }
        } 
        if (isset($tbls)) return $tbls;
        else return false;
        $tableisBD->close();
    }//controlTable
    
    
    /* Метод selectChapter
     * Таблица Главы. Выборка глав раздела.
     * Входит в метод getArticlePart
     * 
     * Аргументы: нет
     * Возвращает простой массив
     * ключ: id строки
     * значение: наименование главы
     * Возвращает null, если выборка не была выполнена 
     * В случае отсутствия записей в таблице 
     * возвращает false
     * */
    protected function selectChapter()
    {
        if ($this->table)
        if ($this->controlTable()) {
        
        if ($this->controlString() !== false) {
         //Указываем кодировку вывода данных из СУБД
         $this->mysqli->query("SET NAMES 'utf8'");
         
         //Подготавливаем запрос к БД prepare
         $sel = $this->mysqli->prepare('
             SELECT id, title 
             FROM ' . $this->table . ' 
             ORDER BY list');
         //Выполняем подготовленный запрос
         $sel->execute();
         //Привязка переменных к подготовленному запросу
         $sel->bind_result($idbook, $titlebk);
         //результат запроса помещаем в цикл  while и создаем рабочий массив
         while($sel->fetch()) {
             $simplelist[$idbook] = $titlebk;
         } 
         }
        }
                 
         if (isset($simplelist)) return $simplelist;
         else return null;         
    }//selectPart
    
    
    /*selectAllArticlesForArrows()*/
    protected function selectAllArticlesForArrows()
    {
        if ($this->table) 
        if ($this->controlTable())  {
           
        if ($this->controlString() !== false) {
         //Указываем кодировку вывода данных из СУБД
         $this->mysqli->query("SET NAMES 'utf8'");
         
         //Подготавливаем запрос к БД prepare
         $artic=$this->mysqli->prepare(
           'SELECT 
              id,
              title, 
              list, 
              idpart,
              alias 
            FROM ' . $this->table . ' 
            ORDER BY list');
         //Выполняем подготовленный запрос
         if ($artic !== false) {
         $artic->execute();
         //Привязка переменных к подготовленному запросу 
         $artic->bind_result(
         $idstring, 
         $titbk, 
         $lbk, 
         
         $idptbk,
         $al);
         //результат запроса помещаем в цикл  while и создаем рабочий массив $arrarticles -["title"][1][15] это title статьи из раздела 1, id статьи 15 /
         while($artic->fetch()) {
             $titbook["title"][$idstring] = $titbk;
             $titbook["list"][$idstring] = $lbk;
            
             $titbook["part"][$idstring] = $idptbk;
             $titbook["alias"][$idstring] = $al;
             
             }
		 }
         
                         
        } 
        }
            if (isset($titbook)) return $titbook;
            else return null;
             //Закрываем запрос
         $artic->close();  
    }//selectAllArticlesForArrows
    
    /*selectAllArticlesForMenu()*/
    protected function selectAllArticlesForMenu()
    {
        if ($this->table) 
        if ($this->controlTable())  {
           
        if ($this->controlString() !== false) {
         //Указываем кодировку вывода данных из СУБД
         $this->mysqli->query("SET NAMES 'utf8'");
         
         //Подготавливаем запрос к БД prepare
         $formenu=$this->mysqli->prepare(
           'SELECT 
              id,
              title, 
              idpart,
              alias 
            FROM ' . $this->table . ' 
            ORDER BY list');
         //Выполняем подготовленный запрос
         if ($formenu !== false) {
         $formenu->execute();
         //Привязка переменных к подготовленному запросу 
         $formenu->bind_result(
         $idstring, 
         $titbk, 
         $idptbk,
         $al);
         //результат запроса помещаем в цикл  while и создаем рабочий массив $arrarticles -["title"][1][15] это title статьи из раздела 1, id статьи 15 /
         while($formenu->fetch()) {
			 $titbook["id"][$idptbk][$al] = $idstring;
             $titbook["title"][$idptbk][$al] = $titbk;
             $titbook["part"][$idptbk][$al] = $idptbk;
             $titbook["alias"][$idptbk][$al] = $al;
             
             }
		     }                          
         } 
         }
            if (isset($titbook)) return $titbook;
            else return null;
              //Закрываем запрос
         $formenu->close();
    }//selectAllArticlesForMenu
    
    /* Метод selectCommon
     * Таблица common. Выборка сопровождающих документов сайта.
     * Входит в метод getCommonArticle
     * 
     * Аргументы: table='common'
     * Возвращает многомерный массив
     * Ключи:
     *        * 1)id порядковый номер статьи,
              * title заголовок,
              * content содержание,
              * author автор,
              * data дата публикации или изменения;
              * 2) второй ключ - порядковый номер статьи
     * Возвращает null, если выборка не была выполнена 
     * */
    protected function selectCommon()
    {
        $this->table = 'common';
        
        if ($this->controlString() !== false) {
         //Указываем кодировку вывода данных из СУБД
         $this->mysqli->query("SET NAMES 'utf8'");
         
         //Подготавливаем запрос к БД prepare
         $selcmn=$this->mysqli->prepare('SELECT 
         id, 
         title,
         content,
         author,
         dat,
         alias
         FROM common ORDER BY id');
         //Выполняем подготовленный запрос
         $selcmn->execute();
         //Привязка переменных к подготовленному запросу
         $selcmn->bind_result(
         $idcmn,
         $titlecmn,
         $contcmn,
         $authcmn,
         $dtcmn,
         $al);
         //результат запроса помещаем в цикл  while и создаем рабочий массив
         while($selcmn->fetch()) {
            $titlebook["id"][$idcmn] = $idcmn; 
            $titlebook["title"][$idcmn] = $titlecmn;
            $titlebook["content"][$idcmn] = $contcmn;
            $titlebook["author"][$idcmn] = $authcmn;
            $titlebook["data"][$idcmn] = $dtcmn;
            $titlebook["alias"][$idcmn] = $al;            
            } 
           
             if (isset($titlebook)) return $titlebook;
             else return null;
             //Закрываем запрос
             $selcmn->close();
         } else return null;
    }//selectCommon
    
    
    /*Метод selectMainForNav
     * Выборка всех данных таблицы главных страниц сайта
     * Включен в метод getArticleDivision(), getArticlePart(),
     * strategyArticles(), menuMain(),modulForwardBack()
     * 
     * Аргументы: 
     * имя таблицы table="mainpage";
     * Метод возвращает рабочий массив $titlebook, ключи 
         * 1) id - порядковый номер,
          * title - заголовок,
          * division - раздел
         * 2) division - наименование раздела, к которому относится главная страница
     * В случае отсутствия записей в таблице 
     * возвращает false(что может говорить об атаке)
     * В случае наличия записей и отсутствия результата возвращает 
     * null
     * */
    protected function selectMainForNav()
    {
        $this->table = 'mainpage';
        
        if ($this->controlTable()) {
           
        if ($this->controlString() !== false) {
        $this->mysqli->query("SET NAMES 'utf8'");
         
         //Подготавливаем запрос к БД prepare
         $fornav = $this->mysqli->prepare(
         'SELECT 
         id, 
         title, 
         division 
         FROM mainpage
         ORDER BY list');
         //Выполняем подготовленный запрос
         if ($fornav !== false) {
         $fornav->execute();
         //Привязка переменных к подготовленному запросу 
         $fornav->bind_result(
         $idbk, 
         $titlebk, 
         $idpbk);
         //результат запроса помещаем в цикл  while и создаем рабочий массив 
         while($fornav->fetch()) {
             
             $titlebook["id"][$idpbk] = $idbk;             
             $titlebook["title"][$idpbk] = $titlebk;
             $titlebook["division"][$idpbk] = $idpbk;
             }
		 }
          } 
          } //var_dump($titlebook);
        
         if (isset($titlebook)) return $titlebook;
         else return null;
         //Закрываем запрос
         $fornav->close(); 
    }//selectMainForNav 
    

	/*Метод selectMainForPage
     * Выборка всех данных таблицы главных страниц сайта
     * Включен в метод getArticleDivision(), getArticlePart(),
     * strategyArticles(), menuMain(),modulForwardBack()
     * 
     * Аргументы: 
     * имя таблицы table="mainpage";
     * Метод возвращает рабочий массив $titlebook, ключи 
         * 2) id - порядковый номер,
          * title - заголовок,
          * content - содержание, 
          * anchor - якоря в статье
          * keywords - ключевые слова, 
          * descript - аннотация к статье,
          * division - раздел
         * 1) division - наименование раздела, к которому относится главная страница
     * В случае отсутствия записей в таблице 
     * возвращает false(что может говорить об атаке)
     * В случае наличия записей и отсутствия результата возвращает 
     * null
     * */
    protected function selectMainForPage()
    {
        $this->table = 'mainpage';
        //$this->division;
        
        if ($this->controlTable()) {
           
        if ($this->controlString() !== false) {
        $this->mysqli->query("SET NAMES 'utf8'");
         
         //Подготавливаем запрос к БД prepare
         $article = $this->mysqli->prepare(
         'SELECT 
         id,
         title,  
         content, 
         anchor, 
         keywords,
         annotation,
         author,
         dat, 
         division 
         FROM mainpage
         ORDER BY list');
         //Выполняем подготовленный запрос
         //$article->bind_param('s', $this->division);
         if ($article !== false) {
         $article->execute();
         //Привязка переменных к подготовленному запросу 
         $article->bind_result(
         $idstring, 
         $titlebk,         
         $contbk,
         $anch,
         $keywbk,
         $annotbk,
         $avt,
         $dt,
         $idpbk);
         //результат запроса помещаем в цикл  while и создаем рабочий массив 
         while($article->fetch()) {
             
             $titlebook[$idpbk]["id"] = $idstring;             
             $titlebook[$idpbk]["title"] = $titlebk;
             //$titlebook["list"][$idpbk] = $listbk;
             $titlebook[$idpbk]["content"] = $contbk;
             $titlebook[$idpbk]["anchor"] = $anch;
             $titlebook[$idpbk]["keywords"] = $keywbk;
             $titlebook[$idpbk]["descript"] = $annotbk;
             $titlebook[$idpbk]["author"] = $avt;
             $titlebook[$idpbk]["data"] = $dt;
             $titlebook[$idpbk]["division"] = $idpbk;
             }
		 }
          } 
          } //var_dump($titlebook);
        
         if (isset($titlebook)) return $titlebook;
         else return null;
         //Закрываем запрос
         $article->close(); 
    }//selectMain 
    
    /* Метод selectSimpleArticles()
     * Выполняет выборку всех статей всех существующих разделов без указания главы.
     * Входит в методы strategyArticles(),menuMain(), 
     * 
     * Аргументы: 
     * table - имя таблицы, которое соответствует имени раздела
     * Метод возвращает многомерный массив $titbook, 
         ключи: 
         * 1)title - заголовок, 
         * content - содержание,
         * anchor - якоря, 
         * author - автор, 
         * data - дата публикации или обновления,
         * recomendation - смотреть также, 
         * keywords - ключевые слова, 
         * descript - аннотация к статье,
         * part - номер главы;
         * alias - алиас заголовка
         * 2) - номер статьи 

     * В случае отсутствия записей в таблице 
     * возвращает false
     * */
    protected function selectSimpleArticlesForPage()
    {
		$this->alias;
		if (isset($this->table)) {
        if ($this->controlTable())  {
           
        if ($this->controlString() !== false) {
         //Указываем кодировку вывода данных из СУБД
         $this->mysqli->query("SET NAMES 'utf8'");
         
         //Подготавливаем запрос к БД prepare
         $forpage = $this->mysqli->prepare(
           'SELECT
              id, 
              title, 
              content,
              anchor, 
              author, 
              dat, 
              recomendation,
              keywords, 
              annotation, 
              idpart,
              alias 
            FROM ' . $this->table . ' 
            WHERE alias = ?');
         //Выполняем подготовленный запрос
         if ($forpage !== false) {
         $forpage->bind_param('s', $this->alias);
         
         if ($forpage->execute())
         //Привязка переменных к подготовленному запросу 
         $forpage->bind_result(
         $idstring,
         $titbk, 
         $conbk, 
         $anch,
         $autbk, 
         $datbk, 
         $recomend, 
         $keybk, 
         $annbk, 
         $idptbk,
         $al);
         //результат запроса помещаем в цикл  while и создаем рабочий массив $arrarticles -["title"][1][15] это title статьи из раздела 1, id статьи 15 /
         while($forpage->fetch()) {
			 $titbook["id"] = $idstring;
             $titbook["title"] = $titbk;
             $titbook["content"] = $conbk;
             $titbook["anchor"] = $anch;
             $titbook["author"] = $autbk;
             $titbook["data"] = $datbk;
             $titbook["recomendation"] = $recomend;
             $titbook["keywords"] = $keybk;
             $titbook["descript"] = $annbk;
             $titbook["part"] = $idptbk;
             $titbook["alias"] = $al;
             
             }
             //Закрываем запрос
            if (isset($forpage)) $forpage->close(); 
		     } 
             }  
            
             }               
       }
             
            if (isset($titbook)) 
            return $titbook;
            else return null;
    }//selectSimpleArticles

    /* Метод selectElements
     * Выборка всех элементов из таблицы элементов.
     * Метод также проверяет существование записей в таблице.
     * Входит в методы getЭлемент
     * Аргументы:
     * table - имя таблицы.
     * 
     * Метод возвращает рабочий массив, 
     * ключи:
     * id - порядковый номер элемента,
     * title - имя элемента на англ.,
     * pos -Позиция элемента в шаблоне, когда элемент - шаблон -позиция 0  
     * activation - состояние элемента: 1-подключен, 0-отключен
     * */
    protected function selectElements()
    {
         if ($this->controlString() !== false) {
         //Указываем кодировку вывода данных из СУБД
         $this->mysqli->query("SET NAMES 'utf8'");
         
         //Подготавливаем запрос к БД prepare
         $elem = $this->mysqli->prepare(
                    "SELECT 
                         id, 
                         title, 
                         pos,
                         activ 
                     FROM " . $this->table);
         
         //Выполняем подготовленный запрос
         $elem->execute();
         //Привязка переменных к подготовленному запросу 
         $elem->bind_result($idel,$titl, $posel, $act);
         //результат запроса помещаем в цикл  while и создаем рабочий массив 
         while($elem->fetch()) {
             $idelem["id"][$idel]=$idel;             
             $idelem["title"][$idel]=$titl;
             $idelem["pos"][$idel]=$posel;
             $idelem["activation"][$idel]=$act;
         }
         
         if (isset($idelem)) return $idelem;
         else return null;
         
         $elem->close(); 
         }         
    }//selectElements
    
    /* Выборка из таблицы шаблонов
     * 
     * Аргументы:
     * table
     * Возвращает массив установленных шаблонов.
     * */
    protected function selectTemplates()
    { 
		$this->table="templates";
        
        if (is_null($this->selectElements())) {
            return null;
        } else {
            return $this->selectElements();
            }
		
	}//selectTemplate
}
