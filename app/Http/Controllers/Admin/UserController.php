<?php

namespace App\Http\Controllers\Admin;

use App\Enums\User\Roles;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Throwable;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    /**
     * @throws Throwable
     */
    public function index(Request $request, Company $company)
    {
        $agents = User::query()->where(['company_id' => $company->id])->get();
        return view('admin.users.index')->with(['agents' => $agents, 'company' => $company]);
    }


    /**
     * @throws Throwable
     */
    public function store(Request $request, Company $company)
    {

        try {
            $this->userService->store(
                $request->input('full_name')
                , $request->input('login')
                , $request->input('password')
                , Roles::Agent
                , $company
            );

            return redirect()->to(route('agents.index', ['company' => $company->id]));

        } catch (Throwable $exception) {

        }

        return redirect()->back();
    }

    public function update(Request $request, Company $company, User $user)
    {

        try {
            $this->userService->update(
                user: $user,
                name: $request->input('full_name')
                , password: $request->input('password')
            );

            return redirect()->to(route('agents.index', ['company' => $company->id]));

        } catch (Throwable $exception) {

        }

        return redirect()->back();
    }

    /**
     * @throws Throwable
     */
    public function createForm(Request $request, Company $company)
    {
        return view('admin.users.create')->with(['company' => $company]);
    }

    /**
     * @throws Throwable
     */
    public function updateForm(Request $request, Company $company, User $user)
    {
        return view('admin.users.update')->with(['company' => $company, 'agent' => $user]);
    }


    /**
     * @throws Throwable
     */
    public function delete(User $user)
    {
        try {
            $this->userService->delete($user);
        } catch (Throwable $exception) {
        }

        return redirect()->back();
    }


}
