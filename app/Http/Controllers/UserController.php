<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserRepositoryInterface;

class UserController extends Controller
{
    protected $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('auth');
    }
    public function index(){
        $users = $this->userRepository->getAllUser();
        return view('users.index', compact('users'));
    }
    public function show($id){
        $user = $this->userRepository->getUserById($id);
        return view('users.show', compact('user'));
    }
}
