<?php namespace model;
/*
 * ViewPage.php
 * 
 * Тест на отображение данных страницы.
 * Copyright 2013 - 2022 Родионова Галина Евгеньевна  https://unatka.ru <gala.anita@mail.ru>
 * * license   https://www.gnu.org/licenses/gpl.html GNU GPLv3
 */

class ViewPage extends WithElements
{
	public $command;//
	

	/* Подключаю объект WorkWithData
	 * */
	public function __construct()
	{
		$this->parametrs = new WorkWithData;
		$this->param = $this->parametrs->getParam();
				if (isset($this->param[0])) 
				$this->division = $this->param[0];//Раздел
				if (isset($this->param[1]) && $this->param[1] !== "")
				$this->alias = $this->param[1];//Алиас(транслитерированый заголовок) страницы
        $this->dirandfile = new WorkWithDir;
        $this->viewform = new Formes;
        if (isset($_POST['command'])) 
        $this->command = htmlspecialchars(strip_tags(trim($_POST['command'])));
        if (isset($_GET['nicknameuser'])) 
        $this->nicknameuser = htmlspecialchars(strip_tags(trim($_GET['nicknameuser'])));
        if (isset($_GET['number'])) 
        $this->number = intval($_GET['number']);
        if (isset($_GET['gruppa'])) 
        $this->gruppa = intval($_GET['gruppa']);
        if (isset($_GET['activ'])) 
        $this->activ = intval($_GET['activ']);
        if (isset($_GET['emailuser'])) 
        $this->emailuser = htmlspecialchars(strip_tags(trim($_GET['emailuser'])));
        if (isset($_POST['nameuser'])) 
        $this->nameuser = htmlspecialchars(strip_tags(trim($_POST['nameuser'])));
        if (isset($_POST['mailuser'])) 
        $this->mailuser = htmlspecialchars(strip_tags(trim($_POST['mailuser'])));
        if (isset($_POST['department'])) 
        $this->department = htmlspecialchars(strip_tags(trim($_POST['department'])));
        if (isset($_POST['sectionin'])) 
        $this->sectionin = htmlspecialchars(strip_tags(trim($_POST['sectionin'])));
        if (isset($_POST['comment'])) 
        $this->comment = htmlspecialchars(strip_tags(trim($_POST['comment'])));
        if (isset($_POST['groupuser'])) 
        $this->groupuser = intval($_POST['groupuser']);
        if (isset($_POST['numberuser'])) 
        $this->numberuser = intval($_POST['numberuser']);
        if (isset($_POST['moder'])) 
        $this->moder = intval($_POST['moder']);
        
	}

    /* Метод strategyViewPage();
     * Стратегия подключения шаблона
     * Определяет имя подключаемого шаблона вида, который определяет
     * вид страницы.
     * */
	public function strategyViewPage()
	{
		$nametemplate = $this->getTemplate();
        if (is_dir("templates")) 
		if (isset($nametemplate))
		$template = "templates/$nametemplate/pages.php";

		if (isset($template)) return $template;		
	}//viewPage
	
	/* Метод
	 * Отображает страницу сопровождения сайта в зависимости от адреса
	 * */
	public function strategyViewCommon()
	{
		if (isset($_GET['rule'])) {
        $rule = addslashes(strip_tags(trim($_GET['rule'])));
        }
        if (isset($rule) && $rule === "commentary") {
        if (isset($_GET['division'])) 
        $division = addslashes(strip_tags(trim($_GET['division'])));
        
        if (isset($_GET['alias'])) 
        $alias = addslashes(strip_tags(trim($_GET['alias'])));       
		}
		if (isset($rule) && $rule === "common") {
		             
		    $this->viewCommonArticle();
		}
		
	}//strategyViewCommon
	
