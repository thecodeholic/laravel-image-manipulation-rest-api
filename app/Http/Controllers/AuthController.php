<?php
/**
 * User: Zura
 * Date: 11/19/2021
 * Time: 10:03 AM
 */

namespace App\Http\Controllers;


use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use http\Env\Request;
use http\Env\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

/**
 * Class AuthController
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->all();

        /** @var User $user */
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $token = $user->createToken('main');

        return response([
            'user' => $user,
            'token' => $token->plainTextToken
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->all();

        $email = $data['email'];
        $password = $data['password'];

        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return abort(401, 'Unauthorized!');
        }


        $token = $user->createToken('main');

        return response([
            'user' => $user,
            'token' => $token->plainTextToken
        ]);

    }

}
