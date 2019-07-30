<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Response;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * @var UserServcice
     */
    protected $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Illuminate\View
     */
    public function create()
    {
        $user = new User();

        return view('admin.users.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return Response
     */
    public function store(UserRequest $request)
    {
        $result = $this->userService->createUser($request);

        if ($result) {
            return redirect()
                ->action('Admin\UserController@create')
                ->with('message_class', 'success')
                ->with('message', trans_choice('user.message.object_inserted_success', 0));
        }

        return redirect()
            ->action('Admin\UserController@create')
            ->with('message_class', 'danger')
            ->with('message', trans_choice('user.message.object_inserted_fail', 0));
    }
}