	/* not free*/
	public function viewGreeting()
	{		
		$nicknameuser = $this->supportNick();
		//$linkCrossing = $this->supportingLinkCross();
		/*if (isset($this->alias) && $this->alias !== "") {
				$exCrossing = "http://apiunatka/login/exit.php?division="
				 .$this->division. "&alias=" .$this->alias;
			} else {
				if (isset($this->division))
				$exCrossing = "http://apiunatka/login/exit.php?division="
				 .$this->division;
				}*/
		 if(isset($nicknameuser) && $nicknameuser !== null) { 
			 echo "<p class='login'>Добро пожа&shy;ло&shy;вать, 
                  <i>$nicknameuser!</i>
                </p>
                <!--<p>
                 <a class='second-button' href='$exCrossing&crossing=goout'>Выйти</a>
                </p>-->";
				}
	}//viewGreeting
	
	
	/* Метод viewHeader();
	 * Отображение заголовка статьи в шаблоне вида.
	 * *Для CSS : h1, main h1
	 * Аргументы: $datapage = $this->strategyArticles();
	 * */
	public function viewHeader()
	{	
		$datapage = $this->strategyArticles();//var_dump($datapage);echo "VIEW";
		if (isset($datapage["title"])) { 		
		echo "<h1 itemprop='headline'>".$datapage['title']."</h1>";         
		} else echo "<h1>Заголовка нет</h1>";
		
	}//viewHeader
	
	/* Метод viewChapter()
	 * Определяет отображение текущего раздела и главы
	 * */
	public function viewChapter()
	{
		$namedivision = $this->forChapter();

		if (isset($this->param) && $this->param !== null) {
			if (isset($this->alias) && $this->alias !== "") {
				if ($namedivision[0] !==0)
				echo "<p>Раздел: " . $namedivision[0] . "</p>";
				if ($namedivision[1] !==0)
                echo "<p>Глава: " . $namedivision[1] . "</p>";
                      } else {
						  if ($namedivision[0] !==0)
						  echo "<p>Раздел: " . $namedivision[0] . "</p>";
						  }
		}
		
	}//viewChapter
	
    /* Метод viewAnchor();
	 * Отображение якорей статьи в шаблоне вида.
	 * *Для CSS : ul .anchor li,ul .anchor li a;
	 * Аргументы: $datapage = $this->strategyArticles();
	 * */
	public function viewAnchor()
	{	
		$datapage = $this->strategyArticles();//var_dump($datapage);echo "VIEW";
        if(isset($datapage["anchor"]) && $datapage["anchor"] !== "") { 
			$anchors = explode(",",$datapage["anchor"]);              
            foreach($anchors as $k => $v) {
                echo "<li><a href ='#anchor".($k+1)."'>".$v."</a></li>";
                } 
              } //else echo "Якоря отсутствуют";		
	}//viewAnchor
	
	/* Метод viewText();
	 * Отображение текста статьи в шаблоне вида.
	 * *Для CSS : article, article h1, article header, article div, article span,
	 * article span address, article time;
	 * Аргументы: $datapage = $this->strategyArticles();
	 * */
	public function viewText()
	{	
		$datapage = $this->strategyArticles();//var_dump($datapage);echo "VIEW";
		if (isset($datapage["title"]) && isset($datapage["content"])) { 
		
           echo $datapage['content'];   
		}	else echo "Статьи нет";		
	}//viewText
	
	/* Метод viewAuthor();
	 * Отображение имени автора статьи в шаблоне вида.
	 * 
	 * Аргументы: $datapage = $this->strategyArticles();
	 * */
	public function viewAuthor()
	{	
		$datapage = $this->strategyArticles();//var_dump($datapage);echo "VIEW";
                   
            if(isset($datapage["author"])) {
              echo $datapage["author"];
		    } else echo "Имя автора отсутствует";			    
	}//viewAuthor
	
	/* Метод ();
	 * Отображение даты публикации статьи в шаблоне вида.
	 * *Для CSS : article, article h1, article header, article div, article span,
	 * article span address, article time;
	 * Аргументы: $datapage = $this->strategyArticles();
	 * */
	public function viewTime()
	{	
		$datapage = $this->strategyArticles();//var_dump($datapage);echo "VIEW";
         if(isset($datapage["data"])) {		    
            echo '<p>' .$datapage["data"]. '</p>';
		    } else echo "Дата отсутствует";	            
		
	}//viewTime
	
