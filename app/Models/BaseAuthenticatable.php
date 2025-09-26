<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

abstract class BaseAuthenticatable extends Authenticatable
{
    /**
     * Check if model has attribute
     */
    public function hasAttribute($key): bool
    {
        return array_key_exists($key, $this->attributes);
    }

    /**
     * Get table name for model
     */
    public static function getTableName(): string
    {
        return with(new static)->getTable();
    }

    /**
     * Scope for active records
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get model's table columns
     */
    public function getTableColumns(): array
    {
        return $this->getConnection()
            ->getSchemaBuilder()
            ->getColumnListing($this->getTable());
    }

    /**
     * Check if model has relation
     */
    public function hasRelation(string $relation): bool
    {
        return method_exists($this, $relation);
    }

    /**
     * Get cached attributes
     */
    public function getCachedAttributes(): array
    {
        return array_merge(
            $this->attributes,
            $this->relations->toArray()
        );
    }
}