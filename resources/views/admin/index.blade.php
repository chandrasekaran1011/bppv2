<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SYSTRA - BPP</title>

    <!-- Fonts -->

    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <meta name="csrf-token" id="csrf" content="{{ csrf_token() }}" />


    <link rel="stylesheet" href="{{asset('css/admin.css')}}">

</head>

<style>
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

                    'logout'=>route('admin.logout'),

                    'getRoles'=> route('admin.getRoles'),
                    'createRole'=> route('admin.createRole'),
                    'updateRole'=>route('admin.updateRole'),
                    'createUser'=>route('admin.createUser'),
                    'getUser'=>route('admin.getUser'),
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