    /* not free
     * Если есть сессия, открывыается форма для комментария
     * В форме указано имя страницы, имя комментатора
     * */
	public function viewAddComment()
	{
		$nicknameuser = $this->supportNick();
		if ($nicknameuser !== null) {
			if (isset($this->command) && $this->command==="saveComment")
			$this->actionAddComment();
			if (isset($_GET['department'])) 
            $division = htmlspecialchars(strip_tags(trim($_GET['department'])));
            else $division = $this->division;
            if (isset($_GET['sectionin'])) 
            $alias = htmlspecialchars(strip_tags(trim($_GET['sectionin'])));
            else $alias = $this->alias;
			echo "<a href='#openModal' id='leavecomment' class='second-button'>Оставить комментарий</a>";
			
			echo "<div class='modalDialog' id='openModal'>";
			
			echo "<div>
					<a href='#close' class='close'>X</a>";
					if (isset($division))
					$this->viewform->textvalueinput = $division;
					if (isset($alias))
					$this->viewform->othervalueinput = $alias;
					if (!isset($_POST["comment"]))
                    $this->viewform->formComment();
                    else echo "Спасибо! Комментарий отправлен на модерацию. Скоро он появится здесь.
			                   Если нет причин отказывать(грубость, незензурные выражения и тому подобное.)";
                    
			echo "</div>
	</div>";
		}
        
	}//viewAddComments
	
	/* not free
	 * Method viewComments
	 * Отображение существующих комментариев
	 * */
    public function viewComments()
	{
		$this->alias;
		$this->division;
		if (isset($this->alias)) {
			if (isset($this->division))
			$this->oper = $this->alias;
		    } else {
				if (isset($this->division))
				$this->oper = $this->division;
				}
				if (isset($this->division)) {
				$this->table = "feedback".$this->division;
		        $selcomments = $this->selectComments();
			}
		if (isset($selcomments) && $selcomments !== null) {
			$onthispage = array_search(1, $selcomments["moder"]);
		} else $onthispage = null; //var_dump($onthispage);
		
		echo "<div>";
		if ($onthispage !== null) {
			echo "<h4>Комментарии</h4>";
		foreach($selcomments["moder"] as $k => $v) {
			if ($v === 1) {			
			echo "<h4>Комментирует " .$selcomments['fromuser'][$k] . "</h4>";
			echo "<p>" .$selcomments['data'][$k]. "</p>";			
			echo "<p>" .$selcomments['text'][$k]. "</p>";
			echo "<hr>";
		}
		}		    
		}  else echo "Комментариев пока нет";
		echo "<div>";
				
	}//viewComments

	
	/**/
    public function viewFooter()
    {
		$this->viewCommonMenu();
		echo "
		<address>Copyright © 2013 - " .date("Y"). " Родионова Галина Евгеньевна</address>
		<div><p>Автор cms-unatka, дизайна и материалов сайта, за исключением 
		особо оговоренных: © Родионова Галина Евгеньевна. 
		<p>Все права защищены. 
        <p>Использование cms-unatkaFREE допускается при 
		сохранении авторского права. Размещение материалов сайта на сторонних ресурсах 
        только с разрешения администрации сайта.</p></div>
		";
	}//viewFooter
	
	/* Метод viewHead();
	 * Отображение заголовков статьи в блоке <head></head>.
	 * Аргументы: $datapage = $this->strategyArticles();class ArticlesReflectionTest
	 * */
	public function viewHead()
	{		
		$datapage = $this->strategyArticles();
		$nametemplate = $this->getTemplate();
		echo "
        <meta name='viewport' content='width=device-width, initial-scale=1'>";
		if ($this->param && $this->param !== null) {
		if (isset($datapage['title']))	
		echo "<title>". $_SERVER['HTTP_HOST'] .".". $datapage['title']."</title>";
		} else {
			echo "<title>" . $_SERVER['HTTP_HOST'] . "</title>";
		}		
        if (isset($datapage['keywords']))		
        echo "<meta name='keywords' content='" . $datapage['keywords'] . "'/>";
        if (isset($datapage['descript']))
        echo "<meta name='description' content='" . $datapage['descript'] . "' />";
	    
	}//viewHead
	
