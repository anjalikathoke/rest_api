<?php

namespace App\Repositories\Auth\Interface;


use App\Http\Requests\Auth\AuthRegisterDtoRequest;

interface AuthRepositoryInterface
{
    public function add(AuthRegisterDtoRequest $data);

    public function update(AuthRegisterDtoRequest $data);

    public function changePassword(Array $data);

}
