<h1>Challenge 5</h1>
<h2>Request</h2>
As we are approaching the last challenge, we have a feedback form for you: https://web5.it/. 
Can you trick who reads the messages into sending us his session cookie?<br>

To validate your solution, please submit an URL belonging to the domain web5.chall.necst.it, which, when opened in a browser:
<ul>
  <li><strong>retrieves the value of cookie <em>xsdmfs</em></strong>, which is is already present in the cookie jar of the browser that will 
  visit your URL (the developers were sloppy, and this cookie is not HTTPOnly). Pay attention to the fact that there 
  are multiple cookies in the cookie jar: you need to submit only the value of <em>xsdmfs</em>!</li>
  <li>submits it through a GET request to https://url/[cookie], where [cookie] is the value of the cookie xsdmfs</li>
</ul>
For example, if document.cookie is xsdmfs=th1s1ssupersecret, your payload must perform a GET request to:
https://url/th1s1ssupersecret.

<h2>Solution</h2>
This challenge can be solved via XSS (Cross-site Scripting).<br>
The solution involves the same script used for challenge 3, but the way it is used is different.
In this case it is required to insert it has a .js file in the attachment field and than it is necessary
to read it via an HTML command.<br>
To solve this challenge the following passages must be done:
<ul>
  <li> Create a .js file containing the script </li>
  <li> Open the web page and insert in the 1st three fields random stuffs and in the
  attchment the created .js</li> 
  <li>Once the Submit button has been pressed, the report data will be shown in a sort of summary. By analysing the code 
  it is possible to see that, in order to read the attachment, it is required the id associated to the created report . This id
  is shown in the browser bar. <br> Copy it.</li>
  <li> In order to read the attchment, a new reposrt must be submitted. Insert in the 1st two fields
  random stuffs, do not insert any attchment and insert into the Message field the js command that can be found in the 
  message.js file. This script will contain also the url copied before.</li>
  <li> Because of the fact that the page retrieve an error and that the goal is to get the url, it is necessary to preserve the log 
  in order to reach it.<br> The solution will be the url in the log above the 403 error.</li>
</ul>

<h3>Little notes</li>
<ul>
<li> The link written into the request is an example and not the real one associated to the challenge.</li>
</ul>