	/* Метод viewCommonMenu
	 * Отображает меню страниц сопровождения сайта
	 * */
	public function viewCommonMenu()
	{
		$commonpage = $this->menuCommon();
		if ($commonpage !== null) {
		echo "<ul>";
		if ($commonpage["title"] !== null) {
			foreach($commonpage["title"] as $k => $v)
			echo "<li><a href = '/common/commonrules.php?rule=common&amp;id=$k'>$v</a></li>";
		    }
		echo "</ul>";
	    } else echo "Нет статей common";

	}//viewCommonMenu

	/* Метод viewMainMenu();
	 * Отображение главного меню.
	 * Аргументы: $param = $this->parametrs->getParam();
	 * $navigation = $this->menuMain(); class ArticlesReflection
	 * * Для CSS : nav, nav ul, nav ul li, nav ul li a,nav legend,;
	 * */
	public function viewMainMenu()
	{		
		$navigation = $this->menuMain();//var_dump($navigation);echo "NAV";
		//var_dump($_SERVER["REQUEST_URI"]);
		
		echo "<ul>";
		foreach($navigation['link'] as $k => $val) {
			if (is_null($this->param)) {
				if ($val === "site") {
					echo "<li>". 
			        $navigation['text'][$k] . "</li>";
				} else {
					echo "<li><a href = '/". $val . "' >". 
			        $navigation['text'][$k] . "</a></li>";
			        }
			} else {
			if (isset($this->param[0]) && $val === $this->param[0]) {
					$textforalink = $navigation['text'][$k];
					echo "<li>  
					<a href = 
					'" . $_SERVER['REQUEST_URI'] . "#menu'>
					Меню раздела
					<span>$textforalink</span> ▼ </a>
					</li>"; 		         
						  } else {
							  if ($val !== "site")
							  echo "<li><a href = '/". $val . "' >". 
			                  $navigation['text'][$k] . "</a></li>";
			                  else echo "<li><a href = '/' >". 
			                  $navigation['text'][$k] . "</a></li>";
			


						  }
					  }
					
				  }
		echo "</ul>";
		
	}//viewMainMenu	
	
	/* Метод viewSimpleMenu()
	 * Отображение меню раздела.
	 * Аргументы: $param = $this->parametrs->getParam();
	 * * Для CSS : menu ul, menu ul li, menu ul li a, 
	 *   class="menu-for-part js-menuForPart",id="menurazdel">&nbsp;<span></span>;
	 * */
	public function viewSimpleMenu()
	{
		$mnpg = $this->menuMain();//var_dump($mnpg);
		$textlink = $mnpg['text'];
		
		$menusimple = $this->menuDivision();

		if (isset($this->division)) { 
			 echo "<ul>";

				    if(isset($menusimple)) {
				    if (!isset($this->alias)) {
				    echo "Раздел: " . $textlink[$this->division];
				    } else { 
						echo "Раздел: <a href='/".$this->division."'>" . $textlink[$this->division] . "</a>";
						}    
				    /*if (isset($this->division))
				    echo "Раздел: " . $textlink[$this->division];*/
                     foreach($menusimple as $k => $v){ 
					 //$k - chapter $v - array	 
                     echo '<li class="js-menuForPart">';
                     if ($k === "-") { 
				     if (is_array($v))
                     echo "Статьи: <span><i class='up'></i></span>";
                     } else { 
					    if (is_array($v))
					    echo "Глава: $k <span><i class='up'></i></span>";
				         }
                    echo "<ul>";//$key -alias, $val - title
                    foreach($v as $key => $val) { 
						if (isset($this->alias) && $this->alias === $key) {
							echo "<li>$val</li>";
							} else {
								echo "<li><a href='/$this->division/$key' title=$val>$val</a></li>";
								}
                        }//foreach2
                    echo "</ul>";
				    } //foreach1
					 
				 }
			 echo "</ul>";  
		 }  else {
			 echo "<ul>";
                foreach($mnpg["link"] as $key => $value){
					if ($key !== "site") {
					echo "<li><a href='/$key' title='" . $mnpg['text'][$key] ."'>
					" . $mnpg['text'][$key] . "</a></li>";
				    } else {
					    echo "<li title='" . $mnpg['text']['site'] ."' >
					    " .$mnpg['text']['site'] ."</li>";
				        }
					}
			echo "</ul>";  		
		 }    			
	}//viewSimpleMenu

