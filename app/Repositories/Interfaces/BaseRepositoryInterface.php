<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
{
    /**
     * Get the current model instance
     */
    public function getModel(): Model;

    /**
     * Create a new record
     */
    public function createRecord(mixed $data = null, array $relations = []): static;

    /**
     * Bulk insert multiple records
     */
    public function bulkInsert(array $records): bool;

    /**
     * Update existing record by ID
     */
    public function updateById(int $id, mixed $data = null): static;

    /**
     * Find record by ID with optional relations
     */
    public function findById(int $id, array $relations = [], array $columns = ['*']): Model;

    /**
     * Get paginated results with advanced filtering
     */
    public function getPaginatedResults(
        array $relations = [],
        array $conditions = [],
        array $columns = ['*'],
        array $orderBy = ['column' => 'id', 'direction' => 'DESC']
    ): LengthAwarePaginator;
}