<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Storage;

class BaseRepository {

    public function setOrder($model, $orders)
    {
        if ($orders != null) {
            foreach($orders as $order) {
                $model = $model->orderBy($order['column'], !empty($order['direction']) ? $order['direction'] : 'asc');
            }
        }
        return $model;
    }

    public function setParameter($model, $parameters)
    {
        if ($parameters != null) {
            foreach ($parameters as $parameter) {
                $operator = !empty($parameter['operator']) ? $parameter['operator'] : '=';
                $custom = !empty($parameter['custom']) ? $parameter['custom'] : '';

                if ($custom == '') $model = $model->where($parameter['column'], $operator, $parameter['value']);
                if ($custom == 'in_array') $model = $model->whereIn($parameter['column'], $parameter['value']);
                if ($custom == 'null') $model = $model->whereNull($parameter['column']);
                if ($custom == 'not_null') $model = $model->whereNotNull($parameter['column']);
            }
        }
        return $model;
    }

    public function upload_image($model, $image, $filename)
    {
        $path = Storage::putFileAs('image', $image, $filename);
        $model->image = $path;
        $model->save();
    }

    public function curl_get($url)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 907275621835dc1a6b180fa0379a5665"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return false;
        } else {
            return json_decode($response, true);
        }
    }

    public function curl_post($url, $fields)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: 907275621835dc1a6b180fa0379a5665"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return false;
        } else {
            return json_decode($response, true);
        }
    }

}
