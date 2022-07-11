<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class GetChartDateRangeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        //If invalid data parameters are supplied, get data from the past month

        if(Carbon::parse($this->fromDate) > Carbon::parse($this->toDate)){
            $this->merge(['fromDate' => null, 'toDate' => null]);
        }

        if($this->fromDate == null){
            $this->merge(['fromDate' => Carbon::now()->subMonth()]);
        }else{
            $this->merge(['fromDate' => Carbon::parse($this->fromDate)]);
        }

        if($this->toDate == null){
            $this->merge(['toDate' => Carbon::now()]);
        }else{
            $this->merge(['toDate' => Carbon::parse($this->toDate)]);
        }
    }

    public function rules()
    {
        return [
            'fromDate' => ['nullable', 'date', 'before:tomorrow'],
            'toDate' => ['nullable', 'date', 'before:tomorrow']
        ];
    }
}
