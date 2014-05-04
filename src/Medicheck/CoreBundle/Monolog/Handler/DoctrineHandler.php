<?php

namespace Medicheck\CoreBundle\Monolog\Handler;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Formatter\LineFormatter;

use Doctrine\DBAL\Connection;

/**
 * Description of PDOHandler
 *
 *
 */
class DoctrineHandler extends AbstractProcessingHandler
{
    private $initialized;
    private $connection;

    public function __construct(Connection $connection, $level = Logger::DEBUG, $bubble = true){
        parent::__construct($level, $bubble);
        
        $this->initialized = false;
        $this->connection = $connection;
    }

    protected function write(array $record)
    {
        if(!$this->initialized) {
            $this->initialize();
        }
        
        $this->connection->executeQuery(
            'INSERT INTO monolog (channel, level_name, message, date, context) VALUES (?, ?, ?, ?, ?)', 
            array(
                $record['channel'], 
                $record['level_name'], 
                $record['formatted'],
                $record['datetime'],
                json_encode($record['context']),
            ),
            array(
                \PDO::PARAM_STR,
                \PDO::PARAM_STR,
                \PDO::PARAM_STR,
                "datetime",
                \PDO::PARAM_STR,
            )
        );
    }

    private function initialize()
    {
        $this->connection->executeQuery(
            'CREATE TABLE IF NOT EXISTS monolog (id INT NOT NULL AUTO_INCREMENT, channel VARCHAR(255), level_name VARCHAR(50), message LONGTEXT, date DATETIME, context TEXT, PRIMARY KEY (id))'
        );

        $this->initialized = true;
    }
    
    protected function getDefaultFormatter()
    {
        return new LineFormatter('%message%');
    }
}
