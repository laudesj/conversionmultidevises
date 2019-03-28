<?php
namespace Ecv;

class Money {
  protected $amount;
  protected $currency;

  public function __construct($amount, $currency) {
    $this->amount = $amount;
    $this->currency = $currency;
  }

  public static function dollar($amount) {
    return new Money($amount, 'USD');
  }

  public static function yen($amount)
  {
    return new Money($amount, 'JPY');
  }

  public static function euro($amount)
  {
    return new Money($amount, 'EUR');
  }

  public static function makeMoney($amount, $currency) {
    return new Money($amount, $currency);
  }

  public function getCurrency() {
    return $this->currency;
  }

  public function getAmount()
  {
    return $this->amount;
  }

  public function times($multiplier) {
    return new Money($this->amount * $multiplier, $this->currency);
  }

  public function plus(Expression $addend) {
    return new Sum(this, addend);
  }

  public function reduce(Bank $bank, $to) {
    $rate = $bank->getRate($this->currency, $to);
    return new Money($this->amount * $rate, $to);
  }

}