	/* Вид стрелок навигации вперед назад*/
	public function viewArrowsForwardBack()
	{
		$links = $this->arrowsForwardBack();//var_dump($links);
		
		if (isset($links) && $links !== null) {
		echo "<div>";
				if (isset($links['beforealias']) && $links['beforealias'] !==0) { 
				echo "<p><a href = ". $links['beforealias'] .">
		        Назад ◄ к стр. ".$links['beforetitle']."</a></p>";
		        }
		echo "</div>";
		echo "<div>";
				if (isset($links['nextalias'])) {
		        echo "<p><a href = " .$links['nextalias'] .">
		        Вперед ► к стр. ".$links['nexttitle']."</a></p>";
		        } 
		echo "</div>";
	    }
	}//viewArrowsForwardBack
	

	/* Метод viewButtonDownload определяет вид ссылки на скачивание 
	 * файлов с сайта*/
	public function viewButtonDownload()
	{
		$resultscan = $this->buttonDownload();
		if ($this->param !== null) {
			if (isset($this->alias) && $this->alias !== "" 
			&& isset($this->division)) {
		if ($resultscan !== null) {
		if (file_exists("downloads/$this->division/$resultscan[0]")) {
			
			echo "<a 
                  href='/downloads/$resultscan[2]' 
                  download='$resultscan[1]' class='button'>Скачать файл</a>";
			  } else echo "Нет файлов для скачивания";
			 }
		     } 
		 }			
	}//viewButtonDownload
	
	/* not free
	 * Метод viewSupportedButtonComment
	 * Выполняет авторизацию или регистрацию пользователя, 
	 * после чего предоставляет форму комментария.
	 * Если осуществляет вход через Яндекс или ВК,
	 * изменяется активация на подтвержденную
	 * */
	 public function viewSupportedButtonComment()
	{
		if ($this->param !== null) {
			$nicknameuser = $this->supportNick();
			if ($nicknameuser === null) {
				if (isset($_POST["forsubmit"])) {
					header("Location:".$_SERVER['HTTP_REFERER']."#leavecomment");
					}
				echo "<a href='#' class='second-button js-secondButton'>Хочу оставить комментарий</a>";
				echo "<div id='mask'>
				<a href='#' class='close js-close'>X</a>
				<div id='sheet'>";
				
				echo "<div id='forbutton'>
				<p><a href=''>Политика</a></p>
				<button id='insheet' class='insheet'>
				Войти через Яндекс</button>
				<button id='insheet-one' class='insheet'>Войти через ВК</button><br>
				<button id='insheet-two' class='insheet'>Просто зарегистрироваться на сайте</button><br>
				</div>";
				
		        echo "<div id='resmessage' hidden>
		        <h3>Вы зарегистрированы на сайте unatka.ru</h3>
		        <p>Ваш логин:</p><p id='message-nick'></p>
		        <p>Ваша почта:</p><p id='message-ml'></p>
		        <p id='message-gr'></p>
		        <p id='message-nmb'></p>
		        <form method = 'POST'>
		        <input type='submit' id='messages' class='button' name='forsubmit' value='OK'>
		        </form>
		        </div>";
				echo "<iframe class='iframe' sandbox='allow-forms allow-scripts' src=''></iframe>";							
	            
	            echo "</div>
				</div>";
			} else {
				 
				$this->viewAddComment();
			}
			echo "<p><a href='#comments' class='second-button'>Посмотреть комментарии</a></p>";
		}
		
	}//viewSupportedButtonComment*/
	 /*DO postMessage
	public function viewSupportedButtonComment()
	{
		if ($this->param !== null) {
			$linkCrossing = $this->supportingLinkCross();
			$nicknameuser = $this->supportNick();
			if ($nicknameuser === null) {
				echo "<p><a href=
				'$linkCrossing&crossing=commentary' class='second-button'>
				Хочу оставить комментарий</a></p>";
			} else {
				 
				$this->viewAddComment();
			}
			echo "<p><a href='#comments' class='second-button'>Посмотреть комментарии</a></p>";
		}
		
	}//viewSupportedButtonComment*/

	
	/* Метод viewSupportedButtonDownload
	 * Выполняет авторизацию или регистрацию пользователя, 
	 * для чего перенаправляет на поддомен api 
	 * После чего возвращает на исходную страницу и отдает файл на скачивание
	 * Если скачивание выполняется из разделов скачивания, при авторизации или 
	 * регистрации изменяет номер группы
	 * Если осуществляет вход через Яндекс или ВК,
	 * изменяется активация на подтвержденную
	 * */
	 public function viewSupportedButtonDownload()
	 {
		if ($this->param !== null) {
			$linkCrossing = $this->supportingLinkCross();
			$nicknameuser = $this->supportNick();
			if ($this->buttonDownload() !== null)  {
			if ($nicknameuser == null) {
				echo "<a class='button'  href=
				'http://$linkCrossing&crossing=download'>К скачиванию</a>";
			} else {
			        $this->viewButtonDownload();
		           }
		}
		}
	}

	
	/* Метод viewSupportedButtonOrder
	 * Выполняет авторизацию или регистрацию пользователя,
	 * изменяет номер группы 
	 * Если осуществляет вход через Яндекс или ВК,
	 * изменяется активация на подтвержденную,
	 * если прямая авторизация или регистрация, требует подтверждения почты. 
	 * после чего предоставляет форму заявки
	 * !!!!!!!!!!!!!!!!!!!!!!!!???????????????
	 * */
	public function viewSupportedButtonOrder()
	{
		
		if ($this->param !== null) {
			$nicknameuser = $this->supportNick();
			if ($nicknameuser) {
			echo "<a class='button' href=
			'http://simplesite/api/login/supportive.php?&crossing=ordering'>Оставить заявку</a>";
			} else {
				//echo "<a href='http://simplesite/api/order/idex.php?nick=" .$nick. "&number=".$us."&gruppa=" .$gr. "&activ=" .$actus. "&mail=" .$ml. "'>Оставить заявку</a>";
			    }
		}

	}//viewSupportedButtonOrder
	
