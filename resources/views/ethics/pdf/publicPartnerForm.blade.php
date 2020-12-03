<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Partner Form</title>
    <style>
        .page-break {
            page-break-after: always;
        }

        footer {
            position: fixed;
            bottom: -50px;
            left: 0px;
            right: 0px;
            height: 40px;
            color: #afadad;
            font-size: 12px;
        }

        header {
            position: fixed;
            top: -30px;
            left: 0px;
            right: 0px;
            height: 50px;
        }

        .small {
            font-size: 10px;
        }

        .large {
            font-size: 14px;
        }

        .medium {
            font-size: 12px;
        }

        p {
            font-size: 14px;
        }

        div,
        ul,
        li {
            font-size: 14px;
        }

        td,
        th {
            font-size: 14px;
            padding: 5px;
        }

        .pagenum:before {
            content: counter(page);
        }
    </style>

<link rel="stylesheet" href="{{URL::asset('assets/css/bootstrap.min.css')}}"  type="text/css" />
</head>

<body>
    <header>
        <img style="position:absolute;right:0px;" width="150px" height="40px" src="images/systra.jpg" alt="systra">
    </header>

    <div class="h4 mt-4 mb-5" style="color:#de3314;">
        <strong>BUSINESS PARTNER FORM – PART A</strong>
    </div>


    <footer>
        FO-02375 v1 
        <span style="position:absolute;left:45%" class="pagenum"></span>
        <span style="position:absolute;right:0px">{{Carbon::now()->toFormattedDateString()}}</span>
    </footer>


    <div class="font-weight-bold mb-3">FOR USE OF Bid Team</div>

    <div class="pl-2 ml-2">
        <div>
            Name of the person who completes this Form:&nbsp; {{$e->ethics->pm()}}
        </div>
        <div>
            Date:{{$e->getTime($e->ethics->pm_at)}}
        </div>

        <hr>

        <div class="mt-3">
            Business Partner name: {{$e->name}}
        </div>
        <div class="mt-3">
            Position: {{$e->getType()}}
        </div>

    </div>

    <table class="table pl-1 mt-3" style="border:0px !important">
        <tbody>
            <tr style="border:0px !important">
                <td scope="row" style="border:0px" class="w-50">Business Partner’s Country : {{ $e->country->name}}</td>
                <td style="border:0px">Country Score* : {{$e->cpi}}</td>

            </tr>
        </tbody>
    </table>


    <div class="pl-2 ml-2 mt-3">Project concerned:{{$e->ethics->contract}} </div>


    <table class="table pl-1 mt-2" style="border:0px !important">
        <tbody>
            <tr style="border:0px !important">
                <td scope="row" style="border:0px" class="w-50">SYSTRA’s Group Contract concerned :
                    {{$e->project->name}}</td>
            </tr>
        </tbody>
    </table>

    <table class="table pl-1 mt-2" style="border:0px !important">
        <tbody>
            <tr style="border:0px !important">
                <td scope="row" style="border:0px" class="w-50">CDO:&nbsp;{{$e->yn($e->ethics->cdo)}}
                    @if($e->ethics->cdo==1){{$e->getTime($e->ethics->cdo_date)}}@endif</td>
            </tr>
        </tbody>
    </table>

    <table class="table pl-1 mt-2" style="border:0px !important">
        <tbody>
            <tr style="border:0px !important">
                <td scope="row" style="border:0px" class="w-50">Project’s Country :{{$e->ethics->getProjectCountry()}}
                </td>
                <td style="border:0px">Country Score* : {{$e->ethics->pcpi}}</td>

            </tr>
        </tbody>
    </table>




    <div style="position:fixed;bottom:30px;font-size:12px">* score of the Corruption Perceptions Index (CPI) evaluated
        by Transparency International .(<a href="www.transparency.org">www.transparency.org/cpi</a>)
    </div>

    <div class="page-break"></div>
    <div class="h4 mt-4 mb-3" style="color:#de3314;">
        <strong>BUSINESS PARTNER FORM – PART B</strong>
    </div>

    <div class="font-weight-bold mb-3">FOR USE OF Bid Team</div>

    <div class="pl-2 ml-2">
        <div>
            Name of the person who completes this Form:&nbsp; {{$e->ethics->pm()}}
        </div>
        <div>
            Date:{{$e->getTime($e->ethics->pm_at)}}
        </div>
    </div>

    <table class="table pl-1 mt-2 table-bordered">
        <tbody>
            <tr>
                <td scope="row" class="w-50  text-wrap " style="padding:5px;">Public Client name</td>
                <td class="w-50 text-wrap  " style="padding:5px;">{{$e->name}}</td>

            </tr>

            <tr>
                <td scope="row" class="w-50 text-wrap " style="padding:5px;">Registered address<br>
                   
                </td>
                <td class="w-50 text-wrap" style="padding:5px;"><p>{{$e->address}}</p></td>

            </tr>
            <tr>
                <td scope="row" class="w-50 text-wrap " style="padding:5px;">Incorporation number</td>
                <td class="w-50 text-wrap " style="padding:5px;">{{$e->cop_num}}</td>

            </tr>
            <tr>
                <td scope="row" class="w-50 text-wrap " style="padding:5px;">Date of incorporation</td>
                <td class="w-50 text-wrap " style="padding:5px;">{{$e->doi->toFormattedDateString()}}</td>

            </tr>
            <tr>
                <td scope="row" class="w-50 text-wrap " style="padding:5px;">Jurisdiction of incorporation</td>
                <td class="w-50 text-wrap " style="padding:5px;">{{$e->cop_juri}}</td>

            </tr>

            <tr>
                <td scope="row" class="w-50 text-wrap " style="padding:5px;">Direct shareholders
                </td>
                <td class="w-50 text-wrap " style="padding:5px;"><p>{{$e->stock_detail}}</p> </td>

            </tr>
            <tr>
                <td scope="row" class="w-50 text-wrap " style="padding:5px;">Names of main directors:
                </td>
                <td class="w-50 text-wrap " style="padding:5px;"><p>{{$e->director}}</p></td>

            </tr>
            <tr>
                <td scope="row" class="w-50 text-wrap " style="padding:5px;">Main affiliated companies:</td>
                <td class="w-50 text-wrap " style="padding:5px;"><p>{{ $e->subsidiary}}</p> </td>

            </tr>
            <tr>
                <td scope="row" class="w-50 text-wrap " style="padding:5px;">Number of employees:</td>
                <td class="w-50 text-wrap " style="padding:5px;">{{$e->employee}}</td>

            </tr>
            <tr>
                <td scope="row" class="w-75">Has a basic integrity review of the Business Partner by way of an internet
                    search been performed according to the Procedure?</td>
                <td>{{$e->search($e->ethics->search)}}</td>
            </tr>

            <tr>
                <td scope="row" class="text-wrap text-justify" style="padding:5px; width:60%;">Does the Public Client have policies and a programme to ensure ethical business practices and prevent corruption, such as:
                    <br>
                    <span class="ml-4 pl-2">
                    - A code of ethics?<br>
                    - Ethics and compliance training?<br>
                    - A compliance officer?<br>
                    - A “whistleblowing” process?<br>
                    - A policy regarding international sanctions
                    </span>
                </td>
                <td class="text-wrap" style="padding:5px;">
                    {{$e->policy($e->ethics->policy)}}<br>
                    <div style="margin-top:17px;">
                    {{$e->policy($e->ethics->p1)}}<br>
                    {{$e->policy($e->ethics->p2)}}<br>
                    {{$e->policy($e->ethics->p3)}}<br>
                    {{$e->policy($e->ethics->p4)}}<br>
                    {{$e->policy($e->ethics->p5)}}
                    </div>    
                </td>

            </tr>

            <tr>
                <td scope="row" class="w-75">Has the Public Client or its Directors been condemned for non-ethical practices or investigation is in progress : </td>
                <td>{{$e->yn($e->ethics->practice)}} 
                @if ($e->ethics->practice==1)
                <p>{{$e->ethics->practice_detail}}</p>
                @endif</td>
            </tr>


        </tbody>
    </table>

    <div class="page-break"></div>
    <div class="h4 mt-4 mb-5" style="color:#de3314;">
        <strong>BUSINESS PARTNER FORM – PART B</strong>
    </div>

    <div>
        <strong>Identified Redflag</strong> (an indicative list is mentioned on §3.3 of the procedure)
    </div>
    <p  class="pl-4 ml-4 text-wrap text-justify">{{$e->ethics->flag}}
    </p>

    <div>
        <strong>Mitigating actions proposed:</strong>
    </div>
    <p  class="pl-4 ml-4 text-wrap text-justify">{{$e->ethics->mitigation}}
    </p>



    <div class="page-break"></div>

    <div class="h5 mt-4 mb-5" style="color:#de3314;">
        <strong>FOR USE OF Local Compliance Officer/Manager</strong>
    </div>
    <div class="pl-2 ml-2">
        <div>
            Name of the person who reviewed this Form: {{$e->ethics->complaince_by()}}
        </div>
        <div>
            Date: {{$e->getTime($e->ethics->ims_at)}}
        </div>
    </div>
    <hr>
    <div class="pl-2 ml-2 mt-3">
        Enhanced integrity review performed? <strong>{{$e->yn($e->ethics->integrity)}}</strong>
    </div>

    <div class="pl-2 ml-2 mt-3">
        Red flag identified from the enhanced integrity review and mitigating actions proposed:
        <br>Amended action plan, if any
    </div>

    <p style="white-space:pre-wrap;" class="pl-4 ml-4 text-wrap text-justify">{{$e->ethics->flag_action}}
    </p>
    <hr>
    <div  class="pl-2 ml-2 mt-2  "><strong>Decision : </strong>
        {{$e->ethics->decisionVal($e->ethics->ims_decision)}}
    </div>

    <div  class="pl-2 ml-2 mt-2  "><strong>valid up to : </strong>
        @if($e->ethics->ims_decision>0){{$e->getTime($e->due_on)}}@endif
    </div>

    <div class="pl-2 ml-2 mt-4">
        <strong>Reason of this decision :</strong>
    </div>
    <p  class="pl-4 ml-4 text-wrap text-justify">{{$e->ethics->ims_reason}}
    </p>
    @if($e->ethics->decision==2)
    <div class="pl-2 ml-2 mt-4">
        <strong>Conditions :</strong>
    </div>
    <p class="pl-4 ml-4 text-wrap text-justify">{{$e->ethics->ims_condition}}
    </p>
    @endif
    @if($e->ethics->ims_add!=null || $e->ethics->ims_add!='' )
    <div class="pl-2 ml-2 mt-4">
        <strong>Additional information if any :</strong>
    </div>
    <p class="pl-4 ml-4 text-wrap text-justify">{{$e->ethics->ims_add}}
    </p>
    @endif

    @if($e->ethics->l1_by!=null )
    <div class="page-break"></div>
    <div class="h5 mt-4 mb-5" style="color:#de3314;">
        <strong>FOR USE OF Group Compliance Officer/Manager</strong>
    </div>
    <div class="pl-2 ml-2">
        <div>
            Name of the person who reviewed this form: {{$e->getUsername($e->ethics->l1_by)}}
        </div>
        <div>
            Date: {{$e->getTime($e->ethics->l1_at)}}
        </div>
    </div>

    <div  class="pl-2 ml-2 mt-2">
        <strong>Decision: </strong>
       {{$e->ethics->decisionVal($e->ethics->l1_decision)}} 
    </div>

    <div  class="pl-2 ml-2 mt-2  "><strong>valid up to : </strong>
        @if($e->ethics->l1_decision>0){{$e->getTime($e->due_on)}}@endif
    </div>

    <div class="pl-2 ml-2 mt-4">
        <strong>Reason of this decision :</strong>
    </div>
    <p  class="pl-4 ml-4 text-wrap text-justify">{{$e->ethics->l1_reason}}
    </p>
    @if($e->ethics->decision==2)
    <div class="pl-2 ml-2 mt-4">
        <strong>Conditions :</strong>
    </div>
    <p  class="pl-4 ml-4 text-wrap text-justify">{{$e->ethics->l1_condition}}
    </p>
    @endif
    @if($e->ethics->l1_add!=null || $e->ethics->l1_add!='' )
    <div class="pl-2 ml-2 mt-4">
        <strong>Additional information if any :</strong>
    </div>
    <p class="pl-4 ml-4 text-wrap text-justify">{{$e->ethics->l1_add}}
    </p>
    @endif

    @endif




    @if($e->ethics->l2_by!=null )
    <div class="page-break"></div>
    <div class="h5 mt-4 mb-5" style="color:#de3314;">
        <strong>FOR USE OF Ethics Committee</strong>
    </div>
    <div class="pl-2 ml-2">
        <div>
            Name of the person who reviewed this form: {{$e->getUsername($e->ethics->l2_by)}}
        </div>
        <div>
            Date: {{$e->getTime($e->ethics->l2_at)}}
        </div>
    </div>

    <div  class="pl-2 ml-2 mt-2">
        <strong>Decision: </strong>
       {{$e->ethics->decisionVal($e->ethics->l2_decision)}} 
    </div>

    <div  class="pl-2 ml-2 mt-2 "><strong>valid up to : </strong>
        @if($e->ethics->l2_decision>0){{$e->getTime($e->due_on)}}@endif
    </div>

    <div class="pl-2 ml-2 mt-4">
        <strong>Reason of this decision :</strong>
    </div>
    <p  class="pl-4 ml-4 text-wrap text-justify">{{$e->ethics->l2_reason}}
    </p>
    @if($e->ethics->decision==2)
    <div class="pl-2 ml-2 mt-4">
        <strong>Conditions :</strong>
    </div>
    <p  class="pl-4 ml-4 text-wrap text-justify">{{$e->ethics->l2_condition}}
    </p>
    @endif
    @if($e->ethics->l2_add!=null || $e->ethics->l2_add!='' )
    <div class="pl-2 ml-2 mt-4">
        <strong>Additional information if any :</strong>
    </div>
    <p class="pl-4 ml-4 text-wrap text-justify">{{$e->ethics->l2_add}}
    </p>
    @endif

    @endif



</body>

</html>