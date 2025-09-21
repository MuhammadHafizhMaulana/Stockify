<?php

namespace App\Http\Repositories;

use App\Models\Category;

class CategoryRepository{
    public function getAll(){
        return Category::all();
    }

    public function findById($id){
        return Category::findOrFail($id);
    }

    public function create(array $data){
        return Category::create($data);
    }

    public function update(Category $category, array $data){
        return $category->update($data);
    }

    public function delete(Category $category){
        return $category->delete();
    }
}
