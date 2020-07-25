<?php

namespace App\Http\Requests\Ethics;

use Illuminate\Foundation\Http\FormRequest;

use Carbon\Carbon;
use App\Rules\BoolRule;
use Illuminate\Validation\Rule;


class PartnerForm extends FormRequest
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
            'name'=>'required|max:200|string',
            'address'=>'required|string',
            'cop_num'=>'required|string|max:50',
            'cop_juri'=>'required|string|max:50',
            'doi'=>'required|date|before:'.Carbon::today(),
            'stock'=>['required',new BoolRule],
            'stock_name'=>'required_if:stock,==,1|max:2000',
            'stock_detail'=>'required_if:stock,==,1|max:3000',
            'director'=>'required',
            'subsidiary'=>'required',
            'employee'=>'required|numeric',
            'revenue'=>['required',new BoolRule],
            'insolvency'=>['required',new BoolRule],

            'policy'=>['required',new BoolRule],
            'p1'=>'required_if:policy,==,1|numeric',
            'p2'=>'required_if:policy,==,1|numeric',
            'p3'=>'required_if:policy,==,1|numeric',
            'p4'=>'required_if:policy,==,1|numeric',
            'p5'=>'required_if:policy,==,1|numeric',

            'q1'=>['required',new BoolRule],
            'q2'=>['required',new BoolRule],
            'q3'=>['required',new BoolRule],
            'q4'=>['required',new BoolRule],
            'q5'=>['required',new BoolRule],

            'person'=>['required',new BoolRule],
            'person_detail'=>'required_if:person,==,1',
            't'=>['required',new BoolRule],
            'p_name'=>'required|string',
            'p_des'=>'required|string',

            'policy_file'=>'sometimes|mimes:pdf|size:20000',
            'certi_file'=>'sometimes|mimes:pdf|size:20000'
        ];
    }

    public function attributes(){
        return [
            'doi'=>'Date of Incorporation',
        ];
    }
}
