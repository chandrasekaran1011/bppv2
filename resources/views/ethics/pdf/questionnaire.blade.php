<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Partner Questionnaire</title>
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
            font-size: 13px;
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
    
    <div class="h3 mt-4 mb-5">
        <strong>BUSINESS PARTNER QUESTIONNAIRE</strong>

    </div>

    <div class="p-3" style="border:2px solid red">
        In the frame of anti-bribery and anti-corruption laws and of our internal process, we require our business partners to complete this questionnaire. We thank you to provide the information requested below to the best of your knowledge and belief.
    </div>

    <div class="h5 mt-2">Definitions</div>

    <p class="text-dark"><strong>“Systra Group” </strong> means Systra, company registered in France before
        the “Registre du Commerce et des Sociétés” of Paris under the number 387 949 530 RCS and/or its
        subsidiaries all over the world.</p>

    <p class="text-dark"><strong>“Client”</strong> means any person which is Systra Group actual or intended
        client.</p>
    <p class="text-dark"><strong>“Principals” </strong>means, in relation to any legal entity:
        <ul class="ml-4 pl-3">
            <li>Any (actual or former) owner, officer or director, or</li>
            <li>Any employee or other representative who has authority to make or influence decisions or
                recommendations regarding the relationship with Systra Group.</li>
        </ul>
    </p>
    <p class="text-dark"><strong>“Public Officials” </strong>  includes the persons exercising, or having exercised within the last year, one of the following functions:
        <ul class="ml-4 pl-3">
            <li>Officers and employees of any national, regional, local or other governmental entity or
                legislative assembly, including elected officials;</li>
            <li>Officers and employees of companies in which a government owns an interest</li>
            <li>Members of a national supreme court or an international court.</li>
            <li>Members of an administrative or management board of a central bank.</li>
            <li>Ambassadors and high-ranking officers in the armed forces.</li>
            <li>Candidates for political office at any level.</li>
            <li>Officers of political parties.</li>
            <li>Officers, employees or official representatives of international organizations, such as the
                World Bank, United Nations, International Monetary Fund, etc.</li>
            <li>Any private person acting temporarily in an official capacity for or on behalf of any such
                public entity or a company in which a government owns an interest, including expert or
                consultant retained by a public entity or state owned company in a bidding process</li>

        </ul>


    </p>


    <p class="text-dark"><strong>“Relevant Person” </strong> means any Client, or any Principal of any
        Client.</p>

    <footer>
        FO-02374 v1 
        <span style="position:absolute;left:45%" class="pagenum"></span>
        <span style="position:absolute;right:0px">{{Carbon::now()->toFormattedDateString()}}</span>
    </footer>
    <div class="page-break"></div>

    <table class="table  table-bordered mt-3">
        <thead>
            <tr>
                <th colspan="2" class="text-left" style="font-size:14px;background-color:#de3314;color:white;">Basic Information</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row" class="w-50   text-wrap " style="padding:5px;">Name of your organization</td>
            <td class="w-50 text-wrap  " style="padding:5px;">{{$e->name}}</td>

            </tr>
            <tr>
                <td scope="row" class="w-50 text-wrap " style="padding:5px;">Organization type <br>(i.e. Private,
                    Public, Partnership, Charity):</td>
                <td class="w-50 text-wrap " style="padding:5px;">{{$e->org_type}}</td>

            </tr>
            <tr>
                <td scope="row" class="w-50 text-wrap " style="padding:5px;">Registered address<br>
                    If available, provide an extract of the commercial registry not older than 3-months.
                </td>
                <td class="w-50 text-wrap" style="padding:5px;white-space:pre-wrap;"><p>{{$e->address}}</p></td>

            </tr>
            <tr>
                <td scope="row" class="w-50 text-wrap " style="padding:5px;">Incorporation number</td>
            <td class="w-50 text-wrap " style="padding:5px;">{{$e->cop_num}}</td>

            </tr>
            <tr>
                <td scope="row" class="w-50 text-wrap " style="padding:5px;">Date of incorporation</td>
                <td class="w-50 text-wrap " style="padding:5px;">{{$e->getTime($e->doi)}}</td>

            </tr>
            <tr>
                <td scope="row" class="w-50 text-wrap " style="padding:5px;">Jurisdiction of incorporation</td>
                <td class="w-50 text-wrap " style="padding:5px;">{{$e->cop_juri}}</td>

            </tr>
            <tr>
                <td scope="row" class="w-50 text-wrap " style="padding:5px;">If listed, which Stock Exchange(s) is it
                    listed on?</td>
                <td class="w-50 text-wrap " style="padding:5px;">{{$e->yn($e->stock)}} @if($e->stock==1){{', '.$e->stock_name}}@endif</td>

            </tr>
            <tr>
                <td scope="row" class="w-50 text-wrap " style="padding:5px;white-space:pre-wrap;">- Direct shareholders (For listed
                    companies, please list only known interests over 10%):
                    - if different, ultimate shareholders over 25%.
                </td>
                <td class="w-50 text-wrap " style="padding:5px;">{{$e->stock_detail}}</td>

            </tr>
            <tr>
                <td scope="row" class="w-50 text-wrap " style="padding:5px;">Names of directors and senior management:
                </td>
            <td class="w-50 text-wrap " style="padding:5px;">{{$e->director}}</td>

            </tr>
            <tr>
                <td scope="row" class="w-50 text-wrap " style="padding:5px;">Please identify your subsidiaries:</td>
            <td class="w-50 text-wrap " style="padding:5px;">{{ $e->subsidiary}}</td>

            </tr>
            <tr>
                <td scope="row" class="w-50 text-wrap " style="padding:5px;">Number of employees:</td>
            <td class="w-50 text-wrap " style="padding:5px;">{{$e->employee}}</td>

            </tr>

            <tr>
                <td scope="row" class="w-50 text-wrap " style="padding:5px;">Does 20% or more of your anticipated annual
                    revenue come from your business with companies from Systra Group:</td>
                <td class="w-50 text-wrap " style="padding:5px;">{{$e->yn($e->revenue)}}</td>
            </tr>

            <tr>
                <td scope="row" class="w-50 text-wrap " style="padding:5px;">Is (or was) your organization under
                    insolvency, liquidation or bankruptcy procedure or debt reorganization?</td>
                <td class="w-50 text-wrap " style="padding:5px;">{{$e->yn($e->insolvency)}}</td>
            </tr>

            <tr>
                <td scope="row" class="w-50 text-wrap " style="padding:5px;white-space:pre-wrap;">Do you intend to use third parties to
                    perform the services covered by the contract with Systra? If yes do you have evaluated the third
                    party integrity?</td>
                <td class="w-50 text-wrap " style="padding:5px;">{{$e->tp}}</td>

            </tr>
        </tbody>
    </table>

    <div class="page-break"></div>

    <table class="table  table-bordered mt-3">
        <thead>
            <tr>
                <th colspan="2" class="text-left" style="font-size:14px;background-color:#de3314;color:white;">Ethics, compliance and political exposure</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row" class="text-wrap text-justify" style="padding:5px; width:60%;">Does your organization have policies and
                    a programme to ensure ethical business practices and prevent bribery and corruption, such as:
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
                    <div style="margin-top:15px;">
                    {{$e->policy($e->ethics->p1)}}<br>
                    {{$e->policy($e->ethics->p2)}}<br>
                    {{$e->policy($e->ethics->p3)}}<br>
                    {{$e->policy($e->ethics->p4)}}<br>
                    {{$e->policy($e->ethics->p5)}}
                    </div>    
                </td>

            </tr>
            <tr>
                <td scope="row" class="text-wrap text-justify" style="padding:5px;width:60%;">Does any government entity, Public Official
                    or Relevant Person own an interest in, or exert control over your organization?</td>
                <td class="text-wrap " style="padding:5px;white-space:pre-wrap;">{{$e->yn($e->ethics->person)}}@if($e->ethics->person==1){{', '.$e->ethics->person_detail}}@endif</td>

            </tr>
            <tr>
                <td scope="row" colspan="2" class="text-wrap text-justify" style="padding:5px;width:60%;">
                    Is any of your organization Principals (as defined above) a:<br>
                    <div class="ml-4">
                    - Public Official, whose mission could have repercussions on SYSTRA Group business?&nbsp;<strong>{{$e->yn($e->ethics->q1)}}</strong> <br>
                    - Systra Group employee?&nbsp;<strong>{{$e->yn($e->ethics->q2)}}</strong><br>
                    - Relevant Person?&nbsp;<strong>{{$e->yn($e->ethics->q3)}}</strong><br>
                    - Family member or personal or professional associate of one of the above?&nbsp;<strong>{{$e->yn($e->ethics->q4)}}</strong><br>
                    - Person subject to any international sanctions?&nbsp;<strong>{{$e->yn($e->ethics->q5)}}</strong><br>
                    </div>
                    <div class="ml-4"><strong>Additional Details:</strong> </div>
                    <div class="ml-4 pl-4" style="white-space: pre-wrap">{{$e->ethics->q_detail}}</div>

                {{-- </td>
                <td class=" text-wrap" style="padding:5px;"> 
                    <div style="margin-top:20px;">
                    
                    {{$e->yn($e->ethics->q2)}}<br>
                    {{$e->yn($e->ethics->q3)}}<br>
                    {{$e->yn($e->ethics->q4)}}<br>
                    {{$e->yn($e->ethics->q5)}}<br>

                    <span style="white-space: pre-wrap">{{$e->ethics->q_detail}}</span>--}}
                                   
                </td>


            </tr>
            <tr>
                <td scope="row" class="text-wrap text-justify" style="padding:5px;width:60%;">
                    Does any Public Official or Relevant Person stand to personal benefit in any way as a result of the proposed agreement with Systra?
                </td>
            <td class="text-wrap" style="padding:5px;">{{$e->ethics->benefit_detail}}</td>

            </tr>
            <tr>
                <td scope="row" class="text-wrap text-justify" style="padding:5px;width:60%;">
                    Has your organization or any of your subsidiaries or any of your organization Principal or subsidiaries’ Principal been, during the five past years, the subject of investigations, proceedings, convictions, debarments and/or professional suspensions related to (or have otherwise been involved in) corruption, anticompetitive practices, fraud, money-laundering, violation of international sanctions or related offences?
                </td>
                <td class="text-wrap" style="padding:5px;">{{$e->ethics->r_detail}}</td>

            </tr>
            <tr>
                <td scope="row" class=" text-wrap " style="padding:5px;width:60%">Has your organization or any of your subsidiaries or any of your organization Principal or subsidiaries’ Principal been listed on a national or international sanction list, including U.S. OFAC Specially Designated Nationals (SDN) and Blocked Persons List?</td>
                <td class=" text-wrap" style="padding:5px;">{{$e->ethics->s_detail}}</td>

            </tr>
            <tr>
                <td scope="row" class="text-wrap text-justify" style="padding:5px;width:60%;">
                    Does your organization have external certifications regarding ethics? (e.g. ISO 37001)
                </td>
                <td class="text-wrap" style="padding:5px;">{{$e->yn($e->ethics->t)}}</td>
            </tr>
            
        </tbody>
    </table>

    <div class="page-break"></div>

    <table class="table  table-bordered mt-3">
        <thead>
            <tr>
                <th colspan="2" class="text-left" style="font-size:14px;background-color:#de3314;color:white;">Financial exposure</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row" class="w-50   text-wrap " style="padding:5px;">Last 3 years statement provided?
                </td>
                <td class="w-50 text-wrap  " style="padding:5px;"> @if($e->ethics->statement_file!=null){{"Yes"}} @else {{"No"}} @endif
                    
               </td>

            </tr>

        </tbody>
    </table>

    <table class="table  table-bordered">
        <thead>
            <tr>
                <th colspan="2" class="text-left" style="font-size:14px;background-color:#de3314;color:white;">Completed by: (must be someone within your organization with authority to bind your organization)</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row" class="w-50   text-wrap " style="padding:5px;">Name
                </td>
            <td class="w-50 text-wrap  " style="padding:5px;">{{$e->ethics->p_name}}</td>

            </tr>
            <tr>
                <td scope="row" class="w-50   text-wrap " style="padding:5px;">Job Title
                </td>
                <td class="w-50 text-wrap  " style="padding:5px;">{{$e->ethics->p_des}}</td>

            </tr>
            <tr>
                <td scope="row" class="w-50   text-wrap " style="padding:5px;">Date
                </td>
                <td class="w-50 text-wrap  " style="padding:5px;">{{$e->getTime($e->question_submitted_on)}}</td>

            </tr>

            <tr>
                <td scope="row" class="w-50   text-wrap " style="padding:5px;">Signature
                </td>

                <td class="w-50 text-wrap  " style="padding:5px;">
                    <img style="margin-top: 20px" src="{{'storage/signature/'.$e->uuid.'.png'}}" min-width="150px" max-width="250px" height="100px" alt="Signature">
                    
                </td>

            </tr>



        </tbody>
    </table>

    <div class="p-3 mt-4 mb-4 text-justify" style="border:2px solid red">
        <strong>Any modification of the information contained in this questionnaire shall be notified to SYSTRA at the latest thirty (30) days after the day on which the modification occurred.</strong> 
        <br><br>
        <strong>Personal Data Information:</strong> SYSTRA’s collection of personal data is limited to data that are proportionate and necessary to evaluate the integrity of its business partners, and limited to the duration necessary to this purpose or provided by law. SYSTRA applies technical and organizational measures to protect personal data. The individuals concerned by this processing have the right to access their personal data and to rectify data that are inaccurate. In the cases provided for by law (UE General Data Protection Regulation), such individuals have also the right to erasure, the right to data portability, the right to object, the right to restriction of processing and the right to file a complaint with the competent supervisory authority. To exercise these rights, please contact SYSTRA’s DPO:  <a style="text-decorations:none;color:blue;" href="mailto:personaldata@systra.com">personaldata@systra.com</a>
    </div>

</body>

</html>