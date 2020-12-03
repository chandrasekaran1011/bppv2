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

    <link rel="stylesheet" href="{{URL::asset('assets/css/bootstrap.min.css')}}" type="text/css" />
</head>

<body>
    <header>
        <img style="position:absolute;right:0px;" width="120px" height="30px" src="images/systra.jpg" alt="systra">
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

    @if ($e->type_id>2)
    <div class="pl-2 ml-2 mt-3">
        Scope of work to be performed by the Business Partner : <br>
        <p class="text-wrap pl-2 ml-2" style="white-space: pre-wrap">
            {{$e->ethics->scope}}
        </p>

    </div>
    @endif


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


    <div class="pl-2 ml-2">
        Method of selection of the Business Partner : {{ $e->mutual($e->ethics->mutual)}}
    </div>

    <div class="pl-2 ml-2">
        Has the Business Partner been recommended by a client ? &nbsp; {{$e->yn($e->ethics->recomm)}}
    </div>

    <div style="position:fixed;bottom:30px;font-size:12px">* score of the Corruption Perceptions Index (CPI) evaluated
        by Transparency International .(<a href="www.transparency.org">www.transparency.org/cpi</a>)
    </div>

    <div class="page-break"></div>
    <div class="h4 mt-4 mb-5" style="color:#de3314;">
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

        <div class="mt-3">
            Business Partner name: {{$e->name}}
        </div>

    </div>

    <table class="table pl-1 mt-2 table-bordered">
        <tbody>
            <tr>
                <td scope="row" class="w-75">Has the need to contract with the Business Partner been validated?
                    (according to procedure cf.2.1)</td>
                <td>{{$e->yn($e->ethics->need)}}</td>
            </tr>
            <tr>
                <td scope="row" class="w-75">Has the Business Partner returned the Business Partner Questionnaire?</td>
                <td>@if($e->q_submission==1){{"Yes"}}@else{{"No"}}@endif</td>
            </tr>
            <tr>
                <td scope="row" class="w-75">Has the Business Partner fully completed and signed the Business Partner
                    Questionnaire?</td>
                <td>@if($e->q_submission==1){{"Yes"}}@else{{"No"}}@endif</td>
            </tr>
            <tr>
                <td scope="row" class="w-75">Has a basic integrity review of the Business Partner by way of an internet
                    search been performed according to the Procedure?</td>
                <td>{{$e->search($e->ethics->search)}}</td>
            </tr>

            <tr>
                <td scope="row" class="w-75">Has the Business Partner a satisfactory ethics program* : </td>
                <td>{{$e->yn($e->ethics->satis)}}</td>
            </tr>

            <tr>
                <td scope="row" class="w-75">Has the Business Partner or its Principal been condemned for non-ethical
                    practices or current investigation is in progress?:</td>
                <td>{{$e->yn($e->ethics->practice)}}</td>
            </tr>


        </tbody>
    </table>

    <div>
        <strong>Identified Redflag</strong> (an indicative list is mentioned on §3.3 of the procedure)
    </div>
    <p style="white-space:pre-wrap;" class="pl-4 ml-4 text-wrap text-justify">{{$e->ethics->flag}}
    </p>

    <div>
        <strong>Mitigating actions proposed:</strong>
    </div>
    <p style="white-space:pre-wrap;" class="pl-4 ml-4 text-wrap text-justify">{{$e->ethics->mitigation}}
    </p>

    @if($e->ethics->ims_at!=null )

        <div class="page-break"></div>
        <div class="h5 mt-4 mb-5" style="color:#de3314;">
            <strong>FOR USE OF LOCAL COMPLIANCE OFFICER/MANAGER</strong>
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
        <div class="pl-2 ml-2 mt-2 "><strong>Decision : </strong>
            {{$e->ethics->decisionVal($e->ethics->ims_decision)}}
        </div>

        <div class="pl-2 ml-2 mt-2 "><strong>valid up to : </strong>
            @if($e->ethics->ims_decision>0){{$e->getTime($e->due_on)}}@endif
        </div>

        <div class="pl-2 ml-2 mt-4">
            <strong>Reason of this decision :</strong>
        </div>
        <p class="pl-4 ml-4 text-wrap text-justify">{{$e->ethics->ims_reason}}
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


    @endif

    @if($e->ethics->l1_by!=null )
        <div class="page-break"></div>
        <div class="h5 mt-4 mb-5" style="color:#de3314;">
            <strong>FOR USE OF GROUP COMPLIANCE OFFICER/MANAGER</strong>
        </div>
        <div class="pl-2 ml-2">
            <div>
                Name of the person who reviewed this Form: {{$e->getUsername($e->ethics->l1_by)}}
            </div>
            <div>
                Date: {{$e->getTime($e->ethics->l1_at)}}
            </div>
        </div>

        <div class="pl-2 ml-2 mt-2">
            <strong>Decision: </strong>
            {{$e->ethics->decisionVal($e->ethics->l1_decision)}}
        </div>

        <div class="pl-2 ml-2 mt-2  "><strong>valid up to : </strong>
            @if($e->ethics->l1_decision>0){{$e->getTime($e->due_on)}}@endif
        </div>

        <div class="pl-2 ml-2 mt-4">
            <strong>Reason of this decision :</strong>
        </div>
        <p class="pl-4 ml-4 text-wrap text-justify">{{$e->ethics->l1_reason}}
        </p>
        @if($e->ethics->decision==2)
        <div class="pl-2 ml-2 mt-4">
            <strong>Conditions :</strong>
        </div>
        <p class="pl-4 ml-4 text-wrap text-justify">{{$e->ethics->l1_condition}}
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
        <strong>FOR USE OF ETHICS COMMITTEE</strong>
    </div>
    <div class="pl-2 ml-2">
        <div>
            Name of the person who reviewed this Form: {{$e->getUsername($e->ethics->l2_by)}}
        </div>
        <div>
            Date: {{$e->getTime($e->ethics->l2_at)}}
        </div>
    </div>

    <div class="pl-2 ml-2 mt-2 ">
        <strong>Decision:</strong>
        {{$e->ethics->decisionVal($e->ethics->l2_decision)}}
    </div>

    <div class="pl-2 ml-2 mt-2 text-wrap "><strong>valid up to : </strong>
        @if($e->ethics->l2_decision>0){{$e->getTime($e->due_on)}}@endif
    </div>

    <div class="pl-2 ml-2 mt-4">
        <strong>Reason of this decision :</strong>
    </div>
    <p class="pl-4 ml-4 text-wrap text-justify">{{$e->ethics->l2_reason}}
    </p>
    @if($e->ethics->decision==2)
    <div class="pl-2 ml-2 mt-4">
        <strong>Conditions :</strong>
    </div>
    <p class="pl-4 ml-4 text-wrap text-justify">{{$e->ethics->l2_condition}}
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