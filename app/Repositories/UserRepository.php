<?php

namespace App\Repositories;

use App\Store;
use App\StoreOwner;
use App\User;
use App\UserAddress;
use App\UserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserRepository extends BaseRepository {

    private $user;
    private $userAuth;
    private $userAddress;
    private $storeOwner;
    private $store;
    public function __construct(User $user, UserAuth $userAuth, UserAddress $userAddress, StoreOwner $storeOwner, Store $store)
    {
        $this->user = $user;
        $this->userAuth = $userAuth;
        $this->userAddress = $userAddress;
        $this->storeOwner = $storeOwner;
        $this->store = $store;
    }

    public function login($email, $password, $remember)
    {
        $user = $this->user->where('email', '=', $email)->first();
        if (!empty($user)) {
            if (Hash::check($password, $user->password)) {
                $this->saveUserAuth($user);
                Auth::login($user, $remember);
                return $user;
            }
        }
        return false;
    }

    public function register($name, $email, $password)
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'email_verified_at' => date('Y-m-d H:i:s'),
            'user_level' => 'User'
        ]);
        $this->saveUserAuth($user);
        Auth::login($user);
        return $user;
    }

    public function saveUserAuth($user)
    {
        UserAuth::create([
            'user_id' => $user->id,
            'auth' => 'login',
            'token' => Str::random(),
            'device' => 'web',
        ]);
    }

    public function logout($token)
    {
        UserAuth::where('token', '=', $token)
            ->update(['auth' => 'logout']);
        Auth::logout();
    }

    public function updateProfile($id, $email, $name, $photo)
    {
        $user = $this->user->find($id);
        $user->update([
            'email' => $email,
            'name' => $name
        ]);

        if ($photo != null) {
            $filename = 'user_photo_' . $user->id . '.' . $photo->extension();
            $path = Storage::putFileAs('photo', $photo, $filename);
            $user->photo = $path;
            $user->save();
        }

        return $user;
    }

    public function updatePassword($id, $password)
    {
        return $this->user->find($id)->update([
            'password' => Hash::make($password)
        ]);
    }

    public function findAddress($id)
    {
        $address = $this->userAddress->find($id);
        if (empty($address)) return false;
        if ($address->user_id != Auth::user()->id) return false;
        return $address;
    }

    public function saveAddress(Request $request)
    {
        if ($request->input('id') == '') {
            $address = $this->userAddress->create($request->all());
            if (count(Auth::user()->addresses) == 1) {
                $address->is_default = 1;
                $address->save();
            }
        } else {
            $address = $this->userAddress->find($request->input('id'));
            if (empty($address)) return false;
            if ($address->user_id != Auth::user()->id) return false;
            $address->update($request->all());
        }
        return $address;
    }

    public function getUserAddress($user_id)
    {
        return $this->userAddress->where('user_id', '=', $user_id)->get();
    }

    public function deleteAddreess($id)
    {
        return $this->userAddress->find($id)->delete();
    }

    public function defaultAddress($id)
    {
        $address = $this->userAddress->find($id);
        $address->is_default = 1;
        $address->save();
        return $address;
    }

    public function search($parameters = null, $orders = null, $paginate = false)
    {
        $users = $this->user;
        $users = $this->setParameter($users, $parameters);
        $users = $this->setOrder($users, $orders);
        return $paginate == false ? $users->get() : $users->paginate($paginate);
    }

    public function find($value, $column = 'id')
    {
        return $this->user->where($column, '=', $value)->first();
    }

    public function save(Request $request)
    {
        $request->merge(['password' => Hash::make($request->input('password'))]);
        $user = $this->user->create($request->all());
        return $user;
    }

    public function update($id, Request $request)
    {
        $user = $this->user->find($id);
        if ($request->input('password') != '') {
            $request->merge(['password' => Hash::make($request->input('password'))]);
            $user->update($request->all());
        } else {
            $user->update($request->except('password'));
        }
        return $user;
    }

    public function delete($id)
    {
        $user = $this->user->find($id);
        $user->delete();
        return $user;
    }

    public function list_store_owner_id($storeId)
    {
        $data = $this->storeOwner->select('user_id')->where('store_id', '=', $storeId)->get();
        $result = [];
        foreach ($data as $item) {
            array_push($result, $item->user_id);
        }
        return $result;
    }

    public function user_store()
    {
        return $this->store->find(Auth::user()->store_owner[0]->store_id);
    }

}
