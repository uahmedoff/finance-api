<?php
namespace App\Models\Traits;

trait ScopeTrait{
    
    public function scopeSort($query){
        $column = (request()->get('column')) ?? 'id';
        $order = (request()->get('order')) ?? 'asc';
        return $query->orderBy($column, $order);
    }

    public function scopeSearch($query){
        $columns = $this->search_columns;
        return $query->where(function ($query) use($columns) {
            foreach ($columns as $column){
                $query->orwhere($column, 'ilike',  '%' . request()->get('search') .'%');
            }
        });
    }

}
