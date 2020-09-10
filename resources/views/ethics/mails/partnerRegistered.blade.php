@component('mail::message')
# Business Partner Registration Complete

<p>
    Due diligence process has been carried out for the business partner {{$p->name}} for the project {{$p->ethics->contract}}
 

Compliance forms including KYP completed and are acceptable. The enhanced integrity and internet search have been carried out against the business partner.

Following are the Red Flags Identified:
    {{$p->ethics->flag}}

 

Hence compliance manager approved the business partner for two years (2 years) with the following condition:

Conditions for Approval:

 

List down the approval conditions.

 

Business partner form, Business partner questionnaire, screenshot of internet search and lexis integrity search report are attached as reference.

 
</p>





@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
