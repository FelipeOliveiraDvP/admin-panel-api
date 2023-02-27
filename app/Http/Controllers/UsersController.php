<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ListUsersRequest;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * @lrd:start
     * **search:** search an user by name or email.
     * **direction:** asc, desc
     * @lrd:end
     */
    public function index(ListUsersRequest $request)
    {
        $query = User::with('role:id,name')->where('role_id', '<>', 1);

        if ($request->input('role_id')) {
            $query->where('role_id', '=', $request->input('role_id'));
        }

        if ($request->input('search')) {
            $query
                ->where('name', 'like', '%' . $request->input('search') . '%')
                ->orwhere('email', 'like', '%' . $request->input('search') . '%');
        }

        $order_by = $request->input('order_by') ?? 'name';
        $direction = $request->input('direction') ?? 'asc';
        $query->orderBy($order_by, $direction);

        return response($query->paginate(10));
    }
}
