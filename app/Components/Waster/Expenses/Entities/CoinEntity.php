<?php

namespace App\Components\Waster\Expenses\Entities;

use App\Components\Waster\Expenses\Entities\Contracts\CoinContract;
use App\Helpers\Entities\Composable;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CoinEntity extends Composable implements CoinContract
{

    /** @var Collection */
    private $storage;

    public function __construct()
    {
        $this->storage = collect([]);
    }

    /**
     * @return int
     */
    public function getID(): int
    {
        return $this->storage->get('id');
    }

    /**
     * @param int $id
     * @return void
     */
    public function setID(int $id): void
    {
        $this->storage->put('id', $id);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->storage->get('type');
    }

    /**
     * @param string $type
     * @return void
     */
    public function setType(string $type): void
    {
        $this->storage->put('type', $type);
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->storage->get('amount');
    }

    /**
     * @param float $amount
     * @return void
     */
    public function setAmount(float $amount): void
    {
        $this->storage->put('amount', $amount);
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->storage->get('created_at');
    }

    /**
     * @param Carbon $createdAt
     * @return void
     */
    public function setCreatedAt(Carbon $createdAt): void
    {
        $this->storage->put('created_at', $createdAt);
    }

}