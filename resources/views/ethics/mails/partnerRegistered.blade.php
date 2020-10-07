<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mail</title>
</head>
<body>
    <div style="max-width: 600px;margin:auto;">

        <h3>Business Partner Registration Complete</h3>
        <p>
            Due diligence process has been carried out for the business partner {{$p->name}} for the project
            {{$p->ethics->contract}}. <br>
        
            The following are the outcome of the process
        
            <ul>
                <li>The Business partner registration status is <strong>{{$p->ethics->decisionVal($p->ethics->decision)}}</strong> </li>
                <li><strong>Reason of this decision :</strong>  
                    <p style="padding-left:20px">{{$p->ethics->reason}}</p>
                </li>
                
                @if ($p->ethics->decision==2)
                    <li><strong>Conditions for Approval:</strong> 
                        <p style="padding-left:20px">{{$p->ethics->condition}}</p> 
                    </li>
                @endif
          
                <li><strong>Redflags Identified :</strong>  
                    <p style="padding-left:20px">{{$p->ethics->flag}}</p>
                </li>
                <li><strong>Mitigation Action :</strong> 
                    <p style="padding-left:20px">{{$p->ethics->mitigation}}</p>
                </li>
            </ul>
        
        
            Business partner form and Business partner questionnaire are attached as reference.
        
        
        </p>
        Thanks,<br>
        E&C Team
        
        </div>
</body>
</html>

