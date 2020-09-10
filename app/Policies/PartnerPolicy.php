<?php

namespace App\Policies;

use App\Models\Admin\User;
use App\Models\Ethics\Partner;
use Illuminate\Auth\Access\HandlesAuthorization;

class PartnerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any partners.
     *
     * @param  \App\Models\Auth\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the partner.
     *
     * @param  \App\Models\Auth\User  $user
     * @param  \App\Models\Partner  $partner
     * @return mixed
     */
    public function view(User $user, Partner $partner)
    {
        if($user->can('View All Records')){
            return true;
        }
        elseif($user->can('View Entity Records')){
            return in_array($partner->project_id,$user->getProjectsIDs());
        }
        elseif($user->can('View Own Records')){
            if($user->id==$partner->cuser || $user->id==$partner->ethics->ims_assign || $user->id==$partner->ethics->l1_assign || $user->id==$partner->ethics->l2_assign){
                return true;
            }
            
        }
        else{
            return false;
        }
    }

    public function pending(User $user, Partner $partner)
    {
        if($user->id==$partner->cuser && $partner->status==2){

            return true;

        }
        elseif($user->id==$partner->ethics()->ims_assign && $partner->status==3){
            return true;
        }else{
            return false;
        }

    }


    public function edit(User $user, Partner $partner)
    {

        if($user->can('View All Records')){
            return true;
        }
        elseif($user->can('View Entity Records')){
            return in_array($partner->project_id,$user->getprojectsArray());
        }
        elseif($user->can('View Own Records')){
            if($user->id==$partner->cuser || $user->id==$partner->ethics()->ims_assign){
                return true;
            }
            
        }
        else{
            return false;
        }

    }

    public function pmApprove(User $user, Partner $partner)
    {
        if($user->id==$partner->cuser){

            return true;

        }
        elseif($user->isAdmin()){
            return true;
        }

        else{
            return false;
        }

    }

    public function imsApprove(User $user, Partner $partner)
    {
        if($user->id==$partner->ethics->ims_assign && $partner->status==3 ){

            return true;

        }
        elseif($user->isAdmin() && $partner->status==3 ){
            return true;
        }
        
        else{
            return false;
        }

    }

    public function l1Approve(User $user, Partner $partner)
    {
        if($user->id==$partner->ethics->l1_assign && $partner->status==8 ){

            return true;

        }
        elseif($user->isAdmin() && $partner->status==8 ){
            return true;
        }
        
        else{
            return false;
        }

    }

    public function l2Approve(User $user, Partner $partner)
    {
        if($user->id==$partner->ethics->l2_assign && $partner->status==9 ){

            return true;

        }
        elseif($user->isAdmin() && $partner->status==9 ){
            return true;
        }
        
        else{
            return false;
        }

    }

    public function financeReview(User $user, Partner $partner)
    {
        if($user->id==$partner->ethics->finance_assigned && $partner->status==2 ){

            return true;

        }
        elseif($user->isAdmin() && $partner->status==2 ){
            return true;
        }
        
        else{
            return false;
        }

    }

    public function renewPartner(User $user, Partner $partner)
    {
        if($user->can('Renew Partner')){
            return true;
        }
        else{
            return false;
        }

    }

}
