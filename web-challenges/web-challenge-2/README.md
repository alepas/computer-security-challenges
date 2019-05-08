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
  and the ccnumber obtained via a SELECt request. <br>
  The input fields will be filled as in the example: <br>
  <strong>username</strong>: random username<br>
  <strong>password</strong>: random password'),((SELECT concat(‘nome’,ccnumber) FROM credit_card WHERE username LIKE ‘tuoNome’),’password2’)
  
  NB. Because of the fact that it is not allowed to use <em>=</em> it can be replace by the LIKE. 
