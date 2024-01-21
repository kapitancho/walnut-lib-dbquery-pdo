<?php

namespace Walnut\Lib\DbQuery\Pdo;

use PDOStatement;
use Walnut\Lib\DbQuery\PreparedQueryExecutor;
use Walnut\Lib\DbQuery\QueryExecutionException;
use Walnut\Lib\DbQuery\QueryResult;

final class PdoPreparedQueryExecutor implements PreparedQueryExecutor {
	public function __construct(private readonly PDOStatement $statement) {}

	/**
	 * @param array<scalar|null>|null $boundParams
	 * @return QueryResult
	 * @throws QueryExecutionException
	 */
	public function execute(array $boundParams = null): QueryResult {
		$this->statement->execute($boundParams ?? []);
		return new PdoQueryResult($this->statement);
	}

	/** @param iterable<array<scalar|null>> $boundParamsArray */
	public function executeMany(iterable $boundParamsArray): void {
		foreach ($boundParamsArray as $boundParams) {
			$this->statement->execute($boundParams);
		}
	}

}