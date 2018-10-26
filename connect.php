

<?php

    /* Incluindo arquivo de configuração */
    require "config.php";

    Class Connect {

        /* Função para se conectar ao BD utilizando mysqli (função do PHP)
           não é mais recomendado utilizar esse método por conta de falhas
           de segurança */

        public function connect_with_mysqli(){

            $conexao = @mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die(mysqli_connect_error());
            mysqli_set_charset($conexao, DB_CHARSET) or die(mysqli_error($conexao));

            /* Retornando a conexão */
            return $conexao;
        }

        /* Função para se conecar ao BD utilizando PDO (biblioteca PHP)
           é mais seguro e mais recomendado que o mysqli */

        public function connect_with_pdo(){

			try{
				
				$conexao = new PDO("mysql:host=".DB_HOSTNAME.";dbname=".DB_DATABASE.";charset=".DB_CHARSET, DB_USERNAME, DB_PASSWORD);
                $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                /* retornando a conexão */
				return $conexao;
			
			}catch(PDOException $e){
				echo "Erro ao conectar-se ao banco de dados.";
			}
        }

        /* função para recuperar algo do BD utilizando mysqli */
        public function get_with_mysqli($table, $fields, $condition){

            /* iniciando a query */
            $query = "SELECT $fields FROM $table WHERE $condition";

            /* recebendo a conexão */
            $connection = $this->connect_with_mysqli();

            $dados = mysqli_query($connection, $query);

            return $dados;

        }

        /* função para recuperar algo do BD utilizando PDO */
        public function get_with_pdo($table, $fields, $condition){

            /* recebendo a conexão */
            $connection = $this->connect_with_pdo();

            /* iniciando a query */
            $query = "SELECT $fields FROM $table WHERE $condition";

            /* preparando a query */
            $stmt = $connection->prepare($query);
            
            /* executando a query */
			$stmt->execute();
			
			/* dando fetch na query */
			$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $dados;

        }


    }

?>