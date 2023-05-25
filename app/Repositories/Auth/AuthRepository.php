<?php

namespace App\Repositories\Auth;

use Exception;
use App\Models\User;
use App\Http\Requests\Auth\AuthDtoRequest;
use App\Repositories\Customer\Interface\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{

    /**
     * Add a single record in the table
     *
     * @param AuthDtoRequest $data
     *
     * @return Array
     */
    public function add(AuthDtoRequest $data){

       // dd($data->toArray());
          try{
              return User::create($data->toArray());
          }catch(Exception $e){
              throw $e;
          }
      }

    /**
     * Update a Customer
     * @param AuthDtoRequest $data
     *
     * @param int $id
     *
     * @return Array
     */
    public function update(AuthDtoRequest $data, int $id)
    {
        if (empty($data) || empty($id)) {
            throw new Exception;
        }

        $customer = User::find($id);

        $customer->update($data->toArray());

        return $customer;
    }

}
