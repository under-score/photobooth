# photobooth

osx only, sorry
`brew upgrade gphoto2`  
set camera mode to RAW and small BASIC and run from terminal
`~/photobooth/binary/gphoto2 --auto-detect`  
`~/photobooth/binary/gphoto2 --set-config capturetarget=1`  
start webserver
`sudo php -S 0.0.0.0:80 -t ~/photobooth/Server`  
copy this app to ~/photobooth  
point your browser to http://localhost
move around with cursor keys, shoot with spacebar, click pic iconfor fullscreen, starring, editing, deleting

![screenshot](screenshot.jpg "overview. ...")

