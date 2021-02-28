<?php

namespace Foolz\SphinxQL\Drivers\Mysqli;

use Foolz\SphinxQL\Drivers\MultiResultSetAdapterInterface;
use Foolz\SphinxQL\Drivers\ResultSet;
use Foolz\SphinxQL\Exception\ConnectionException;

class MultiResultSetAdapter implements MultiResultSetAdapterInterface
{
    /**
     * @var bool
     */
    protected $valid = true;

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getAllAsArray(): array
    {
    	$connection = $this->connection->getConnection();

    	$results = [];
		do {
			if ($res = $connection->store_result()) {
				$results[] = $res->fetch_all(MYSQLI_ASSOC);
				$res->free();
			}
		} while ($connection->more_results() && $connection->next_result());

		return $results;
    }

    /**
     * @inheritdoc
     * @throws ConnectionException
     */
    public function getNext()
    {
        if (
            !$this->valid() ||
            !$this->connection->getConnection()->more_results()
        ) {
            $this->valid = false;
        } else {
            $this->connection->getConnection()->next_result();
        }
    }

    /**
     * @inheritdoc
     * @throws ConnectionException
     */
    public function current()
    {
        $adapter = new ResultSetAdapter($this->connection, $this->connection->getConnection()->store_result());
        return new ResultSet($adapter);
    }

    /**
     * @inheritdoc
     * @throws ConnectionException
     */
    public function valid()
    {
        return $this->connection->getConnection()->errno == 0 && $this->valid;
    }
}
