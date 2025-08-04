<?php
namespace App\Modules\V1\Transaction\Bo\Add;

class TransactionDetailsBO
{
    private ?int $userId = null;
    private ?string $text = null;
    private ?float $amount = null;
    private ?string $notes = null;
    private ?int $category = null;

    public function toArray(): array
    {
        $collection = [];

        if (isset($this->userId)) {
            $collection['user_id'] = $this->userId;
        }
        if (isset($this->text)) {
            $collection['text'] = $this->text;
        }
        if (isset($this->text)) {
            $collection['text'] = $this->text;
        }
        if (isset($this->amount)) {
            $collection['amount'] = $this->amount;
        }
        if (isset($this->notes)) {
            $collection['notes'] = $this->notes;
        }
        if (isset($this->category)) {
            $collection['category'] = $this->category;
        }

        return $collection;
    }

    /**
     * Get the value of text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set the value of text
     *
     * @return  self
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get the value of amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     *
     * @return  self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of notes
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set the value of notes
     *
     * @return  self
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get the value of category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the value of category
     *
     * @return  self
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get the value of userId
     */ 
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */ 
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }
}