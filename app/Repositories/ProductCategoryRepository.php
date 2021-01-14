<?php

namespace App\Repositories;

use App\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductCategoryRepository extends BaseRepository {

    private $productCategory;
    public function __construct(ProductCategory $productCategory)
    {
        $this->productCategory = $productCategory;
    }

    public function getAll()
    {
        $productCategory = $this->productCategory;
        $productCategory = $this->setOrder($productCategory, array(['column' => 'id', 'direction' => 'desc']));
        return $productCategory->get();
    }

    public function find($id, $column = 'id')
    {
        return $this->productCategory->where($column, '=', $id)->first();
    }

    public function search($parameters = null, $orders = null, $paginate = false)
    {
        $productCategorys = $this->productCategory;
        $productCategorys = $this->setParameter($productCategorys, $parameters);
        $productCategorys = $this->setOrder($productCategorys, $orders);
        return $paginate == false ? $productCategorys->get() : $productCategorys->paginate($paginate);
    }

    public function save(Request $request)
    {
        $productCategory = $this->productCategory->create($request->all());
        return $productCategory;
    }

    public function update($id, Request $request)
    {
        $productCategory = $this->productCategory->find($id);
        $productCategory->update($request->all());
        return $productCategory;
    }

    public function delete($id)
    {
        return $this->productCategory->find($id)->delete();
    }

}
