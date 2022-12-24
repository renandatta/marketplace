<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ManagementUserController extends Controller
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('auth');
        $this->middleware('management');
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $storeId = $request->has('store_id') ? $request->get('store_id') : '';
        Session::put('menu_active', 'user');
        return view('management.user.index', compact('storeId'));
    }

    public function search(Request $request)
    {
        $parameters = [];
        if ($request->input('name') != '')
            array_push($parameters, [
                'column' => 'name', 'value' => '%' . $request->input('name') . '%', 'operator' => 'like'
            ]);
        if ($request->input('store_id') != '') {
            $listUserId = $this->userRepository->list_store_owner_id($request->input('store_id'));
            array_push($parameters, [
                'column' => 'id', 'value' => $listUserId, 'custom' => 'in_array'
            ]);
        }
        $users = $this->userRepository->search($parameters, null, 10);
        return $request->has('ajax') ? $users : view('management.user._table', compact('users'));
    }

    public function info(Request $request)
    {
        $user = $request->has('id') ? $this->userRepository->find($request->get('id')) : [];
        return view('management.user.info', compact('user'));
    }

    public function save(Request $request)
    {
        if ($request->has('id')) {
            $user = $this->userRepository->update($request->input('id'), $request);
        } else {
            $user = $this->userRepository->save($request);
        }
        if ($request->has('ajax')) return $user;
        return redirect()->route('management.user')
            ->with('success', 'User Berhasil Disimpan');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $user = $this->userRepository->delete($request->input('id'));
        if ($request->has('ajax')) return $user;
        return redirect()->route('management.user')
            ->with('success', 'User Berhasil Dihapus');
    }
}
