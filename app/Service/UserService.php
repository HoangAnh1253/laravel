<?php

namespace App\Service;

use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;



class UserService
{
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUser(){
       return $this->userRepository->getAllUser();
    }

    public function getAllUserPaginate(int $paginate = 6){
        return $this->userRepository->getAllUserPaginate($paginate);
     }
    
    public function getUserWhere(string $field = '', $value = '')
    {
        return $this->userRepository->getUserWhere($field , $value);
    }

    public function getUserWherePaginate(string $field = '', $value = '', $paginate = 6){
        return $this->userRepository->getUserWherePaginate($field, $value, $paginate);
    }

    public function create(Request $request){
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
            'name' => ['string'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['string', 'min:6'],
            'gender' => ['boolean'],
            'bithdate' => ['date'],
            "phone_number" => ['min:8']
        ]);
        
        if ($validator->stopOnFirstFailure()->fails()) {
            return back()->withError($validator->errors()->first());
        }
        
        $payload['password'] = Hash::make($payload['password']);
        $this->userRepository->create($payload);
    }

    public function update(Request $request, User $user){
        $payload = $request->only([
            "name",
            "email",
            "gender",
            "birthdate",
            "password",
            "phone_number"
        ]);
        $validator = Validator::make($payload, [
            'name' => ['string'],
            'email' => ['email', Rule::unique('users')->ignore($user)],
            'gender' => ['boolean'],
            'bithdate' => ['date'],
            'password' => ['min:6'],
            "phone_number" => ['min:8']
        ]);
      
        
        if ($validator->stopOnFirstFailure()->fails()) {
            return response()->json([
                "error" =>  $validator->errors()->first()
            ]);
            return Response::json(["error" => $validator->errors()->first()]);
            // error_log($validator->errors()->first());
        }
        
        if(!isset($payload["password"]))
        {
            $payload["password"] = $user->password;
        }else
            $payload["password"] = Hash::make($payload["password"]);
        return new UserResource($this->userRepository->update($user, $payload));

    }

    public function disable(User $user){
        return $this->userRepository->softDelete($user);
    }

    public function destroy(User $user){
        return $this->userRepository->forceDelete($user);
    }
}