<?php

namespace App\Entity;

use Yoop\EntityInterface;

class Note implements EntityInterface {

    private int $id;

    private string $message;

    private string $date;

    /**
     * Get the value of id
     *
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Get the value of message
     *
     * @return string
     */
    public function getMessage(): string {
        return $this->message;
    }

    /**
     * Set the value of message
     *
     * @param string $message
     *
     * @return self
     */
    public function setMessage(string $message): self {
        $this->message = $message;
        return $this;
    }

    /**
     * Get the value of date
     *
     * @return string
     */
    public function getDate(): string {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @param string $date
     *
     * @return self
     */
    public function setDate(string $date): self {
        $this->date = $date;
        return $this;
    }
}