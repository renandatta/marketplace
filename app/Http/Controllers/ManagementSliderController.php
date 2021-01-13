<?php

namespace App\Http\Controllers;

use App\Repositories\CourierRepository;
use App\Repositories\SliderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ManagementSliderController extends Controller
{
    private $sliderRepository;
    public function __construct(SliderRepository $sliderRepository)
    {
        $this->middleware('auth');
        $this->middleware('management');
        $this->sliderRepository = $sliderRepository;
    }

    public function index()
    {
        Session::put('menu_active', 'slider');
        return view('management.slider.index');
    }

    public function search(Request $request)
    {
        $parameters = [];
        if ($request->input('name') != '')
            array_push($parameters, [
                'column' => 'name', 'value' => '%' . $request->input('name') . '%', 'operator' => 'like'
            ]);
        $sliders = $this->sliderRepository->search($parameters, null, 10);
        return $request->has('ajax') ? $sliders : view('management.slider._table', compact('sliders'));
    }

    public function info(Request $request)
    {
        $slider = $request->has('id') ? $this->sliderRepository->find($request->get('id')) : [];
        return view('management.slider.info', compact('slider'));
    }

    public function save(Request $request)
    {
        if ($request->has('id')) {
            $slider = $this->sliderRepository->update($request->input('id'), $request);
        } else {
            $slider = $this->sliderRepository->save($request);
        }
        return redirect()->route('management.slider')
            ->with('success', 'Slider Berhasil Disimpan');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $this->sliderRepository->delete($request->input('id'));
        return redirect()->route('management.slider')
            ->with('success', 'Slider Berhasil Dihapus');
    }
}
