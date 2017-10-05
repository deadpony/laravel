<?php

namespace App\Convention\ValueObjects\Identity;

final class Identity
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $UUIDv4 = "/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i";

    /**
     * @param string $id
     * @throws \InvalidArgumentException
     */
    public function __construct(string $id)
    {
        $validation = preg_match($this->UUIDv4, $id);

        if ($validation === false || $validation === 0) {
            throw new \InvalidArgumentException("Incorrect Identity format, should be UUIDv4");
        }

        $this->id = $id;
    }

    /**
     * @return string
     */
    public function id() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id();
    }

    /**
     * @param Identity $id
     * @return bool
     */
    public function equals(Identity $id)
    {
        return strtolower((string) $this) === strtolower((string) $id);
    }
}