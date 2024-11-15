<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\User\IndexRequest;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(IndexRequest $request)
    {
        $data = $request->validated();
        $users = User::paginate($data['per_page'] ?? 10)->withQueryString();

        return view('user.index', compact('users'));
    }
}
