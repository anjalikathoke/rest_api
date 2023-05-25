<?php

namespace App\Repositories\Customer;

use Exception;
use App\Models\Customer;
use App\Http\Requests\Customer\CustomerDtoRequest;
use App\Repositories\Customer\Interface\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{


    /**
     * Find record by ID
     * @param int $id Find the record by ID
     */
    public function findById(int $id){
        try{
            return Customer::find($id);
            //return Customer::find($id)->orders->order_details;
        }catch(Exception $e){
            throw $e;
        }
    }

    /**
     * Add a single record in the table
     *
     * @param CustomerDtoRequest $data
     *
     * @return Array
     */
    public function add(CustomerDtoRequest $data){

       // dd($data->toArray());
          try{
              return Customer::create($data->toArray());
          }catch(Exception $e){
              throw $e;
          }
      }

    /**
     * Update a Customer
     * @param CustomerDtoRequest $data
     *
     * @param int $id
     *
     * @return Array
     */
    public function update(CustomerDtoRequest $data, int $id)
    {
        if (empty($data) || empty($id)) {
            throw new Exception;
        }

        $customer = $this->findById($id);

        $customer->update($data->toArray());

        return $customer;
    }

    /**
     * Soft delete a Customer
     * @param int $id delete record by ID
     */
    public function delete(int $id)
    {
        $customer = $this->findById($id);

        if ($customer->delete() === false) {
            throw new Exception;
        }

        $customer->delete();

       return true;
    }
}
