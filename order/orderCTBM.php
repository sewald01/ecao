#!/usr/local/bin/php

<?php 
require("/home/content/48/7686848/html/includes/bv-library.php");

printHeader("Order Cry the Beloved Mind"); 
?>
<body>
<h1 class="title" align="center">Order Form</h1>
<h2 class="title" align="center">For the printed and electronic copies of <em>Cry 
  the Beloved Mind</em></h2>
<table width="400" border="0" align="center" cellpadding="2" cellspacing="10">
  <tr>
    <td><div align="right"><img src="ssl.gif" border="0"></div></td>
    <td> 
      <!--
TrustLogo Html Builder Code:
Shows the logo at URL http://www.brainvoyage.com/order/secure_site.gif
Logo type is Secure Site Seal - For SSL Certificate holders ("SC")
Floating on the Bottom Left
//-->
      <div align="left">
        <script type="text/javascript">TrustLogo("http://www.brainvoyage.com/order/secure_site.gif", "SC", "bottomleft");</script>
        <br>
      </div></td>
  </tr>
</table>
<div class="title" align="center"><br>
  Please fill out what books you want and the appropriate shipping information. 
  Our server is secure, we use independent digital certificate and data encryption 
  to protect you information. If you want more information about the orders click 
  <a href="https://www.brainvoyage.com/order/">here</a> and you will go back to 
  the initial order page. This click will link with http://www.brainvoyage.com/order/ </div> 
  <br>
</p>
<table border=0 cellpadding=2 cellspacing=0 bgcolor="#000000" width="100%"><tr><td>
<table border=0 width="100%" bgcolor=#eaeaea>
  <tr><td colspan=3 align=center><b><em><span style="font-size:14pt;">Cry the Beloved Mind</span></em></b><br><br></td></tr>
  <tr>
    <td valign=top class=data>
      <form action="https://www.brainvoyage.com/cgi-bin/orderCTBM.php" method="post"> 
       <div align=center>
       <table border=0 cellpadding=0 cellspacing=0 width=95%>
        <tr><td class="data">Book</td><td class="data">Price</td><td class="data">Quantity</td></tr>
        <tr><td colspan="3"><hr noshade></td></tr>
        <tr><td class="data">Special Autographed Edition (Internet sale price: $1 off)
 </td><td class="data">$21.95/ea</td><td><input type=text size=2 name="AutographedCopies"></td></tr>
        <tr><td colspan="3"><hr noshade></td></tr>
        <tr><td class="data">Customized Copy (Internet sale price: $1 off)
</td><td class="data">$24.45/ea</td><td><input type=text size=2 name="CustomizedCopies"></td></tr>
        <tr><td colspan="3">
		      <table width="100%" border=0 cellpadding=2 cellspacing=0>
		        <tr>
				      <td>&nbsp;&nbsp;&nbsp;</td>
              <td class=data>
                <table border=0 cellpadding=2 cellspacing=0 bgcolor="#000000" width="100%"><tr><td>
                <table width="100%" bgcolor=#eaeaea border=0>
                  <tr><td align=center colspan=2><b>If you are ordering Customized copies, please fill out this section</b></td></tr>
                  <tr><td>To (Up to two names, eg To Jack and Jill):</td><td><input type=text name="CustomizedName"></td></tr>
                  <tr><td>Phrase:</td><td> <select name="CustomizedPhrase" id="CustomizedPhrase">
	                           <option value="Good Luck" SELECTED>Good Luck</option>
                          	 <option value="Enjoy!">Enjoy!</option>
                          	 <option value="Best Wishes">With Best Wishes</option>
                            </select> 
                  </td></tr>
                </table>
                </td></tr></table>
              </td>
            </tr>
          </table>
        </td></tr>
        <tr><td colspan="3"><hr noshade></td></tr>
        <tr><td class="data">Personalized Copy (Internet sale price: $1 off)
</td><td class="data">$26.95/ea</td><td><input type=text size=2 name="PersonalizedCopies"></td></tr>
        <tr><td colspan="3">
		      <table width="100%" border=0 cellpadding=2 cellspacing=0>
		        <tr>
				      <td>&nbsp;&nbsp;&nbsp;</td>
              <td class=data>
                <table border=0 cellpadding=2 cellspacing=0 bgcolor="#000000" width="100%"><tr><td>
                <table width="100%" bgcolor="#eaeaea" border=0>
                  <tr><td align=center colspan=2><b>If you are ordering Personalized copies, please fill out this section</b></td></tr>
                  <tr><td>To (Up to three names, eg To Jack, Jill, and John):</td><td><input type=text name="PersonalizedName"></td></tr>
                  <tr><td>Phrase (Can be modified by Dr. Neppe for size and/or content):</td><td><input type=text name="PersonalizedPhrase"></td></tr>
                </table>
                </td></tr></table>
              </td>
            </tr>
          </table>
        </td></tr>
        <tr><td colspan="3"><hr noshade></td></tr>
		<tr><td class="data">Millennial Copy (Internet sale price: $10 off! Some numbers unavailable; we will correct pricing by hand)
</td><td class="data"></td><td></td></tr>
        <tr><td class="data">&nbsp;&nbsp;2-4 (250 dollars extra) (but with only $12.95 on the book)

</td><td class="data">$262.95/ea</td><td><input type=text size=2 name="Millennial24"></td></tr>   

     
       <tr><td class="data">&nbsp;&nbsp;6-9 (120 dollars extra) (but with only $12.95 on the book)

 </td><td class="data">$132.95/ea</td><td><input type=text size=2 name="Millennial69"></td></tr>

		<tr><td class="data">&nbsp;&nbsp;10-19 (60 dollars extra) (but with only $12.95 on the book)

