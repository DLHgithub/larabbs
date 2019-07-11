<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler as Uploader;
use App\Http\Requests\users\UserEditPasswordRequest;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth', ['except' => ['show']]);
    // }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }
    public function update(UserRequest $request,  User $user)
    {
        $this->authorize('update', $user);
        $data = $request->all();

        if ($request->avatar) {
            $result = (new Uploader())->saveUserAvatar($request->avatar, $user->id);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }
        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }

    /**
     * 修改密码
     */
    public function editPassword(User $user)
    {
        $this->authorize('update', $user);
        return view('users.editPassword', compact('user'));
    }

    /**
     * 修改密码
     */
    public function updatePassword(UserEditPasswordRequest $request, User $user)
    {
        $this->authorize('update', $user);
        if (!$user->checkPassword($request->password_old)) {
            session()->flash('danger', '您输入的旧密码错误');
            return redirect()->back()->withInput();
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        session()->flash('success', '密码更新成功！');
        return redirect()->route('users.show', [$user]);
    }
}
