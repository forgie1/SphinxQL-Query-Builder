<?php

namespace Foolz\SphinxQL\Drivers;

interface MultiResultSetAdapterInterface
{

	/**
	 * Returns all multi results
	 * @return array
	 */
	public function getAllAsArray(): array;

    /**
     * Advances to the next rowset
     */
    public function getNext();

    /**
     * @return ResultSetInterface
     */
    public function current();

    /**
     * @return bool
     */
    public function valid();
}
