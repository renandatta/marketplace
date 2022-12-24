<?php

namespace App\Repositories;

use App\Store;
use App\StoreLevel;
use Illuminate\Http\Request;

class StoreRepository extends BaseRepository {

    private $store;
    private $storeLevel;
    public function __construct(Store $store, StoreLevel $storeLevel)
    {
        $this->store = $store;
        $this->storeLevel = $storeLevel;
    }

    public function get_store($parameters = null, $orders = null, $paginate = null)
    {
        $stores = $this->store;
        $stores = $this->setParameter($stores, $parameters);
        $stores = $this->setOrder($stores, $orders);
        return $paginate == null ? $stores->get() : $stores->paginate($paginate);
    }

    public function find($id, $column = 'id')
    {
        return $this->store->where($column, '=', $id)->first();
    }

    public function search($parameters = null, $orders = null, $paginate = false)
    {
        $stores = $this->store;
        $stores = $this->setParameter($stores, $parameters);
        $stores = $this->setOrder($stores, $orders);
        return $paginate == false ? $stores->get() : $stores->paginate($paginate);
    }

    public function save(Request $request)
    {
        $store =  $this->store->create($request->all());
        return $store;
    }

    public function update($id, Request $request)
    {
        $store = $this->store->find($id);
        $store->update($request->all());
        return $store;
    }

    public function delete($id)
    {
        return $this->store->find($id)->delete();
    }

    public function getAllLevel()
    {
        return $this->storeLevel->all();
    }

}
