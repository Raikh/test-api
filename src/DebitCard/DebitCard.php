<?php

namespace Onigae\TestApi\DebitCard;


use Onigae\TestApi\Interfaces\ClientApiInterface;

class DebitCard
{
    private ClientApiInterface $clientApi;
    private array $cardData;
    /**
     * [
     * 'id',
     * 'first_name',
     * 'last_name',
     * 'address',
     * 'city',
     * 'country_id',
     * 'phone',
     * 'currency',
     * 'balance',
     * 'pin',
     * 'status'
     * ];
    /

    /**
     * DebitCard constructor.
     * @param ClientApiInterface $clientApi
     * @param array $cardData
     */
    public function __construct(
        ClientApiInterface $clientApi,
        array $cardData
    )
    {
        $this->clientApi = $clientApi;
        $this->cardData = $cardData;
    }

    public function refresh()
    {
        $card = $this->clientApi->getCard($this->cardData['id']);
        if(!empty($card))
        {
            $this->cardData = $card->getCardInfo();
        }
    }

    public function getId()
    {
        return $this->cardData['id'];
    }

    public function getPin(): int
    {
        return $this->cardData['pin'];
    }

    public function setPin(int $pin)
    {
        $result = $this->clientApi->setPin($this->getId(), $pin);
        if(!empty($result))
        {
            $this->cardData['pin'] = $pin;
        }
    }

    public function getBalance()
    {
        return $this->cardData['balance'];
    }

    public function getHistory()
    {
        return $this->clientApi->getHistory($this->getId());
    }

    public function getCardInfo(): array
    {
        return $this->cardData;
    }

    public function deactivate()
    {
        $result = $this->clientApi->deactivate($this->getId());

        if(!empty($result))
        {
            $this->cardData['status'] = 'deactivated';
        }
    }

    public function activate()
    {
        $result = $this->clientApi->activate($this->getId());

        if(!empty($result))
        {
            $this->cardData['status'] = 'activated';
        }
    }

    public function load(int $sum)
    {
        $result = $this->clientApi->load($this->getId(), $sum);

        if(!empty($result))
        {
            $this->cardData['balance'] += $sum;
        }
    }
}