<?php

return [
    //Select for local and Azure Authentic ation

    'authentication'=>env('AUTHENTICATION','azure'),
    //Validaty for a Business partner Registration Link (in Days)
    'registration_validity'=>10,

    //Validaty for a Business partner Approval in months
    'partner_validity'=>24,

    //Python file Location
    'python_search_location'=>env('python'),

    //Partner Renewal Expiration in days (Intital 90 days as per procedure)
    'renewal_expiry'=>90,

    //Account notification to common mail ID

    'accounts_notification'=>env('ACCOUNT_NOTIFICATION',False),

];
