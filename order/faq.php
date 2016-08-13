#!/usr/local/bin/php

<? 
require("/home/content/48/7686848/html/includes/bv-library.php");

printHeader("Frequently Asked Questions"); 
?>

<script type="text/javascript">
/* Smooth scrolling
   Changes links that link to other parts of this page to scroll
   smoothly to those links rather than jump to them directly, which
   can be a little disorienting.

   sil, http://www.kryogenix.org/

   v1.0 2003-11-11
   v1.1 2005-06-16 wrap it up in an object
*/

var ss = {
  fixAllLinks: function() {
    // Get a list of all links in the page
    var allLinks = document.getElementsByTagName('a');
    // Walk through the list
    for (var i=0;i<allLinks.length;i++) {
      var lnk = allLinks[i];
      if ((lnk.href && lnk.href.indexOf('#') != -1) && 
          ( (lnk.pathname == location.pathname) ||
	    ('/'+lnk.pathname == location.pathname) ) && 
          (lnk.search == location.search)) {
        // If the link is internal to the page (begins in #)
        // then attach the smoothScroll function as an onclick
        // event handler
        ss.addEvent(lnk,'click',ss.smoothScroll);
      }
    }
  },

  smoothScroll: function(e) {
    // This is an event handler; get the clicked on element,
    // in a cross-browser fashion
    if (window.event) {
      target = window.event.srcElement;
    } else if (e) {
      target = e.target;
    } else return;

    // Make sure that the target is an element, not a text node
    // within an element
    if (target.nodeType == 3) {
      target = target.parentNode;
    }

    // Paranoia; check this is an A tag
    if (target.nodeName.toLowerCase() != 'a') return;

    // Find the <a name> tag corresponding to this href
    // First strip off the hash (first character)
    anchor = target.hash.substr(1);
    // Now loop all A tags until we find one with that name
    var allLinks = document.getElementsByTagName('a');
    var allDivs = document.getElementsByTagName('div');
    var all = [allLinks, allDivs];
    var destinationLink = null;
    for (var j=0; j<all.length; j++) {
      for (var i=0;i<all[j].length;i++) {
        var lnk = all[j][i];
        if (lnk.name && (lnk.name == anchor)) {
          destinationLink = lnk;
          break;
        } else if (lnk.id && (lnk.id == anchor)){
	  destinationLink = lnk;
          break;
	}
      }
    }
    /*
    var allLinks = document.getElementsByTagName('a');
    var destinationLink = null;
    for (var i=0;i<allLinks.length;i++) {
      var lnk = allLinks[i];
      if (lnk.name && (lnk.name == anchor)) {
        destinationLink = lnk;
        break;
      }
    }
    */

    // If we didn't find a destination, give up and let the browser do
    // its thing
    if (!destinationLink) return true;

    // Find the destination's position
    var destx = destinationLink.offsetLeft; 
    var desty = destinationLink.offsetTop;
    var thisNode = destinationLink;
    while (thisNode.offsetParent && 
          (thisNode.offsetParent != document.body)) {
      thisNode = thisNode.offsetParent;
      destx += thisNode.offsetLeft;
      desty += thisNode.offsetTop;
    }
	
	//add div with a "TOP" link and highlight TD
	destinationLink.parentNode.style.backgroundColor = 'yellow';
	
	var d = document.getElementById('toplinkdiv');
	d.setAttribute('style','position:absolute; top:'+(desty-7)+'px;left:240px; display:block;');
	ss.addEvent(d.firstChild,'click',ss.smoothScroll);

    // Stop any current scrolling
    clearInterval(ss.INTERVAL);

    cypos = ss.getCurrentYPos();

    ss_stepsize = parseInt((desty-cypos)/ss.STEPS);
    ss.INTERVAL =
setInterval('ss.scrollWindow('+ss_stepsize+','+desty+',"'+anchor+'")',10);

    // And stop the actual click happening
    if (window.event) {
      window.event.cancelBubble = true;
      window.event.returnValue = false;
    }
    if (e && e.preventDefault && e.stopPropagation) {
      e.preventDefault();
      e.stopPropagation();
    }
  },

  scrollWindow: function(scramount,dest,anchor) {
    wascypos = ss.getCurrentYPos();
    isAbove = (wascypos < dest);
    window.scrollTo(0,wascypos + scramount);
    iscypos = ss.getCurrentYPos();
    isAboveNow = (iscypos < dest);
    if ((isAbove != isAboveNow) || (wascypos == iscypos)) {
      // if we've just scrolled past the destination, or
      // we haven't moved from the last scroll (i.e., we're at the
      // bottom of the page) then scroll exactly to the link
      window.scrollTo(0,dest);
      // cancel the repeating timer
      clearInterval(ss.INTERVAL);
      // and jump to the link directly so the URL's right
      location.hash = anchor;
    }
  },

  getCurrentYPos: function() {
    if (document.body && document.body.scrollTop)
      return document.body.scrollTop;
    if (document.documentElement && document.documentElement.scrollTop)
      return document.documentElement.scrollTop;
    if (window.pageYOffset)
      return window.pageYOffset;
    return 0;
  },

  addEvent: function(elm, evType, fn, useCapture) {
    // addEvent and removeEvent
    // cross-browser event handling for IE5+,  NS6 and Mozilla
    // By Scott Andrew
    if (elm.addEventListener){
      elm.addEventListener(evType, fn, useCapture);
      return true;
    } else if (elm.attachEvent){
      var r = elm.attachEvent("on"+evType, fn);
      return r;
    } else {
      alert("Handler could not be removed");
    }
  } 
}

