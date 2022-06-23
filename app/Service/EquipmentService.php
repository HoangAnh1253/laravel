<?php

namespace App\Service;

use App\Repositories\EquipmentRepository;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;


class EquipmentService
{
    public function __construct(EquipmentRepository $equipmentRepository)
    {
        $this->equipmentRepository = $equipmentRepository;
    }

    public function getAllEquipment(){
        return $this->equipmentRepository->getAllEquipment();
     }
 
     public function getAllEquipmentPaginate(int $paginate = 6){
         return $this->equipmentRepository->getAllEquipmentPaginate($paginate);
      }


    public function getEquipmentWhere(string $field = '', $value = '')
    {
        return $this->equipmentRepository->getEquipmentWhere($field , $value);
    }

    public function getEquipmentWherePaginate(string $field = '', $value = '', $paginate = 6){
        return $this->equipmentRepository->getEquipmentWherePaginate($field, $value, $paginate);
    }

    public function create(Request $request)
    {
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
            throw new InvalidArgumentException($validator->errors()->first());
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

    public function update(Request $request, Equipment $equipment)
    {
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
            throw new InvalidArgumentException($validator->errors()->first());
        }

        return $this->equipmentRepository->update($equipment, $payload);
    }

    public function disable(Equipment $equipment)
    {
        return $this->equipmentRepository->softDelete($equipment);
    }

    public function destroy(Equipment $equipment)
    {
        return $this->equipmentRepository->forceDelete($equipment);
    }

    public  function unassign(Equipment $equipment)
    {
        $payload = [
            "status" => "available",
            "users_id" => null
        ];
        return $this->equipmentRepository->update($equipment, $payload);
    }
}