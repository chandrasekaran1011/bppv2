<?php

namespace App\Http\Requests\Ethics;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use App\Rules\BoolRule;
use Illuminate\Validation\Rule;


class IndividualFormRequest extends FormRequest
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
            'license'=>'required',
            'revenue'=>['required',new BoolRule],
            'tp'=>'required',

            'q1'=>['required',new BoolRule],
            'q2'=>['required',new BoolRule],
            'q3'=>['required',new BoolRule],
            'q4'=>['required',new BoolRule],
            'q5'=>['required',new BoolRule],

            'person'=>['required',new BoolRule],
            'person_detail'=>'required_if:person,==,1',
            'q_detail'=>'required',
            'r_detail'=>'required',
            's_detail'=>'required',
            'benefit_detail'=>'required',
            'p_name'=>'required|string',
            'p_des'=>'required|string',

            'statement_file'=>'sometimes|file|mimes:pdf|max:20000',

            
        ];
    }

    public function attributes(){
        return [
            'cop_num'=>'Tax Number and/or Business Identification Number',
            'cop_juri'=>'Jurisdiction of incorporation',
            'doi'=>'Date of Birth',
            'revenue'=>'20% or more of your anticipated annual revenue data',
            'tp'=>'Use third parties',
            'q1'=>'Relationship detail',
            'q2'=>'Relationship detail',
            'q3'=>'Relationship detail',
            'q4'=>'Relationship detail',
            'q5'=>'Relationship detail',
            'q5'=>'Relationship detail',
            'person'=>' Are you a Public offical ',
            'person_detail'=> ' Details about Public official',
            'q_detail'=>' More relationship detail',

            'r_detail'=>' Violation detail',
            's_detail'=>' Sanction detail',
            'benefit_detail'=> ' Personal benefit',

            'p_name'=>'Person Name',
            'p_des'=>'Designation',

            'statement_file'=>'Financial statement file'


        ];
    }

    public function messages()
    {
        return [
            'person_detail.required_if'=>'Provide more info on "Are you a Public offical"'
        ];
    }

    
}
