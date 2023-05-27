<?php

namespace App\Repositories\Auth;

use Exception;
use App\Models\User;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\Auth\AuthUpdateDtoRequest;
use App\Http\Requests\Auth\AuthRegisterDtoRequest;
use App\Repositories\Auth\Interface\AuthRepositoryInterface;


class AuthRepository implements AuthRepositoryInterface
{

    /**
     * Add a single record in the table
     *
     * @param AuthRegisterDtoRequest $data
     *
     * @return Array
     */
    public function add(AuthRegisterDtoRequest $data){

       // dd($data->toArray());
          try{
              return User::create($data->toArray());
          }catch(Exception $e){
              throw $e;
          }
      }

    /**
     * Update a Customer
     * @param AuthUpdateDtoRequest $data
     *
     * @param int $id
     *
     * @return Array
     */
    public function update(AuthUpdateDtoRequest $data)
    {
        if (empty($data)) {
            throw new Exception;
        }

        $user = JWTAuth::user();
        if (empty($user)) {
            throw new Exception;
        }

        try{
            $user->update($data->toArray());
            return $user;
        }catch(Exception $e){
            throw $e;
        }
    }

     /**
     * change Password
     *
     * @param Array $data
     *
     * @return Array
     */
    public function changePassword(Array $data)
    {
        if (empty($data)) {
            throw new Exception;
        }

        $user = JWTAuth::user();
        if (empty($user)) {
            throw new Exception;
        }

        try{
            return $user->update($data);
        }catch(Exception $e){
            throw $e;
        }
    }

}
