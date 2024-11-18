<?php 

    /**
     * Database
     * 
     * This class actives query builder from table or query.
     * 
     * @author Davide Cesarano <davide.cesarano@unipegaso.it>
     * @link https://github.com/davidecesarano/embryo-pdo
     */

    namespace Embryo\PDO;

    use Embryo\PDO\QueryBuilder\QueryBuilder;
    use Embryo\PDO\QueryBuilder\Query;
    use PDOException;

    class Connection 
    {
        /**
         * @var \PDO $pdo
         */
        private $pdo;
        
        /**
         * Set PDO connection.
         *
         * @param \PDO $pdo
         */
        public function __construct(\PDO $pdo)
        {
            $this->pdo = $pdo;
        }

        /**
         * Set query builder from table.
         *
         * @param string $table
         * @return QueryBuilder
         */
        public function table(string $table): QueryBuilder
        {
            return new QueryBuilder($this->pdo, $table);
        }

        /**
         * Set query from string
         *
         * @param string $query
         * @return Query
         */
        public function query(string $query): Query
        {
            return (new Query($this->pdo))->query($query);
        }

        /**
         * Transaction
         * 
         * @param \Closure $callback
         * @return mixed
         * @throws PDOException
         */
        public function transaction(\Closure $callback)
        {
            $callback = \Closure::bind($callback, $this);
            try {

                $this->pdo->beginTransaction();
                $result = $callback();
                $this->pdo->commit();
                return $result;

            } catch (PDOException $e) {
                $this->pdo->rollback();
                throw new PDOException($e->getMessage());
                
            }
        }

        /**
         * Begin Transaction
         *
         * @return mixed
         */
        public function beginTransaction() {
            try {
                $this->pdo->beginTransaction();
                return true;
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage());

            }
        }

        /**
         * Commit
         *
         * @return mixed
         */
        public function commit() {
            try {
                $this->pdo->commit();
                return true;
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage());

            }

        }

        /**
         * Rollback
         *
         * @return mixed
         */
        public function rollback() {
            try {
                $this->pdo->rollback();
                return true;
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage());

            }

        }
    }