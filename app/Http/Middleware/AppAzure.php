<?php
namespace App\Http\Middleware;

use RootInc\LaravelAzureMiddleware\Azure as Azure;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use Illuminate\Support\Facades\Auth;


use App\Models\Admin\User;


class AppAzure extends Azure
{
    protected function success($request, $access_token, $refresh_token, $profile)
    {
        $graph = new Graph();
        $graph->setAccessToken($access_token);
        
        $graph_user = $graph->createRequest("GET", "/me")
                      ->setReturnType(Model\User::class)
                      ->execute();
        
        $email = strtolower($graph_user->getUserPrincipalName());

        //dd($email);

        $user=User::where('email',$email)->where('active',1)->first();

        if($user){
            if(Auth::guard('web')->loginUsingId($user->id)){
                return parent::success($request, $access_token, $refresh_token, $profile);
                  // return redirect()->route('ethics.index');
            } 
        }
        else{
            abort(401,'Not Registered');
        }

    }

    // public function getLogoutUrl()
    // {
    //     return $this->baseUrl . "common" . $this->route . "logout?post_logout_redirect_uri=".env('APP_URL');
    // }




}