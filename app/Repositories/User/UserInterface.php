<?php


namespace App\Repositories\User;


interface UserInterface
{
    public function getUsers($request);
    public function destroy($id);
    public function checkEmail($request);
    public function store($request);
    public function getById($id);
    public function update($request, $id);
    public function updateLastLogin($id);
    public function register($request);
    public function getByEmail($request);
    public function generalResetPass($request, $userType);
    public function getUserByToken($token);
    public function updatePasswordByToken($request, $token);
    public function checkActiveUserToken($token);
    public function updateProfile($request);
    public function getUserSendMail($conditions);
}
