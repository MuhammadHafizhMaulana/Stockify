<?php

namespace App\Http\Services;

use App\Http\Repositories\CategoryRepository;


class CategoryService{

    protected $categoryRepo;

    public function __construct(CategoryRepository $categoryRepo){
        $this->categoryRepo = $categoryRepo;
    }

    public function listCategory(){
        return $this->categoryRepo->getAll();
    }

    public function createCategory(array $dataCategory){
        return $this->categoryRepo->create($dataCategory);
    }

    public function updateCategory($id, array $dataCategory){
        $category = $this->categoryRepo->findById($id);
        return $this->categoryRepo->update($category, $dataCategory);
    }

    public function deleteCategory($id){
        $category = $this->categoryRepo->findById($id);
        return $this->categoryRepo->delete($category);
    }

    public function getCategoryById($id){
        return $this->categoryRepo->findById($id);
    }
}
