<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormValidation extends FormRequest
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
            'avregingTime'=>'required|max:20',
            'risingWindTreshold'=>'required|max:20',
            'obj.operaterUP'            => 'nullable|in:OPERATER_UP',
            'obj.operaterDown'          => 'nullable|in:OPERATER_DOWN',
            'obj.ledOn'                 => 'nullable|in:LED_ON',
            'obj.ledOff'                => 'nullable|in:LED_OFF',
            'data.avregingTime'         => 'nullable|numeric',
            'data.risingWindTimeDelay'  => 'nullable|date_format:"H:i:s"',
            'data.fallingWindTimeDelay' => 'nullable|date_format:"H:i:s"',
            'data.ledDelay'             => 'nullable|date_format:"H:i:s"',
            'data.risingInterval'       => 'nullable|date_format:"H:i:s"',
            'data.loweringInterval'     => 'nullable|date_format:"H:i:s"',
            'data.risingWindTreshold'   => 'nullable|numeric',
            'data.fallingWindTreshold'  => 'nullable|numeric',
        ];
    }
    public function messages()
    {
        return [
            'avregingTime.required' =>'Potrebno je popuniti polje Avreging time',
            'avregingTime.max' =>'Polje Avreging time ne sme imati više od 20 karaktera',
            'risingWindTreshold.required' =>'Potrebno je popuniti polje Rising wind treshold',
            'risingWindTreshold.max' =>'Polje Rising wind treshold ne sme imati više od 20 karaktera',
        ];
    }
}
