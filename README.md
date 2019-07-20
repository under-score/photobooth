# photobooth

osx only, sorry, run  
`brew upgrade gphoto2`  
set camera mode to RAW and small BASIC and run  
`~/photobooth/binary/gphoto2 --auto-detect`  
`~/photobooth/binary/gphoto2 --set-config capturetarget=1`  
start webserver
`sudo php -S 0.0.0.0:80 -t ~/photobooth/Server`  
copy this app to ~/photobooth  
point your browser to http://localhost
move around with cursor keys & shoot with spacebar  
click picture icons for full screen, starring, deleting ...

![screenshot](screenshot.jpg "overview. ...")  

i edit with https://viliusle.github.io/miniPaint 
