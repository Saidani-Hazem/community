<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{



    public function index(){
        return response()->json(['users' => user::all()]);
    }


    
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'birthdate' =>'required|string',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'pic' => 'image|mimes:jpg|max:3072',
            ]);

            $picId = Str::uuid()->toString();
            $imageExt = $request->file('pic')->getClientOriginalExtension();
            $picname = $picId . '.' . $imageExt;
            $path = public_path('usersPic');

            $request->file('pic')->move($path, $picname);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->pic = $picId;
            $user->birthdate = $request->birthdate;
            $user->save();

            return response()->json(['msj' => 'User created']);
        } catch (Exception $e) {
            return response()->json(['err' => $e->getMessage()]);
        }
    }

    public function show(user $user)
    {
        $user = user::find($user);

        if ($user) {
            return response()->json(['user' => $user]);
        } else {
            return response()->json(['err' => 'user not found']);
        }
    }


    public function update(Request $request, user $user)
    {
        try {

            $request->validate([
                'name' => 'required|string|max:255',
                'birthdate' =>'required|string',
                'phone' =>'string',
                'password' => 'nullable|string|min:8',
                'pic' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
            ]);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->birthdate = $request->birthdate;
            $user->phone = $request->phone;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            if ($request->hasFile('pic')) {
                $oldPicPath = public_path('usersPic/' . $user->pic . '.' . pathinfo($user->pic, PATHINFO_EXTENSION));
                if (File::exists($oldPicPath)) {
                    File::delete($oldPicPath);
                }
                $picId = Str::uuid()->toString();
                $newFilePath = $request->file('pic')->storeAs('usersPic', $picId . '.' . $request->file('pic')->getClientOriginalExtension());
                $user->pic = $picId;
            }
            $user->save();
            return response()->json(['msg' => 'User updated']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }


    public function destroy(User $user)
    {
        if ($user) {
            $picPath = public_path('usersPic/' . $user->pic . '.png' . pathinfo($user->pic, PATHINFO_EXTENSION));
            if (File::exists($picPath)) {
                File::delete($picPath);
            }
            $user->delete();
            return response()->json(['msg' => 'User and picture deleted']);
        } else {
            return response()->json(['msg' => 'User not found']);
        }
    }
}
