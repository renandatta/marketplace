<?php

namespace App\Repositories;

use App\FeaturedProduct;
use App\FeaturedProductDetail;
use App\Product;
use App\ProductCategory;
use App\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductRepository extends BaseRepository {

    private $featuredProduct;
    private $featuredProductDetail;
    private $productCategory;
    private $product;
    private $productImage;
    public function __construct(FeaturedProduct $featuredProduct, FeaturedProductDetail $featuredProductDetail,
                                ProductCategory $productCategory, Product $product, ProductImage $productImage)
    {
        $this->featuredProduct = $featuredProduct;
        $this->featuredProductDetail = $featuredProductDetail;
        $this->productCategory = $productCategory;
        $this->product = $product;
        $this->productImage = $productImage;
    }

    public function getFeaturedProductByName($name)
    {
        return $this->featuredProduct->where('name', '=', $name)
            ->with('details')
            ->first();
    }

    public function getAllParentCategory()
    {
        $productCategory = $this->productCategory->where('parent_code', '=', '#');
        $productCategory = $this->setOrder($productCategory, array(['column' => 'code']));
        return $productCategory->get();
    }

    public function getCategoryBySlug($slug)
    {
        return $this->productCategory->where('slug', '=', $slug)->first();
    }

    public function getProduct($parameters, $orders, $paginate = false)
    {
        $product = $this->product;
        $product = $this->setParameter($product, $parameters);
        $product = $this->setOrder($product, $orders);
        return $paginate == true ? $product->paginate($paginate) : $product->get();
    }

    public function getLatestProduct()
    {
        return $this->product->orderBy('id', 'desc')->limit(5)->get();
    }

    public function getMaxPrice($parameters)
    {
        $product = $this->product;
        $product = $this->setParameter($product, $parameters);
        $product = $product->orderBy('price', 'desc');
        return $product->first()->price;
    }

    public function getProductBySlug($slug)
    {
        return $this->product->where('slug', '=', $slug)->first();
    }

    public function getProductStock($id)
    {
        $product = $this->product->find($id);
        if (empty($product)) return false;
        return $product->stock;
    }

    public function find($id, $column = 'id')
    {
        return $this->product->where($column, '=', $id)->first();
    }

    public function search($parameters = null, $orders = null, $paginate = false)
    {
        $products = $this->product;
        $products = $this->setParameter($products, $parameters);
        $products = $this->setOrder($products, $orders);
        return $paginate == false ? $products->get() : $products->paginate($paginate);
    }

    public function save(Request $request)
    {
        return $this->product->create($request->all());
    }

    public function update($id, Request $request)
    {
        $product = $this->product->find($id);
        $product->update($request->all());
        return $product;
    }

    public function delete($id)
    {
        $product = $this->product->find($id);
        $product->delete();
        return $product;
    }

    public function get_all_child_category()
    {
        return $this->productCategory->where('parent_code', '<>', '#')->get();
    }

    public function search_image($parameters = null, $orders = null, $paginate = false)
    {
        $productImages = $this->productImage;
        $productImages = $this->setParameter($productImages, $parameters);
        $productImages = $this->setOrder($productImages, $orders);
        return $paginate == false ? $productImages->get() : $productImages->paginate($paginate);
    }

    public function save_image(Request $request)
    {
        if ($request->hasFile('image')) {
            $productImage = $this->productImage->create(['product_id' => $request->input('product_id')]);
            $image = $request->file('image');
            $filename = Str::random(6).'_' . $productImage->id . '.'. $image->extension();
            $path = Storage::putFileAs('image', $image, $filename);
            $productImage->location = $path;
            $productImage->save();
            return $productImage;
        }
        return false;
    }

    public function delete_image($id)
    {
        $image = $this->productImage->find($id);
        $image->delete();
        return $image;
    }

    public function search_featured($parameters = null, $orders = null, $paginate = false)
    {
        $featureds = $this->featuredProduct;
        $featureds = $this->setParameter($featureds, $parameters);
        $featureds = $this->setOrder($featureds, $orders);
        return $paginate == false ? $featureds->get() : $featureds->paginate($paginate);
    }

    public function find_featured($value, $column = 'id')
    {
        return $this->featuredProduct->where($column, '=', $value)->first();
    }

    public function save_featured(Request $request)
    {
        return $this->featuredProduct->create($request->all());
    }

    public function update_featured($id, Request $request)
    {
        $featured = $this->featuredProduct->find($id);
        $featured->update($request->all());
        return $featured;
    }

    public function delete_featured($id)
    {
        $featured = $this->featuredProduct->find($id);
        $featured->delete();
        return $featured;
    }

    public function search_featured_detail($parameters = null, $orders = null, $paginate = false)
    {
        $featured_details = $this->featuredProductDetail
            ->select('featured_product_details.*')
            ->join('products', 'products.id', '=', 'featured_product_details.product_id');
        $featured_details = $this->setParameter($featured_details, $parameters);
        $featured_details = $this->setOrder($featured_details, $orders);
        return $paginate == false ? $featured_details->get() : $featured_details->paginate($paginate);
    }

    public function find_featured_detail($value, $column = 'id')
    {
        return $this->featuredProductDetail->where($column, '=', $value)->first();
    }

    public function save_featured_detail(Request $request)
    {
        return $this->featuredProductDetail->create($request->all());
    }

    public function update_featured_detail($id, Request $request)
    {
        $featured_detail = $this->featuredProductDetail->find($id);
        $featured_detail->update($request->all());
        return $featured_detail;
    }

    public function delete_featured_detail($id)
    {
        $featured_detail = $this->featuredProductDetail->find($id);
        $featured_detail->delete();
        return $featured_detail;
    }

}
