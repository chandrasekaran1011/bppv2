<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SYSTRA - BPP</title>

    <!-- Fonts -->

    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <meta name="csrf-token" id="csrf" content="{{ csrf_token() }}" />
    
<style>
        html, body {
        font-family: 'Lato', sans-serif;
    }
    .lds-ellipsis {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
    }

    .lds-ellipsis div {
        position: absolute;
        top: 33px;
        width: 13px;
        height: 13px;
        border-radius: 50%;
        background: #fff;
        animation-timing-function: cubic-bezier(0, 1, 1, 0);
    }

    .lds-ellipsis div:nth-child(1) {
        left: 8px;
        animation: lds-ellipsis1 0.6s infinite;
    }

    .lds-ellipsis div:nth-child(2) {
        left: 8px;
        animation: lds-ellipsis2 0.6s infinite;
    }

    .lds-ellipsis div:nth-child(3) {
        left: 32px;
        animation: lds-ellipsis2 0.6s infinite;
    }

    .lds-ellipsis div:nth-child(4) {
        left: 56px;
        animation: lds-ellipsis3 0.6s infinite;
    }

    @keyframes lds-ellipsis1 {
        0% {
            transform: scale(0);
        }

        100% {
            transform: scale(1);
        }
    }

    @keyframes lds-ellipsis3 {
        0% {
            transform: scale(1);
        }

        100% {
            transform: scale(0);
        }
    }

    @keyframes lds-ellipsis2 {
        0% {
            transform: translate(0, 0);
        }

        100% {
            transform: translate(24px, 0);
        }
    }
</style>
    <link rel="stylesheet" href="{{asset('css/ethics.css')}}">
   

</head>

<body>

    <div id="app">
        <v-app>
            
            <admin-header :home="'{{route('home')}}'"></admin-header>
                
            <v-content >
                <v-container>
                    <v-row :align="'start'" :justify="'start'">
                        <v-col cols="12">
                            <router-view></router-view>
                        </v-col>

                    </v-row>
                </v-container>
            </v-content>

            
        </v-app>
    </div>
    </div>
    <script>
        const urlParams = new URLSearchParams(window.location.search);

        const myParam = urlParams.get('q');

        if(myParam){
            window.location.hash=myParam;

            console.log('Redirect Initiated');
        }



    </script>

    
    <script>
            
  @auth
    window.Permissions = {!! json_encode(Auth::user()->allPermissions, true) !!};
  @else
    window.Permissions = [];
  @endauth

            window.links = {!! json_encode([

                    'logout'=>route('logout'),
                    'getFormData'=>route('ethics.getFormData'),
                    'storePublicForm'=>route('ethics.storePublicForm'),
                    'storeOtherForm'=>route('ethics.storeOtherForm'),
                    'storePmForm'=>route('ethics.storePmForm'),
                    'compForm'=>route('ethics.compForm'),
                    'detail'=>route('ethics.detail'),
                    'searchResults'=>route('ethics.searchResults'),
                    'auditResults'=>route('ethics.auditResults'),
                    'escalationForm'=>route('ethics.escalationForm'),
                    'resendNotification'=>route('ethics.resendNotification'),
                    'view'=>route('ethics.view'),
                    'entityData'=>route('ethics.entityData'),
                    'searchResult'=>route('ethics.searchResult'),
                    'questionnaireNotSubmitted'=>route('ethics.questionnaireNotSubmitted'),
                    'deletePartner'=>route('ethics.deletePartner'),
                    'blacklistPartner'=>route('ethics.blacklistPartner'),
                    'whitelistPartner'=>route('ethics.whitelistPartner'),
                    'googleSearch'=>route('ethics.googleSearch'),
                    'financeReview'=>route('ethics.financeReview'),
                    'renew'=>route('ethics.renew'),
                    'renewApprove'=>route('ethics.renewApprove'),
                    'pendingApproval'=>route('ethics.pendingApproval'),
                    'monthlyReport'=>route('ethics.monthlyReport'),
                    'cdoReport'=>route('ethics.cdoReport'),
                    'masterReport'=>route('ethics.masterReport'),
                    'genrateReport'=>route('ethics.genrateReport'),
                    'getDashboard'=>route('ethics.getDashboard'),
                    'arrangementStore'=>route('ethics.arrangementStore'),
                    'arrangementDelete'=>route('ethics.arrangementDelete'),
                    'viewFiles'=>route('ethics.viewFiles'),
                    'uploadFile'=>route('ethics.uploadFile'),
                    'getEdit'=>route('ethics.getEdit'),
                    'updatePartner'=>route('ethics.updatePartner'),
                    'pursuance'=>route('ethics.pursuance'),
                    

                ], true) !!};
            
            window.pTypes={!!$partner!!}; 
            

    </script>


    <script src="{{mix('js/manifest.js')}}"></script>
    <script src="{{mix('js/vendor.js')}}"></script>
    <script src="{{mix('js/ethics.js')}}"></script>







</body>

</html>