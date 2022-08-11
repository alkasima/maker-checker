# maker-checker
 
Maker Checker is a laravel 8 api the system resolves around the idea that for any change to be made to user information by an administrator, it must be approved by a fellow administrator in order to take effect; and if the request is declined, the change isn't persisted.

The system is using laravel passport authentication.

<H1>API Endpoint Documentation</H1>
<table>
<tr>
<th>S/N</th>
<th>Method</th>
<th>End Point</th>
<th>Description</th>
</tr>

<tr>
<td>1<td>
<td>POST</td>
<td>api/v1/login</td>
<td>send two parameter email and password to generate access token for using the api</td>
</tr> 

<tr>
<td>2<td>
<td>POST</td>
<td>api/v1/register</td>
<td>register to register a new admin by sending first_name, last_name, email, password parameter</td>
</tr> 

<tr>
<td>3<td>
<td>GET</td>
<td>api/v1/users</td>
<td>return all registered users</td>
</tr> 

<tr>
<td>4<td>
<td>POST</td>
<td>api/v1/users/create</td>
<td>To create a new user request</td>
</tr> 


<tr>
<td>5<td>
<td>PUT</td>
<td>api/v1/users/update/id</td>
<td>Update user information by providing user_id</td>
</tr> 


<tr>
<td>6<td>
<td>Delete</td>
<td>api/v1/users/delere/id</td>
<td>Delete user information by providing user_id</td>
</tr> 

<tr>
<td>7<td>
<td>GET</td>
<td>api/v1/users/requested</td>
<td>Get all requested information from database</td>
</tr> 

<tr>
<td>8<td>
<td>Confirm request</td>
<td>/api/v1/users/confirm/</td>
<td>Accept or decline request by sending status parameter with accept or decline</td>
</tr> 



</table>
