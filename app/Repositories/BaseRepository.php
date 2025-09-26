<?php

namespace App\Repositories;

use App\Models\BaseModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /** @var array Fillable fields for mass assignment */
    protected array $fillable = [];

    /** @var Model The model instance */
    protected Model $model;

    /** @var Request The current request instance */
    protected Request $request;

    /**
     * Constructor
     * 
     * @param Request $request Current HTTP request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get the current model instance
     * 
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * Create a new record with optional relations
     * 
     * @param mixed|null $data Data for creation
     * @param array $relations Relations to eager load
     * @return static
     */
    public function createRecord(mixed $data = null, array $relations = []): static
    {
        DB::beginTransaction();
        try {
            $data = $data ?? $this->request->only($this->fillable);
            $this->model = $this->model->create($data);
            
            if (!empty($relations)) {
                $this->model = $this->model->with($relations)->findOrFail($this->model->id);
            }
            
            DB::commit();
            return $this;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Bulk insert multiple records
     * 
     * @param array $records Array of records to insert
     * @return bool
     */
    public function bulkInsert(array $records): bool
    {
        return DB::transaction(function () use ($records) {
            return $this->model->insert($records);
        });
    }

    /**
     * Update existing record by ID
     * 
     * @param int $id Record ID
     * @param mixed|null $data Update data
     * @return static
     */
    public function updateById(int $id, mixed $data = null): static
    {
        DB::beginTransaction();
        try {
            $this->model = $this->model->findOrFail($id);
            $data = $data ?? $this->request->only($this->fillable);
            $this->model->update($data);
            
            DB::commit();
            return $this;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Find record by ID with optional relations
     * 
     * @param int $id Record ID
     * @param array $relations Relations to eager load
     * @param array $columns Specific columns to select
     * @return Model
     */
    public function findById(int $id, array $relations = [], array $columns = ['*']): Model
    {
        $query = $this->model->newQuery();

        if (!empty($relations)) {
            $query->with($relations);
        }

        return $query->select($columns)->findOrFail($id);
    }

    /**
     * Get paginated results with advanced filtering
     * 
     * @param array $relations Relations to eager load
     * @param array $conditions Query conditions
     * @param array $columns Columns to select
     * @param array $orderBy Ordering parameters
     * @return LengthAwarePaginator
     */
    public function getPaginatedResults(
        array $relations = [],
        array $conditions = [],
        array $columns = ['*'],
        array $orderBy = ['column' => 'id', 'direction' => 'DESC']
    ): LengthAwarePaginator {
        $query = $this->buildQueryWithConditions($conditions);
        
        if (!empty($relations)) {
            $query->with($relations);
        }

        return $query->select($columns)
            ->orderBy($orderBy['column'], $orderBy['direction'])
            ->paginate($this->request->input('per_page', 15));
    }

    /**
     * Build query with advanced conditions
     * 
     * @param array $conditions Array of query conditions
     * @return Builder
     */
    protected function buildQueryWithConditions(array $conditions): Builder
    {
        $query = $this->model->newQuery();

        foreach ($conditions as $condition) {
            $this->applyQueryCondition($query, $condition);
        }

        return $query;
    }

    /**
     * Apply individual query condition
     * 
     * @param Builder $query Query builder instance
     * @param array $condition Condition parameters
     * @return void
     */
    protected function applyQueryCondition(Builder $query, array $condition): void
    {
        if (count($condition) === 3) {
            [$field, $operator, $value] = $condition;
            
            switch ($operator) {
                case 'like':
                    $query->where($field, 'like', "%{$value}%");
                    break;
                case 'in':
                    $query->whereIn($field, (array) $value);
                    break;
                case 'between':
                    $query->whereBetween($field, (array) $value);
                    break;
                default:
                    $query->where($field, $operator, $value);
            }
        } else {
            [$field, $value] = $condition;
            $query->where($field, $value);
        }
    }
}