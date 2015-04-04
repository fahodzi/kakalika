Kakalika Issue Tracker
======================

The goal behind kakalika is to provide an issue managment tool that is easy to setup, easy to
administer and easy to use. It is meant to be that kind of tool that anyone can
figure out in just a few clicks. 

Since kakalika is currently in its infancy and is obviously quite far from 
what it is actually supposed to be. It still however, packs a little punch. 
For now you can: 
- Log your issues (that's why its an issue tracker).
- Give your issues statuses with our simple built in workflow.
- Categorize all your issues with our built in issue statuses.
- Comment on issues and keep track of the history of all comments.
- Track your projects with milestones.
- Categorize issues by components to which they belong in your project.
- Create and comment on issues over email.

Installing Kakalika
-------------------
There are two primary ways of installing kakalika. You could either use the 
release archive or you could checkout the source code and configure it yourself.
Using the release archive is recommended for server environments and checking
out the code is recommended for tinkerers and hackers.

### Requirements

- Apache web server
- PHP 5.3+
- MySQL server 5+ or PostgreSQL
- `mod_rewrite` and `.htaccess` enabled

### Installing from the Release Archive

1. Download and extract the release archive to the document root of your apache
   web server.
   
2. Create a blank database on your preferred database server (mysql or postgresql) 
   to hold the data.

3. Point browser to `/install` and follow the steps on the browser. 

4. Alternatively, you can execute `install/run` on the command line. If you choose
   the command line option ensure you run the script as the web server's user 
   to ensure that file permissions are properly set.

### Checking Out the Code
1. Clone the source repository `git clone https://github.com/ekowabaka/kakalika.git`
2. Change directory into the newly cloned kakalika directory and execute `composer install`
3. Create the following directories in the new kakalika directory:
    - `cache`
    - `public/js`
    - `public/css`
    - `public/images`
    - `config`
4. Execute `install/run` from the command line or point your browser to `/install`.

### Post Installation Steps
After installation completes successfuly:

1. Delete the `install` directory or make it inaccesible to the web server
2. Protect the `config` directory and make it read only
3. Point your browser to the document root and enjoy Kakalika


Contributing
------------
If you wish to help on this project feel free to fork the code and
send in pull requests.

LICENSE
-------
Copyright (c) 2008-2013 James Ekow Abaka Ainooson

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
"Software"), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

