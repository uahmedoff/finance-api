<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Api\V1\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CategoryRequest;
use App\Http\Resources\Api\V1\CategoryResource;
use App\Http\Resources\Api\V1\CategoryMiniResource;

class CategoryResourceController extends Controller{
    
    protected $category;

    public function __construct(Category $category){
        $this->category = $category;
        parent::__construct();
    }

    public function index(){
        if(!auth()->user()->can('See categories'))
            return response()->json(['message' => __('auth.forbidden')],403);

        $categories = $this->category
            ->search()
            ->filter()
            // ->with('wallet.currency')
            ->sort()
            ->paginate($this->per_page);
        return CategoryMiniResource::collection($categories);    
    }

    public function store(CategoryRequest $request){
        if(!auth()->user()->can('Create category'))
            return response()->json(['message' => __('auth.forbidden')],403);
        
        $category = $this->category->create([
            'name' => $request->name,
            'icon' => $request->icon,
            'color' => $request->color,
            'bgcolor' => $request->bgcolor,
            'type' => $request->type,
            'parent_id' => $request->parent_id,
            'wallet_id' => $request->wallet_id
        ]);
        return new CategoryResource($category);
    }

    public function show($id){
        if(!auth()->user()->can('See category'))
            return response()->json(['message' => __('auth.forbidden')],403);

        $category = $this->category->findOrFail($id);
        return new CategoryResource($category);
    }

    public function update(Request $request, $id){
        if(!auth()->user()->can('Edit category'))
            return response()->json(['message' => __('auth.forbidden')],403);

        $category = $this->category->findOrFail($id);
        if(
            $request->filled('name') && 
            $request->name != $category->getOriginal('name')
        )
            $category->name = $request->name;
        if(
            $request->filled('icon') && 
            $request->icon != $category->getOriginal('icon')
        )
            $category->icon = $request->icon;
        if(
            $request->filled('color') && 
            $request->color != $category->getOriginal('color')
        )
            $category->color = $request->color;
        if(
            $request->filled('bgcolor') && 
            $request->bgcolor != $category->getOriginal('bgcolor')
        )
            $category->bgcolor = $request->bgcolor;
        if(
            $request->filled('type') && 
            $request->type != $category->getOriginal('type')
        ) 
            $category->type = $request->type;
        if(
            $request->filled('parent_id') && 
            $request->parent_id != $category->getOriginal('parent_id')
        ) 
            $category->parent_id = $request->parent_id;
        if(
            $request->filled('wallet_id') && 
            $request->wallet_id != $category->getOriginal('wallet_id')
        ) 
            $category->wallet_id = $request->wallet_id;
                            
        $category->save();             
        return new CategoryResource($category);
    }

    public function destroy($id){
        if(!auth()->user()->can('Delete category'))
            return response()->json(['message' => __('auth.forbidden')],403);

        $category = $this->category->findOrFail($id);
        $category->delete();
        return response()->json([],204);
    }
}
