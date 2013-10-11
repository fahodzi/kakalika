Kakalika Issue Tracker
======================

![Screenshot](http://ekowabaka.me/kakalika/screen.png)

The goal behind kakalika is to provide an issue managment tool that is easy to setup, easy to
administer and easy to use. It is meant to be that kind of tool that anyone can
figure out in just a few clicks. 

Although kakalika is currently in its infancy and is obviously quite far from 
what it is actually supposed to be, it still packs a little punch. For now you
can: 
- Log your issues (that's why its an issue tracker)
- Give your issues statuses with our simple built in workflow
- Categorize all your issues with our built in categories
- Comment on issues and keep track of all the history of comments

Installing Kakalika
-------------------

### Requirements

- Apache web server
- PHP 5.3+
- MySQL server 5+
- mysqli extension for PHP
- `mod_rewrite` and `.htaccess` enabled

### Setting up

1. Download and extract release to your document root. If you however clone the git repository 
   instead of installing then initialize and update all submodules before proceeding 
   with the installation.
2. Ensure that the following directories exist and are writable by the web server:
   - `cache`
   - `public/js`
   - `public/css`
   - `public/images`
   - `config`
3. Create a blank database on your mysql server to hold the data

4. Point browser to `/install` and follow the steps on the browser. 
   You can also execute `install/run` on the command line. If you choose
   the command line option ensure you run as the web server's user so that
   permissions are properly checked.

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





