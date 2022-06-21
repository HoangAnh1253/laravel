<?php

namespace App\Service;

use App\Repositories\EquipmentRepository;
use Illuminate\Http\Request;
use App\Http\Resources\EquipmentResource;
use App\Http\Resources\UserResource;
use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class EquipmentService
{
    public function __construct(EquipmentRepository $equipmentRepository)
    {
        $this->equipmentRepository = $equipmentRepository;
    }

    public function create(Request $request){
        $payload = $request->only([
            'name',
            'desc',
            'status',
            'categories_id',
            'users_id'
        ]);

        $validator = Validator::make($payload, [
            'name' => ['required', 'string'],
            'desc' => ['required', 'string'],
            'status' => ['in:available,used']
        ]);

        if ($validator->stopOnFirstFailure()->fails()) {
            return new Response(["message" => "bad input"], HttpFoundationResponse::HTTP_BAD_REQUEST);
        }
        $category = Category::find($payload['categories_id']);
        $hash = Hash::make($payload['name']);
        $serial = substr($hash, 9, 3) . $category->title . substr($hash, 7, 6);
        while (!ctype_alnum($serial)) {
            $hash = Hash::make($payload['name']);
            $serial = substr($hash, 9, 3) . $category->title . substr($hash, 7, 6);
        }
        $payload['serial_number'] = $serial;
        $this->equipmentRepository->create($payload);
    }

    public function update(Request $request, Equipment $equipment){
        $payload = $request->only([
            'name',
            'desc',
            'status',
            'users_id'
        ]);

        $validator = Validator::make($payload, [
            'name' => ['required', 'string'],
            'desc' => ['required', 'string'],
            'status' => ['in:available,used']
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            return new Response(["message" => "bad input"], HttpFoundationResponse::HTTP_BAD_REQUEST);
        }

        return $this->equipmentRepository->update($equipment, $payload);
    }

    public function disable(Equipment $equipment){
        return $this->equipmentRepository->softDelete($equipment);
    }

    public function destroy(Equipment $equipment){
        return $this->equipmentRepository->forceDelete($equipment);
    }
}