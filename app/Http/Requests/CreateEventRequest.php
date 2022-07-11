<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'activityName' => 'required|max:30',
            'description' => 'required|max:150',
            'people' => 'required|gt:1|lte:100',
            'tag' => 'required',
            'startDate' => 'required|date|after:now',
            'startTime' => 'required',
            'lng' => 'required|max:45',
            'lat' => 'required|max:45',
            'houseNumber' => 'required|max:10',
            'postalCode' => 'required|max:45',
            'location' => 'required',
            'route'=> 'required',
            'locality' => 'required',
            'picture' => 'required',
            'initiator' => 'nullable|boolean'
        ];
    }
}
