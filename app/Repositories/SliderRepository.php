<?php

namespace App\Repositories;

use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SliderRepository extends BaseRepository {

    private $slider;
    public function __construct(Slider $slider)
    {
        $this->slider = $slider;
    }

    public function getAll()
    {
        $slider = $this->slider;
        $slider = $this->setOrder($slider, array(['column' => 'id', 'direction' => 'desc']));
        return $slider->get();
    }

    public function find($id, $column = 'id')
    {
        return $this->slider->where($column, '=', $id)->first();
    }

    public function search($parameters = null, $orders = null, $paginate = false)
    {
        $sliders = $this->slider;
        $sliders = $this->setParameter($sliders, $parameters);
        $sliders = $this->setOrder($sliders, $orders);
        return $paginate == false ? $sliders->get() : $sliders->paginate($paginate);
    }

    public function save(Request $request)
    {
        $slider = $this->slider->create($request->all());
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $this->upload_image($slider, $image, Str::random(6).'_' . $slider->id . '.'. $image->extension());
        }
        return $slider;
    }

    public function update($id, Request $request)
    {
        $slider = $this->slider->find($id);
        $slider->update($request->all());
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $this->upload_image($slider, $image, Str::random(6).'_' . $slider->id . '.'. $image->extension());
        }
        return $slider;
    }

    public function delete($id)
    {
        return $this->slider->find($id)->delete();
    }

}
