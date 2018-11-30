# N-Queen-Genetic-Algorithm

This is a simple attempt to solve the N Queen Problem using Genetic Algorithm with PHP.

## How to Install
Simple run the index.php using a webserver with php 7+.

You can configure the parameters in index.php.

## The Problem
The eight queens puzzle is the problem of placing eight chess queens on an 8×8 chessboard so that no two queens threaten each other. Thus, a solution requires that no two queens share the same row, column, or diagonal. The eight queens puzzle is an example of the more general n queens problem of placing n non-attacking queens on an n×n chessboard, for which solutions exist for all natural numbers n with the exception of n=2 and n=3.

## Individuals
Each Board is an individual of the population.

## Algorithm's Parameters
The parameters size population, mutation rate, board size, number of childs, selection method and maximum number of generation can be changed in the file index.php.

## Selection Method
The project have two selection methods, half kill that order the population by the board quality (Fitness) and kill the worst half and the roulette method that select two random individuals and randomly pick one giving the one with higher fitness better chance to be selected for breeding.

## Crossover and Mutation
For the crossover we create a mask of the parent's genes (queen position) getting the longer sequence that is equal to both parents and replicate that for the child and the others genes are randomly generated. In case of Mutation all genes are randomly generated to compensate the inelasticity of the crossover so we have genes diversity.

## Stopping Criteria
By default the stop criteria is when the solution is found, ie. no queen attack each other, but is possible to set the maximum number of generations that will be created.

## Fitness Function
The Fitness Function is what defines how good is a individual, this function is defined by:
  Fitness = 1 / (1 + Number of attacks)
Following this as close an individual are from 1 the better he is, 1 being the solution of the problem.
