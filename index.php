<?php
/**
 * Created by PhpStorm.
 * User: rdoliveira
 * Date: 27/11/2018
 * Time: 18:43
 */

require 'app/Population.php';
use app\Population;

set_time_limit(0);

/* Config Parameters */

$population_size = null; //Set the start population size. Set to null for default value of 2*($board_size)^2
$board_size = 8; //Size of the board or number of queens.
$mutation_rate = 0.2; //Set between 0 (no mutation) and 1 (full random).
$number_of_childs = 4; //Number of childs each parents generate. Set to 4 to keep the initial population size.
$selection_method = 1; //0 for kill worst half method and 1 for roulette method.
$generation_limit = -1; //Set the limit of generations that will be generated to find the solution. -1 to no limit.

/* End Config Parameters */

$population = new Population($population_size, $board_size, $mutation_rate, $number_of_childs, $selection_method);

$population->startAlgorithm($generation_limit);

?>

<style>
    *, *::before, *::after{
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
    }

    #board {
        width:100%;
        height:100%;
        text-align: center;
    }

    #containerFull {
        margin-left:auto;
        margin-right:auto;
        width:600px;
        height:600px;
    }

    #container {
        border: 3px solid #000;
        width: 600px;
        height: 600px;
        border-radius: 5px;
        float: left;
    }

    .row {
        clear: both;
    }

    .row div {
        font-size: 3em;
        float: left;
        width: var(--n);
        height: var(--n);
        border-left: 1.5px solid #000;
        border-bottom: 1.5px solid #000;
        text-align: center;
    }

    .row div:first-child {
        border-left: 0;
    }

    .line-1 div:nth-child(2n+1)  {
        background: #000;
        color: #FFF
    }

    .line-2 div:nth-child(2n)  {
        background: #000;
        color: #FFF
    }
</style>

<div id="board">
    <h3><?= $population->foundSolution()?"Solution Found":"Solution Not Found" ?></h3>
    <h3>Initial Population Size: <?= 2 * pow($board_size, 2) ?></h3>
    <h3>Final Population Size: <?= count($population->getBoards()) ?></h3>
    <h3>Board's Size: <?= $population->getBoardSize() ?></h3>
    <h3>Mutation Rate: <?= $population->getMutationRate() ?></h3>
    <h3>Generation's Count: <?= $population->getGenerationCount() ?></h3>
    <?php echo $population->getBestSolution() ?>
</div>