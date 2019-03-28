<?php

require_once 'vendor/autoload.php';
use Ecv\Bank;
use Ecv\Money;
use Ecv\Sum;

// | Produit | Quantité | Prix    | Total
// | ---     | ---:     | ---:    | ---:
// | Prod 1  | 1        | 99.99 € | 99.99 €
// | Prod 2  | 2        | $69.99  | $139.98
// |         |          | Total ¥ | 28015.33 ¥

$bank = Bank::getInstance();
print_r($bank->getRates());

// j'ajoute le bitcoin
$bank->addRate('BTC', 0.00029);
print_r($bank->getRates());

// tests de certaines conversions
echo "USD -> EUR = " . $bank->getRate('USD', 'EUR') . "\n";
echo "EUR -> USD = " . $bank->getRate('EUR', 'USD') . "\n";
echo "USD -> BTC = " . $bank->getRate('USD', 'BTC') . "\n";

// exemple tiré de l'énoncé
$ligne_1 = Money::euro(99.99);
$ligne_2 = Money::dollar(69.99)->times(2);
$total = (new Sum($ligne_1, $ligne_2))->reduce($bank, 'JPY');
print_r($total);

// ajout d'une 3eme ligne/produit en BTC
$ligne_3 = Money::makeMoney(1, 'BTC');
$total = (new Sum($ligne_3, new Sum($ligne_1, $ligne_2)))->reduce($bank, 'JPY');
// affichage du total du panier en YEN
print_r($total);