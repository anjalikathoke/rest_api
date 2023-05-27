<?php

namespace App\Repositories\Auth\Interface;


use App\Http\Requests\Auth\AuthUpdateDtoRequest;
use App\Http\Requests\Auth\AuthRegisterDtoRequest;

interface AuthRepositoryInterface
{
    public function add(AuthRegisterDtoRequest $data);

    public function update(AuthUpdateDtoRequest $data);

    public function changePassword(Array $data);

}
