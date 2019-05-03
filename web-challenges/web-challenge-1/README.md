<h1>Challenge 1</h1>
<h2>Request</h2>
I need to gain access to https://web1.it/web-challenge-1.php as user <strong>Sebastian</strong>.

<h2>Solution</h2>
This challenge can be solved via SQL injection.<br>
I have both the <string>username</string>, Sebastian, and the <string>SQL request</string>, 
so I just have to find a way to bypass the password insertion in order to login.<br>
By analysing the code it is possible to see that:
<ul>
  <li> There is a function, called get_value, that decode in base64 every string that has been insert into the login form. This is
  a good hint, in fact both username and password will have to be insert encoded in base64.</li>
  <li> In login function there's the following SQL request <em>"SELECT user_id FROM users WHERE 
  username='$username' and password='$password'"</em>. This is the vulnerable point, by knowing how the request is done to the DB
  it is possible to put correct SQL into the input fields in order to modify it. </li>
  <li> The secret I'm searching is strictly related to the username Sebastian, so the username input field will just have to 
  contain the name encoded in base64.</li>
  <li> Because of the fact that I don't have the password, I will have to put an SQL string, such as <em>'OR'1'='1</em>, that
  will make the second part of the SQL query always true.</li>
</ul>

All the observations made above make easy to reach the following solution:<br>
<strong>username</strong> : U2ViYXN0aWFu  (Sebastian written in base64)<br>
<strong>password</strong> : J09SJzEnPScx  ('OR'1'='1 written in base64) <br>


<h3>Little comment </h3>
The link written into the request is an example and not the real one associated to the challenge.
