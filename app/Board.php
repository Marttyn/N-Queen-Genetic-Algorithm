<?php
/**
 * Created by PhpStorm.
 * User: rdoliveira
 * Date: 27/11/2018
 * Time: 16:55
 */

namespace app;

/**
 * Class Board
 * @package app
 */
class Board
{
    /**
     * @var int
     */
    private $size;
    /**
     * @var array
     */
    private $position;
    /**
     * @var int
     */
    private $fitness;
    /**
     * @var int
     */
    private $clashes;

    /**
     * Board constructor.
     * @param $size
     */
    public function __construct($size)
    {
        $this->size = $size;
    }

    public function initializeBoard(): void
    {
        for ($i = 0; $i < $this->size; $i++) {
            $this->position[] = mt_rand(0, $this->size - 1);
        }

        $this->calcFitness();
    }

    public function calcFitness(): void
    {
        $clashes = 0;
        for ($i = 0; $i < count($this->position); $i++) {
            for ($j = $i + 1; $j < count($this->position); $j++) {
                if ($this->position[$i] == $this->position[$j] || abs($this->position[$i] - $this->position[$j]) == $j - $i){
                    $clashes++;
                }
            }
        }

        $this->clashes = $clashes;
        $this->fitness = 1/(1+$clashes);
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return int
     */
    public function getClashes(): int
    {
        return $this->clashes;
    }

    /**
     * @return array
     */
    public function getPosition(): array
    {
        return $this->position;
    }

    /**
     * @param array $position
     */
    public function setPosition(array $position): void
    {
        $this->position = $position;
        $this->size = count($position);
        $this->calcFitness();
    }

    /**
     * @return float
     */
    public function getFitness(): float
    {
        return $this->fitness;
    }

}