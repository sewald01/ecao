#!/usr/local/bin/php

<?php 
require("/home/content/48/7686848/html/includes/bv-library.php");

printHeader("E-Mail a friend about Cry the Beloved Mind"); 

if($submission == "") { 



echo <<<EOD
<h2 align="center">Suggest This Book To A Friend</h2>
<p>If you like this site or the book, please alert a friend. Of course, please ensure that your e-mail is legitimate and appropriate (this is monitored and can be traced). If you would like to send a more <a href="http://brainvoyage.com/ctbm/emailfriend.php">compact e-mail, click here.</a></p>

<form method=post action="/ctbm/emailfriend_long.php">
<table border=0 cellpadding=2 cellspacing=3>
<tr>
	<td align="right">Name of Recipient:</td>
	<td align="left"><input TYPE="text" NAME="name" SIZE="35" MAXLENGTH="40" class="inputsmall"></td>
</tr>
<tr>
	<td align="right">E-mail of Recipient:</td>
	<td align="left"><input TYPE="text" NAME="email" SIZE="35" MAXLENGTH="40" class="inputsmall"></td>
</tr>
<tr>
	<td align="right">Your Name:</td>
	<td align="left"><input TYPE="text" NAME="sender" SIZE="35" MAXLENGTH="40" class="inputsmall"></td>
</tr>
<tr>
	<td align="right">Your E-mail:</td>
	<td align="left"><input TYPE="text" NAME="senderemail" SIZE="35" MAXLENGTH="40" class="inputsmall"></td>
</tr>
<tr><td height="2" colspan="2"> &nbsp; </td></tr>
<tr>
    <td bgcolor="#E6EEFB" colspan="2">
<p><strong>This is the copy of email that will be forwarded to your friend:</strong>
<hr width="62%" align="left"></p>
<p>This e-mail is about a book "<i>Cry the Beloved Mind: A Voyage of Hope</i>" which you may find valuable. Certainly, it has had outstanding recommendations from readers and excellent reviews. This book is written in a new literary style so as to intrigue general readers and yet at the same time teach them about brain medications and social, medical and ethical dilemmas. The book is written so effectively that the reader almost feels that trade secrets in medicine are being whispered. There is a comprehensive website devoted to it at http://www.brainvoyage.com.</p>

<p>"<i>Cry the Beloved Mind: A Voyage of Hope</i>" is Dr Vernon Neppe's latest book for the general reader, patients, family members, students and colleagues in the various medical and related disciplines. The page http://www.brainvoyage.com/ctbm contains excerpts from the book, an interview with the author, a press release, information for the media, biographies and summaries of the book, and extensive comments by others on the book.</p>

<p>The information I gleaned is as follows.<br>
"<i>Cry the Beloved Mind: A Voyage of Hope</i>" aims to educate by fascinating the reader --- an excellent read, all the while learning information. The author is Vernon Neppe MD, PhD, an expert in the field of Neuropsychiatry and Psychopharmacology and guides us through the intriguing myriad of brain medications, psychiatry and neurology using an entirely new literary device "sciction" --- science through fiction. The style of writing is a "play within prose," using dialogue between doctor and patient, and doctor and medical student and focusing on different difficult cases which are composites of patients that have been treated. Dr Neppe discusses brain medications in a detail comprehensible to the general reader, patient and family member, and yet apparently at an educational enough level for even medical doctors to benefit. He stimulates interest even more by the use of delectable "spices" like "what is normality?," "is there a meaning to life?" and more pragmatic issues like "should I use generic drugs," "what hope does one give the suicidal patient." We learn about explosions in the brain, problems with herbal remedies, drug interactions, the newest advances in antidepressant therapy and Dr Neppe's own discoveries in brain medicine, in the most effective manner of reading a compelling tale all the while learning science. Amongst the endorsements are very positive comments by other notable authors, reviewers, colleagues as well as the general public.</p>

<p>The website also contains places to order the book in one of two rather unique forms:
<br>Imagine buying an author AUTOGRAPHED copy over the internet at a $1 reduction. Dr Neppe has even undertaken for a small amount more to personally message the book. These collector's first edition bound copies of this book can be obtained only through this site at http://www.brainvoyage.com/order. The cost is \$22.95 (A special time-limited \$1 off discount actually makes it \$21.95 per copy) plus shipping. Significant further discounts exist for 5 or more copies. You can order this through an internet secured server or fill out an order form and mail or fax it or fill in everything but credit card information on the secured server and phone it in.</p>

<p>Equally innovative is buying an INTERNET version --- This is apparently the first book being downloaded through the most well-known and largest software companies. An electronic internet version of "Cry the Beloved Mind: A Voyage of Hope" is also available only through http://www.brainvoyage.com/order at \$18.95 (originally $19.95, however, at this time we are offering a $1.00 off!). This electronic book has the advantage of being able to <i>search rapidly</i> for particular words or terms, as well as being immediately available to anyone in the world. This is particularly useful for people outside the USA where the book may not be easily available. This version will be downloaded from one of the leading sites on the internet that specialize in software downloads. http://www.brainquestpress.com/digital/index.html
will take you there. The version requires the free Adobe Acrobat Reader to read the PDF file and this can be easily downloaded if necessary. The combination bound book and the electronic (eBook) version is available at a further \$5 discount.</p>

<p>I hope you have found this information useful.</p>


    </td>
</tr>
<tr><td height="2" colspan="2"> &nbsp; </td></tr>
<tr>
	<td align="right" valign="top">Add a Personal Message (Optional):</td>
	<td align="left" valign="top"><TEXTAREA name="optionalmsg" rows="5" wrap=virtual cols="45" class="inputsmall">You may want to check out this website http://www.brainvoyage.com and a very interesting book: more details below.</TEXTAREA></td>
</tr>
<tr>
<tr>
	<td> &nbsp; </td>
	<td align="left">
	    <input type="hidden" name="submission" value="1"> 
		<input type="submit" value="Send Mail" class="inputsmall"> 
	</td>
</tr>
</table>
</form>

<p><em>Note: We have encoded this page and can trace any spammers or those who illegally abuse this page.</em></p>

EOD;

} else {
echo "
<h3 class=\"title\" align=\"center\">An e-mail message was sent. Thank you for your interest!</h3>
<li><a href=\"http://www.brainvoyage.com/ctbm/emailfriend_long.php\">E-mail another friend</a></li>
<li><a href=\"http://www.brainvoyage.com\">Return to Main</a></li><br><br><hr width=90%>
";

$message = <<<EOD

Hello $name,

$optionalmsg

- - - -
This e-mail is about a book "Cry the Beloved Mind: A Voyage of Hope" which you may find valuable. 
Certainly, it has had outstanding recommendations from readers and excellent reviews. This book is 
written in a new literary style so as to intrigue general readers and yet at the same time teach 
them about brain medications and social, medical and ethical dilemmas. The book is written so 
effectively that the reader almost feels that trade secrets in medicine are being whispered. There 
is a comprehensive website devoted to it at http://www.brainvoyage.com.

"Cry the Beloved Mind: A Voyage of Hope" is Dr Vernon Neppe's latest book for the general reader, 
patients, family members, students and colleagues in the various medical and related disciplines. 
The page http://www.brainvoyage.com/ctbm contains excerpts from the book, an interview with the 
author, a press release, information for the media, biographies and summaries of the book, and 
extensive comments by others on the book.

The information I gleaned is as follows.
Cry the Beloved Mind: A Voyage of Hope aims to educate by fascinatingthe reader --- an excellent 
read, all the while learning information. The author is Vernon Neppe MD, PhD, an expert in the 
field of Neuropsychiatry and Psychopharmacology and guides us through the intriguing myriad of 
brain medications, psychiatry and neurology using an entirely new literary device "sciction" --- 
science through fiction. The style of writing is a "play within prose," using dialogue between 
doctor and patient, and doctor and medical student and focusing on different difficult cases which 
are composites of patients that have been treated. Dr Neppe discusses brain medications in a detail 
comprehensible to the general reader, patient and family member, and yet apparently at an educational 
enough level for even medical doctors to benefit. He stimulates interest even more by the use of 
delectable "spices" like "what is normality?," "is there a meaning to life?" and more pragmatic 
issues like "should I use generic drugs," "what hope does one give the suicidal patient." We learn 
about explosions in the brain, problems with herbal remedies, drug interactions, the newest advances 
in antidepressant therapy and Dr Neppe's own discoveries in brain medicine, in the most effective 
manner of reading a compelling tale all the while learning science. Amongst the endorsements are 
very positive comments by other notable authors, reviewers, colleagues as well as the general public.

The website also contains places to order the book in one of two rather unique forms: 
Imagine buying an author AUTOGRAPHED copy over the internet at a $1 reduction. Dr Neppe has even 
undertaken for a small amount more to personally message the book. These collector's first edition 
bound copies of this book can be obtained only through this site at http://www.brainvoyage.com/order. 
The cost is $22.95 (A special time-limited $1 off discount actually makes it $21.95 per copy) plus 
shipping. Significant further discounts exist for 5 or more copies. You can order this through an 
internet secured server or fill out an order form and mail or fax it or fill in everything but credit 
card information on the secured server and phone it in.

Equally innovative is buying an INTERNET version --- This is apparently the first book being 
downloaded through the most well-known and largest software companies. An electronic internet version 
of "Cry the Beloved Mind: A Voyage of Hope" is also available only through http://www.brainvoyage.com/order 
at \$17.95. This electronic book has the advantage of being able to search rapidly for particular words 
or terms, as well as being immediately available to anyone in the world. This is particularly useful for 
people outside the USA where the book may not be easily available. This version will be downloaded from 
one of the leading sites on the internet that specialize in software downloads. 
http://www.brainvoyage.com/order/ will take you there. The version requires the free Adobe Acrobat Reader 
to read the PDF file and this can easily downloaded if necessary. The combination bound book / electronic 
version is available at a further \$5 discount.

I hope you have found this information useful.

With my best wishes,
$sender

*Note: This message was sent by $sender ($senderemail) from www.brainvoyage.com.


EOD;

$x = mail($email, "$sender wants you to see the book Cry the Beloved Mind",$message, "From: $senderemail\nReply-To: $senderemail\nbcc: psyche@pni.org");

}



<script type="text/javascript">
<!--
window.onload=openmenu('menu1');
//-->
</script>


printFooter(); 

?>