<?php
namespace Ecv;

interface Expression {
  public function reduce(Bank $bank, $to);
  public function plus(Expression $addend);
  public function times($multiplier);
}