ss.STEPS = 25;

ss.addEvent(window,"load",ss.fixAllLinks);
</script>
<a name="#top"></a>
<div id="toplinkdiv" style="position:fixed; bottom:13px; left:225px;"><a href="#top">TOP</a></div>
<H1 CLASS="title" align="center">Frequently Asked Questions</H1>
<a href="#A" class="t1">Why buy from Brainvoyage.com?</a><br>
<a href="#A1" class="t2">Can I buy these books anywhere else?</a><br>
<a href="#A2" class="t2">What is the contact information for Brainvoyage.com?</a><br>
<a href="#B" class="t1">Basics on E-Books.</a><br>
<a href="#B1" class="t2">Tell me more about  Electronic Books (E-Books) (Digital Books).</a><br>
<a href="#B2" class="t2">Why did brainvoyage.com choose PDF format for their EBooks?</a><br>
<a href="#B3" class="t2">What was the first electronic book marketed by a major applications download company on the internet?</a><br>
<a href="#B4" class="t2">How do I read the EBook (electronic /digital book)?</a><br>
<a href="#C" class="t1">Downloading my EBooks.</a><br>
<a href="#C1" class="t2">Please assist me with my EBook downloads?</a><br>
<a href="#C2" class="t2">How do I download and install an eBook?</a><br>
<a href="#C3" class="t2">How large are the files for downloading?</a><br>
<a href="#C4" class="t2">What happens after downloading?</a><br>
<a href="#C5" class="t2">How do I download multiple files?</a><br>
<a href="#C6" class="t2">What files do I download for the electronic (digital) book versions by Vernon M Neppe MD, PhD?</a><br>
<a href="#C7" class="t2">But what happens if my Zipped file is corrupted?</a><br>
<a href="#C8" class="t2">I cannot download the EBook (electronic version of the book) as I am disconnected before the download finishes! What should I do?</a><br>
<a href="#C9" class="t2">When do I choose the web download, when the CD?</a><br>
<a href="#C10" class="t2">I ordered  the E- book (electronic book) but how do I get to the download page?</a><br>
<a href="#C10" class="t2">I did not yet download the E- book (electronic book) I ordered. How do I download it?</a><br>
<a href="#C10" class="t2">I followed the steps for purchasing a book and I got a confirmation email but I do not understand how I get the book now. Will it be emailed to me?</a><br />
<a href="#D" class="t1">Compatibility</a><br>
<a href="#D1" class="t2">What operating systems will my eBook run on?</a><br>
<a href="#D2" class="t2">Will the eBook harm my computer?</a><br>
<a href="#D3" class="t2">I cannot search for particular words when reading the Electronic Book.</a><br>
<a href="#E" class="t1">Conditions for purchasing books</a><br>
<a href="#E1" class="t2">What are the terms of sale?</a><br>
<a href="#E2" class="t2">What about licenses for the EBooks?</a><br>
<a href="#E3" class="t2">Can I purchase resale rights?</a><br>
<a href="#E4" class="t2">Can I make copies of my eBook?</a><br>
<a href="#E5" class="t2">Can I use more than one copy of this Ebook?</a><br>
<a href="#F" class="t1">Safety: You're okay. </a><br>
<a href="#F1" class="t2">Will you share my email address?</a><br>
<a href="#F2" class="t2">Is it safe to use my credit card or online check to purchase your EBooks?</a><br>
<a href="#F3" class="t2">What payment methods are there?</a><br>
<a href="#F4" class="t2">Can you tell me more about your shipping policy?</a><br>
<a href="#F5" class="t2">Can I fax my order form instead of going through a secured internet server?</a><br>
<a href="#F6" class="t2">Which vendor will appear on my credit card?</a><br>
<a href="#G" class="t1">Dr Neppe's Books on Brainvoyage.com</a><br>
<a href="#G1" class="t2">What about the Deja Vu books? </a><br>
<a href="#G2" class="t2">What about the Medicolegal  books?</a><br>
<a href="#G3" class="t2">What is Cry the Beloved Mind? </a><br>
<a href="#G4" class="t2">I understand Dr Neppe is a playwright too. Where can I locate his play?</a><br>
<a href="#G5" class="t2">Tell me about the hard  copies of Dr Neppe's books</a><br>
<a href="#H" class="t1">Collector's items and autographed editions</a><br>
<a href="#H1" class="t2">Why should I bother with an autographed first edition?</a><br>
<a href="#H2" class="t2">But can I even have the book personally inscribed by the author?</a><br>
<a href="#H3" class="t2">But the Psychology of Deja Vu by Dr Neppe is available only for $1000! That sounds amazing.</a><br>
<a href="#I" class="t1">SPECIAL OFFERS</a><br>
<a href="#I1" class="t2">What special packages are avaliable for E-BOOKS  on brainvoyage.com?</a><br>
<a href="#I2" class="t2">In a special TalkRadio offer there was a special teleconference</a><br>
<a href="#I3" class="t2">In a special TalkRadio offer there was a special questionnaire</a><br>
<a href="#I4" class="t2">Do I qualify for a $1 reduction on each Cry The Beloved Mind bound book?</a><br>
<a href="#I5" class="t2">I qualify for a $1 reduction on each book despite it being autographed? Yes a great offer!</a><br>
<a href="#I6" class="t2">How can I buy the electronic version in combination with the printed autographed copy of the book or multiple versions and get $5 off?</a><br>
<a href="#I7" class="t2">I made a mistake and completed my order. Now I want to order more. Can I get the $5 off for second and consecutive items.</a><br>
<a href="#I8" class="t2">When does the "TalkRadio" code expire?</a><br>
<a href="#I9" class="t2">In the special TalkRadio offer can I get 20% off all items, or just the first?</a><br>
<a href="#I10" class="t2">Can I use the special TalkRadio offer where I get 20% off all items, even if I did not listen to the radio program?</a><br>
<a href="#I11" class="t2">Where do I pay sales tax?</a><br>
<a href="#I12" class="t1">I did not download my EBooks. How do I go about doing this?</a><br>
<a href="#I13" class="t1">I have lost my password I registered on site with. How do I acquire it?</a><br>
<br><br>










