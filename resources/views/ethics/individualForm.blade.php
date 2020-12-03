@extends('main.vlayout')

@section('content')
<div class="container rounded" style="border:solid 2px black;background-color:#ffffff;">
    <div class="h2 mt-4 mb-5">
    <strong>BUSINESS PARTNER QUESTIONNAIRE - {{$ethics->type->name}}</strong> 
        <img class="float-right" style="margin-top: -5px" width="150px" height="40px" src="{{asset('images/systra.jpg')}}" alt="systra">
    </div>

    <div class="p-3" style="border:2px solid red">
        In the frame of anti-bribery and anti-corruption laws and of our internal process, we require our business
        partners to complete this questionnaire. We thank you to provide the information requested below to the best of
        your knowledge and belief.
        <a href="#" class="text-primary" data-toggle="modal" data-target="#exampleModal">Guidelines</a>
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
                    <label class="reqFields">Name, Forename</label>
                </div>        
                <div class="col-md-6">    
                    <input type="text" class="form-control" name="name" id="name" aria-describedby="name" value="{{old('name',$ethics->name)}}" placeholder="Name of the Business Partner" required='required'>
                    <small>Enter the Full name of the individual</small>
                </div>  
        </div>


        <div class="form-group d-flex mt-3">
            <div class="col-md-6">
                <label class="reqFields">Resident address</label>
            </div>        
            <div class="col-md-6">    
                
                <div class="form-group">
                    <textarea class="form-control" name="address" required id="address" height="90px"  placeholder="Address">{{old('address')}}</textarea>
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
                <label >Incorporation Certificate</label>
            </div>
            <div class="col-md-6">
                <input type="file" class="form-input" name="incorp_file" id="incorp_file"
                onchange="Filevalidation('incorp_file')" accept=".pdf" aria-describedby="incorp_file" min="1" placeholder="Certificate (PDF Only,Max 20 MB)">

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

        <link rel="stylesheet" href="{{asset('/assets/css/flatpickr.min.css')}}">
        <script src="{{asset('/assets/js/flatpicker.js')}}"></script>

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
                    <textarea class="form-control" name="tp"  id="tp" height="90px" aria-describedby="director" maxlength="60" placeholder="Yes/No.if yes provide details." required="required">{{old('tp')}} </textarea>
                    <small class="form-text text-muted">Mention "NA" if not applicable</small>
                </div>
            </div>
        </div>

        <div class="card-header bg-primary text-white">
            Ethics, compliance and political exposure
        </div> 
 

  
        <div class="form-group d-flex mt-3">
            <label for="" class="col-md-6 form-label reqFields">1)Are you a <a href="#" class="text-primary" data-toggle="modal" data-target="#exampleModal"> Public Official </a>?  </label>
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
                <label for="" class="col-md-6 form-label"> <i class="fas fa-chevron-right mr-2"></i>A Public Official?</label>
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
                <label for="" class="col-md-6 form-label"> <i class="fas fa-chevron-right mr-2"></i>An employee of SYSTRA Group ?</label>
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
                <label for="" class="col-md-6 form-label"> <i class="fas fa-chevron-right mr-2"></i>A Relevant Person ?</label>
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

            <div class="form-group d-none mt-3" >
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
                <label for="" class="col-md-6 form-label"> <i class="fas fa-chevron-right mr-2"></i>A Person subject to any international sanctions ?</label>
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
                4) Have you been, during the five past years, the subject of investigations, proceedings, convictions, debarments and/or professional suspensions related to (or have you otherwise been involved in) corruption, anticompetitive practices, fraud, money-laundering, violation of international sanctions or related offences?
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
                <label>Provide the last 3 year Tax Return statements<br>PDF only (Max 20 MB)</label>
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
                <label class="reqFields">Name, Forename</label>
            </div>        
            <div class="col-md-6">    
                <input type="text" class="form-control" name="p_name" id="p_name" aria-describedby="p_name" value="{{old('p_name')}}" placeholder="Your Name" required='required'>
                <small>Enter your Full name </small>
            </div>  
        </div>

        <script src="/assets/js/signature_pad.min.js"></script>

        <div class="form-group d-flex mt-3">
            <div class="col-md-6">
                <label class="reqFields">Signature</label>
            </div>        
            <div class="col-md-6">    
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#signModal">
                    Signature
                </button>
                <img src="" id="sign-img" width="150px" height="100px" alt="signature image">
            </div>  
        </div>
        <!-- Button trigger modal -->

        
        <!-- Modal -->
        <div class="modal fade" id="signModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Signature</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        <canvas id="signature-pad" class="signature-pad" width=400 height=200></canvas>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="sign-clear" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="save-png" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" id="signature" name="signature" value="" required>

        

        <script>
                var canvas = document.getElementById('signature-pad');
            
                var signaturePad = new SignaturePad(canvas, {
                    backgroundColor: 'rgb(255, 255, 255)' 
                });

                document.getElementById('save-png').addEventListener('click', function () {
                    if (signaturePad.isEmpty()) {
                        return alert("Please provide a signature first.");
                    }
                    
                    var data = signaturePad.toDataURL('image/png');
                        console.log(data);
                        $('#sign-img').attr('src',data);
                        $('#signature').val(data);
                        $('#signModal').modal('hide');
                    });

                    $(document).on('click','#sign-clear',function(){
                        signaturePad.clear();
                    });

                    


        </script>

        <div class="text-center mt-3 mb-3">
        <button type="submit" class="btn btn-primary btn-lg">Submit</button>
        </div>  
        
        <div class="p-3 mt-4 mb-4" style="border:2px solid red">
            <strong>Any modification of the information contained in this questionnaire shall be notified to SYSTRA at the latest thirty (30) days after the day on which the modification occurred.</strong> 
            <br><br>
            <strong>Personal Data Information:</strong> SYSTRA’s collection of personal data is limited to data that are proportionate and necessary to evaluate the integrity of its business partners, and limited to the duration necessary to this purpose or provided by law. SYSTRA applies technical and organizational measures to protect your personal data. You have the right to access your personal data and to rectify data that are inaccurate. In the cases provided for by law (UE General Data Protection Regulation), you have also the right to erasure, the right to data portability, the right to object and the right to restriction of processing. To exercise your rights, please contact SYSTRA’s DPO:<a style="text-decorations:none;color:blue;" href="mailto:personaldata@systra.com">personaldata@systra.com</a>. You also have the right to file a complaint with the competent supervisory authority. 
       
       
       
        </div>
      
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="h4">Definitions</div>
                <hr>
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

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</form>

<script>
    function Filevalidation(id){ 
        var fi = document.getElementById(id); 
        console.log(fi);
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

@endsection