<h1>Challenge 3</h1>

<h2>Request</h2>
Our network administrators use a super-insecure password checker: <em>https://web3.it/code_challenge.php</em>. Knowing that the administrators will visit any URL you send to them, can you exploit a vulnerability to exfiltrate their session cookie? <br>
Your solution will be checked with an automated grader. To validate your solution, please submit an URL belonging to the domain web3.it, which, when opened in a browser:
<ul>
  <li><strong>retrieves the value of the cookie <em>secret</em></strong>, which is already present in the cookie jar of the browser that will visit your URL (note that this cookie doesn't have the HTTPOnly flag)</li>
  <li> submits it through a GET request to https://url/[cookie], where [cookie] is the value of the cookie secret.</li>
</ul>
For example, if document.cookie is secret=th1s1ssupersecret, your payload must perform a GET request to: https://url/th1s1ssupersecret.

<h2>Solution</h2>
This challenge can be solved via XSS (Cross-site Scripting). <br>
Because of the fact that the password checker is super-insecure it is possible
to inject any js script in order to retrieve the cookie that must be steal.<br>
The injected script is formed by a function that select the desidered cookie,
in this case the cookie called <em>secret</em>, and by a location.ref jQuery 
that has the aim to GET it.

<h3>Some notes</h3>
<ul>
  <li> The link written into the request is an example and not the real one associated to the challenge.</li>
  <li> The challenge's goal is to obtained the url containing the GET 
  request, so, in order to reach it, I have first turned off internet before submitting and, only after, 
  I have submitted the script. In this way I had on the browser bar the 
  desidered url.<br></li>
  <li>The solution code can be found in a .js file; please note that in order to run in the
  password field it should be put into script tag.</li>
<ul>
