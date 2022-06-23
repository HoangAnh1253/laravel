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
use App\Service\CategoryService;
use App\Service\EquipmentService;
use App\Service\UserService;
use Illuminate\Support\Facades\DB;

class EquipmentController extends Controller
{

    protected $equipmentService, $userService;

    public function __construct(EquipmentService $equipmentService, UserService $userService, CategoryService $categoryService)
    {
        $this->equipmentService = $equipmentService;
        $this->userService = $userService;
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $equipments = $this->equipmentService->getAllEquipmentPaginate(3);
        $categories = $this->categoryService->getAllCategory();
        $users = $this->userService->getAllUser();

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
        $equipments = $this->equipmentService->getEquipmentWherePaginate('serial_number', $equipment, 5);
        $categories =  $this->categoryService->getAllCategory();
        $users = $this->userService->getAllUser();
        return view('pages.equipment', ['equipments' => EquipmentResource::collection($equipments), 'categories' => $categories, 'users' => $users]);
    }

    public function filter($category_id)
    {
        $equipments = $this->equipmentService->getEquipmentWherePaginate('categories_id', $category_id, 5);;
        $categories = $this->categoryService->getAllCategory();
        $users = $this->userService->getAllUser();
        $category = $this->categoryService->findCategoryById($category_id);
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
        $equipments = $this->equipmentService->getEquipmentWherePaginate("users_id",$user->id, 5);
        $categories = $this->categoryService->getAllCategory();
        $users = $this->userService->getAllUser();
        if (is_null($user->id)) {
            $authUser = Auth::user();
            $equipments = $authUser->equipments;
            return view('pages.my_equipments')->with(['user' => $user, 'equipments' => $equipments]);
        } else {
            return view('pages.equipment', ['equipments' => EquipmentResource::collection($equipments), 'categories' => $categories, 'users' => $users]);
        }
    }

}
//     public function search(Request $request)
//     {
//         if ($request->ajax()) {
//             $output = "";
//             $equipments = DB::table('equipment')->where('name', 'LIKE', '%' . $request->search . "%")->get();

//             if ($equipments) {
//                 foreach ($equipments as $equipment) {
//                     $category = Category::find($equipment->categories_id);
//                     $user = User::find($equipment->users_id);
//                     if(!isset($user->name))
//                     {
//                         $user->name = '';
//                     }
//                     $output .= "
//                     <tr id='$equipment->serial_number' class='table-row  $category->title '>
//                         <th scope='row'> $equipment->serial_number </th>
//                         <td class='equipName'> $equipment->name </td>
//                         <td class='equipDesc'> $equipment->desc </td>
//                         <td class='equipCategory'> $category->title </td>
//                         <td class='equipStatus'> $equipment->status </td>
//                         <td class='equipUser'>$user->name</td>
//                     </tr>
//                     ";
//                 }
//                 return Response($output);
//             }
//         }
//     }
// }


//{{ isset({$equipment->nam}) ? {$equipment->nam} . ' (ID: ' . {$equipment->nam} . ')' : '' }}
// <td>
// <button onclick='{addDataToModel('{$equipment->serial_number}','edit')}'
// value='1'
// class='btn btn-success' data-bs-toggle='modal' data-bs-target='#editEquipModal'><i
// class='fas fa-clock'></i>Edit</button>
// <button onclick='openAssignModal('{$equipment->serial_number}')' class='btn btn-warning'
// data-bs-toggle='modal' data-bs-target='#assignEquipModal'><i class='fas fa-clock'></i>Assign</button>

// <button onclick='unAssignEquipment(this.parentNode.parentNode.id,this)' class='btn btn-secondary unassign-btn'
// {{ isset({$equipment->user->name}) ? '' : 'hidden' }}><i class='fas fa-clock'></i>Unassigned</button>


//                     <button onclick='{addDataToModel('{$equipment->serial_number}','delete')}'
// class='btn btn-danger'
// data-bs-toggle='modal' data-bs-target='#deleteEquipModal'>Delete</button>
// </td>
// </tr>