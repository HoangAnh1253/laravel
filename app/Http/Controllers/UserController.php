<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreExamineeRequest;
use App\Http\Requests\UpdateExamineeRequest;
use App\Http\Resources\EquipmentResource;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::paginate(5);
        return view('pages.user', ["users" => UserResource::collection($users)]);
        return UserResource::collection($users);
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
     * @param  \App\Http\Requests\StoreExamineeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, UserRepository $repository)
    {
        //
        $payload = $request->only([
            'name',
            'email',
            'birthdate',
            'gender',
            'phone_number',
            'is_admin'
        ]);
        if(!isset($payload['password']))
            $payload['password'] = "password";
        $validator = Validator::make($payload, [
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['string', 'min:6'],
        ]);
        
        if ($validator->stopOnFirstFailure()->fails()) {
            return new Response(["message" => "bad input"], HttpFoundationResponse::HTTP_BAD_REQUEST);
        }
        
        $payload['password'] = Hash::make($payload['password']);
        $created = $repository->create($payload);
        return redirect()->route('user');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Examinee  $examinee
     * @return \Illuminate\Http\Response
     */
    public function edit(User $examinee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateExamineeRequest  $request
     * @param  \App\Models\Examinee  $examinee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, UserRepository $repository)
    {
        //
       
        $payload = $request->only([
            "name",
            "email",
            "gender",
            "birthdate",
            "password",
            "phone_number"
        ]);
        $validator = Validator::make($request->all(), [
            'name' => ['string'],
            'email' => ['email'],
            'gender' => ['boolean'],
            'bithdate' => ['date'],
            'password' => ['min:6']
        ]);
      

        if ($validator->stopOnFirstFailure()->fails()) {
            return new Response(["message" => "bad input"], HttpFoundationResponse::HTTP_BAD_REQUEST);
        }
      
       

        if(!isset($payload["password"]))
        {
            $payload["password"] = $user->password;
        }else
            $payload["password"] = Hash::make($payload["password"]);
        $updated = $repository->update($user, $payload);
        if (!$updated)
            return new \Exception("loi r cha");
        return new UserResource($updated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Examinee  $examinee
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, UserRepository $repository)
    {
        //
        $deleted = $repository->forceDelete($user);
        if (!$deleted)
            return new \Exception("loi r cha");
        return new UserResource($deleted);
    }

    public function disable(User $user, UserRepository $repository)
    {
        $deleted = $repository->softDelete($user);
        if (!$deleted)
            return new \Exception("loi r cha");
        return redirect()->route('user');
    }

    public function getEquipments(User $user)
    {
        $equipments = $user->equipments;
        return EquipmentResource::collection($equipments);
    }
}