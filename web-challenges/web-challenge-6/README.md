<h1>Challenge 6</h1>
<h2>Request</h2>
Can you politely convince this API https://web6.it/ to give you the flag of the user semitone?

<h2>Solution</h2>
By analysing the code it is possible to see that:
<ul>
  <li> There are two possible request: the first one is a POST request for the login and 
  the second one is a GET request which retrieve the flag.</li>
  <li> The login function generete an active and  acceptable token, encoded via SHA256, for 3 seconds.</li>
  <li> It is possible to do a valid GET request while the login is sleeping, in fact during this small 
  lapse of time the given user han an active token. </li>
</ul>

In order to solve this challenge it is necessary to
<ul>
  <li> evaluete the token by encoding the concatenation of username and password; </li>
  <li> open the terminal; </li>
  <li> write on the browser bar the following url: <em>"https://web page/token evaluated before/flag"</em>; </li>
  <li> write in the terminal the command in ubuntu_login_command.sh </li>
</ul>
As soon as the POST request is launched, reload the web page; in this way the solution will appear.<br> 
<strong>REMEMBER:</strong> be fast in reloading! There are just 3 seconds!

<h3>Some notes</h3>
<ul>
<li> The link written into the request is an example and not the real one associated to the challenge.</li>
</ul>


