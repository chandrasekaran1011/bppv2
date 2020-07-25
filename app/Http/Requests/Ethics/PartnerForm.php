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
            'name'=>'required|max:50|string',
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
            'tp'=>'required',

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
            'q_detail'=>'required',
            'r_detail'=>'required',
            's_detail'=>'required',
            't'=>['required',new BoolRule],
            'p_name'=>'required|string',
            'p_des'=>'required|string',

            'policy_file'=>'sometimes|file|mimes:pdf|max:20000',
            'certi_file'=>'sometimes|file|mimes:pdf|max:20000',
            'statement_file'=>'sometimes|file|mimes:pdf|max:20000',
        ];
    }

    public function attributes(){
        return [
            'cop_num'=>'Incorporation number',
            'cop_juri'=>'Jurisdiction of incorporation',
            'doi'=>'Date of incorporation',
            'stock_name'=>'Stock Exchange',
            'stock_detail'=>'Direct shareholders',
            'revenue'=>'20% or more of your anticipated annual revenue data',
            'insolvency'=>' insolvency, liquidation or bankruptcy',
            'tp'=>'Use third parties',
            'p1'=>'Policy detail',
            'p2'=>'Policy detail',
            'p3'=>'Policy detail',
            'p4'=>'Policy detail',
            'p5'=>'Policy detail',

            'q1'=>'Relationship detail',
            'q2'=>'Relationship detail',
            'q3'=>'Relationship detail',
            'q4'=>'Relationship detail',
            'q5'=>'Relationship detail',

            'person'=>' Are you a Public offical ',
            'person_detail'=> ' Details about Public official',
            'q_detail'=>' More relationship detail',

            'r_detail'=>' Violation detail',
            's_detail'=>' Sanction detail',
            'benefit_detail'=> ' Personal benefit',
            't'=>'External Certification',

            'p_name'=>'Person Name',
            'p_des'=>'Designation',

            'statement_file'=>'Financial statement file',
            'policy_file'=>'Policy File',
            'certi_file'=>'Certificate File',
        ];
    }

    public function messages()
    {
        return [
            'person_detail.required_if'=>'Provide more info on "Are you a Public offical"'
        ];
    }
}
