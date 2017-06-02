# Localhost Site List
## Background
I'm lazy so I don't clear out my localhost after a project. This means I have loads of self-sufficient 'sites' that are at addresses like `localhost/sites/attitude` and `localhost/sites/rofwell.github.io`. Obviously, this is annoying and the only way I can see all of them is by going to `localhost/sites/` and browsing the file directory - and the default Apache file directory system is not very user friendly, so I thought 'why not make my own site list'.
## Overview
This site list uses PHP to grab a list of all directories inside `localhost/sites/` and reads an `about.json` file in each directory. Based on this information it displays a set of sites.
