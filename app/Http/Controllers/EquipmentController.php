<?php

namespace App\Http\Controllers;

use App\Http\Resources\EquipmentResource;
use App\Http\Resources\UserResource;
use App\Models\Category;
use App\Models\Equipment;
use App\Repositories\EquipmentRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;



class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $equipments = Equipment::paginate(5);
        $categories = Category::all();
        $users = User::all();
        return view('pages.equipment', ['equipments' => EquipmentResource::collection($equipments), 'categories' => $categories, 'users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, EquipmentRepository $repository)
    {
        //
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
        $created = $repository->create($payload);
        $equipments = Equipment::paginate(5);
        $categories = Category::all();
        $users = User::all();
        return redirect()->route('equipment');
        return view('pages.equipment', ['equipments' => EquipmentResource::collection($equipments), 'categories' => $categories, 'users' => $users]);


        return new EquipmentResource($created);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function show($equipment)
    {
        $equipments = Equipment::where('serial_number', $equipment)->paginate(5);
        $categories = Category::all();
        $users = User::all();

        return view('pages.equipment', ['equipments' => EquipmentResource::collection($equipments), 'categories' => $categories, 'users' => $users]);
        //return redirect('/equipments')->with(['equipments' => EquipmentResource::collection($equipments), 'categories' => $categories]);

        //return new EquipmentResource($equipment);
    }

    public function filter($category_id)
    {
        $equipments = Equipment::where('categories_id', $category_id)->paginate(5);
        $categories = Category::all();
        $users = User::all();
        $category = Category::find($category_id);
        return view('pages.equipment', ['equipments' => EquipmentResource::collection($equipments), 'categories' => $categories, 'users' => $users, 'filter' => $category->title]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function edit(Equipment $equipment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Equipment $equipment, EquipmentRepository $repository)
    {
        //
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

        $updated = $repository->update($equipment, $payload);
        return new EquipmentResource($updated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipment $equipment, EquipmentRepository $repository)
    {
        //
        $deleted = $repository->forceDelete($equipment);
        if (!$deleted)
            return new \Exception("loi r cha");
        return new EquipmentResource($deleted);
    }

    public function disable(Equipment $equipment, EquipmentRepository $repository)
    {

        $deleted = $repository->softDelete($equipment);
        if (!$deleted)
            return new \Exception("loi r cha");
        $equipments = Equipment::paginate(5);
        $categories = Category::all();
        $users = User::all();
        return redirect()->route('equipment')->with(['equipments' => EquipmentResource::collection($equipments), 'categories' => $categories, 'users' => $users]);
        return view('pages.equipment', ['equipments' => EquipmentResource::collection($equipments), 'categories' => $categories, 'users' => $users]);
        //view('pages.equipment', ['equipments' => EquipmentResource::collection($equipments), 'categories' => $categories]);
        //  return redirect('equipments');
    }

    public function getUser(Equipment $equipment)
    {
        $user = $equipment->user;
        return new UserResource($user);
    }

    public function getEquipmentsOfUser(User $user)
    {
        $equipments = $user->equipments;
        if(count($equipments) == 0)
        {
            $authUser = Auth::user();
            $equipments = $authUser->equipments;
            return view('pages.my_equipments')->with(['user' => $user, 'equipments' => $equipments]);
        }
        
    }
}