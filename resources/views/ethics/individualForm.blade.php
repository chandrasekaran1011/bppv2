@extends('main.vlayout')

@section('content')
<div class="container rounded" style="border:solid 2px black;background-color:#ffffff;">
    <div class="h2 mt-4 mb-5">
    <strong>BUSINESS PARTNER QUESTIONNAIRE - {{$ethics->type->name}}</strong> 
       <img class="float-right" width="150px" height="50px" src="{{asset('images/systra.jpg')}}"  alt="systra">
    </div>
    <form action="{{route('individualStore',['id'=>$ethics->uuid])}}" method="post" enctype="multipart/form-data">
        @csrf()
        @if ($errors->any())
            <div class="alert alert-danger m-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <script>
                $( document ).scrollTop(0);
            </script>
        @endif


        <div class="form-group d-flex mt-3">
                <div class="col-md-6">
                    <label class="reqFields">Name of your Organization</label>
                </div>        
                <div class="col-md-6">    
                    <input type="text" class="form-control" name="name" id="name" aria-describedby="name" value="{{old('name',$ethics->name)}}" placeholder="Name of the Business Partner" required='required'>
                    
                </div>  
        </div>

        <div class="form-group d-flex mt-3">
            <div class="col-md-6">
                <label class="reqFields">Resident address</label>
            </div>        
            <div class="col-md-6">    
                
                <div class="form-group">
                    <textarea class="form-control" name="address" required id="address" height="90px"  placeholder="Address (If available, provide an extract of the commercial registry not older than 3-months.)">{{old('address')}}</textarea>
                </div>
            </div>
        </div> 


        <div class="form-group d-flex mt-3">
            <div class="col-md-6">
                <label class="reqFields">Tax Number and/or Business Identification Number</label>
            </div>        
            <div class="col-md-6">    
                <input type="text" class="form-control" name="cop_num" id="cop-num" aria-describedby="cop-num" value="{{old('cop_num')}}" placeholder="Identification Number" required='required' maxlenght="20">
                <small class="form-text text-muted">Mention "NA" if not applicable</small>
            </div>  
        </div>  

        <div class="form-group d-flex mt-3">
            <div class="col-md-6">
                <label class="reqFields">Jurisdiction of incorporation</label>
            </div>        
            <div class="col-md-6">    
                <input type="text" class="form-control" name="cop_juri" id="cop-juri" aria-describedby="cop-juri" value="{{old('cop_juri')}}" placeholder="Jurisdiction of incorporation" required='required' maxlenght="20">
                <small class="form-text text-muted">Mention "NA" if not applicable</small>
            </div>  
        </div> 

        <div class="form-group d-flex mt-3">
            <div class="col-md-6">
                <label class="reqFields">Date of Birth</label>
            </div>        
            <div class="col-md-6">    
                
                <input class="form-control form_date1" size="16" type="text"  name="doi" readonly="" value="{{old('doi')}}">

            </div>  
        </div>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <script>
                $(".form_date1").flatpickr({
                    altInput: true,
                    altFormat: "F j, Y",
                    dateFormat: "Y-m-d",
                    maxDate:"today"
                });
        </script>

        <div class="form-group d-flex mt-3">
            <div class="col-md-6">
                <label class="reqFields">Do you have the required licenses to work? If applicable</label>
            </div>        
            <div class="col-md-6">    
                <input type="text" class="form-control" name="license" id="license" aria-describedby="license" value="{{old('license')}}" placeholder="Yes/No.Reference if applicable" required='required' maxlenght="20">
                <small class="form-text text-muted">Mention "NA" if not applicable</small>
            </div>  
        </div> 



        <div class="form-group d-flex mt-3">
            <label for="" class="col-md-6 form-label reqFields">Does 20% or more of your anticipated annual revenue come from your business with companies from Systra Group? </label>
            <div class="col-md-6">
                
                <div class="form-check form-check-inline icheck-primary">
                    <input class="form-check-input" type="radio" name="revenue" id="revenue_yes" value="1" @if(old('revenue')=="1"){{'checked'}}@endif>
                    <label class="form-check-label" for="revenue_yes">Yes</label>
                </div>
                <div class="form-check form-check-inline icheck-danger">
                    <input class="form-check-input" type="radio" name="revenue" id="revenue_no" value="0" required @if(old('revenue')=="0"){{'checked'}}@endif>
                    <label class="form-check-label" for="revenue_no">No</label>
                </div>
            </div>
        </div>  

        
        <div class="form-group d-flex mt-3">
            <div class="col-md-6">
                <label class="reqFields">
                    Do you intend to use third parties to perform the services covered by the contract with Systra? If yes do you have evaluated the third party integrity?
                </label>
            </div>        
            <div class="col-md-6">    
                
                <div class="form-group">
                    <textarea class="form-control" name="tp"  id="tp" height="90px" aria-describedby="director" maxlength="60" required="required">{{old('tp')}} </textarea>
                    <small class="form-text text-muted">Mention "NA" if not applicable</small>
                </div>
            </div>
        </div>

        <div class="card-header bg-primary text-white">
            Ethics, compliance and political exposure
        </div> 
 

  
        <div class="form-group d-flex mt-3">
            <label for="" class="col-md-6 form-label reqFields">1)Are you a Public Official?  </label>
            <div class="col-md-6">
                
                <div class="form-check form-check-inline icheck-primary">
                    <input class="form-check-input" type="radio" name="person" id="person_yes" @if(old('person')=="1"){{'checked'}}@endif value="1">
                    <label class="form-check-label" for="person_yes">Yes</label>
                </div>
                <div class="form-check form-check-inline icheck-danger">
                    <input class="form-check-input" type="radio" name="person" id="person_no" @if(old('person')!="1"){{'checked'}}@endif value="0"  required>
                    <label class="form-check-label" for="person_no">No</label>
                </div>
            </div>
        </div>

        <div class="group-person pl-3">
            <div class="form-group d-flex mt-3">
                <div class="col-md-6">
                    <label class="reqFields">
                        Provide more details if any.<br>(mention "NA" if none)                   
                    </label>
                </div>        
                <div class="col-md-6">    
                    
                    <div class="form-group">
                        <textarea class="form-control" name="person_detail"  id="person_detail" height="90px" placeholder="If yes, provide details" aria-describedby="person_detail">{{old('person_detail')}}</textarea>

                    </div>
                </div>
            </div>                       

        </div>

        <hr class="m-0">

        <div class="ml-2 mt-3">
            <label for="" class="col-md-6 form-label reqFields">2) Do you have any personal or professional relationship with </label>
        </div>

        <div class=" pl-5">     


            <div class="form-group d-flex mt-3">
                <label for="" class="col-md-6 form-label"> <i class="fas fa-chevron-right mr-2"></i>Public Official, whose mission could have repercussions on SYSTRA Group business?</label>
                <div class="col-md-6">
                    
                    <div class="form-check form-check-inline icheck-primary">
                        <input class="form-check-input" type="radio" name="q1" id="q1_yes" value="1" @if(old('q1')=="1"){{'checked'}}@endif>
                        <label class="form-check-label" for="q1_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline icheck-danger">
                        <input class="form-check-input" type="radio" name="q1" id="q1_no" value="0" @if(!old('q1')=="1"){{'checked'}}@endif required>
                        <label class="form-check-label" for="q1_no">No</label>
                    </div>
                </div>
            </div>

            <div class="form-group d-flex mt-3">
                <label for="" class="col-md-6 form-label"> <i class="fas fa-chevron-right mr-2"></i>Systra Group employee ?</label>
                <div class="col-md-6">
                    
                    <div class="form-check form-check-inline icheck-primary">
                        <input class="form-check-input" type="radio" name="q2" id="q2_yes" value="1" @if(old('q2')=="1"){{'checked'}}@endif>
                        <label class="form-check-label" for="q2_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline icheck-danger">
                        <input class="form-check-input" type="radio" name="q2" id="q2_no" value="0" @if(!old('q2')=="1"){{'checked'}}@endif required>
                        <label class="form-check-label" for="q2_no">No</label>
                    </div>

                </div>
            </div>

            <div class="form-group d-flex mt-3">
                <label for="" class="col-md-6 form-label"> <i class="fas fa-chevron-right mr-2"></i>Relevant Person ?</label>
                <div class="col-md-6">
                    
                    <div class="form-check form-check-inline icheck-primary">
                        <input class="form-check-input" type="radio" name="q3" id="q3_yes" value="1" @if(old('q3')=="1"){{'checked'}}@endif >
                        <label class="form-check-label" for="q3_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline icheck-danger">
                        <input class="form-check-input" type="radio" name="q3" id="q3_no" value="0" @if(!old('q3')=="1"){{'checked'}}@endif required>
                        <label class="form-check-label" for="q3_no">No</label>
                    </div>
                    
                </div>
            </div>

            <div class="form-group d-flex mt-3">
                <label for="" class="col-md-6 form-label"> <i class="fas fa-chevron-right mr-2"></i>Family member or personal or professional associate of one of the above?</label>
                <div class="col-md-6">
                    
                    <div class="form-check form-check-inline icheck-primary">
                        <input class="form-check-input" type="radio" name="q4" id="q4_yes" value="1" @if(old('q4')=="1"){{'checked'}}@endif>
                        <label class="form-check-label" for="q4_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline icheck-danger">
                        <input class="form-check-input" type="radio" name="q4" id="q4_no" value="0" @if(!old('q4')=="1"){{'checked'}}@endif required>
                        <label class="form-check-label" for="q4_no">No</label>
                    </div>
                  
                </div>
            </div>

            <div class="form-group d-flex mt-3">
                <label for="" class="col-md-6 form-label"> <i class="fas fa-chevron-right mr-2"></i>Person subject to any international sanctions ?</label>
                <div class="col-md-6">
                    
                    <div class="form-check form-check-inline icheck-primary">
                        <input class="form-check-input" type="radio" name="q5" id="q5_yes" value="1" @if(old('q5')=="1"){{'checked'}}@endif>
                        <label class="form-check-label" for="q5_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline icheck-danger">
                        <input class="form-check-input" type="radio" name="q5" id="q5_no" value="0" @if(!old('q5')=="1"){{'checked'}}@endif required>
                        <label class="form-check-label" for="q5_no">No</label>
                    </div>
                  
                </div>
            </div>

            <div class="form-group d-flex mt-3">
                <div class="col-md-6">
                    <label >
                        <span class="reqFields">Provide more details if any</span>.<br>(mention "NA" if none)                   
                    </label>
                </div>        
                <div class="col-md-6">    
                    
                    <div class="form-group">
                        <textarea class="form-control" name="q_detail"  id="q_detail" height="90px" placeholder="If yes, provide details" aria-describedby="q_detail">{{old('q_detail')}}</textarea>

                    </div>
                </div>
            </div>  



        </div>    

        <hr class="m-0">  
        
        <div class="form-group d-flex mt-3">
            <div class="col-md-6">
                <label class="reqFields">
                3) Does any Public Official or Relevant Person stand to personal benefit in any way as a result of the proposed agreement with Systra?
                </label>
            </div>        
            <div class="col-md-6">    
                
                <div class="form-group">
                    <textarea class="form-control" required name="benefit_detail"  id="benefit_detail" height="90px" placeholder="Yes/No. If yes, provide details" aria-describedby="benefit_detail">{{old('benefit_detail')}}</textarea>
                </div>
            </div>
        </div>

        <hr class="m-0"> 

        <div class="form-group d-flex mt-3">
            <div class="col-md-6">
                <label class="reqFields">
                4) Have you been, during the five past years, the subject of investigations, proceedings, convictions, debarments and/or professional suspensions related to (or have otherwise been involved in) corruption, anticompetitive practices, fraud, money-laundering, violation of international sanctions or related offences?
                </label>
            </div>        
            <div class="col-md-6">    
                
                <div class="form-group">
                    <textarea class="form-control" required name="r_detail"  id="r_detail" style="height:150px;" aria-describedby="r_detail" placeholder="Yes/No. If yes, provide details">{{old('r_detail')}}</textarea>
                </div>
            </div>
        </div> 

        <hr class="m-0">  

        <div class="form-group d-flex mt-3">
            <div class="col-md-6">
                <label class="reqFields">
                5)Have you been listed on a national or international sanction list, including U.S. OFAC Specially Designated Nationals (SDN) and Blocked Persons List?
                </label>
            </div>        
            <div class="col-md-6">    
                
                <div class="form-group">
                    <textarea class="form-control" required name="s_detail"  id="s_detail" style="height:100px;" placeholder="Yes/No. If yes, provide details" aria-describedby="s_detail">{{old('s_detail')}}</textarea>
                </div>
            </div>
        </div> 



        <div class="card-header bg-primary text-white">
            Financial exposure
        </div>  


        <div class="form-group d-flex mt-3">
            <div class="col-md-6">
                <label>Provide the last 3 year Tax Return statements<br> (optional ,PDF only (Max 20 MB))</label>
            </div>        
            <div class="col-md-6">    
                <input type="file" class="form-input" name="statement_file" accept=".pdf" id="statement_file" aria-describedby="statement_file"  min="1" placeholder="Certificate (PDF Only)" >
                
            </div>  
        </div>

        <div class="card-header bg-primary text-white">
            Declaration
        </div> 

        <div class="form-check pl-4 mt-3">
            <input class="form-check-input" type="checkbox" value="1" id="declaration" required>
            <label class="form-check-label" for="declaration">
                I certify that the information I am about to provided is true and complete to the best of my knowledge.
            </label>
        </div>           

        <div class="form-group d-flex mt-3">
            <div class="col-md-6">
                <label class="reqFields">Name</label>
            </div>        
            <div class="col-md-6">    
                <input type="text" class="form-control" name="p_name" id="p_name" aria-describedby="p_name" value="{{old('p_name')}}" placeholder="Your Name" required='required'>
            </div>  
        </div>

        <div class="form-group d-flex mt-3">
            <div class="col-md-6">
                <label class="reqFields">Designation</label>
            </div>        
            <div class="col-md-6">    
                <input type="text" class="form-control" name="p_des" id="p_des" aria-describedby="p_des" value="{{old('p_des')}}" placeholder="Your Designation" required='required'>
            </div>  
        </div>

        <div class="text-center mt-3 mb-3">
        <button type="submit" class="btn btn-primary btn-lg">Submit</button>
        </div>           
      
</div>

</form>

@endsection