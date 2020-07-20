<?php

namespace App\Http\Controllers\Web;

use \App\Eloquent\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show()
    {
        return view('web.home');
    }

    public function mentorRegister(Request $request)
    {
        return view('web.users.mentor_register');
    }

    public function doMentorRegister(Request $request)
    {
        $data = $request->all();
        $data['name'] = $data['email'];
        $validator = Validator::make($data, $this->getValidations());

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'msg' => implode('<br>', $validator->errors()->all()),
            ], 400);
        }

        $data['password'] = Hash::make($data['password']);
        $data['role'] = User::ROLE_MENTOR;
        $data['avatar'] = User::DEFAULT_AVATAR_URL;
        $user = User::create($data);
        DB::table('user_role_pivot')
            ->insert([
                'user_id' => $user->id,
                'role_id' => User::ROLE_MENTOR,
            ]);

        //@todo send verification email

        return response()->json([
            'status' => 1,
        ], 200);
    }

    public function learnerRegister(Request $request)
    {
        return view('web.users.learner_register');
    }

    public function doLearnerRegister(Request $request)
    {
        $data = $request->all();
        $data['name'] = $data['email'];
        $validator = Validator::make($data, $this->getValidations());

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'msg' => implode('<br>', $validator->errors()->all()),
            ], 400);
        }

        $data['password'] = Hash::make($data['password']);
        $data['role'] = User::ROLE_LEARNER;
        $data['avatar'] = User::DEFAULT_AVATAR_URL;
        $user = User::create($data);
        DB::table('user_role_pivot')
            ->insert([
                'user_id' => $user->id,
                'role_id' => User::ROLE_LEARNER,
            ]);

        //@todo send verification email

        return response()->json([
            'status' => 1,
        ], 200);
    }

    private function getValidations()
    {
        return [
            'fullname' => 'required|max:100',
            'phone_number' => 'required|unique:users,phone_number|min:9|max:15',
            'avatar' => 'sometimes|image|max:' . User::AVATAR_FILE_SIZE_LIMITATION,
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|unique:users,name',
            'password' => 'required|string|min:' . User::MIN_PASSWORD_LENGTH . '|max:' . User::MAX_PASSWORD_LENGTH,
        ];
    }
}
