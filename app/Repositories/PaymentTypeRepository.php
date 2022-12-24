<?php

namespace App\Repositories;

use App\PaymentType;
use Illuminate\Http\Request;

class PaymentTypeRepository extends BaseRepository
{
    private $paymentType;
    public function __construct(PaymentType $paymentType)
    {
        $this->paymentType = $paymentType;
    }

    public function search($parameters = null, $orders = null, $paginate = false)
    {
        $paymentTypes = $this->paymentType;
        $paymentTypes = $this->setParameter($paymentTypes, $parameters);
        $paymentTypes = $this->setOrder($paymentTypes, $orders);
        return $paginate == false ? $paymentTypes->get() : $paymentTypes->paginate($paginate);
    }

    public function find($value, $column = 'id')
    {
        return $this->paymentType->where($column, '=', $value)->first();
    }

    public function save(Request $request)
    {
        return $this->paymentType->create($request->all());
    }

    public function update($id, Request $request)
    {
        $paymentType = $this->paymentType->find($id);
        $paymentType->update($request->all());
        return $paymentType;
    }

    public function delete($id)
    {
        $paymentType = $this->paymentType->find($id);
        $paymentType->delete();
        return $paymentType;
    }
}
