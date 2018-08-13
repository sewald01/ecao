#!/usr/bin/perl

# Ray Eads (coylh@eskimo.com) 1997

require '/home/content/48/7686848/html/_PNI/lib/cgi-lib.pl';

$REFERRER = "http://www.pni.org/ispe/";

$WEB_DIR = "/home/content/48/7686848/html/_PNI/";

#$SENDMAIL = "/usr/sbin/sendmail -f access\@pni.org";

###################################################################
# Caution to those who change code below this line.               #
# I am not a programmer, and your assumptions about               #
# what I have done will hurt you.                                 #
###################################################################

$LOG_FILE = $WEB_DIR . ".access_request_ispe.log";
#$LOCK_FILE = $WEB_DIR . "/tmp/access.log.lock";
#$MESSAGE_FILE = $WEB_DIR . "/tmp/tmp_access_message";

&ReadParse;

$email = $in{'email'};
$name = $in{'name'};

@keys = keys %in;

print "Content-type: text/html\n\n";

#print "$LOCK_FILE, $MESSAGE_FILE";

# Is the request formatted properly?
if ( not $email or not $email =~ /\w+?\@\w+?\.\w+?/ or $email =~ /;/ or length($email) > 100 or not $name or length($name) > 100 or length($name) < 1)
{
  print <<"EOQ";
<HTML>
<HEAD>
<TITLE>Message Incomplete</TITLE>
<META HTTP-EQUIV="refresh" CONTENT="5; URL=$REFERRER">
<LINK REL="stylesheet" TYPE="text/css" HREF="/.styles/main.css">
</HEAD>

<BODY BGCOLOR="white">
<ILAYER SRC="/.clip/top.html"></ILAYER>
<H1>Message Incomplete</H1>
$email
<P>Please fill out the entire form.</P>
<ILAYER SRC="/.clip/bottom.html"></ILAYER>
</BODY>
</HTML>
EOQ

  exit -1;
}

# Check for lock file.
#while ( -e $LOCK_FILE )
#{
#  if ( $i > 3)
#  {
#    if ($DEBUG eq "on")
#    {
#      print "DEBUG: Waited too long for lock file.\n";
#    }
#    unlink $LOCK_FILE;
#    last;
#  }
#  $i++;
#  sleep 1;
#}
 
# Create lock file
#open FLOCK_FILE, ">$LOCK_FILE";
#print FLOCK_FILE localtime();
#close FLOCK_FILE;

# Has this email address requested a password before?

open LOG_FILE, "$LOG_FILE" or die "Error: Can't open $LOG_FILE\n";

while(<LOG_FILE>)
{
  if(m/$email/i)
  {
        print "<HTML>\n";
        print "<HEAD>\n";
        print "<TITLE>Access Denied</TITLE>\n";
        print "<META HTTP-EQUIV=\"refresh\" CONTENT=\"5; URL=http://www.pni.org/ispe/\">\n";
        print "<BODY BGCOLOR=\"white\">\n";
        print "<IMG SRC=\"http://www.pni.org/.pictures/pni_banner_small.jpg\">\n";
        print "<HR>\n";
        print "<H1>Access Denied</H1>\n";
        print "<P>The password has already been sent to that address.</P>\n";
        print "<HR>\n";
        print "<A HREF=\"http://www.pni.org/ispe/\"><IMG SRC=\"http://www.pni.org/.pictures/arrow_back_t_28x22.gif\" BORDER=0 ALT=\"BACK\"></A>\n";
        print "</BODY>\n";
        print "</HTML>\n";
        close LOG_FILE;
        exit -1;
  }
}

open LOG_FILE, ">>$LOG_FILE" or die "Error: Can't open $LOG_FILE\n";

print LOG_FILE "$email:$name\n";
close LOG_FILE;

# Remove lock file.
#unlink $LOG_FILE;
 
open ACCESS_PASSWORD, "/$WEB_DIR/ispe/neppe/.access_password" or die "Error: Can't open neppe.\n";
$p = <ACCESS_PASSWORD>;
chomp $p;
@pass = split /:/, $p;

#open MESSAGE_FILE, ">$MESSAGE_FILE" or die "Error: Can't open $MESSAGE_FILE.\n";
open(MAIL, "| /usr/sbin/sendmail -n -oi -t");
print MAIL <<"EOQ";
From: access\@pni.org
To: $email
Bcc: lv\@pni.org
Subject: Your request for ISPE\n\n

Thank you for your interest the ISPE of Vernon M
Neppe, MD, PhD.
We attach for you the password required to obtain it from the internet.
Please go to http\:\/\/www.pni.org\/ispe\/.
In the second line you should see a link to \"Dr. Neppe\'s ISPE\".
Please click on that link and a box will pop up.
Please record the following all in upper case. 
Name: $pass[0]\nPassword: $pass[1]\n\n
Putting in this information and clicking return will allow you access
to the ISPE.
If you want to download the ISPE from the internet, the following may be useful:
On Netscape, simply go to the File menu and press send page. You will receive an EMail attachment.
On Explorer or other browser \(including Netscape if this method is preferred\), at the file menu,
Save As and place in the appropriate folder in your hard drive.
Please note that the password you have been given is current but may
change at any time.
For security, it should not be given to anyone else except with PNI\'s
E-Mailed consent.
Thank you for your interest

With our best wishes,
Customer Service.
Pacific Neuropsychiatric Institute.
EOQ

#close MESSAGE_FILE;
#system "$SENDMAIL $email < $MESSAGE_FILE";
#unlink $MESSAGE_FILE;

print <<"EOQ";
<HTML>
<HEAD>
<TITLE>Message Sent</TITLE>
<META HTTP-EQUIV="refresh" CONTENT="5; URL=$REFERRER">
<LINK REL="stylesheet" TYPE="text/css" HREF="/.styles/main.css">
</HEAD>
<BODY BGCOLOR="white">
<ILAYER SRC="/.clip/top.html"></ILAYER>
<H1>Message Sent</H1>
<P>Thank you!</P>
<ILAYER SRC="/.clip/bottom.html"></ILAYER>
</BODY>
</HTML>
EOQ

exit 0;
