<!DOCTYPE html>
<html lang="en">
<!--
   pages.html
   
   Copyright 2013 - 2023 Родионова Галина Евгеньевна  https://unatka.ru <gala.anita@mail.ru>
   * license   https://www.gnu.org/licenses/gpl.html GNU GPLv3
-->
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Security-Policy" 
content="default-src 'self';style-src 'self' 'unsafe-inline'; script-src 'self' 'unsafe-inline';object-src 'self';">
<link rel="stylesheet" href="/templates/sample/style.css" />
<link rel='icon' href='favicon.svg' type='image/svg' />
<?php $control->viewHead(); ?>
</head>

<body>
	<div id="base-wrapper" class="unionrules"><!--this main greed -->
		<!--class domen - это шапка, ее можно изменять, она не включена в обрабатывающий класс -->
		<div class="domen"><!--row 2-3 column 1-6-->
			
			<div id="logo"><!--column in domen 2-3 row 1-2-->
                <picture>
                    <source srcset="/images/logo-green-120.svg">
                    <img src="/images/green-120.png">                    
                </picture>            
            </div><!--logo-->
            
           <div class="name"><a href="<?php echo $control->viewDomain(); ?>"><h1>Домен сайта</h1></a></div><!--column in domen 3-4 row 1-2-->
            
            <div class="about"><!--column in domen 4-5 row 1-2-ссылка на контакты-->
           <a class="second-button js-secondButton" href=""></a>
              
            </div><!--about-->
            
            <div class="up"><!--column in domen 5-6 row 1-2 -->
				<?php  $control->viewGreeting(); ?>
            </div><!--up -->
            
		</div><!--domen -->
		
		<!--class="arrow-up-down" также не включен в файл-обработчик. Это стрелки вверх-вниз-->
		<div class="arrow-up-down"><!--arrow-up-down-row 5-6 column 2-11 -->
            <p class ="navdown" id="js-OnBottom">↓</p>
            <p class ="navup" id="js-OnTop">↑</p>
        </div><!--end arrowup-->
        
        <!--Главное меню, входит в обработчик-->
        <nav class="nav"><!--nav-row 3-4 column 2-5 -->
			<!--Здесь данные главного меню justify-flex-around=.nav ul  -->	
		    <?php $control->viewMainMenu(); ?>
		</nav><!--nav-->	
		
		<!--id="twice" не входит в обработчик - контейнер для двух блоков-->
		<div id="twice"> <!--twice -row 4-5 column 2-5-FOR-Add-->
           <div id="askfor">  
           </div> <!--end asakfor -->   
		    <!--Якорь или ссылка на форму входа -->	
           <div id="linkform"> <!-- -->
           </div><!--end linkform-->
                 
        </div><!--twice -->
        
        <!--Основное содержимое страницы входит в обработчик -->
        <main itemscope itemtype="https://schema.org/Article" class="main"><!--main -row 5-6 column 2-5-->
			  <!--Заголовок страницы Входит в обработчик -->
              <header><?php $control->viewHeader(); ?></header><!---row 1-2 column 2-4 в main -->
			  
			  <!--id="video" Входит в обработчик, поле для видео-->
			  <div id="video" class="video"><!--row 2-3 column 2-3 в main-->
			        <?php $control->viewVideoSimple(); ?>
			  </div><!--end id="video"-->
			  
			<!--!!!!!!!!!!!!chapter Наименование текущего раздела и главы, входит в обработчик-->
			<div class="chapter"> <!--chapter -row 2-3 column 3-4 в main-->
                <?php $control->viewChapter(); ?>
            </div><!--end chapter-->
            
            <!-- -->
            <ul id="anchor" class="anchor"><!---row 3-4 column 2-4 в main -->
			        <?php $control->viewAnchor(); ?>
            </ul>
            
            <!--Текст статьи входит в обработчик -->
			<article><!---row 4-5 column 2-4 в main -->
				<?php $control->viewText(); ?>
			    <meta itemscope itemprop='mainEntityOfPage'
                      itemType='https://schema.org/WebPage'
                      itemid=<?php echo "/$_SERVER[REQUEST_URI]" ?>/> 	
			</article><!--end article-->
			<!--Автор статьи Входит в обработчик -->
			<span id="address" itemprop = "author" itemscope 
              itemtype = "https://schema.org/Person"><!---row 5-6 column 2-3 в main -->
			  <address itemprop="name"><picture>
                    <source srcset="/images/stylo2-24.svg">
                    <img src="/images/stylo2-24.png">                    
                </picture><?php $control->viewAuthor(); ?></address>
			</span><!--end span-->
			<!--Дата публикации Входит в обработчик -->
			<time id="time" itemprop="datePublished">				
				<?php $control->viewTime(); ?>
			</time><!---row 5-6 column 3-4 в main -->

        </main><!--end main-->
        
       	<!--id="double" не входит в обработчик - контейнер для двух блоков-->
        <div id="double"><!--row 6-7 column 2-5 -->
			<!--id = "download" входит в обработчик - скачивание файлов-->
            <div id = "download"><!--row 1-2 column 2-3 в double--->
			    <?php $control->viewButtonDownload(); ?>	
            </div><!--end download--> 
            <!--id="commentary" входит в обработчик ССылки на страницу комментариев-->
            <div id="commentary" class="comment"><!--row 1-2 column 3-4 в double--->
            </div><!--commentary-->
            
        </div><!--end double-->
        
        <!--id="arrow" Постраничная навигация входит в обработчик-->
        <div id="arrow" class="arrow"><!--row 7-8 column 2-5 -->
			 <?php $control->viewArrowsForwardBack(); ?>	
		</div><!--end arrow--> 
		<!--reccomend Скрытое поле дополнительных ссылок Входит в обработчик--> 
		<details id="reccomend"><!--row 8-9 column 2-5 -->
			 <?php $control->viewRecomendaton(); ?>	
		</details><!--end details--> 
		
		<!--menu меню текущего раздела Входит в обработчик
		 #menu ul и #menu ul li ul-->
		<menu id="menu"><!--row 9-10 column 2-6 -->
			 <?php $control->viewSimpleMenu(); ?>	
		</menu> <!--end menu-->
		
		<!--id="log" секция для формы входа Входит в обработчик-->
		<section id="comments"><!--row 10-11 column 2-6 -->
			 
	    </section><!--end section--> 
	     <!--поле предупреждения о куки Не входит в обработчик-->
        <div id="warn">
			<div class = "warn warn-act">
				<div class='warn-text'>Мы используем куки. 
			    Продолжая пользоваться сайтом Вы соглашаетесь с этим.</div>
			    <button class='button warn-but' type='button'>Понятно.</button>
			    <a class='warn-list' href='' target='_blank'>Подробнее</a>
            </div>
        </div><!--row 11-12 column 2-5 -->
	    
	    <!--Подвал Входит в обработчик-->
	     <footer class="footer"><!--row 12-13 column 2-6 -->
		    	  <?php $control->viewFooter(); ?>	            
        </footer><!--end menu-->
        
	</div><!--end base-wrapper-->
    	<script src="/lib/jquery/jquery.min.js"></script>
        <script src="/lib/javascript.js"></script>

</body>

</html>
