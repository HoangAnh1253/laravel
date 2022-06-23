<?php

namespace App\Service;

use App\Http\Resources\CategoryResource;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;



class CategoryService
{
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategory(){
        return $this->categoryRepository->getAllCategory();
     }
 
     public function getAllCategoryPaginate(int $paginate = 6){
         return $this->categoryRepository->getAllCategoryPaginate($paginate);
      }


    public function getCategoryWhere(string $field = '', $value = '')
    {
        return $this->categoryRepository->getCategoryWhere($field , $value);
    }

    public function getCategoryWherePaginate(string $field = '', $value = '', $paginate = 6){
        return $this->categoryRepository->getCategoryWherePaginate($field, $value, $paginate);
    }

    public function findCategoryById(string $id){
        return $this->categoryRepository->findCategoryById($id);
    }
        

    public function create(Request $request){
        $payload = $request->only([
            'title'
        ]);

        $validator = Validator::make($payload, [
            'title' => ['required', 'string', 'unique:categories']
        ]);

        if ($validator->stopOnFirstFailure()->fails()) {
            return back()->withError($validator->errors()->first());
        }
        
        $this->categoryRepository->create($payload);
    }

    public function update(Request $request, Category $category){
        // return response()->json([
        //     "error" =>  'aaa'
        // ]);
        $payload = $request->only([
            'title',
        ]);

        $validator = Validator::make($payload, [
            'title' => ['required', 'string', Rule::unique('categories')->ignore($category)],
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            return response()->json([
                "error" =>  $validator->errors()->first()
            ]);
        }

        return new CategoryResource($this->categoryRepository->update($category, $payload));
    }

    public function disable(Category $category){
        return $this->categoryRepository->softDelete($category);
    }

    public function destroy(Category $category){
        return $this->categoryRepository->forceDelete($category);
    }
}