<?php
/**
 * Created by PhpStorm.
 * User: rdoliveira
 * Date: 27/11/2018
 * Time: 17:40
 */

namespace app;

require 'Board.php';

/**
 * Class Population
 * @package app
 */
class Population
{
    /**
     * @var array
     */
    private $boards;
    /**
     * @var int
     */
    private $board_size;
    /**
     * @var float
     */
    private $mutation_rate;
    /**
     * Number of childs each parents generate. Set to 4 to keep the initial population size.
     * @var int
     */
    private $number_childs;
    /**
     * Method to select what individuals will breed. 0 for kill worst half method and 1 for roulette method.
     * @var int
     */
    private $selection_method;
    /**
     * @var int
     */
    private $generation_count = 0;

    /**
     * Population constructor.
     * @param int|null $population_size
     * @param int $board_size
     * @param float $mutation_rate
     * @param int $number_childs
     * @param int $selection_method
     */
    public function __construct(int $population_size = null, int $board_size = 8, float $mutation_rate = 0.1, int $number_childs = 4, int $selection_method = 1)
    {
        $this->board_size = $board_size;
        $this->mutation_rate = $mutation_rate;
        $this->number_childs = $number_childs;
        $this->selection_method = $selection_method;
        if (!isset($population_size)) {
            $population_size = 2 * pow($board_size, 2);
        }
        for ($i = 0; $i < $population_size; $i++) {
            $board = new Board($this->board_size);
            $board->initializeBoard();
            $this->boards[] = $board;
        }
    }

    public function startAlgorithm(int $limit)
    {
        //echo "<pre>";
        while (!$this->foundSolution() && $limit != 0) {
            $this->nextGeneration();
            if ($limit != -1) {
                $limit--;
            }
        }
    }

    /**
     * Generates the next generation of boards doubling the number than killing the worst half
     */
    public function nextGeneration()
    {
        $childGeneration = [];

        while (count($this->boards) > 1) {
//            do {
//                $parent1 = mt_rand(0, count($this->boards) - 1);
//                $parent2 = mt_rand(0, count($this->boards) - 1);
//            } while ($parent1 == $parent2);
            $parent1 = count($this->boards) - 1;
            $parent2 = count($this->boards) - 2;

            $aux = $parent1;
            $aux2 = $parent2;
            if ($aux2 > $aux) {
                $aux2--;
            }
            $parent1 = $this->boards[$parent1];
            $parent2 = $this->boards[$parent2];
            array_splice($this->boards, $aux, 1);
            array_splice($this->boards, $aux2, 1);

            $childGeneration = array_merge($childGeneration, $this->crossover($parent1, $parent2));
        }

        $this->boards = $childGeneration;
        if ($this->selection_method == 0) {
            $this->killHalfMethod();
        } elseif ($this->selection_method == 1) {
            $this->rouletteMethod();
        }
        $this->generation_count++;
    }

    /**
     * @param Board $parent1
     * @param Board $parent2
     * @return array
     */
    private function crossover(Board $parent1, Board $parent2): array
    {
        $childGeneration = [];

        for ($k = 0; $k < $this->number_childs; $k++) {

            $child = null;

            if (mt_rand(0, 100) / 100 > $this->mutation_rate) {
                $match = [];
                $matchAux = [];

                foreach ($parent1->getPosition() as $key => $position) {
                    if ($position == $parent2->getPosition()[$key]) {
                        $matchAux[$key] = $position;
                    } elseif (count($matchAux) > 0) {
                        if (count($match) < count($matchAux)) {
                            $match = $matchAux;
                            $matchAux = [];
                        }
                    }
                }

                if (count($matchAux) > 0 && count($match) == 0)
                    $match = $matchAux;

                if (count($match) > 0) {
                    for ($i = 0; $i < $this->board_size; $i++) {
                        if (!in_array($i, array_keys($match))) {
                            $child[$i] = mt_rand(0, $this->board_size - 1);
                        } else {
                            $child[$i] = $match[$i];
                        }
                    }

                    $childGeneration[$k] = new Board($this->board_size);
                    $childGeneration[$k]->setPosition($child);
                } else {
                    $child = new Board($this->board_size);
                    $child->initializeBoard();
                    $childGeneration[$k] = $child;
                }
            } else {
                $child = new Board($this->board_size);
                $child->initializeBoard();
                $childGeneration[$k] = $child;
            }
        }

        return $childGeneration;
    }

    /**
     * Sort the population by Fitness than kill the worst half
     */
    private function killHalfMethod()
    {
        usort($this->boards, array($this, "bestFitness"));
        array_splice($this->boards, count($this->boards) / 2);
    }

    /**
     * Give each individual a chance to breed based on your fitness
     */
    private function rouletteMethod()
    {
        $population_size = count($this->boards) / 2;
        $boards = [];
        for ($i = 0; $i < $population_size; $i++) {
            do {
                $parent1 = mt_rand(0, count($this->boards) - 1);
                $parent2 = mt_rand(0, count($this->boards) - 1);
            } while ($parent1 == $parent2);

            $aux = $parent1;
            $aux2 = $parent2;
            if ($aux2 > $aux) {
                $aux2--;
            }
            $parent1 = $this->boards[$parent1];
            $parent2 = $this->boards[$parent2];

            if ($parent1->getFitness() > $parent2->getFitness()) {
                $fitnessPercentage = (100 * $parent1->getFitness()) / ($parent1->getFitness() + $parent2->getFitness());
            } else {
                $fitnessPercentage = (100 * $parent2->getFitness()) / ($parent1->getFitness() + $parent2->getFitness());
            }

            if (mt_rand(0, 100) <= $fitnessPercentage) {
                array_splice($this->boards, $aux2, 1);
                $boards[] = $parent1;
            } else {
                array_splice($this->boards, $aux, 1);
                $boards[] = $parent2;
            }
        }
        $this->boards = $boards;
    }

    /**
     * @param Board $board1
     * @param Board $board2
     * @return int
     */
    private function bestFitness(Board $board1, Board $board2): int
    {
        return $board2->getFitness() <=> $board1->getFitness();
    }

    /**
     * @return bool
     */
    public function foundSolution(): bool
    {
        if ($this->boards[0]->getFitness() == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return string
     */
    public function getBestSolution(): string
    {
        $board_position = $this->boards[0]->getPosition();

        $tabuleiroHTML = '<div id="containerFull"><div id="container">';
        $linha = 1;
        $coluna = 1;
        $tamanho = 100 / count($board_position);
        $font = (600 / count($board_position)) * (2 / 3);

        foreach ($board_position as $value) {
            $tabuleiroHTML .= "<div class=\"row line-{$linha}\" style='--n:{$tamanho}%;'>";
            for ($i = 0; $i < count($board_position); $i++) {
                if ($i == $value) {
                    $tabuleiroHTML .= "<div id=\"$coluna\" style='font-size: {$font}px !important;'>&#9819</div>";
                } else {
                    $tabuleiroHTML .= "<div id=\"$coluna\"></div>";
                }
                $coluna++;
            }
            $tabuleiroHTML .= '</div>';
            if ($linha == 2) {
                $linha = 1;
            } else {
                $linha++;
            }
        }

        return $tabuleiroHTML;
    }

    /**
     * @return float
     */
    public function getMutationRate(): float
    {
        return $this->mutation_rate;
    }

    /**
     * @return array
     */
    public function getBoards(): array
    {
        return $this->boards;
    }

    /**
     * @return int
     */
    public function getBoardSize(): int
    {
        return $this->board_size;
    }

    /**
     * @return int
     */
    public function getGenerationCount(): int
    {
        return $this->generation_count;
    }
}