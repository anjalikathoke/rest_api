<?php
namespace App\Services\Customer;

use App\Http\Resources\Customer\CustomerResource;
use App\Repositories\Customer\CustomerRepository;
use App\Http\Requests\Customer\CustomerDtoRequest;
use App\Http\Resources\Customer\CustomerOrderResource;

class CustomerService
{
    /**
     * Constructor based dependency injection
     *
     * @param CustomerRepository $repository
     *
     * @return void
     */
    public function __construct(protected CustomerRepository $repository)
    {

    }


    /**
     * create function
     *
     * @param CustomerDtoRequest $data
     * @return array
     */
    public function create(CustomerDtoRequest $data){
        try{
            return new CustomerResource(
                $this->repository->add($data)
            );
        }catch(\Exception $e){
            throw $e;
        }
    }

    /**
     * update function
     *
     * @param CustomerDtoRequest $data
     * @param int $id
     * @return array
     */
    public function update(CustomerDtoRequest $data, int $id){

        try{
            return new CustomerResource(
                $this->repository->update($data,$id)
            );
        }catch(\Exception $e){
            throw $e;
        }
    }

    /**
     * Get the customer details
     *
     * @param int $id
     *
     * @return array
     */
    public function show(int $id)
    {
        try{
            return new CustomerResource(
                $this->repository->findById($id)
            );
        }catch(\Exception $e){
            throw $e;
        }
    }

    /**
     * Get the customer details
     *
     * @param int $id
     *
     * @return array
     */
    public function customer_order(int $id)
    {
        try{
            return new CustomerOrderResource(
                $this->repository->findById($id)
            );
        }catch(\Exception $e){
            throw $e;
        }
    }



    /**
     * delete by id
     *
     * @return array
     */
    public function delete(int $id)
    {
        try{
            return $this->repository->delete($id);
        }catch(\Exception $e){
            throw $e;
        }
    }

}