	/* видео
	 * На Главной сайта нет видео и нет меню текущего раздела
	 * */
	 public function viewVideoSimple()
	 {
		 if (isset($this->param)) {
			if (isset($this->alias)) { 
			if (is_dir("media")) {
			if (is_dir("media/$this->division")) {
			if (file_exists("media/$this->division/$this->alias.mp4")) {
			 /*Вид модуля для любой страницы */ 
			echo "<video width='98%' controls = 'controls'>
			<source src ='" .$this->viewDomain() . "/media/".$this->division."/" . $this->alias. ".ogg'
			type='video/ogg; codecs = theora, vorbis'>
			<source src ='" .$this->viewDomain() . "/media/" . $this->division . "/" . $this->alias. ".mp4' 
			type='video/mp4; codecs=avc1.42E01E, mp4a.40.2'>
			</video>";
					} //else echo "Видео отсутствует";
				}
				}	
			 } else {
				 if (is_dir("media")) {
				 if (file_exists("media/main/$this->division.mp4")) {
			 /*Вид модуля для любой страницы */ 
			echo "<video width='98%' controls = 'controls'>
			<source src ='" .$this->viewDomain() . "/media/main/" . $this->division . ".mp4' 
			type='video/mp4; codecs=avc1.42E01E, mp4a.40.2'>";
			//echo "<source src ='" .$this->viewDomain() . "/media/main/" . $this->division . ".ogg'type='video/ogg; codecs = theora, vorbis'>";
			
			echo "</video>";
					} //else echo "Видео отсутствует";	
				 }
			 }			 
		 } else {
			  if (is_dir("media")) {
				 if (file_exists("media/main/site.mp4")) {
			 /*Вид модуля для любой страницы */ 
			echo "<video width='98%' controls = 'controls'>";
			//echo "<source src ='/media/main/site.ogg' type='video/ogg; codecs = theora, vorbis'>";
			echo "<source src ='" .$this->viewDomain() . "/media/main/site.mp4' 
			type='video/mp4;'>
			</video>";
					} //else echo "Видео отсутствует";	
				 }			 
		 }
	 }//viewVideoSimple
	
	
	/* Метод viewRecomendaton()
	 * Для CSS : details, summary, ul class = "reccomend" (li)(a)
     * Отображение рекомендаций(смотрите также), находится в блоке details*/
    public function viewRecomendaton()
     {
		$datapage = $this->strategyArticles();
		
		if(isset($datapage["recomendation"]) && $datapage["recomendation"] !== null) {        
            echo '<summary>Дополнительно</summary>';
            echo '<ul class = "reccomend">';
            
            foreach($datapage["recomendation"] as $key => $val){
                echo "<li>
                <a href ='/$key'>$val</a>
                </li>";
            } 
            echo '</ul>'; 
		    } else {
				echo "<summary>Дополнительно</summary>";
				echo '<ul class = "reccomend">';
				echo "<li>
                <p>На этой странице нет рекомендаций</p>
                </li>";
				echo '</ul>'; 
			    }            
	 }//viewRecomendaton

	 
   /*Отображение домена сайта, если это не поддомен*/
    public function viewDomain()
	{
		 if (!empty($_SERVER['HTTPS'])) {
			 $scheme = "https";
		 } else {
			 $scheme = "http";
		 }
		 return  $scheme . '://' . $_SERVER['HTTP_HOST'];	
		
	}//viewDomain
	
