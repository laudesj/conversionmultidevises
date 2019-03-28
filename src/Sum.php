<?php
namespace Ecv;

class Sum implements Expression {
  public $augend;
  public $addend;

  public function __construct($augend, $addend) {
    $this->augend = $augend;
    $this->addend = $addend;
  }

  public function reduce(Bank $bank, $to) {
    $amount = $this->augend->reduce($bank, $to)->getAmount() + $this->addend->reduce($bank, $to)->getAmount();
    return new Money($amount, $to);
  }

  public function plus(Expression $addend) {
    return new Sum($this, $addend);
  }

  public function times($multiplier) {
    return new Sum($this->augend->times($multiplier), $this->addend->times($multiplier));
  }
}
