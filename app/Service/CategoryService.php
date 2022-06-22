<?php

namespace App\Service;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;



class CategoryService
{
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function create(Request $request){
        $payload = $request->only([
            'title'
        ]);

        $validator = Validator::make($payload, [
            'title' => ['required', 'string']
        ]);

        if ($validator->stopOnFirstFailure()->fails()) {
            return new Response(["message" => "bad input"], HttpFoundationResponse::HTTP_BAD_REQUEST);
        }
        
        $this->categoryRepository->create($payload);
    }

    public function update(Request $request, Category $category){
        $payload = $request->only([
            'title',
        ]);

        $validator = Validator::make($payload, [
            'title' => ['required', 'string'],
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            return new Response(["message" => "bad input"], HttpFoundationResponse::HTTP_BAD_REQUEST);
        }

        return $this->categoryRepository->update($category, $payload);
    }

    public function disable(Category $category){
        return $this->categoryRepository->softDelete($category);
    }

    public function destroy(Category $category){
        return $this->equipmentRepository->forceDelete($category);
    }
}