<?php namespace model;
/*
 * Connect.php
 * Соединение с СУБД
 * Copyright 2013 - 2021 Родионова Галина Евгеньевна https://unatka.ru <gala.anita@mail.ru>
 * 
 */

class Connect
{
    
    /*Внешние параметры соединения, 
     * хранятся в отдельном внешнем файле
     * в зашифрованном виде*/
    public $server;//Сервер
    public $datbas;//имя бд, задается файлом конфигурации
    public $username;//Имя пользователя БД
    public $parol;//Пароль пользователя БД
    
    /*Внутренние параметры соединения*/
    protected $host;//Сервер
    protected $user;//Имя пользователя БД
    protected $pass;//Пароль пользователя БД
    protected $db;//имя бд
    
  
    /*Метод connectMysqli
     * Создает постоянное соединение с СУБД MariaDB
     * Принимает внешние зашифрованные параметры соединения
     * и переводит их в protected
     * Аргументы: 
     * $server;//Сервер
     * $datbas;//имя бд, задается файлом конфигурации
     * $username;//Имя пользователя БД
     * public $parol;//Пароль пользователя БД 
     * Аргументы: 
     * $host;//Сервер
     * $db;//имя бд,
     * $user;//Имя пользователя БД
     * $pass;//Пароль пользователя БД
     * Возвращает постоянное соединение*/
    
    public function connectMysqli()
    {
        $this->host = 'localhost';
        $this->user = base64_decode($this->username);
        $this->pass = base64_decode($this->parol);
        $this->db = base64_decode($this->datbas);
        
       // mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        
        $this->mysqli = new \mysqli($this->host, $this->user, $this->pass, $this->db);
        if (mysqli_connect_errno()) {
            printf("Соединение не установлено: %s\n", mysqli_connect_error());exit();
            }
            if ($this->mysqli) return $this->mysqli;  
    }//connectMysqli
}//Connect
