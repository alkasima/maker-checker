<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contac Form</title>
</head>
<body>
    <p>Your are requested to make changes of the user with the following details</p> 
    <h1>Request  Details</h1>
    <p>Request Type: {{$details['request_type']}}</p>
    <p>Request Status: {{$details['request_status']}}</p>
    <p>First Name: {{$details['first_name']}}</p>
    <p>Last Name: {{$details['last_name']}}</p>
    <p>Email: {{$details['email']}}</p>    
</body>
</html>