<table border=0 cellpadding=2 cellspacing=3>
  <tr>
    <td colspan=2>    <p><strong> <a name="A"></a>Why buy from Brainvoyage.com?</strong></p>
    <hr noshade color=#000000></td>
  </tr>
  <tr>
    <td width="12" valign="top" class="bighead">Q</td>
    <td width="896" class=data><p> <a name="A1"></a>Can I buy these books anywhere else?</p></td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> <p> Not any more. We used to allow companies like Amazon and Barnes and Noble to purchase Cry the Beloved Mind.<br>
      In fact the book was 5 star ranked by these companies.<br>
      We no longer do so.&nbsp;<br>
      All books --- bound and electronic published by Brainvoyage.com (Brainquest Press) are exclusively available on this site.</p>
    <p></p></td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="A2"></a>What is the contact information for Brainvoyage.com?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> <p>Our mailing address is<br>
        Brainvoyage.com<br>
        4616 25th Ave. NE, PMB #236<br>
        Seattle, WA 98105<br>
        USA<br>
        (206)527-8229<br>
    <a href="mailto:techsupport@brainvoyage.com">techsupport@brainvoyage.com</a></p></td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000>
    <p><strong><a name="B"></a>Basics on E-Books.</strong><br>
    </p>
    <hr noshade color=#000000>    <p>&nbsp;    </p></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="B1"></a>Tell me&nbsp;more about&nbsp; Electronic Books (E-Books) (Digital Books).</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> Electronic Books&nbsp; are called E-Books or Digital Books. It is a new technology.<br>
      This allows having the book on your computer and it does not occupy physical space.&nbsp;<br>
      Any scientific book is logical to be in electronic format.<br>
    An eBook is actually computer software designed with the look and feel of a real book, but runs on YOUR computer! This is NOT a text file that you open up in a word processor. Once downloaded and installed onto your system our books have the look and feel of a real book! You can print out any page you like or even the entire eBook!</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="B2"></a>Why did brainvoyage.com choose PDF format for their EBooks?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> Texts are presented in Adobe PDF format.&nbsp; &nbsp;This allows easy searching.<br>
    You need Adobe Reader to view this item. Download if necessary at: <a href="http://www.adobe.com/products/acrobat/readstep2.html">http://www.adobe.com/products/acrobat/readstep2.html</a></td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="B3"></a>What was the first&nbsp;electronic book marketed by a major applications download company on the internet?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> Apparently the first was Dr Vernon Neppe's Cry the Beloved Mind: A Voyage of Hope. This may be one of many reasons to expect this book to increase in value.&nbsp;</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="B4"></a>How do I read the EBook (electronic /digital book)?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> The book is in Adobe PDF format. To read it you will need a PDF reader. You can download one here. If you have this free application, just click on the EBook . You can read it either directly from your computer screen or from the printed copy.</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000>
    <p><strong><a name="C"></a>Downloading my EBooks.</strong></p>
    <hr noshade color=#000000>    <br>    </td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="C1"></a>Please assist me with my EBook downloads?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> E-Books with multiple files or combination items are archived for download via the zip format.&nbsp;&nbsp;<br>
      We recommend WinZip, which is standard in Windows XP, and there are several free utilities available.&nbsp;&nbsp;<a href="http://www.winzip.com/downwzeval.htm">http://www.winzip.com/downwzeval.htm</a>&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;<br>
    Macintosh users&nbsp;&nbsp;can use Stuffit Expander at <a href="http://www.stuffit.com/mac/expander/index.html">http://www.stuffit.com/mac/expander/index.html</a>.&nbsp;</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="C2"></a>How do I download and install an eBook?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> After you've submitted your payment, you are prompted to &quot;click&quot; your mouse on the link below for your book download. If you lose the download or want to try again, the download is available for a week or so. You can re-access it by going to&nbsp;the&nbsp;&nbsp;&quot;my account&quot; option inside the cart at any time you can obtain your&nbsp;order history and access available downloads.<br>
    You can get there by going to&nbsp;<a href="http://www.brainvoyage.com/shop/catalog/">http://www.brainvoyage.com/shop/catalog/</a> and pressing on My Account (second item on the left in the Brainvoyage Online Store).&nbsp;<br></td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="C3"></a>How large are the files for downloading?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> The files are between 2 MB and 15 MB in size.&nbsp;Please note that downloading of items may take some time.</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="C4"></a>What happens after downloading?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> The files usually expand automatically, or the computer may ask you if it can be expanded and you can press &quot;yes&quot;,&nbsp;&nbsp;but if not please double click on the Zip to manually open. For the Deja Vu Trilogy (Series) there are three zipped books in the larger zipped files so you may need to click on the individually zipped files in the folder.&nbsp;&nbsp;You should wait till the whole download is completed and unzipped or unstuffed completely before pressing on it, otherwise the incomplete file may show an error.&nbsp;&nbsp;Once opened,&nbsp;&nbsp;the glossaries are available for copying and pasting; however, the other files cannot be altered: that password is not available to you.&nbsp;&nbsp;You may always access your account order history and available downloads by utilizing the &quot;my account&quot; option inside the cart at any time. Therefore, if downloads don't come up or disappear, go to &quot;my account&quot;, select your order by date, click on it and the downloads will re-appear.</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="C5"></a>How do I download multiple files?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> Our E-Books with multiple files or combination items are archived for download via the zip format.&nbsp;&nbsp;<br>
      We recommend WinZip, which is standard in Windows XP, and there are several free utilities available.&nbsp;&nbsp;<a href="http://www.winzip.com/downwzeval.htm">http://www.winzip.com/downwzeval.htm</a>&nbsp;&nbsp;.&nbsp;&nbsp;<br>
    Macintosh users&nbsp;&nbsp;can use Stuffit Expander at <a href="http://www.stuffit.com/mac/expander/index.html">http://www.stuffit.com/mac/expander/index.html</a>.</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="C6"></a>What files do I download for the electronic (digital) book versions by Vernon M Neppe MD, PhD?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> It's easy. Click download and off it goes.<br>
      If there are more files to download they come zipped (PC and Macs can open these).&nbsp;<br>
    They are all in the very standard PDF format which requires Adobe Acrobat Reader, a free program. They are not compressed.&nbsp;</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="C7"></a>But what happens if my Zipped file is corrupted?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> After checking again that the download was complete, you can try two options:<br>
      <ol start="1">
	  <li>Try another computer.</li>
      <li>Try opening the file on a PC not a Mac, for example.</li>
    <li>Contact us and we'll direct you to a special download site for no extra costs.</li></ol></td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="C8"></a>I cannot download the EBook (electronic version of the book) as I am disconnected before the download finishes! What should I do?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> Successfully downloading the book can be challenging, especially on a slower connection. The larger the file, the more time it takes to download, and presents more opportunity for interruption. This is why we recommend only those with Cable, DSL, T1 or other fast connections try this route and do not take responsibility for slower connections, though it may work. However, if you have a dial up connection, the following may be useful
      <p>Sometimes on your browser, like Firefox, Netscape, AOL or Internet Explorer, or in your PPP/ IP application that is used to connect you onto the net, there is an option like &quot;disconnect after inactivity of thirty minutes.&quot; If your browser does not recognize the downloading as activity, you may be disconnected. This can be changed usually by changing the period to longer, say 120 minutes before disconnecting. Usually you have to quit your browser or PPP program for this to take effect. If this is so, try to download again.<br>
        If you have purchased the software and want to try to download again, you can use the same password you were given. If you still cannot download: Unfornately, we cannot offer free tech support but you can phone us at 206 527 8229. Please ensure that you have your particulars and your order number you were given.<br>
    </p></td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="C9"></a>When do I choose the web download, when the CD?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> <p>We recognize that electronic downloads may be too slow or you want a hard copy of these books. The Brainvoyage CD contains all the books.&nbsp;&nbsp;But to open any you need the password. This is provided once you order the CD and have purchased the appropriate download. If you have already bought a download and then want the CD please EMail us at <a href="mailto:CD@brainvoyage.com">CD@brainvoyage.com</a> so we can provide you with the password to open the EBook on CD. Please remember to include your order number or a copy of your order.</p>
    </td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="C10"></a>I followed the steps for  purchasing a book and I got a confirmation email but I do not understand how I get the  book now. Will it be emailed to me?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> <p>After going through your whole order and purchasing you should  have seen a screen saying download now. </p>
      <p>On the lower part of that page you will get a flashing screen  saying:&nbsp; <br />
        </p>
      <p>Download your products here: <br />
        D&eacute;j&agrave; Vu E-Book Trilogy, All three Deja vu selections  Expiry date: Saturday 16 June, 2007 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1 downloads remaining </p>
      <p>Click on this and it will automatically download.&nbsp; <br />
        The rate of download will depend on your connection. For cable  internet, it may be a minute or two or less; for modem downloads, it could be  an hour.&nbsp; <br />
        If you left this screen, you can return via going to the MY  ACCOUNT box and clicking on your pending order. <br />
        You can there by going to&nbsp;<a href="http://www.brainvoyage.com/shop/catalog/">http://www.brainvoyage.com/shop/catalog/</a> <br />
    Or if you lose this link, simply go to Brainvoyage.com, click on  Order, Click on My Account box near the top left (second item down after HOME) </p></td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000>
    <p><strong><a name="D"></a>Compatibility</strong><br>
    </p>
    <hr noshade color=#000000>    <p>&nbsp;    </p></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="D1"></a>What operating systems will my eBook run on?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data>You name it and PDF files generally are accessible to the system. They are now the standards for sharing files.<br>
    The EBooks are in PDF format and cross-compatible. The same file can run on&nbsp; ALL Windows and Macintosh operating systems. You should have Adobe Acrobat Reader, eXPert PDF Reader, or FOXIT Reader installed on your system PRIOR to downloading the PDF version of our eBook. We provide the free dowload links on our order page.</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="D2"></a>Will the eBook harm my computer?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> Certainly not! There are no viruses in them.</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="D3"></a>I cannot search for particular words when reading the Electronic Book. </td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> Please ensure you have downloaded or have available the latest version of Adobe Acrobat Reader with the special search function.<br>
      &nbsp;We hope you use the special resources of PDF files by using the search functions in Adobe Acrobat Reader.&nbsp;<br>
      If you do not have this program, or want an upgrade, please go to the Adobe site at <a href="http://www.adobe.com/products/acrobat/readstep2.html">http://www.adobe.com/products/acrobat/readstep2.html</a> and obtain your copy for free.<br>
      Remember to check Step 2 on this page for searching if it requests it before downloading.<br>
    This will allow extra functions including searching.</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000>
    <p><strong><a name="E"></a>Conditions for purchasing books</strong></p>
    <hr noshade color=#000000>    <p><br>
    </p></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="E1"></a>What are the terms of sale?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> 1. The client agrees to these conditions which include those listed in the disclaimer and copyright conditions of this site.<br>
      2. All book purchases are final.<br>
      3. Once downloads have been performed, or CDs or books purchased there is no return of amounts paid.<br>
      4. All signed books cannot be returned.<br>
      5. Liability is under all circumstances limited to the total amount paid for the purchase.<br>
      6. The responsibility is on the client to contact brainvyoyage.com to ensure that attendance or performance of any of special offers is carried out. The parties providing this cannot be responsible for any unforeseen events, and may change the conditions or cancel at any time without monetary or other penalty.<br>
    7. The&nbsp;&nbsp;conditions and listings above including the disclaimers and copyrights,&nbsp;&nbsp;&nbsp;protect all parties involved with the manufacture, production, authorship and sale or any other means of involvement with any of these items, including but not limited to any corporations, employees, consultants. affiliates and any other individuals, and their families involved.<br></td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="E2"></a>What about licenses for the EBooks?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> Through your purchase you have agreed to all the conditions of purchase. E-Books are only licensed in the quantity purchased.&nbsp;&nbsp;A single download is only for use by a single user.&nbsp;&nbsp;Brainvoyage.com does offer&nbsp;&nbsp;volume purchase, for multi-user E-Book licenses, please visit <a href="http://www.brainvoyage.com/shop/catalog/">http://www.brainvoyage.com/shop/catalog/</a>. By using Brainvoyage E-Book software, you are agreeing to be bound by the terms of this license. If you do not agree to the terms of this license, do not use the Software. The EBooks produced by Brainvoyage.com&nbsp;&nbsp;are copyrighted and distribution without purchase of extra licenses (1 per computer)&nbsp;&nbsp;is only permitted by written permission of Brainquest Press&nbsp;&nbsp;DBA brainvoyage.com . All specifications and offers are subject to change without notification. You use this software on your own risk. After purchase, this software is licensed to you and may not be reproduced, sold or redistributed without consent. If you are uncertain about your right to copy any material you should not use these EBooks.</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="E3"></a>Can I purchase resale rights?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> Not at this time.&nbsp; Reselling our eBooks without our exclusive writtten permission will lead tol prosecution to the fullest extent of the law as well as file a lawsuit for damages.&nbsp;<br>
    In the future, we hope to establish an affiliate link .</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="E4"></a>Can I make copies of my eBook?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> Yes.&nbsp; But software piracy is against the law... You may install it on all your personal computers provided you run only one copy at a time. Don't give it away to others.<br>
    Purchase of the EBook entitles you to one copy of this book. If you want more than one copy, please purchase another software license. If you intend to purchase numerous copies e.g. 10 or more, e.g.. for a library or an institutional license, please contact us as <a href="mailto:questions@brainvoyage.com">questions@brainvoyage.com</a>.</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="E5"></a>Can I use more than one copy of this Ebook?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> Purchase of the EBook entitles you to one copy of this book. If you want more than one copy, please purchase another software license. If you intend to purchase numerous copies e.g. 10 or more, e.g.. for a library or an institutional license, please contact us as CTBM@brainvoyage.com. </td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000>
    <p><strong><a name="F"></a>Safety: You're okay.&nbsp;</strong></p>
    <hr noshade color=#000000>    <p><br>
    </p></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="F1"></a>Will you share my email address?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> We do not do this. We maintain your privacy.&nbsp;</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="F2"></a>Is it safe to use my credit card or online check to purchase your EBooks?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> Most certainly.&nbsp; We use a well known secured server and&nbsp; processing transactions is secured. Moreover we process purchases by hand so that any reductions we can give are avaialble. You can also use Paypal instead</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="F3"></a>What payment methods are there?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> Credit card orders are processed and thereafter hard copies shipped as soon as possible.&nbsp;<br>
      Cash or check payments&nbsp;&nbsp;are necessarily delayed until we receive payment. Please&nbsp;&nbsp;make checks or money orders payable to Brainvoyage.com and send to the address below.&nbsp;<br>
      Brainvoyage.com<br>
      4616 25th Ave. NE, PMB #236<br>
      Seattle, WA 98105<br>
      USA<br>
    You can also pay through the well-known Paypal.</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="F4"></a>Can you tell me more about your shipping policy?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> Orders will generally be shipped on the same day or within one working day (after confirmation of your credit card transaction). Shipping occurs by priority mail in the United States, book air mail outside the USA. Sometimes we need to confirm your information e.g. when you don't leave the name to personally&nbsp; inscribe customized or personalized books.</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="F5"></a>Can I fax my order form instead of going through a secured internet server?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> Absolutely on both questions.</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="F6"></a>Which vendor will appear on my credit card?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data>The vendor will be either &quot;Brainquest Press&quot; or &quot;Brainvoyage.com&quot; or &quot;Pacific Neuropsychiatric Institute&quot;</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000>
    <p><strong><a name="G"></a>Dr Neppe's Books on Brainvoyage.com</strong></p>
    <hr noshade color=#000000>    <p><br>
    </p></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="G1"></a>What about the Deja Vu books?&nbsp;</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data>We are particularly pleased to have produced the remarkable Deja Vu Trilogy of books, classics in the area and by the world authority on Deja Vu, Vernon Neppe MD, PhD.&nbsp;&nbsp;Deja vu A Second Look is a wonderful reflection of current thinking in the area, Deja Vu Revisited is a significant rewrite of the first and most important book in the area, The Psychology of Deja Vu, and the Deja Vu Glossary and Library just links the two others in a way for quick knowledge. Most importantly all are in PDF format. This means they can be read as files on your computer and when you need to search for information, you can easily do so.&nbsp;&nbsp;Using &quot;search&quot; is sometimes difficult because of the French accents put onto terms like deja. Consequently, there are both accented and unaccented versions for easier searching. Read more here: <a href="http://www.brainvoyage.com/deja">http://www.brainvoyage.com/deja</a></td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="G2"></a>What about the Medicolegal&nbsp; books?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data>Professor Neppe has also extended his skills as an internationally recognized forensic neuropsychiatry expert by writing a practical and excellent monograph for attorneys. Again this need not occupy physical space, and How Attorneys Can Best Utilize Their Medical Expert Witness: A Medical Expert's Perspective has proven very valuable. Read more here: <a href="http://www.brainvoyage.com/attorney">http://www.brainvoyage.com/attorney</a><br></td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="G3"></a>What is&nbsp;Cry the Beloved Mind?&nbsp;</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data>Cry the Beloved Mind: A Voyage of Hope, the first book defined as written in the genre of sciction.&nbsp;<br>
    Read extensively about it at <a href="http://www.brainvoyage.com/ctbm">http://www.brainvoyage.com/ctbm</a></td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="G4"></a>I understand Dr Neppe is a playwright too. Where can I locate his play?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data>Dr Vernon Neppe's medical psychological play with anomalous tinges is&nbsp;Quakes:&nbsp; &nbsp;Dr Neppe may be offering what may be the first play in EBook format.&nbsp;<br>
      This is also a wonderful education through fascination experience.&nbsp;<br>
    Read more here:&nbsp;&nbsp;<a href="http://www.brainvoyage.com/quakes/">http://www.brainvoyage.com/quakes/</a></td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="G5"></a>Tell me about the hard&nbsp; copies of Dr Neppe's books</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data>In addition to digital books, we also have available hard copies of books. A particular favorite is Dr Neppe's classic Cry the Beloved Mind: A Voyage of Hope.&nbsp;<br>
      This book not only had the highest rating from both Amazon and Barnes and Noble but is one of a handful of educational books listed as a favorite by Ondopia's book page.&nbsp;&nbsp;&nbsp;Autographed books sometimes become valuable commodities and the book may ultimately be very special.&nbsp;&nbsp;<br>
    Read more here: <a href="http://www.brainvoyage.com/ctbm">http://www.brainvoyage.com/ctbm</a></td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000>
    <p><strong><a name="H"></a>Collector's items and autographed editions</strong></p>
    <hr noshade color=#000000>    <p><br>
    </p></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="H1"></a>Why should I bother with an autographed first edition?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data>Along with the possibility that this book will become a classic, there is an intrinsic value of having an autographed copy much like having an autographed baseball card. <a href="http://www.brainvoyage.com/ctbm/autographed.php">[more information]</a>.</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="H2"></a>But can I even have the book personally inscribed by the author?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data>Yes, certainly. Cry the Beloved Mind is still available in a first edition inscribe format.<br>
      The autographed first edition will contain an original signature by the author, Dr Vernon Neppe, on the title page. You may want to ask Dr Neppe to personally inscribe the book.&nbsp;
      <p>Many readers like to exhibit personally autographed copies of books. This is automatic with any orders from this site provided Dr neppe is available which he currently is. When you complete the order form, you will be asked for details.</p>
      <p>CUSTOMIZED COPIES: For a limited time only, and an extra $2.50 per book, your signed autographed copy may be personally inscribed by Dr Neppe to you or you and your friend. Dr Neppe will also write a short personal message (one of : &quot;Enjoy.&quot; &quot;With best wishes.&quot; &quot;Good luck.&quot;&nbsp; Lengthier inscriptions are not available. You should indicate on the order form (if you do this on the internet, in the comments section) that you want a personal inscription and if you specifically want one of the above, please list it. If you are filling out a Quality Paperback order form. please make sure the writing is legible as otherwise inadvertent errors may occur. Please indicate the names of the persons you want on the inscription.&nbsp; You should begin with 'INSCRIBE&quot; or indicate that you want the personalized inscription.&nbsp;</p>
      <p>PERSONALIZED COPIES: Personalized inscriptions may be possible beyond two people or three words. This costs $5 instead of the$2.50 extra. This should be arranged with Brainvoyage.com either by Email at the time of order to <a href="mailto:inscriptions@brainvoyage.com">inscriptions@brainvoyage.com</a> (preferable), by phoning at USA (206) 527-8229 and leaving a message or faxing to 206 5261522. The limitation is space on the title page and obviously the choice of wording has to be appropriate.</p>
      <p>For both customized and personalized copies, of Dr Neppe is requested to personally inscribe the book, we CANNOT guarantee that this will happen as Dr Neppe has to be available to do this individually. If he does not personally inscribe it, none of Brainvoyage.com (the DBA for Brainquest Press), Bookzone or Peanut Butter Publishing can be held liable in any way. Moreover, if there are errors in the inscription, no refunds can be given. Dr Neppe will try his best to ensure that there are no spelling errors. The inscription may or may not be dated.</p>
      <p>MILLENNIAL COLLECTORS EDITIONS: if available.<br>
        COSTS: $25 extra for those numbered between 20 and 99; for numbers 10-19, this is $50 extra per book,; for 1-9 : $100 extra per book. If these numbers are Whereas the MILLENIAL EDITION is a speculative, it may be an excellent long-term investment but no warranties or guarantees can be given.<br>
        There is good reason why this millenial version could inflate in value.<br>
        1. This is the first book written in the new literary genre of sciction.<br>
        2. Collector's numbered autographed first edition.<br>
        3. This book may become a classic.</p>
      <p>Collectors will want this book. Cover it in transparent plastic or similar material so it can maintain its original appearance.<br>
    </p>    </td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="H3"></a>But the Psychology of Deja Vu by Dr Neppe is available only for $1000! That sounds amazing.</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data>It might be. Published originally by&nbsp;&nbsp;Witwatersrand University Press in&nbsp; Johannesburg, South Africa in 1983, it is a rare edition by the world authority on the area and the first scientific book on deja vu.&nbsp;This book is alo the most detailed scientific analysis of d&eacute;j&agrave; vu. The book is already a significant and major collector's item. It has already fetched $500 at its first auction and is now becoming available at $1000.&nbsp;<br>
The major collector's value has several reasons: The overwhelming reason is significant inadvertent printing error: The side spine was empty other than the insignia of the publisher; similarly the back cover is blank. This error has been compared to the Penny Black Stamp error. The key is its rarity, spontaneity, inadvertent quality. There may be other such books but we do not know of anything comparable particularly given the circumstances. This was the first published book on the d&eacute;j&agrave; vu phenomenon. It is written by the world authority on the subject. It is out of press and very few copies remain available.&nbsp;<br>
The only proof copies are available through this site.&nbsp;<br>
Optional autographing by the author increases its value even more.<br>
See&nbsp;<a href="http://www.brainvoyage.com/deja/PDV">http://www.brainvoyage.com/deja/PDV</a>.</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000>
    <p><strong><a name="I"></a>SPECIAL OFFERS</strong></p>
    <hr noshade color=#000000>    <p><br>
    </p></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="I1"></a>What special packages are avaliable for E-BOOKS&nbsp; on brainvoyage.com?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data>A special discounted package is available for buying the full combination of electronic books even now.<br>
      Special offers are available only using your credit card for the full combination of everything at&nbsp;<a href="http://www.brainvoyage.com/shop/catalog/">http://www.brainvoyage.com/shop/catalog/</a>.&nbsp;<br>
      We&nbsp;&nbsp;offer the whole package at $30 off and also take into account what you have already paid with any reduction coupons.&nbsp;<br>
      Even if you have purchased, please EMail us and we will give you a special code to download the books you haven't yet downloaded.&nbsp;<br>
    We will bill your credit card for the balance.</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="I2"></a>In a special Talk Radio offer there was a special teleconference</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data>True. If you used the special &quot;TalkRadio&quot; discount offer, you may have qualified to hear Dr Neppe at a special Internet Teleconference discussion on deja vu where you may have the opportunity to ask questions at the nominal rate of $35 instead of the regular $175. We anticipate this will take place during the winter. To secure your place please respond within a week of this EMail putting in your purchase order number above and requesting to be notified of the date, time and arrangements. When these become available we will let you know. Please EMail : <a href="mailto:Symposia@brainvoyage.com">Symposia@brainvoyage.com</a>.&nbsp;&nbsp;If you prefer you can just paste this section of this EMail but remember to put in your Order number, name of the attendee (one person can be designated by you) and your contact EMail. ****</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="I3"></a>In a special Talk Radio offer there was a special questionnaire</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data>True.&nbsp;If you used the special &quot;TalkRadio&quot; discount offer, you may have also&nbsp;qualified for a special questionnaire on deja vu that Professor Neppe has been developing for Internet use. This will be free for your one time use. We hope this will be also available during the winter.&nbsp;&nbsp;To secure your place please respond within a week of this EMail putting in your purchase order number above and requesting to be notified of the date, time and arrangements. When these become available we will let you know. Please EMail : <a href="mailto:Questionnaire@brainvoyage.com">Questionnaire@brainvoyage.com</a>.&nbsp;&nbsp;If you prefer you can just paste this section of this EMail but remember to put in your Order number, name of the attendee (one person can be designated by you) and your contact EMail.</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="I4"></a>Do I qualify for a $1 reduction on each Cry The Beloved Mind bound book?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data>Yes you do. As a special offer right here at brainvoyage.com, you will receive 1 dollar off the price, as well as have the book autographed by the author. Some people may qualify for additional discounts, for example the TalkRadio offer.</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="I5"></a>I qualify for a $1 reduction on each book despite it being autographed? Yes a great offer!</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data> Yes you do. As a special offer right here at brainvoyage.com, you will receive 1 dollar off the price, as well as have the book autographed by the author. Some people may qualify for additional discounts.</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="I6"></a>How can I buy the electronic version in combination with the printed autographed copy of the book or multiple versions and get $5 off?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data>In the same order, order any combinations of EBooks, Bound books or CDs. Each time you will get $5 more off with the second order on.
      This will be processed immediately in the total of your order.&nbsp;You need do nothing.
      If for some reason it doesn't, just write something in the comments section,&nbsp; we humans should pick up this and will discount it $5 (unless you have paid via PayPal, which is an alternative payment option, but because it is outside we cannot assist further).    </td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="I7"></a>I made a mistake and completed my order. Now I want to order more. Can I get the $5 off for second and consecutive items.</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data>We will try our best. Please alert us in the comments section. Again, we humans should pick up this and will discount it $5 (unless you have paid via PayPal, which is an alternative payment option, but because it is outside we cannot assist further). </td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="I8"></a>When does the &quot;talkradio&quot; code expire?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data>We have extended it for the present. We can modify it at any time. </td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="I9"></a>In the special TalkRadio offer can I get 20% off all items, or just the first? </td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data>All items on that order. But only if you used the special &quot;TalkRadio&quot; discount offer.</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="I10"></a>Can I use the special Talk Radio offer where I get 20% off all items, even if I did not listen to the radio program? </td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data>Yes, provided you put in the &quot;talkradio&quot; in the order code bar, all items on that order will receive 20% of the total in the discount offer.</td>
  </tr>
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class=data><a name="I11"></a>Where do I pay sales tax?</td>
  </tr>
  <tr>
    <td valign=top class="bighead">A</td>
    <td class=data>Sales tax is only applied for any items shipped to Washington State. This is based on the item cost, plus shipping costs * 8.9%.</td>
  </tr>
  <tr>
    <td colspan="2"><hr noshade="noshade" color="#000000" /></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class="data"><a name="I12" id="I12"></a>I did not download my   EBooks. How do I go about doing this?</td>
  </tr>
  <tr>
    <td valign="top" class="bighead">A</td>
    <td class="data"><p>The EBooks that you have ordered, will be reflected in your account history.<br />
      One easy way to go to your account history is to go to the order page<br />
      https://www.brainvoyage.com/shop/catalog<br />
      Check on Account history and log on.<br />
      Alternatively if you know your Order number you can go direct to your order by <br />
      https://www.brainvoyage.com/shop/catalog/account_history_info.php?order_id=wxyz<br /><br />In this instance you put in the order id in the spot where wxyz appears above. For example if your order number was 108 then you put in:<br />
        https://www.brainvoyage.com/shop/catalog/account_history_info.php?order_id=108<br />
    You will be asked for your password that you registered with.</p>
    </td>
  </tr>
  <tr>
    <td colspan="2"><hr noshade="noshade" color="#000000" /></td>
  </tr>
  <tr>
    <td valign="top" class="bighead">Q</td>
    <td class="data"><a name="I13" id="I13"></a>I have lost my password I registered on site with. How do I acquire it?</td>
  </tr>
  <tr>
    <td valign="top" class="bighead">A</td>
    <td class="data">Go to your Account History registration at <br />
      https://www.brainvoyage.com/shop/catalog<br />
    Click on &quot;Password Forgotten?&quot; under where you login. A new password will be EMailed to you. Afterwards, you can login with this new password and go to &quot;My Account&quot; to change your password to something more convenient. </td>
  </tr>
  
  <tr>
    <td colspan=2><hr noshade color=#000000></td>
  </tr>

 <!--  
  <tr>
    <td valign="top" class="bighead">Q</td><td class=data><a name="digitalDownload">How</a> do I decompress the book?</td>
  </tr><tr>
    <td valign=top class="bighead">A</td><td class=data>The file is in ZIP format, so it all depends on what system you're using:<br><ul><li>Windows: Download <a href="http://www.winzip.com" class="std">WinZip</a> to decompress it.</li><li>Macintosh: Download <a href="http://www.aladdinsys.com/" class="std">StuffIt</a> to decompress the file.</li><li>Linux/Unix/BSD: Use the 'unzip' util, which should be installed already. Type 'man unzip' at the console for help. If it is not installed, you may download a free copy <a href="http://freshmeat.net/projects/unzip/" class="std">here</a>.</td>
  </tr>
  <tr><td colspan=2><hr noshade color=#000000></td></tr>
   -->
</table>

<? printFooter(); ?>
