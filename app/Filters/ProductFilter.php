<?php

namespace App\Filters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class ProductFilter
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $query): Builder
    {
        // Search by name and other available fields (sku if present, otherwise description)
        $query->when($this->request->query('search'), function (Builder $q) {
            $search = $this->request->query('search');
            $q->where(function ($qb) use ($search) {
                $qb->where('name', 'like', "%{$search}%");

                // Prefer SKU if column exists, otherwise search description as secondary field
                if (Schema::hasColumn('products', 'sku')) {
                    $qb->orWhere('sku', 'like', "%{$search}%");
                } elseif (Schema::hasColumn('products', 'description')) {
                    $qb->orWhere('description', 'like', "%{$search}%");
                }
            });
        });

        // Categories may be passed as `categories` or `categories[]`
        $categories = $this->request->query('categories', $this->request->query('categories[]'));
        if (!empty($categories)) {
            $ids = is_array($categories) ? $categories : explode(',', (string) $categories);
            $query->whereIn('category_id', $ids);
        }

        // Optional status filter
        $query->when($this->request->query('status'), fn ($q, $status) => $q->where('status', $status));

        return $query;
    }
}
