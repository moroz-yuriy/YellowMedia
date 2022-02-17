<?php

namespace App\Http\Controllers\API\v0;


use App\Company;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserController extends \App\Http\Controllers\Controller
{
    /**
     * @throws ValidationException
     */
    public function register(Request $request): JsonResponse
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $data = $request->only([
            'first_name',
            'last_name',
            'phone',
            'email',
            'password'
        ]);

        $user = User::create($data);

        return response()->json($user);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function signIn(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!$user = User::where('email', $request->input('email'))->first()) {
            return response()->json([], 404);
        }

        if (Hash::check($request->input('password'), $user->password)) {
            $user->api_token = Base64_encode(Str::random(40));
            $user->save();

            return response()->json(['api_token' => $user->api_token]);
        } else {
            return response()->json([], 401);
        }
    }

    public function recoverPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        $user->recovery_token = Base64_encode(Str::random(40));
        $user->save();

        /**
         * TODO: send email with recovery_token
         */
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getCompanies(Request $request): JsonResponse
    {
        return response()->json([Auth::user()->companies]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function storeCompanies(Request $request): JsonResponse
    {
        $this->validate($request, [
            'title' => 'required',
            'phone' => 'required',
            'description' => 'required'
        ]);

        /** @var Company $company */
        $company = Auth::user()->companies()->updateOrCreate($request->only(['title', 'phone', 'description']));

        return response()->json($company, 201);
    }
}
