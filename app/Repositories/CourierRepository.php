<?php

namespace App\Repositories;

use App\Courier;
use App\CourierService;
use Illuminate\Http\Request;

class CourierRepository extends BaseRepository
{

    private $courier;
    private $courierService;
    public function __construct(Courier $courier, CourierService $courierService)
    {
        $this->courier = $courier;
        $this->courierService = $courierService;
    }

    public function get_province_all()
    {
        return json_decode(raja_ongkir_location());
    }

    public function get_city_by_province($provinceId)
    {
        $locations = json_decode(raja_ongkir_location());
        foreach ($locations as $location) {
            if ($location->province_id == $provinceId) return $location->cities;
        }
        return null;
    }

    public function get_city($city_name)
    {
        $locations = json_decode(raja_ongkir_location());
        foreach ($locations as $location) {
            foreach ($location->cities as $city) {
                if ($city->city_name == $city_name) return $city;
            }
        }
        return null;
    }

    public function shipping_cost($origin, $destination, $weight, $courier = 'pos')
    {
        $result = $this->curl_post(
            "https://api.rajaongkir.com/basic/cost",
            "origin=". $origin ."&destination=". $destination ."&weight=". $weight ."&courier=" . $courier
        );
        $couriers = $result['rajaongkir']['results'][0];
        $courier = $this->courier->firstOrCreate(['name' => $couriers['name']]);
        foreach ($couriers['costs'] as $cost) {
            $this->courierService->firstOrCreate([
                'courier_id' => $courier->id,
                'name' => $cost['service'],
                'price' => 0
            ]);
        }

        return $result['rajaongkir']['results'];
    }

    public function find($value, $column = 'id')
    {
        return $this->courier->where($column, '=', $value)->first();
    }

    public function search($parameters = null, $orders = null, $paginate = false)
    {
        $couriers = $this->courier;
        $couriers = $this->setParameter($couriers, $parameters);
        $couriers = $this->setOrder($couriers, $orders);
        return $paginate == false ? $couriers->get() : $couriers->paginate($paginate);
    }

    public function save(Request $request)
    {
        return $this->courier->create($request->all());
    }

    public function update($id, Request $request)
    {
        $courier = $this->courier->find($id);
        $courier->update($request->all());
        return $courier;
    }

    public function delete($id)
    {
        return $this->courier->find($id)->delete();
    }

    public function find_service($value, $column = 'id')
    {
        return $this->courierService->where($column, '=', $value)->first();
    }

    public function search_service($parameters = null, $orders = null, $paginate = false)
    {
        $courierServices = $this->courierService;
        $courierServices = $this->setParameter($courierServices, $parameters);
        $courierServices = $this->setOrder($courierServices, $orders);
        return $paginate == false ? $courierServices->get() : $courierServices->paginate($paginate);
    }

    public function save_service(Request $request)
    {
        return $this->courierService->create($request->all());
    }

    public function update_service($id, Request $request)
    {
        $courierService = $this->courierService->find($id);
        $courierService->update($request->all());
        return $courierService;
    }

    public function delete_service($id)
    {
        return $this->courierService->find($id)->delete();
    }

}
