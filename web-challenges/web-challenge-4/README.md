<h1> Challenge 4</h1>
<h2> Request </h2>
Our network administrators just updated their super-insecure password checker: https://web4.it/code_challenge.php. Can you use it to exfiltrate their session cookie again?<br>
To validate your solution, please submit an URL belonging to the domain web4.it, which, when opened in a browser:
<ul>
  <li><strong>retrieves the value of the cookie <em>secret</em></strong>, which is already present in the cookie jar of the browser that will visit 
your URL (note that this cookie doesn’t have the HTTPOnly flag)</li>
  <li> submits it through a GET request to https://url/[cookie], where [cookie] is the value of the cookie secret</li>
</ul>
For example, if document.cookie is secret=th1s1ssupersecret, your payload must perform a GET request to: https://url/th1s1ssupersecret.

<h2>Solution</h2>
This challenge is similar to <em>Challenge 3</em>, but it is a bit more complex
because it contains a filter function which doesn't allow to write the script 
tag; the input tags containing onload or onerror attributes; the img tag and some
chars such as %. <br>
The way to proceed, and the idea behind this challenge is exactly the same 
of the third one, the only difference is given by the used script that can 
be found in script.js file.

<h3>Some notes</h3>
<ul>
  <li> The link written into the request is an example and not the 
  real one associated to the challenge.</li>
</ul>