<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SYSTRA - BPP</title>

    <!-- Fonts -->

    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <meta name="csrf-token" id="csrf" content="{{ csrf_token() }}" />


    <link rel="stylesheet" href="{{asset('css/admin.css')}}">

</head>

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

<body>

    <div id="app">
        <v-app>
            <admin-header></admin-header>
            <v-content>
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
        window.links = {!! json_encode([

                    'logout'=>route('logout'),

                    'getRoles'=> route('admin.getRoles'),
                    'dashboard'=> route('admin.dashboard'),
                    'createRole'=> route('admin.createRole'),
                    'updateRole'=>route('admin.updateRole'),
                    'createUser'=>route('admin.createUser'),
                    'getUser'=>route('admin.getUser'),
                    'getUserData'=>route('admin.getUserData'),
                    'actionUser'=>route('admin.actionUser'),
                    'updateUser'=>route('admin.updateUser'),
                    //Projects
                    'projectIndex'=>route('admin.projectIndex'),
                    'storeProject'=>route('admin.storeProject'),
                    'updateProject'=>route('admin.updateProject'),
                    'deleteProject'=>route('admin.deleteProject'),

            ], true) !!};
            

    </script>


    <script src="{{mix('js/manifest.js')}}"></script>
    <script src="{{mix('js/vendor.js')}}"></script>
    <script src="{{mix('js/admin.js')}}"></script>







</body>

</html>