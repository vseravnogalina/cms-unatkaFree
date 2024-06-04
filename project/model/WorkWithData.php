<?php namespace model;
/*
 * WorkWithData.php
 * Класс обрабатывает полученные от сайта get параметры для формирования вида статей
 * 
 * Copyright 2013 - 2022 Родионова Галина Евгеньевна  https://unatka.ru <gala.anita@mail.ru>
 */
 
 class WorkWithData
 {
	 
	 /* Метод getParam();
	  * Метод получает данные адресной строки и преобразует их в массив
	  * для дальнейшей работы. Данные адресной строки - результат перенаправления 
	  * в hteccess;
	  * Адресная строка имеет вид: namesite/division/article, 
	  * hteccess приводит ее к виду index.php?route=(division/article);
	  * Аргументы : $_GET['route'];
	  * Возвращает массив данных адресной строки типа главная страница, если 
	  * массив пустой, - это главная страница сайта и метод возвращает null,
	  * если есть только division/ - элемент массива с ключом [0](элемент article пустой) - 
	  * это главная страница раздела, 
	  * если строка полная division/article, division элемент массива с ключом [0] - указывает на раздел,
	  * article - элемент массива с ключом [1] указывает на статью - 
	  * это страница статьи.
	  * */
	 public function getParam()
	 {
		 $arr = array();
		 
         /* Обработка данных адресной строки*/
		 if (!empty($_GET['route'])) {
		 $route = $_GET['route'];
		 $route = ltrim($route,'\\');
		//echo 
		$route = str_replace('\\',DIRECTORY_SEPARATOR,$route);		 
	     }

         if (isset($route))
         $arr = explode('/', $route);
         else $arr = null;
		 
		if (is_array($arr) && array_key_exists(0, $arr))
		return $arr;
		else return null;
	 }//selectParametrs
	 
	
 }//WorkWithData
