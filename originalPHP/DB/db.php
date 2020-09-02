<?php
  class DB{
    private $host;
    private $name;
    private $user;
    private $pass;
    protected $connect;

    function __construct($host,$name,$user,$pass){
      $this->host = $host;
      $this->name = $name;
      $this->user = $user;
      $this->pass = $pass;
    }

    public function connectdb(){
      $this->connect = new PDO('mysql:dbname='.$this->name.';host='.$this->host.';charset=utf8',$this->user,$this->pass);
      if(!$this->connect){
        echo "接続できませんでした";
        die();
      }
    }
  }
