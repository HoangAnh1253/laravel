<?php

namespace App\Http\Controllers;

use App\Http\Resources\EquipmentResource;
use App\Http\Resources\UserResource;
use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Service\EquipmentService;

class EquipmentController extends Controller
{

    protected $equipmentService;

    public function __construct(EquipmentService $equipmentService)
    {
        $this->equipmentService = $equipmentService;
    }

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
    public function store(Request $request)
    {
        //
        $this->equipmentService->create($request);
        return redirect()->route('equipment');
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
    public function update(Request $request, Equipment $equipment)
    {
        //
        $updated = $this->equipmentService->update($request, $equipment);
        return new EquipmentResource($updated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipment $equipment)
    {
        //
        $deleted = $this->equipmentService->destroy($equipment);
        if (!$deleted)
            return new \Exception("loi r cha");
        return new EquipmentResource($deleted);
    }

    public function disable(Equipment $equipment)
    {
        $deleted = $this->equipmentService->disable($equipment);
        if (!$deleted)
            return new \Exception("loi r cha");
        return redirect()->route('equipment');
    }

    public function getUser(Equipment $equipment)
    {
        $user = $equipment->user;
        return new UserResource($user);
    }

    public function getEquipmentsOfUser(User $user)
    {
        
        $equipments = Equipment::where("users_id", $user->id)->paginate(5);
        $categories = Category::all();
        $users = User::all();
        if (is_null($user->id)) {
            $authUser = Auth::user();
            $equipments = $authUser->equipments;
            return view('pages.my_equipments')->with(['user' => $user, 'equipments' => $equipments]);
        } else {
            return view('pages.equipment', ['equipments' => EquipmentResource::collection($equipments), 'categories' => $categories, 'users' => $users]);
        }
    }
}