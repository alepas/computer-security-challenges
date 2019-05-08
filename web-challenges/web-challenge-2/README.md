<h1>Challenge 2</h1>
<h2>Request</h2>
This is a simple and super-secure website that allows you just to register and login: https://web2.it/code_challenge.php.<br>
Can you get the credit card number of the user Douglas? <br>
Note that you do not necessarily need to log in as Douglas to accomplish this.

<h2>Solution</h2>
Since the beginning it is clear that the vulnerable operation is the registration one because the SQL query asscoaited to
the login is in some way locked.<br>
By analyzing the code it is also possible to see that there are some filters on strings that can be insert into the 2 input fields.
Between those unaccepted words there are also <em>union</em>, <em>=</em> and <em>' or '</em> and so it is not possible to go
for the easiest way which would make me put into the username field something like:<br>
<ul>
  <li>' OR (SELECT ccnumber FROM credit_card WHERE username='Douglas')";#</li>
  <li>random name' UNION (SELECT ccnumber FROM credit_card WHERE username='Douglas')";# </li>
</ul>

The two solutions written above wouldn't be accepted because of the filtered strings that they contain.<br>

Going deeper into the register_user function it is possible to find that:
<ul>
  <li> there are 2 queries: the first one is a SELECT which checks if the selected username is already into the db, 
  the second one is an INSERT which inserts the tuple (username, password) into the db.</li>
  <li> there are no further checks on what is insert, so the only control done is given by the filter function</li>
  <li> the only case in which the username is printed is when there already exist an other user with the same username
  into the DB</li>
</ul>

The objective is to correctely register a user containing the credit card number of Douglas and then retrieve it by trying
to register a second user with the same username.<br>
In order to achieve the goal it is necessary to follow the next few steps:
<ul>
  <li> use the INSERT query to add in the DB 2 new users, the second tuple has a username formed by the concat of a random string
  and the ccnumber obtained via a SELECT request. <br>
  The input fields will be filled as in the example: <br>
  <strong>username</strong>: random username<br>
  <strong>password</strong>: random password'),((SELECT concat('random name',ccnumber) FROM credit_card WHERE username LIKE 'Douglas%'),'password2')
  
  NB. Because of the fact that it is not allowed to use <em>=</em> it can be replace by the LIKE. </li>
  <li> press the Registation button, if everything has been written in a correct way, the 2 new users will be succesfully
  add to the DB</li>
  <li> do a second registation in which the username is equal to the concat registered before:
  In order to correctly fill the SQL request it is necessary to do the or between a random possible username and
  the desidered one, but the <em>or</em> is a not allowed string. To bypass the filter is is foundametal 
  to notice that the string that is actually replaced isn't <em>or</em> but it's the or sourrounded by 2 spaces.<br>
  Because of this it is possible to avoid the replace of this string by writing <strong>/*'*/OR/*'*/</strong>. The comments
  before and after the or changes the string format and let it to be read.<br>
  The input fields will be filled as in the example: <br>
  <strong>username</string>: random name'/*'*/OR/*'*/ username LIKE (SELECT concat('random name',ccnumber) FROM credit_card WHERE username LIKE 'Douglas%')';# <br>
  <strong>password</strong>: random password </li>
  <li> press the Registation button</li>
</ul>
The error allert will tell the username given by the concatenation and so it will retrieve the information we are looking for.
  
  

  