#!/usr/bin/env python

import bottle
import json
from time import sleep
import hashlib
import os

sessions = {}
app = application = bottle.Bottle()

with open('users.json', 'r') as user_json:
    all_people = json.load(user_json)


class User():
    def __init__(self, uname, admin="False", flag=""):
        self.uname = uname
        self.admin = admin
        self.flag = flag

    def to_dict(self):
        return {'uname': self.uname, 'flag': self.flag}

//NB. The GET request will be done to https://web site/token/flag
//The token is the one that is evaluated at the beginning of the login function, so before doing the 
//request I will have to find a way to obtain the same encoded token.

@bottle.get('/<token:re:[a-fA-F0-9]{64}>/flag')
def get_person(token):
    try:
        if token in sessions and sessions[token].admin:
            content = sessions[token]
            del sessions[token]
            return json.dumps(
                {'flag': all_people[content.to_dict()['uname']]['flag']})
        else:
            return bottle.abort(403)
    except IndexError:
        return bottle.abort(403)

//Here is the vulnerability: 
//after the token creation, if an active session with the same token doesn't exists, the code will sleep for 3 sec mantaining the login 
//and letting the user do other requests. 
//It is also in this function that I find the type of encode that must be done in orther to obtain the corret token
@bottle.post('/login')
def login():
    new_session = bottle.request.json
    uname = new_session['uname']
    password = new_session['password']
    token = hashlib.sha256(new_session['uname'] + new_session['password']).hexdigest()

    if token in sessions:
        return bottle.abort(400)  # bad request!

    # let's create a temporary session
    sessions[token] = User(uname)

    sleep(3)  # we don't want any bruteforce of the passwords, do we?

    if all_people[uname]['password'] == password:
        sessions[token] = User(uname, all_people[uname]['admin'], all_people[uname]['flag'])
        return json.dumps(sessions[token])
    else:
        if token in sessions:
            del sessions[token]

bottle.run(server='cherrypy', host='0.0.0.0', port=8080)