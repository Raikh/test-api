<?php

namespace Onigae\TestApi\Interfaces;

use Onigae\TestApi\DebitCard\DebitCard;

interface ClientApiInterface
{
    public function setPin(int $cardId, int $pin);

    public function getPin(int $cardId);

    public function getBalance(int $cardId);

    public function getHistory(int $cardId);

    public function getCard(int $cardId): ?DebitCard;

    public function activate(int $cardId);

    public function deactivate(int $cardId);

    public function load(int $cardId, int $sum);

    public function countries();

    public function getCountry(int $countryId);
}