</td><td class="data">$72.95/ea</td><td><input type=text size=2 name="Millennial1019"></td></tr>

		<tr><td class="data">&nbsp;&nbsp;20-99 (30 dollars extra) (but with only $12.95 on the book)

</td><td class="data">$42.95/ea</td><td><input type=text size=2 name="Millennial2099"></td></tr>
       
<!-- Digital  -->	   
	   <tr><td colspan="3"><hr noshade></td></tr>
	   <tr><td class="data">EBook (electronic) version (Internet sale price at present) (Plus $5 combination if printed book, adjusted at check-out)<br><i>The electronic download is temporarily disabled. In the comments section indicate if you want the EBook and we will manually handle it. The cost remains $18.95 (less any reductions for multiple orders) and we will handle it manually for you.</i>

</td><td class="data">$18.95</td><td><input type="checkbox" name="ebook" value="1"></td></tr>
	   <tr><td colspan="3"><hr noshade></td></tr>
	<tr><td colspan=3>
Downloadable version of The Psychology of Deja Vu: A Second Look priced at $19.95<br>
Available shortly 
</td></tr>
	   <tr><td colspan="3"><hr noshade></td></tr>
<tr><td colspan=3>

Collector's Autographed First Edition of The Psychology of Deja Vu: Have I Been Here Before priced at $1,000.00<br>
A publication defect produced only the publisher emblem in the spine; and an empty back cover; moreover this book is written by the world authority in the area of Deja Vu, and was the first (and until recently) only book on the topic. These features combined with the great rarity of the book make it a potentially valuable item for collectors. 
	</td></tr>	   
	   </table>
    </td>
  </tr>
</table>
</td></tr></table>
<br><br>
<table border=0 cellpadding=2 cellspacing=0 bgcolor="#000000" width="100%"><tr><td>
<table border=0 width="100%" bgcolor=#eaeaea>
  <tr><td colspan=3 align=center class=theader>Payment/Shipping Information</td></tr>
  <tr>
    <td valign=top class=data>
      <div align=center>
       <table border=0 cellpadding=0 cellspacing=0 width=95%>
        <tr><td class="data">
			<table border=0 cellpadding=0 cellspacing=0>
			<tr><td class=data><input type=radio name="Country" value="USA">USA</input></td><td class=data>State: 
			
			<select name="State" >
	<option value="AL">AL</option>
	<option value="AK">AK</option>
	<option value="AZ">AZ</option>
	<option value="AR">AR</option>
	<option value="CA">CA</option>
	<option value="CO">CO</option>
	<option value="CT">CT</option>
	<option value="DE">DE</option>
	<option value="DC">DC</option>
	<option value="FL">FL</option>
	<option value="GA">GA</option>
	<option value="HI">HI</option>
	<option value="ID">ID</option>
	<option value="IL">IL</option>
	<option value="IN">IN</option>
	<option value="IA">IA</option>
	<option value="KS">KS</option>
	<option value="KY">KY</option>
	<option value="LA">LA</option>
	<option value="ME">ME</option>
	<option value="MD">MD</option>
	<option value="MA">MA</option>
	<option value="MI">MI</option>
	<option value="MN">MN</option>
	<option value="MS">MS</option>
	<option value="MO">MO</option>
	<option value="MT">MT</option>
	<option value="NE">NE</option>
	<option value="NV">NV</option>
	<option value="NH">NH</option>
	<option value="NJ">NJ</option>
	<option value="NM">NM</option>
	<option value="NY">NY</option>
	<option value="NC">NC</option>
	<option value="ND">ND</option>
	<option value="OH">OH</option>
	<option value="OK">OK</option>
	<option value="OR">OR</option>
	<option value="PA">PA</option>
	<option value="RI">RI</option>
	<option value="SC">SC</option>
	<option value="SD">SD</option>
	<option value="TN">TN</option>
	<option value="TX">TX</option>
	<option value="UT">UT</option>
	<option value="VT">VT</option>
	<option value="VA">VA</option>
	<option value="WA" selected>WA</option>
	<option value="WV">WV</option>
	<option value="WI">WI</option>
	<option value="WY">WY</option>
</select>

			</td></tr>
			<tr><td class=data><input type=radio name="Country" value="USProt">US Protectorate&nbsp;&nbsp;&nbsp;&nbsp;</input></td>
          <td class=data>Protectorate: <select name="Protectorate" id="Protectorate">
                            <option value="AS">American Samoa</option>
                            <option value="FM">Fererated States of Micronesia</option>
                            <option value="GU" selected>Guam</option>
                            <option value="MP">No. Marina Islands</option>
                            <option value="PR">Puerto Rico</option>
                            <option value="PW">Palau</option>
                            <option value="MH">Marshall Island</option>
                            <option value="TT">Trust Territory</option>
                            <option value="VI">Virgin Islands</option>
                            <option value="AA">Armed Forces the Americas</option>
                            <option value="AE">Armed Forces Europe</option>
                            <option value="AP">Armed Forces Pacific</option>
                           </select>
      </td></tr>
			<tr><td class=data><input type=radio name="Country" value="Canada">Canada</input></td><td class=data>Province: <input name="Providence"></td></tr>
			<tr><td class=data><input type=radio name="Country" value="Other">Other</input></td><td class=data>Country: <input type=text name="CountryOther">&nbsp;&nbsp; State (if applicable): <input type=text name="StateOther"></td></tr>
		    </table>
		</td></tr>
	   </table>
    </td>
  </tr>
</table>
</td></tr></table><br>

<div align=center><input type=submit value="Continue"></form></div>
</FORM>
</body>
<?php printFooter(); ?>