	/* Метод strategyArticles();
	 * Подготовка данных к отображению страницы;
	 * Входит в методы  viewArticle(), viewMainArticle(),viewHead(), 
	 * class ViewPage
	 * 
	 * Аргументы: $param = $this->parametrs->getParam();
	 * Данные передаются в зависимости от параметров адресной строки.
	 * Включены методы selectSimpleArticles() и selectMain() класс WithDbTest.
	 * */
	protected function strategyArticles()
	{

			if (isset($this->division) && $this->division !== "") {
				if (isset($this->alias) && $this->alias !=="")
				$mark = "paramZero";
				else $mark = "paramOne";
			} else $mark ="no_param";
			
			
			if (isset($mark))
			switch($mark){
				case("no_param"):
				if ($this->selectMainForPage() !== null)
			        $workarr = $this->selectMainForPage();					    
				    $newarray = $workarr["site"];
					
				break;
				case("paramOne"):	
				    if ($this->selectMainForPage() !== null)
			        $workarr = $this->selectMainForPage();			    
				    if (isset($this->division))
				    $newarray = $workarr[$this->division];
				break;
				case("paramZero"):
				    if (isset($this->division))
				    $this->table = $this->division;
				    if (isset($this->alias))
				    $newarray = $this->selectSimpleArticlesForPage(); 
									
				break;
			}
			
		if (isset($newarray)) return $newarray;
        else return null;    
	}//strategyArticles
	
	/* Метод viewCommonArticle();
	 * Отображение статьи сопровождения в шаблоне вида.
	 * *Для CSS : article, article h1, article header, article div, article address,
	 * article time;
	 * Аргументы: $datapage = $this->getCommonArticle();
	 * */
	protected function viewCommonArticle() 
	{
	    if (isset($_GET['id'])) $id = intval($_GET['id']);
		    $workarr = $this->selectCommon(); //var_dump($workarr);

				 $datapage = array(
                      "title" => $workarr["title"][$id],
			        "content" => $workarr["content"][$id],
			         "author" => $workarr["author"][$id],
			           "data" => $workarr["data"][$id],);
	   if (isset($datapage["title"]) && isset($datapage["content"])) { 
		
		echo "<article>";
		echo "<header>
            <h1>".$datapage['title']."</h1>
        </header>";
       
        echo "<div>" .$datapage['content']. "</div>"; 
             
        if(isset($datapage["author"])) {
              echo '
                <address>' . $datapage["author"].'</address>';
		    }
		    
        if(isset($datapage["data"])) {		    
            echo '<time>' .$datapage["data"]. '</time>';
		    }                
                   
        echo "</article>";
		} else echo "Статьи отсутствуют"; 
	}//viewCommonArticle		
}//ViewPage
