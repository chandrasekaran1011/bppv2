@extends('main.vlayout')

@section('content')
<div class="container rounded" style="border:solid 2px black;background-color:#ffffff;">
    <div class="h2 mt-4 mb-5">
       <strong>BUSINESS PARTNER QUESTIONNAIRE</strong> 
       <img class="float-right" width="150px" height="50px" src="{{asset('images/systra.jpg')}}"  alt="systra">
    </div>
    <form action="{{route('partnerStore',['id'=>$ethics->uuid])}}" method="post" enctype="multipart/form-data">
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
                    <label class="reqFields">Business Partner Name</label>
                </div>        
                <div class="col-md-6">    
                    <input type="text" class="form-control" name="name" id="name" aria-describedby="name" value="{{old('name',$ethics->name)}}" placeholder="Name of the Business Partner" required='required'>
                    
                </div>  
        </div>

        <div class="form-group d-flex mt-3">
            <div class="col-md-6">
                <label class="reqFields">Registered address</label>
            </div>        
            <div class="col-md-6">    
                
                <div class="form-group">
                    <textarea class="form-control" name="address"  id="address" height="90px"  placeholder="Address (If available, provide an extract of the commercial registry not older than 3-months.)">{{old('address')}}</textarea>

                </div>
            </div>
        </div> 


        <div class="form-group d-flex mt-3">
            <div class="col-md-6">
                <label class="reqFields">Incorporation number</label>
            </div>        
            <div class="col-md-6">    
                <input type="text" class="form-control" name="cop_num" id="cop-num" aria-describedby="cop-num" value="{{old('cop_num')}}" placeholder="Incorporation number" required='required' maxlenght="20">
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
                <label class="reqFields">Date of incorporation</label>
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
            <label for=""  class="col-md-6 form-label reqFields">Listed in stock exchange </label>
            <div class="col-md-6">
                <div class="form-check form-check-inline icheck-primary">
                    <input class="form-check-input" type="radio" name="stock" id="stock_yes" value="1" @if(old('stock')=="1"){{'checked'}}@endif>
                    <label class="form-check-label" for="stock_yes">Yes</label>
                </div>
                <div class="form-check form-check-inline icheck-danger">
                    <input class="form-check-input" type="radio" name="stock" id="stock_no" value="0"  @if(old('stock',0)=="0"){{'checked'}}@endif required>
                    <label class="form-check-label" for="stock_no">No</label>
                </div>                

            </div>
        </div>

        <script>           

            $(document).ready(function () {
                change_stock({{old('stock',0)}});
                
                $(document).on('change','input[name=stock]',function(){
                    var val=$(this).prop("checked", true).val();
                    change_stock(val); 
                });   
            });
            function change_stock(val){
                if(val=="1")
                    {
                        $('.stock-group').show();
                    }
                    else{
                        $('.stock-group').hide();     
                    }

                
            }
            
        </script>

        <div class="stock-group">
            <div class="form-group d-flex mt-3">
                <div class="col-md-6">
                    <label class="reqFields">Stock Exchange</label>
                </div>        
                <div class="col-md-6">    
                    <input type="text" class="form-control" name="stock_name" id="stock-name" aria-describedby="stock-name" value="{{old('stock-name')}}" placeholder="Stock Exchange Name (BSE,NYSE)" maxlenght="20">
                    
                </div>  
            </div> 

            <div class="form-group d-flex mt-3">
                <div class="col-md-6">
                    <label class="reqFields">
                        Direct shareholders (For listed companies, please list only known interests over 10%)<br>
                        if different, ultimate shareholders over 25%.

                    
                    </label>
                </div>        
                <div class="col-md-6">    
                    
                    <div class="form-group">
                        <textarea class="form-control" name="stock_detail"  id="stock_detail" height="90px" aria-describedby="stock_detail">{{old('stock_detail')}} </textarea>

                    </div>
                </div>
            </div> 

        
        </div>    


        <div class="form-group d-flex mt-3">
            <div class="col-md-6">
                <label class="reqFields">
                Names of directors and senior management:
                <br>
                (separated by comma)
                </label>
            </div>        
            <div class="col-md-6">    
                
                <div class="form-group">
                    <textarea class="form-control" name="director"  id="director" height="90px" aria-describedby="director" maxlength="60" placeholder="John Abraham, Micheal Scofield" required="required">{{old('director')}}</textarea>

                </div>
            </div>
        </div>

        <div class="form-group d-flex mt-3">
            <div class="col-md-6">
                <label>
                Specify subsidiaries:
                <br>
                (separated by comma)
                </label>
            </div>        
            <div class="col-md-6">    
                
                <div class="form-group">
                    <textarea class="form-control" name="subsidiary"  id="subsidiary" placeholder="Subsidiary Companies.(Mention 'NA' if not applicable)" height="90px" aria-describedby="subsidiary" maxlength="60" required="required">{{old('subsidiary')}}</textarea>

                </div>
            </div>
        </div>  

        <div class="form-group d-flex mt-3">
            <div class="col-md-6">
                <label><span class="reqFields">Number of Employees</span> <br>(Minimum : 2)</label>
            </div>        
            <div class="col-md-6">    
                <input type="number" class="form-control" name="employee" id="employee" aria-describedby="employee" value="{{old('employee',2)}}" min="1" placeholder="Number of Employees"  maxlenght="20" required="required">
                
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
            <label for="" class="col-md-6 form-label reqFields">Is (or was) your organization under insolvency, liquidation or bankruptcy procedure or debt reorganization? </label>
            <div class="col-md-6">
                
                <div class="form-check form-check-inline icheck-primary">
                    <input class="form-check-input" type="radio" name="insolvency" id="insolvency_yes" value="1" @if(old('insolvency')=="1"){{'checked'}}@endif>
                    <label class="form-check-label" for="insolvency_yes">Yes</label>
                </div>
                <div class="form-check form-check-inline icheck-danger">
                    <input class="form-check-input" type="radio" name="insolvency" id="insolvency_no" value="0" required @if(old('insolvency')=="0"){{'checked'}}@endif >
                    <label class="form-check-label" for="insolvency_no">No</label>
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
                    <textarea class="form-control" name="tp"  id="tp" height="90px" aria-describedby="third party" maxlength="60" required="required">{{old('tp')}} </textarea>
                    <small class="form-text text-muted">Mention "NA" if not applicable</small>
                </div>
            </div>
        </div>

        <div class="card-header bg-primary text-white">
            Ethics, compliance and political exposure
        </div> 

        <div class="form-group d-flex mt-3">
            <label for="" class="col-md-6 form-label reqFields">1) Does your organization have policies and a programme to ensure ethical business practices and prevent bribery and corruption? </label>
            <div class="col-md-6">
                
                <div class="form-check form-check-inline icheck-primary">
                    <input class="form-check-input" type="radio" name="policy" id="policy_yes" value="1" @if(old('policy')=="1"){{'checked'}}@endif >
                    <label class="form-check-label" for="policy_yes">Yes</label>
                </div>
                <div class="form-check form-check-inline icheck-danger">
                    <input class="form-check-input" type="radio" name="policy" id="policy_no" value="0" @if(!old('policy')=="1"){{'checked'}}@endif required>
                    <label class="form-check-label" for="policy_no">No</label>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {

                policyChange({{old('policy',0)}});

                $('input[type=radio][name=policy]').change(function() {
                    
                    policyChange(this.value);
                });

                function policyChange(val){
                    if (val == '1') {
                        $('.group-policy').show();
                        $("#p1_yes").prop("checked", @if(old('p1')=="1"){{true}}@else{{false}}@endif);
                        $("#p2_yes").prop("checked", @if(old('p2')=="1"){{true}}@else{{false}}@endif);
                        $("#p3_yes").prop("checked", @if(old('p3')=="1"){{true}}@else{{false}}@endif);
                        $("#p4_yes").prop("checked", @if(old('p4')=="1"){{true}}@else{{false}}@endif);
                        $("#p5_yes").prop("checked", @if(old('p5')=="1"){{true}}@else{{false}}@endif);
                        $("#p1_no").prop("checked", @if(old('p1')=="0"){{true}}@else{{false}}@endif);
                        $("#p2_no").prop("checked", @if(old('p2')=="0"){{true}}@else{{false}}@endif);
                        $("#p3_no").prop("checked", @if(old('p3')=="0"){{true}}@else{{false}}@endif);
                        $("#p4_no").prop("checked", @if(old('p4')=="0"){{true}}@else{{false}}@endif);
                        $("#p5_no").prop("checked", @if(old('p5')=="0"){{true}}@else{{false}}@endif);
                    }
                    else{
                        $('.group-policy').hide();
                        $("#p1_no").prop("checked", true);
                        $("#p2_no").prop("checked", true);
                        $("#p3_no").prop("checked", true);
                        $("#p4_no").prop("checked", true);
                        $("#p5_no").prop("checked", true);
                    }
                }
            });

        </script>
           
          
        <div class="group-policy pl-5"> 
            
            <div class="pl-3 ml-2">
                <label for="" class="col-md-6 form-label reqFields ">Does the Policy / Program contain the following -   </label>
            </div>  

            <div class="form-group d-flex mt-3">
                <label for="" class="col-md-6 form-label"> <i class="fas fa-chevron-right mr-2"></i> A code of ethics ? </label>
                <div class="col-md-6">
                    
                    <div class="form-check form-check-inline icheck-primary">
                        <input class="form-check-input" type="radio" name="p1" id="p1_yes"   @if(old('p1')=="1"){{'checked'}}@endif  value="1">
                        <label class="form-check-label" for="p1_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline icheck-danger">
                        <input class="form-check-input" type="radio" name="p1" id="p1_no"   @if(!old('p1')=="1"){{'checked'}}@endif value="0">
                        <label class="form-check-label" for="p1_no">No</label>
                    </div>
                </div>
            </div>

            <div class="form-group d-flex mt-3">
                <label for="" class="col-md-6 form-label"> <i class="fas fa-chevron-right mr-2"></i>Ethics and compliance training ? </label>
                <div class="col-md-6">
                    
                    <div class="form-check form-check-inline icheck-primary">
                        <input class="form-check-input" type="radio" name="p2" id="p2_yes"  @if(old('p2')=="1"){{'checked'}}@endif value="1">
                        <label class="form-check-label" for="p2_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline icheck-danger">
                        <input class="form-check-input" type="radio" name="p2" id="p2_no"   @if(!old('p2')=="1"){{'checked'}}@endif value="0">
                        <label class="form-check-label" for="p2_no">No</label>
                    </div>
                </div>
            </div>


            <div class="form-group d-flex mt-3">
                <label for="" class="col-md-6 form-label"> <i class="fas fa-chevron-right mr-2"></i>A compliance officer ?</label>
                <div class="col-md-6">
                    
                    <div class="form-check form-check-inline icheck-primary">
                        <input class="form-check-input" type="radio" name="p3" id="p3_yes" @if(old('p3')=="1"){{'checked'}}@endif value="1">
                        <label class="form-check-label" for="p3_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline icheck-danger">
                        <input class="form-check-input" type="radio" name="p3" id="p3_no" @if(!old('p3')=="1"){{'checked'}} @endif value="0">
                        <label class="form-check-label" for="p3_no">No</label>
                    </div>
                </div>
            </div>

            <div class="form-group d-flex mt-3">
                <label for="" class="col-md-6 form-label"> <i class="fas fa-chevron-right mr-2"></i>A “whistleblowing” process ?</label>
                <div class="col-md-6">
                    
                    <div class="form-check form-check-inline icheck-primary">
                        <input class="form-check-input" type="radio" name="p4" id="p4_yes" @if(old('p4')=="1"){{'checked'}}@endif value="1">
                        <label class="form-check-label" for="p4_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline icheck-danger">
                        <input class="form-check-input" type="radio" name="p4" id="p4_no" @if(!old('p4')=="1"){{'checked'}}@endif value="0">
                        <label class="form-check-label" for="p4_no">No</label>
                    </div>
                </div>
            </div>

            <div class="form-group d-flex mt-3">
                <label for="" class="col-md-6 form-label"> <i class="fas fa-chevron-right mr-2"></i>A policy regarding international sanctions ?</label>
                <div class="col-md-6">

                    <div class="form-check form-check-inline icheck-primary">
                        <input class="form-check-input" type="radio" name="p5" id="p5_yes" @if(old('p5')=="1"){{'checked'}}@endif value="1">
                        <label class="form-check-label" for="p5_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline icheck-danger">
                        <input class="form-check-input" type="radio" name="p5" id="p5_no" @if(!old('p5')=="1"){{'checked'}}@endif value="0">
                        <label class="form-check-label" for="p5_no">No</label>
                    </div>
                    
                </div>
            </div>

            <div class="form-group d-flex mt-3">
                <div class="col-md-6">
                    <label>Attach Relevent Policy/Program Document (optional ,PDF only)</label>
                </div>        
                <div class="col-md-6">    
                    <input type="file" class="form-input" name="policy_file" accept=".pdf" id="policy_file" aria-describedby="policy_file" onchange="Filevalidation('policy_file')"  min="1" placeholder="Policy Document (PDF Only)" >
                    
                </div>  
            </div>          

        </div>  

        <hr class="m-0">

        <div class="form-group d-flex mt-3">
            <label for="" class="col-md-6 form-label reqFields">2) Does any government entity, Public Official or Relevant Person own an interest in, or exert control over your organization? </label>
            <div class="col-md-6">
                
                <div class="form-check form-check-inline icheck-primary">
                    <input class="form-check-input" type="radio" name="person" id="person_yes" @if(old('person')=="1"){{'checked'}}@endif value="1">
                    <label class="form-check-label" for="person_yes">Yes</label>
                </div>
                <div class="form-check form-check-inline icheck-danger">
                    <input class="form-check-input" type="radio" name="person" id="person_no" @if(!old('person')=="0"){{'checked'}}@endif value="0" checked required>
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
            <label for="" class="col-md-6 form-label reqFields">3) Is any of your organization Principals (as defined above) a    </label>
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
                4) Does any Public Official or Relevant Person stand to personal benefit in any way as a result of the proposed agreement with Systra?
                </label>
            </div>        
            <div class="col-md-6">    
                
                <div class="form-group">
                    <textarea class="form-control" name="benefit_detail"  id="benefit_detail" height="90px" placeholder="Yes/No. If yes, provide details" aria-describedby="benefit_detail" required>{{old('benefit_detail')}}</textarea>
                </div>
            </div>
        </div>

        <hr class="m-0"> 

        <div class="form-group d-flex mt-3">
            <div class="col-md-6">
                <label class="reqFields">
                5) Has your organization or any of your subsidiaries or any of your organization Principal or subsidiaries’ Principal been, during the five past years, the subject of investigations, proceedings, convictions, debarments and/or professional suspensions related to (or have otherwise been involved in) corruption, anticompetitive practices, fraud, money-laundering, violation of international sanctions or related offences?         
                </label>
            </div>        
            <div class="col-md-6">    
                
                <div class="form-group">
                    <textarea class="form-control" name="r_detail"  id="r_detail" style="height:150px;" aria-describedby="r_detail" placeholder="Yes/No. If yes, provide details" required>{{old('r_detail')}}</textarea>
                </div>
            </div>
        </div> 

        <hr class="m-0">  

        <div class="form-group d-flex mt-3">
            <div class="col-md-6">
                <label class="reqFields">
                6) Has your organization or any of your subsidiaries or any of your organization Principal or subsidiaries’ Principal been listed on a national or international sanction list, including U.S. OFAC Specially Designated Nationals (SDN) and Blocked Persons List?
                </label>
            </div>        
            <div class="col-md-6">    
                
                <div class="form-group">
                    <textarea class="form-control" name="s_detail"  id="s_detail" style="height:100px;" placeholder="Yes/No. If yes, provide details" aria-describedby="s_detail" required>{{old('s_detail')}}</textarea>
                </div>
            </div>
        </div> 


        <hr class="m-0">  


        <div class="form-group d-flex mt-3">
            <label for="" class="col-md-6 form-label reqFields"> 7) Does your organization have external certifications regarding ethics? (e.g. ISO 37001) ?</label>
            <div class="col-md-6">
                
                <div class="form-check form-check-inline icheck-primary">
                    <input class="form-check-input" type="radio" name="t" id="t_yes" value="1"  @if(old('t')=="1"){{'checked'}} @endif >
                    <label class="form-check-label" for="t_yes">Yes</label>
                </div>
                <div class="form-check form-check-inline icheck-danger">
                    <input class="form-check-input" type="radio" name="t" id="t_no" value="0"  @if(!old('t')=="1"){{'checked'}}@endif required>
                    <label class="form-check-label" for="t_no">No</label>
                </div>
                
            </div>
        </div>

        <div class="form-group d-flex mt-3">
            <div class="col-md-6">
                <label>Attach Certificate if yes (optional ,PDF only)</label>
            </div>        
            <div class="col-md-6">    
                <input type="file" class="form-input" name="certi_file" id="certi_file" accept=".pdf" aria-describedby="certi_file" onchange="Filevalidation('certi_file')"  min="1" placeholder="Certificate (PDF Only)" >
            </div>  
        </div> 


        <div class="card-header bg-primary text-white">
            Financial exposure
        </div>  


        <div class="form-group d-flex mt-3">
            <div class="col-md-6">
                <label>Provide the last 3 year annual statements<br> (optional ,PDF only)</label>
            </div>        
            <div class="col-md-6">    
                <input type="file" class="form-input" name="statement_file" id="statement_file" onchange="Filevalidation('statement_file')"  accept=".pdf" aria-describedby="statement_file"  min="1" placeholder="Certificate (PDF Only)" >
                
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



<script> 
    function Filevalidation(id){ 
        var fi = document.getElementById(id); 
        if (fi.files.length > 0) { 
            for (let i = 0; i <= fi.files.length - 1; i++) { 
  
                let fsize = fi.files.item(i).size; 
                let file = Math.round((fsize / 1024)); 
                // The size of the file. 
                console.log(fi);
                if (file >= 20000) { 
                    fi.value='';
                    alert( 
                      "File too Big, please select a file less than 20MB"); 
                } 
            } 
        } 
    } 
</script> 





</form>

@endsection