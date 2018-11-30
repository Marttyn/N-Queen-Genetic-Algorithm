LEIA ME

- O grupo
	Daniela
	Rafael Domingos de Oliveira
	Thulio
	Wallace

- O problema
	O problema das N-rainhas consiste em encontrar todas as combinações possíveis de N rainhas num tabuleiro de dimensão N por N tal que nenhuma das rainhas ataque qualquer outra. Duas rainhas atacam-se uma à outra quando estão na mesma linha, na mesma coluna ou na mesma diagonal do tabuleiro.

- Representação dos indivíduos
	Cada tabuleiro é considerado um indivíduo.

- Parâmetros do sistema (tamanho da população, taxa de mutação...)
	Os parâmetros de tamanho da população, taxa de mutação, tamanho do tabuleiro, número de filhos, mêtodo de seleção dos sobreviventes e limite de gerações podem ser setados no arquivo index.php dentro do projeto.

- Políticas de seleção e eliminação de indivíduos.
	Foram implementadas duas políticas de seleção, half kill que ordena a população pela sua qualidade (função calcFitness) e mata a pior metade e o metodo da roleta que seleciona dois pares aleátorios e aleátoriamente seleciona um deles dando prioridade para o de melhor qualidade.

- Operadores genéticos (recombinação e mutação)
	O Crossover é realizado com a combinação dos genes em comum dos pais, ou seja, sequencias de posicionamento das rainhas em comum dos pais são herdadas pelos filhos e as outras posições são geradas aleatoriamente. Em caso de mutação todas as posições do filho são geradas aleatoriamente.

- Critérios de parada
	Por padrão o critério de parada é o encontro da solução, ou seja, nenhuma rainha ataca outra, porem é possível selecionar um número máximo de gerações para o algoritmo.

- Função de avaliação (a mais importante e mais complicada de ser definida)
	A função de avaliação de cada indivíduo (calcFitness) é calculada da seguinte forma:
	fitness = 1 / (1 + (Nº ataques no tabuleiro))
	Nesse caso quanto mais perto de 1 o fitness do tabuleiro for mais proximo está da solução, sendo 1 o tabuleiro possui uma das possíveis soluções.

- Uma breve análise do grupo sobre o desenvolvimento do trabalho
	Em comparação com o algoritmo Tempera Simulada acredito que o algoritmo genético teve um desempenho pior, pois o algoritmo Tempera Simulada possui uma heuristíca que define um caminho mais claro para a solução não contando tanto com a aleátoriedade mas a definição e implemetação de tal heuristíca é bem complexa. O algoritmo genético possui uma versatilidade maior, vejo varios cenários que podem ser solucionados com o uso do mesmo e não possui uma complexidade tão grande em seu desenvolvimento, porem devido a sua aleátoriedade pode-se tornar bem instável dependendo da escolha dos parâmetros utilizados, políticas de eliminação e crossover, com essa análise acredito que o algoritmo genético não é a melhor escolha para buscar soluções para o problema das N Rainhas.