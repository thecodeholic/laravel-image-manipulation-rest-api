<?php
/**
 * User: Zura
 * Date: 11/19/2021
 * Time: 10:04 AM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * Class RegisterRequest
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package App\Http\Requests
 */
class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|exists:App\Models\User,email',
            'password' => 'required'
        ];
    }
}
