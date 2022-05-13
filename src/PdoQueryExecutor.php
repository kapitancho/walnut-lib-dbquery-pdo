<?php

namespace Walnut\Lib\DbQuery\Pdo;

use Walnut\Lib\DbQuery\QueryExecutionException;
use Walnut\Lib\DbQuery\QueryExecutor;

final class PdoQueryExecutor implements QueryExecutor {

	public function __construct(
		private readonly PdoConnector $pdoConnector
	) {}

	public function execute(string $query, array $boundParams = null): PdoQueryResult {
		try {
			$stmt = $this->pdoConnector->getConnection()->prepare($query);
			$stmt->execute($boundParams ?? []);
			return new PdoQueryResult($stmt);
		} catch (\PDOException $ex) {
			throw new QueryExecutionException($query, $ex);
		}
	}

	public function lastIdentity(): string {
		return $this->pdoConnector->getConnection()->lastInsertId();
	}

	public function foundRows(): ?int {
		// @codeCoverageIgnoreStart
		/**
		 * @var int|string|null
		 */
		$result = $this->pdoConnector->getConnection()->query("SELECT FOUND_ROWS()")
			->fetchAll(\PDO::FETCH_NUM)[0][0] ?? null;
		return isset($result) ? (int)$result : null;
		// @codeCoverageIgnoreEnd
	}
}