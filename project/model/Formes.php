<?php namespace model;
/*
 * Formes.php
 * 
 * Copyright 2013 - 2023 Родионова Галина Евгеньевна  https://unatka.ru <gala.anita@mail.ru>
 * * license   https://www.gnu.org/licenses/gpl.html GNU GPLv3
 */

class Formes
{
	   /* Поля форм*/
    public $command;//Команда на исполнение
    public $hiddennameinput;//Скрытое поле
    public $hiddenvalueinput;//Скрытое поле    
    public $nameaction;//Значение поля кнопки тип submit   
    public $namelegend;//Легенда
    public $nameinput;//Имя поля кнопки тип submit
    public $othernameinput;//Поле для взаимодействия с js. Сюда вставляется значение
    public $othervalueinput;
    public $textnameinput;//Текстовое поле
    public $textvalueinput;//Текстовое поле    
	
	public static function formBegin() 
    {
        echo "<form class = 'formes' method='POST'>";
    }
    
    public static function formBeginHide() 
    {
        echo "<form class = 'formes' method='POST' hidden>";
    }
      
    /* Метод formEnd.
     * Фрагмент - Окончание формы.
     * 
     * Аргументы:  
     * Имеет кнопку отправки данных типа submit, имя nameinput, 
     * значение nameaction.
     * Скрытое поле command 
     * Применяется в генерируемой форме.
     * */
    public function formEnd() 
    {
        if (isset($this->command))
        echo "<input type='hidden' name='command' value='$this->command' >";
        echo "<p><input class='button' type='submit' 
        name='$this->nameinput' value='$this->nameaction'></p>"; 
        echo "</form>";
    }//formEndSelect() 
    
    /* Метод blockInputs
     * Блок полей: 
     * текстовое, скрытое и поле для вставки js.
     * 
     * Аргументы:
     * namelegend - Легенда
     * othernameinput - поле для вставки js
     * hiddennameinput - скрытое поле
     * textnameinput - текстовое поле.
     * 
     * Используется для генерации форм.
     * */
    public function blockInputs()
    {
        echo "<fieldset>
        <legend class='legends'>";
            if (isset($this->namelegend))
            echo $this->namelegend; 
            echo "</legend>";
            
            if (isset($this->othernameinput)) {
            echo "<input class='part' type='text' 
                  name='$this->othernameinput' value='' readonly />"; 
              }
            
            if (isset($this->hiddennameinput))
            echo "<input type='hidden' name='$this->hiddennameinput' 
            value='$this->hiddenvalueinput' >";
           if (isset($this->textnameinput))
            echo "<input type='text' name='$this->textnameinput' 
            value='$this->textvalueinput' >";
          echo "</fieldset>";   
    } //blockInputs
    
}
