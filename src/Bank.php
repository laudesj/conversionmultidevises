<?php
namespace Ecv;

class Bank {
  private static $_instance = null;
  private $rates = [];

  private function __construct() {
    $json = file_get_contents("https://api.exchangeratesapi.io/latest");
    $this->rates = json_decode($json, true);
  }

  public static function getInstance() {
    if (is_null(self::$_instance)) {
      self::$_instance = new Bank();
    }
    return self::$_instance;
  }

  public function reduce(Expression $source, $to) {
    return $source->reduce($this, $to);
  }

  public function addRate($to, $rate) {
    $this->rates['rates'][$to] = $rate;
  }

  public function getRate($from, $to) {
    if ($from == $to) {
      return 1;
    }
    if ($from == 'EUR' && array_key_exists($to, $this->rates['rates'])) {
      return $this->rates['rates'][$to];
    }
    if (array_key_exists($from, $this->rates['rates']) && ($to == 'EUR')) {
      return 1 / $this->rates['rates'][$from];
    }
    if (array_key_exists($from, $this->rates['rates']) && (array_key_exists($to, $this->rates['rates']))) {
      return 1 / $this->rates['rates'][$from] * $this->rates['rates'][$to];
    }
    return false;
  }

  public function getBase() {
    return $this->rates['base'];
  }

  public function getRates() {
    return $this->rates;
  }

}