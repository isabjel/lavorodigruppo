<!DOCTYPE html>
<HTML>
<HEAD>
<TITLE>Prova di file php</TITLE>
<BODY>
<?php
$OGGI = "18.12.2023";
print "<B>Salve mondo $OGGI</B>";
$v[0] = 1; $v[1] = 'secondo';
print "<BR/>Ho trovato: " . count($v) . " dati in $v \$v";
print "<BR>$v[1]<BR/>";
print var_dump($v[1]);

if (count($v)==2) {
	print "<P>Sono due</P>";
} 
else {
	print "<P>NON sono due</P>";
}

for ($k=0; $k < count($v); $k++) {
	print "EURO <I>$v[$k]</I><BR><BR>";
}
print $_SERVER;
for ($k=0; $k < count($_SERVER); $k++) {
	print "$k) $_SERVER[$k] <BR/>";
}
print $_SERVER[SERVER_NAME];
?>
</BODY>
</HTML>

