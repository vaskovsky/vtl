# Scalability

The web application has two parts: front-end and backend,
which can be located on different servers.

The backend server hosts PHP files,
which deliver data for the web application.

One or more front-end servers can access a single backend server.

The front-end server hosts static HTML files and script `api.js`.
This allows
* change the design of the application without knowledge of JavaScript, PHP and other technologies,
* cache front-end on client,
* use CDN to load the frontend faster from anywhere in the world.

Default, front-end looks for backend on the same server, in the same directory,
but you can specify a different location by using the element

```
<link id="server" href="https://vaskovsky.net/vtl/sample/en/" rel="preconnect"/>
```
________________________________________________________________________________
