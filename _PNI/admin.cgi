#!/usr/bin/perl
 
########################################################################
# COPYRIGHT NOTICE:
#
# Copyright 2002 FocalMedia.Net All Rights Reserved.
#
# Selling the code for this program without prior written consent 
# from FocalMedia.Net is expressly forbidden. You may not 
# redistribute this program in any shape or form.
# 
# This program is distributed "as is" and without warranty of any
# kind, either express or implied. In no event shall the liability 
# of FocalMedia.Net for any damages, losses and/or causes of action 
# exceed the total amount paid by the user for this software.
#
########################################################################

use FindBin;
use lib $FindBin::Bin;
use CGI;
use CGI::Carp qw(fatalsToBrowser);
use acs;

### WINDOWS USERS EDIT BELOW ##############################################
$cfile = "config.cfg";
#$cfile = "e:/full/server/path/to/config.cfg";
###########################################################################

&get_setup;
$q = CGI->new;

$default_permissions = 0777;  ### DEFAULT PERMISSIONS THAT IS USED FOR DATA FILES IN DATA DIRECTORY

#####
#$setupcrit = &get_setup;
#($data_dir, $web_url, $script_url, $username, $password, $webroot) = split (/\t/, $setupcrit);
#####

acs::check_access($username, $password, $q->param('username'), $q->param('password'));

$template = acs::gtemplate("ctl");


##################################################################################

if ($q->param('fct') eq "stats") {&stats; exit;}
if ($q->param('fct') eq "mysearch") {&mysearch;}

print "Content-type: text/html\n\n";

#################################################################################

if ($q->param('fct') eq "") {&start;}
if ($q->param('fct') eq "what_search") {&what_search;}
if ($q->param('fct') eq "what_search1") {&what_search1;}
if ($q->param('fct') eq "what_search2") {&what_search2;}
if ($q->param('fct') eq "save_dirs") {&save_dirs;}
if ($q->param('fct') eq "search_settings") {&search_settings;}
if ($q->param('fct') eq "save_ss") {&save_ss;}
if ($q->param('fct') eq "html_code") {&html_code;}
if ($q->param('fct') eq "upgrade") {&tmplup;}
if ($q->param('fct') eq "templates") {&template_scr;}
if ($q->param('fct') eq "template_edit") {&template_edit;}
if ($q->param('fct') eq "save_template") {&save_template;}
if ($q->param('fct') eq "save_dirs2") {&save_dirs2;}




#################################################################################

sub save_dirs2
{

$totalitems = $q->param('totalitems');

### GET SELECTED AND DESELECTED ITEMS
$sel_count = 0;
$dsel_count = 0;

for ($ms = 0; $ms < $totalitems; $ms++)
	{
	$dname = "D" . $ms;
	
	if ($q->param($dname) ne "") ### SELECTED ITEMS
		{
		$sel_list[$sel_count] = $q->param($dname);
		#print "==> S = $sel_list[$sel_count]<BR>";
		
		#######################
		if ($q->param('include') eq "y") ### SELECT SUB DIRECTORIES FOR SEARCH
			{
			$tdirs_crit = "$webroot" . $q->param($dname);
			#print "==> $tdirs_crit<BR>";
			@totalseldirs = &get_total_dirs($tdirs_crit);
				$crcount = 0;
				foreach $ss (@totalseldirs)
					{
					$totalseldirs[$crcount] =~ s/$webroot//g;
					$crcount++;
					}
			
			push(@sel_list, @totalseldirs);
			$itcounter = @totalseldirs; $itcounter = $itcounter - 1;
			$sel_count = $sel_count + $itcounter;
			}
		#####################
		
		$sel_count++;
		}
		else
		{
		$cname = "C" . $ms; ### DESELECTED ITEMS
		$dsel_list[$dsel_count] = $q->param($cname);
		#print "!!==> S = $dsel_list[$dsel_count]<BR>";
		
				#######################
				if ($q->param('exclude') eq "y") ### SELECT SUB DIRECTORIES FOR SEARCH
					{
					$tdirs_crit = "$webroot" . $q->param($cname);
					#print "==> $tdirs_crit<BR>";
					@totalseldirs = &get_total_dirs($tdirs_crit);
						$crcount = 0;
						foreach $ss (@totalseldirs)
							{
							$totalseldirs[$crcount] =~ s/$webroot//g;
							$crcount++;
							}
					
					push(@dsel_list, @totalseldirs);
					$itcounter = @totalseldirs; $itcounter = $itcounter - 1;
					$dsel_count = $dsel_count + $itcounter;
					}
				#####################

		
		$dsel_count++
		}
	}	

$selected_dirs = &get_file_contents("$data_dir/searchloc.dat");
@alldselected = split (/\n/, $selected_dirs);

### REMOVE DIRS THAT WAS DESELECTED OR NOT SELECTED
$ccount = 0;
foreach $dir_to_be_searched (@alldselected)
	{
	
	$found_dir = "";
		foreach $unselected_dir (@dsel_list)
			{
			#print "U--> $unselected_dir<br>";
			
			if ($unselected_dir eq $dir_to_be_searched)
				{
				$found_dir = "true";
				}
			}
	
	if ($found_dir ne "true")
		{
		$currentdirs[$ccount] = $dir_to_be_searched;
		$ccount++;
		}
	}

### ADD DIRS THAT HAS BEEN SELECTED
$dta_count = 0;

foreach $sel_item (@sel_list)
	{
	$already_present = "";
	
		foreach $curritem (@currentdirs)
			{
			if ($curritem eq $sel_item)
				{
				$already_present = "true";
				}
			}
	
	## ADD DIR IF NOT ALREADY PRESENT
	if ($already_present ne "true")
		{
		push(@currentdirs, $sel_item);
		}
	}


open (SEARCHF, "> $data_dir/searchloc.dat");

foreach $item (@currentdirs)
	{
	if ($item ne "/")
		{
		print SEARCHF "$item\n";
		}
	}


if ($q->param('public') eq "yes")
	{
	print SEARCHF "/\n";
	}

close(SEARCHF);

$current_pos = $q->param('current_pos');

&saved_settings("Settings Saved.", "$script_url/admin.cgi?fct=what_search2&lc=$current_pos");

}




sub save_template
{

$tmplfname = $q->param('template');
$template_contents = $q->param('template_contents');

open (TMPLF, "> $data_dir/$tmplfname");
	print TMPLF $template_contents;
close (TMPLF);

&saved_settings("Template Saved.", "$script_url/admin.cgi?fct=templates");

}


#################################################################################

sub template_edit
{

$tname = $q->param('template');

if ($tname eq "main_layout.html")
	{
	$use_of_template = "<b>Search Results Main Layout</b><br>This template is used as a wrapper for the search results page. You can add your own HTML code, graphics and menu bars to this template.";
	$template_contents = &get_file_contents("$data_dir/main_layout.html");
	}

if ($tname eq "listings.html")
	{
	$use_of_template = "<b>Search Result Listings</b><br>This template is used in conjunction with the main layout template. The search result listings template represents the look and feel of search result listings. You can change the fonts and styles of text in it.";
	$template_contents = &get_file_contents("$data_dir/listings.html");
	}

if ($tname eq "layout.html")
	{
	$use_of_template = "<b>Advanced Search and Preferences</b><br>This template is used when a user wants to do an advanced search or when he/she wants to change his/her search preferences.";
	$template_contents = &get_file_contents("$data_dir/layout.html");
	}

if ($tname eq "preferences.html")
	{
	$use_of_template = "<b>Search Preferences</b><br>This template is used when in conjunction with layout.html - This is the form displayed to visitors who would like to change their search preferences.";
	$template_contents = &get_file_contents("$data_dir/preferences.html");
	}

if ($tname eq "advanced.html")
	{
	$use_of_template = "<b>Advanced Search</b><br>This template is used when in conjunction with layout.html - This form is used when a user would like to do an advanced search. You are also welcome to construct your own .html page for an advanced search option.";
	$template_contents = &get_file_contents("$data_dir/advanced.html");
	}


$tmpledit = <<END_OF_TMPL;

<table border="0" cellpadding="9" cellspacing="1" width="100%">
  <tr>
    <td width="100%"><form method="POST" action="$script_url/admin.cgi">
      <input type="hidden" name="fct" value="save_template"><input type="hidden" name="template"
      value="$tname"><strong><font face="Arial" size="4"><p>Templates</font></strong> </p>
      <p><font face="Verdana" size="2">The templates enables you to completely customize your
      search results and any FM SiteSearch Pro related pages to the look of your web site.</font></p>
      <div align="center"><center><table border="1" cellpadding="3" cellspacing="0" width="100%"
      bordercolor="#FFFFFF" bordercolorlight="#C0C0C0">
        <tr>
          <font face="Verdana" size="1"><td width="100%" bgcolor="#F8D752" height="18"></font><font
          face="Verdana" size="2" color="#000000"><strong>Editing Template: $tname</strong></font></td>
        </tr>
        <tr>
          <font face="Verdana" size="1"><td width="100%" bgcolor="#F2F2F2" height="18"><div
          align="center"><center><p><strong>&nbsp;&nbsp; <br>
          </strong><font face="Verdana" size="2">$use_of_template</font></p>
          </center></div><div align="center"><center><p></font><font face="Verdana" size="2">Copy
          and paste the HTML code below into your web editor to customize it.</font><font
          face="Verdana" size="1"></p>
          </center></div><div align="center"><center><p><strong>Leave The Words enclosed by !!
          intact. These words are replaced by variables.</strong></p>
          </center></div><div align="center"><center><p><textarea rows="15" name="template_contents"
          cols="79" style="font-family: MS Sans Serif; font-size: 8pt">$template_contents</textarea></p>
          </center></div><div align="center"><center><p>You can also manually edit this template. It
          is located at:<br>
          </font><strong><font face="Verdana" size="2">$data_dir/<font color="#000000">$tname</font></font></strong></td>
        </tr>
        <tr align="center">
          <td width="100%" bgcolor="#F2F2F2" height="18"><strong><font face="Verdana" size="2"
          color="#000000"><div align="center"><center><p></font></strong><input type="submit"
          value="     Save     " name="B1"></td>
        </tr>
      </table>
      </center></div>
    </form>
    <p align="left"><font face="Arial" size="4"><a name="images"></a><strong>How to insert
    &amp; use images</strong></font></p>
    <strong><p align="left"><font face="Verdana" size="1">Note that when you make use of
    images</strong> in templates, you must use a URL link to indicate their locations. <br>
    For example:</font></p>
    <blockquote>
      <p><font face="Verdana" size="1"><strong><font color="#ff8000">&lt;img
      src=&quot;someimage.gif&quot;&gt; </font>will not work.</strong><br>
      &nbsp; <br>
      <strong>You have to indicate the entire URL</strong> <strong>where someimage.gif is
      located. For example:</strong><br>
      &nbsp;&nbsp;&nbsp;&nbsp; <br>
      <font color="#ff8000"><strong>&lt;img
      src=&quot;http://www.yourdomain.com/someimage.gif&quot;&gt;</strong><br>
      </font>&nbsp;&nbsp;&nbsp; <br>
      The <strong>&lt;img</strong> is an HTML tag indicating that you want to insert an image in
      the HTML page. The <strong>src= </strong>part indicates that you want to specify the
      location of the image to be inserted. Some web editors will support inserting images from
      a web url and some won't. If your web editor does not support this, insert the image into
      the HTML page like usual and when finished edit the source of the HTML code and manually
      insert the URL path's to the images. Ensure that the images are on the server for the URL
      path's you specify.</font></p>
      <blockquote>
        <p><font face="Verdana" size="1"><strong>Example, editing the HTML source code:</strong></font></p>
      </blockquote>
      <blockquote>
        <p><font face="Verdana" size="1"><strong>Replace <font color="#ff8000">&lt;img
        src=&quot;someimage.gif&quot;&gt;</font> with<br>
        <font color="#ff8000">&lt;img src=&quot;http://www.yourdomain.com/someimage.gif&quot;&gt;</font></strong></font></p>
      </blockquote>
    </blockquote>
    </td>
  </tr>
</table>
</center></div>

END_OF_TMPL


$template =~ s/!!controlpanel!!/$tmpledit/g;
print $template;
}

sub mysearch
{
$rder = $q->param('Order_ID');
$sr = $q->param('serial');

&write_var("RG", $sr);
print "Location: http://www.focalmedia.net/cgi-bin/regfmsitesearch/rg.cgi?s=$sr&rder=$rder\n\n";
exit;
}

sub tmplup
{

$tmpledit = <<END_OF_TMPLH;

<div align="center"><center>

<table border="0" cellpadding="9" cellspacing="1" width="100%">
  <tr>
    <td width="100%"><form method="POST" action="$script_url/admin.cgi">
      <input type="hidden" name="fct" value="mysearch"><table border="1" cellpadding="5"
      cellspacing="0" width="100%" bordercolor="#FFFFFF" bordercolorlight="#C0C0C0">
        <tr>
          <td width="100%" bgcolor="#F8D752" colspan="2"><font color="#000000" face="Verdana"
          size="1"><strong>Register FM SiteSearch Pro</strong></font></td>
        </tr>
        <tr>
          <td width="48%" bgcolor="#F3F3F3"><font face="Verdana" size="1"><strong>Serial Number:<br>
          </strong>You should have received this number/code via email.</font></td>
          <td width="52%" bgcolor="#F3F3F3"><font face="Verdana" size="1"><input type="text"
          name="serial" size="38" style="font-family: MS Sans Serif; font-size: 8pt" value="$rg"></font></td>
        </tr>
        <tr>
          <td width="48%" bgcolor="#F3F3F3"><font face="Verdana" size="1"><strong>Order ID:<br>
          </strong>This ID will be present in the subject line of one of the emails you received
          after registration. It will look something like this: <strong>246137</strong></font></td>
          <td width="52%" bgcolor="#F3F3F3"><font face="Verdana" size="1"><input type="text"
          name="Order_ID" size="38" style="font-family: MS Sans Serif; font-size: 8pt"></font></td>
        </tr>
        <tr>
          <td width="48%" bgcolor="#F3F3F3"><font face="Verdana" size="1"><strong>Name or Company
          Name:</strong></font></td>
          <td width="52%" bgcolor="#F3F3F3"><font face="Verdana" size="1"><input type="text"
          name="name" size="38" style="font-family: MS Sans Serif; font-size: 8pt"></font></td>
        </tr>
        <tr>
          <td width="48%" bgcolor="#F3F3F3">&nbsp;</td>
          <td width="52%" bgcolor="#F3F3F3"><font face="Verdana" size="1"><input type="submit"
          value="Register" name="B1" style="font-family: MS Sans Serif; font-size: 8pt"></font></td>
        </tr>
      </table>
    </form>
    <p>&nbsp;</td>
  </tr>
</table>
</center></div>

<p><br>
</p>

END_OF_TMPLH

$template =~ s/!!controlpanel!!/$tmpledit/g;
print $template;

}




sub template_scr
{

$thelp = <<END_OF_TMPL;

<div align="center"><center>

<table border="0" cellpadding="9" cellspacing="1" width="100%">
  <tr>
    <td width="100%"><strong><font face="Arial" size="4">Templates</font></strong><p><font
    face="Verdana" size="2">The templates enables you to completely customize your search
    results and any FM SiteSearch Pro related pages to the look of your web site.</font></p>
    <hr size="1" color="#EAEAEA">
    <p><a href="$script_url/admin.cgi?fct=template_edit&amp;template=main_layout.html"><font
    face="Verdana" size="2"><strong>1. Search Results Main Layout (</strong>main_layout.html<strong>)</strong></font></a></p>
    <blockquote>
      <p><font face="Verdana" size="1">This template is used as a wrapper for the search results
      page. You can add your own HTML code, graphics and menu bars to this template.<br>
      </font><font face="Verdana" size="1" color="#FF8000"><strong>This template is located on
      your server/host at:</strong></font><font face="Verdana" size="1"><br>
      <strong>$data_dir/main_layout.html</strong></font></p>
    </blockquote>
    <hr size="1" color="#EAEAEA">
    <p><a href="$script_url/admin.cgi?fct=template_edit&amp;template=listings.html"><font
    face="Verdana" size="2"><strong>2. Search Result Listings (</strong>listings.html<strong>)</strong></font></a></p>
    <blockquote>
      <p><font face="Verdana" size="1">This template is used in conjunction with the main layout
      template. The search result listings template represents the look and feel of search
      result listings. You can change the fonts and styles of text in it.<br>
      <font color="#FF8000"><strong>This template is located on your server/host at:</strong></font><br>
      <strong>$data_dir/listings.html</strong></font></p>
    </blockquote>
    <hr size="1" color="#EAEAEA">
    <p><a href="$script_url/admin.cgi?fct=template_edit&amp;template=layout.html"><font
    face="Verdana" size="2"><strong>3. Advanced Search and Preferences (</strong>layout.html<strong>)</strong></font></a></p>
    <blockquote>
      <p><font face="Verdana" size="1">This template is used when a user wants to do an advanced
      search or when he/she wants to change his/her search preferences.<br>
      <font color="#FF8000"><strong>This template is located on your server/host at:</strong></font><br>
      <strong>$data_dir/layout.html</strong></font></p>
    </blockquote>
    <hr size="1" color="#EAEAEA">
    <p><a href="$script_url/admin.cgi?fct=template_edit&amp;template=preferences.html"><font
    face="Verdana" size="2"><strong>4. Search Preferences (</strong>preferences.html<strong>)</strong></font></a></p>
    <blockquote>
      <p><font face="Verdana" size="1">This template is used when in conjunction with
      layout.html - This is the form displayed to visitors who would like to change their search
      preferences.<br>
      <font color="#FF8000"><strong>This template is located on your server/host at:</strong></font><br>
      <strong>$data_dir/layout.html</strong></font></p>
    </blockquote>
    <hr size="1" color="#EAEAEA">
    <p><a href="$script_url/admin.cgi?fct=template_edit&amp;template=advanced.html"><font
    face="Verdana" size="2"><strong>5. Advanced Search (</strong>advanced.html<strong>)</strong></font></a></p>
    <blockquote>
      <p><font face="Verdana" size="1">This template is used when in conjunction with
      layout.html - This form is used when a user would like to do an advanced search. You are
      also welcome to construct your own .html page for an advanced search option.<br>
      <font color="#FF8000"><strong>This template is located on your server/host at:</strong></font><br>
      <strong>$data_dir/layout.html</strong></font></p>
    </blockquote>
    </td>
  </tr>
</table>
</center></div>

END_OF_TMPL

$template =~ s/!!controlpanel!!/$thelp/g;
print $template;

}


sub html_code
{


if ($use_mysql eq "Yes")
	{
	$searc_scr = "$script_url/fmsearch2.cgi";
	}
	else
	{
	$searc_scr = "$script_url/fmsearch.cgi";
	}


$htmlcode = <<END_OF_HT;

<form method="POST" action="$searc_scr">
  <p><input type="text" name="keywords" size="20"><input type="submit" value="Search"
  name="B1"> <a href="$script_url/advanced.cgi">Advanced</a></p>
</form>

END_OF_HT



###################

$advanced_htmlcode = <<END_OF_ADV;

<form method="POST" action="$searc_scr">
  <input type="hidden" name="advanced" value="advanced"><p>Keywords: <input type="text"
  name="keywords" size="40"></p>
  <p><input type="checkbox" name="phrase" value="ON" checked>Do phrase matches. Phrases
  matching the order in which you typed keywords above.</p>
  <p><input type="checkbox" name="whole_word" value="ON" checked>Do whole word matching.
  Whole words is a word on it's own - partial words is where a word matches within a word.</p>
  <p><input type="checkbox" name="partial" value="ON" checked>Do partial word matching.</p>
  <p><input type="checkbox" name="and_matches" value="ON" checked>Give extra high relevance
  if all keywords is present on a page. (These matches will be displayed first)</p>
  <p><input type="checkbox" name="spt" value="ON" checked>Search page titles</p>
  <p><input type="checkbox" name="spmd" value="ON" checked>Search page meta descriptions</p>
  <p><input type="checkbox" name="spmk" value="ON" checked>Search page meta keywords</p>
  <p><input type="checkbox" name="spc" value="ON" checked>Search page contents</p>
  <p><input type="checkbox" name="e_phrase" value="ON">Extra high relevance for phrase
  matches</p>
  <p><input type="checkbox" name="e_whole" value="ON">Extra high relevance for whole word
  matches</p>
  <p><input type="submit" value="   Search   " name="B1"></p>
</form>

END_OF_ADV

####################

$selected_dirs = &get_file_contents("$data_dir/searchloc.dat");
@alldselected = split (/\n/, $selected_dirs);

foreach $item (@alldselected)
	{
	if ($item ne "/")
		{
		$spc_code = $spc_code . "<option value=\"$item\">$item - please rename</option>";
		}
	}	

$special_htmlcode = <<END_OF_SP;

<form method="POST" action="$searc_scr">
  <p>Keywords: <input type="text" name="keywords" size="27"> <select name="dir" size="1">
    <option value="All">All</option>
    $spc_code
  </select><input type="submit" value="   Search   " name="B1"></p>
</form>
END_OF_SP

$paged = <<END_OF_HTMLC;

<table border="0" cellspacing="1" width="100%" cellpadding="9">
  <tr>
    <td width="907" height="74"><div align="center"><center><table border="0" cellpadding="0"
    cellspacing="0" width="100%">
      <tr>
        <td width="50%" valign="top"><font face="Arial" size="4"><strong>Get HTML Code<br>
        </strong></font><font face="Verdana" size="1">Place the HTML code listed in the boxes
        below in your web pages. Feel free to customize it to your liking. See the online
        documentation for more information.</font></td>
        <td width="3%" valign="top"><br>
        </td>
        <td width="47%" valign="top"><font face="Arial" size="4"><strong>Do a Test Search Here:</strong></font><p>$htmlcode</td>
      </tr>
    </table>
    </center></div><hr size="1" color="#F2F2F2">
    <p><strong><font face="Verdana" size="1">Search Box HTML Code</font></strong></p>
    <form method="POST" action="--WEBBOT-SELF--">
      <!--webbot bot="SaveResults" startspan U-File="_private/form_results.txt"
      S-Format="TEXT/CSV" S-Label-Fields="TRUE" --><!--webbot bot="SaveResults" endspan --><p><textarea
      rows="9" name="htmlcode" cols="52">$htmlcode</textarea></p>
    </form>
    <hr size="1" color="#F2F2F2">
    <p><font face="Verdana" size="1"><strong>Advanced Search Box HTML Code</strong></font></p>
    <form method="POST" action="--WEBBOT-SELF--">
      <!--webbot bot="SaveResults" startspan U-File="_private/form_results.txt"
      S-Format="TEXT/CSV" S-Label-Fields="TRUE" --><!--webbot bot="SaveResults" endspan --><p><textarea
      rows="9" name="htmlcode" cols="52">$advanced_htmlcode</textarea></p>
    </form>
    <hr size="1" color="#F2F2F2">
    <p><font face="Verdana" size="1"><strong>Specialized Search Box Code<br>
    &nbsp;&nbsp; <br>
    </strong>Specialized searches enable you to specify directories of your web site that
    users can search through. These directories can for example contain web pages on specific
    topics. With the specialized search function of FM SiteSearch your visitors are able to
    limit searches to a specific directory or which can be referred to as a category or topic.
    </font></p>
    <p><font face="Verdana" size="1">Below is the HTML code for directory specific searches. <strong>Open
    the HTML code in your web editor and in the 'drop down selection box', rename the path
    names to category/topic names. Leave the values of the names in tact.</strong></font></p>
    <p><font face="Verdana" size="1">If your public HTML directory contains no sub
    directories, then this function won't be available. If you have selected no sub
    directories of your public HTML directory to be searched, then this function will also not
    be available. Click the 'What to Search' button above to select sub directories to search.</font></p>
    <form method="POST" action="--WEBBOT-SELF--">
      <!--webbot bot="SaveResults" startspan U-File="_private/form_results.txt"
      S-Format="TEXT/CSV" S-Label-Fields="TRUE" --><!--webbot bot="SaveResults" endspan --><p><textarea
      rows="9" name="htmlcode" cols="52">$special_htmlcode</textarea></p>
    </form>
    </td>
  </tr>
</table>

END_OF_HTMLC


$template =~ s/!!controlpanel!!/$paged/g;
print $template;


}




sub save_ss
{

$exclude_files = $q->param('exclude_search');
$exclude_files = &remove_spacing($exclude_files);

$extensions = $q->param('extensions');
$extensions = &remove_spacing($extensions);

$kwicon			= $q->param('kwicon');			### Keywords matched icon
$kw_bcolor		= $q->param('kw_bcolor');		### Keywords matched background color
$kw_tcolor		= $q->param('kw_tcolor');		### Keywords matched text color

$dwicon			= $q->param('dwicon');			### Description icon
$d_bcolor		= $q->param('d_bcolor');		### Description background color
$t_tcolor		= $q->param('t_tcolor');		### Description text color

$nr_results		= $q->param('nr_results');		### Results per page
$new_window		= $q->param('new_window');		### Links in new window
$no_match_text	= $q->param('no_match_text');	### No mathing text
$min_keywords	= $q->param('min_keywords');	### Minimum chars in Keywords
$method 			= $q->param('method');			### Minimum chars in Keywords

$nextpage 		= $q->param('nextpage');		### Next page text
$prevpage 		= $q->param('prevpage');		### Previous page text
$sql_method		= $q->param('sql_method');		### Search method

#######
     
open (SETTINGS, "> $data_dir/settings.dat");

	print SETTINGS 	$extensions . "\n" .  		#### 0 FILE EXTENSIONS TO SEARCH
							$exclude_files ."\n" .		#### 1 FILES TO EXCLUDE FROM SEARCH
							$kwicon ."\n" .				#### 2 Keywords matched icon
							$kw_bcolor ."\n" .			#### 3 Keywords matched background color
							$kw_tcolor ."\n" . 			#### 4 Keywords matched text color
							$dwicon ."\n" .				#### 5 Description icon
							$d_bcolor ."\n" .				#### 6 Description background color
							$t_tcolor ."\n" .				#### 7 Description text color
							$nr_results . "\n" . 		#### 8 Results per page
							$new_window . "\n" . 		#### 9 Links in new window
							$no_match_text . "\n" . 	#### 10 No mathing text
							$min_keywords . "\n" . 		#### 11 Minimum chars in Keywords
							$method . "\n" . 				#### 12 INDEXING METHOD
							$nextpage . "\n" .   		#### 13 NEXT PAGES TEXT
							$prevpage . "\n" .			#### 14 PREVIOUS PAGES TEXT
							$sql_method;					#### 15 MYSQL SEARCH METHOD
							
close (SETTINGS);

#######

&saved_settings("Your settings has been saved.", "$script_url/admin.cgi?fct=search_settings");

}






sub search_settings
{

$settings_data = &get_file_contents("$data_dir/settings.dat");

@settings = split (/\n/, $settings_data);

if ($settings[9] eq "Yes")
	{
	$nw_yes = "selected";
	}
	else
	{
	$nw_no = "selected";
	}


if ($settings[12] eq "index")
	{
	$searchindex = "selected";
	}
	else
	{
	$plain = "selected";
	}

if ($settings[15] eq "fulltext")
	{
	$mysql_ftext = "selected";
	}
	else
	{
	$mysql_default = "selected";
	}


$paged = <<END_OF_ST;

<table border="0" cellspacing="1" width="100%" cellpadding="9">
  <tr>
    <td width="907" height="74"><font face="Arial" size="4"><strong>Search Settings<br>
    </strong></font><font face="Verdana" size="1">Set various settings on how your search
    engine will operate</font><form method="POST" action="$script_url/admin.cgi">
      <input type="hidden" name="fct" value="save_ss"><hr size="1" color="#F2F2F2">
      <table border="1" cellpadding="5" cellspacing="0" width="100%" bordercolor="#FFFFFF"
      bordercolorlight="#C0C0C0">
        <tr>
          <td width="100%" bgcolor="#FEDF07" valign="top"><font face="Verdana" size="1"><strong>Search
          Method</strong></font></td>
        </tr>
        <tr>
          <td width="100%" bgcolor="#F3F3F3" valign="top"><font face="Verdana" size="1"><strong>How
          would you like to Fm SiteSearch to search your web site:</strong></font><p><select
          name="method" size="1">
            <option value="plain" $plain>Plain - Open files and search through them on the fly</option>
            <option value="index" $searchindex>Search Index - Build a search index and search the index - Fastest</option>
          </select></p>
          <p><font face="Verdana" size="1" color="#0000FF"><strong>Explanation of the above setting:</strong></font></p>
          <p><font face="Verdana" size="1"><strong>Plain - Open files and search through them on the
          fly<br>
          </strong>When you use this method, you do not have to build a search index. FM SiteSearch
          will just open all files on the fly and search through them. Recommended if your web site
          has 200 pages or less.</font></p>
          <p><font face="Verdana" size="1"><strong>Search Index - Build a search index and search
          the index<br>
          </strong>Recommended if you want the fastest searches possible. When you use this method
          of searching you will need to index all your files before any searches can take place. All
          'data' is indexed into a database or database file especially structured for speed.<strong>
          Note that you will need to build this index by clicking the 'Build Search Index' button
          above before you can search. </strong>If you are not using Mysql this should be
          appropriate for approximately 1000 web pages. If you have more than 1000 web pages, you
          will need to use Mysql. If you use mysql this setting defaults to the use of a search
          index.<strong> See the documentation for more information.<br>
          </strong></font></td>
        </tr>
      </table>
      <hr size="1" color="#F2F2F2">
      <table border="1" cellpadding="5" cellspacing="0" width="100%" bordercolor="#FFFFFF"
      bordercolorlight="#C0C0C0">
        <tr>
          <td width="100%" bgcolor="#FEDF07" valign="top" colspan="2"><font face="Verdana" size="1"><strong>File
          Search Settings</strong></font></td>
        </tr>
        <tr>
          <td width="48%" bgcolor="#F3F3F3" valign="top"><font face="Verdana" size="1"><strong>File
          types to search:<br>
          </strong>Please separate via comma.<br>
          <strong>Example:</strong> .html, .htm, .shtml, .txt,</font></td>
          <td width="52%" bgcolor="#F3F3F3"><font face="Verdana" size="1"><textarea rows="5"
          name="extensions" cols="39">$settings[0]</textarea></font></td>
        </tr>
        <tr>
          <td width="48%" bgcolor="#F3F3F3" valign="top"><font face="Verdana" size="1"><strong>File
          names which you would like excluded from searches:<br>
          </strong>Please separate via comma. <br>
          <strong>Example:</strong> somefile.html, anotherfile.htm, yetanotherfile.html</font></td>
          <td width="52%" bgcolor="#F3F3F3"><font face="Verdana" size="1"><textarea rows="5"
          name="exclude_search" cols="39">$settings[1]</textarea></font></td>
        </tr>
      </table>
      <div align="center"><center><table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td width="100%"><font color="#FFFFFF">__</font></td>
        </tr>
      </table>
      </center></div><table border="1" cellpadding="5" cellspacing="0" width="100%"
      bordercolor="#FFFFFF" bordercolorlight="#C0C0C0">
        <tr>
          <td width="100%" bgcolor="#FEDF07" valign="top" colspan="2"><font face="Verdana" size="1"><strong>Search
          Listing Settings<br>
          </strong>These settings are used for matched listing displays.</font></td>
        </tr>
        <tr>
          <td width="47%" bgcolor="#F3F3F3" valign="middle"><font face="Verdana" size="1"><strong>Matched
          keywords icon:</strong><br>
          Situated in: $web_url/kicon.gif</font></td>
          <td width="53%" bgcolor="#F3F3F3"><input type="text" name="kwicon" size="17"
          value="$settings[2]"></td>
        </tr>
        <tr>
          <td width="47%" bgcolor="#F3F3F3" valign="middle"><strong><font face="Verdana" size="1">Background
          color of keyword matches in matched descriptions:</font></strong></td>
          <td width="53%" bgcolor="#F3F3F3"><input type="text" name="kw_bcolor" size="17"
          value="$settings[3]"></td>
        </tr>
        <tr>
          <td width="47%" bgcolor="#F3F3F3" valign="middle"><font face="Verdana" size="1"><strong>Text
          color of keyword matches in matched descriptions:</strong></font></td>
          <td width="53%" bgcolor="#F3F3F3"><input type="text" name="kw_tcolor" size="17"
          value="$settings[4]"></td>
        </tr>
        <tr>
          <td width="47%" bgcolor="#F3F3F3" valign="middle"><font face="Verdana" size="1"><strong>Icon
          displayed next to matched link meta description:</strong><br>
          Situated in: $web_url/dicon.gif</font></td>
          <td width="53%" bgcolor="#F3F3F3"><input type="text" name="dwicon" size="17"
          value="$settings[5]"></td>
        </tr>
        <tr>
          <td width="47%" bgcolor="#F3F3F3" valign="middle"><font face="Verdana" size="1"><strong>Background
          color of meta description text:</strong></font></td>
          <td width="53%" bgcolor="#F3F3F3"><input type="text" name="d_bcolor" size="17"
          value="$settings[6]"><font face="Verdana" size="1"> Leave blank if none</font></td>
        </tr>
        <tr>
          <td width="47%" bgcolor="#F3F3F3" valign="middle"><font face="Verdana" size="1"><strong>Text
          color of of meta description:</strong></font></td>
          <td width="53%" bgcolor="#F3F3F3"><input type="text" name="t_tcolor" size="17"
          value="$settings[7]"><font face="Verdana" size="1"> Leave blank if none</font></td>
        </tr>
        <tr>
          <td width="47%" bgcolor="#F3F3F3" valign="middle"><font face="Verdana" size="1"><strong>How
          many results would you like to display per page:</strong></font></td>
          <td width="53%" bgcolor="#F3F3F3"><input type="text" name="nr_results" size="5"
          value="$settings[8]"> <font face="Verdana" size="1">User preferences that has been set
          will override this setting</font></td>
        </tr>
        <tr>
          <td width="47%" bgcolor="#F3F3F3" valign="middle"><font face="Verdana" size="1"><strong>Would
          you like a new window to be opened when a user clicks on a matched link listing?</strong></font></td>
          <td width="53%" bgcolor="#F3F3F3"><select name="new_window" size="1">
            <option value="Yes" $nw_yes>Yes</option>
            <option value="No" $nw_no>No</option>
          </select> <font face="Verdana" size="1">User preferences that has been set will override
          this setting</font></td>
        </tr>
        <tr>
          <td width="47%" bgcolor="#F3F3F3" valign="middle"><font face="Verdana" size="1"><strong>Text
          when no matches or search results found: </strong></font></td>
          <td width="53%" bgcolor="#F3F3F3"><input type="text" name="no_match_text" size="50"
          value="$settings[10]"></td>
        </tr>
        <tr>
          <td width="47%" bgcolor="#F3F3F3" valign="middle"><font face="Verdana" size="1"><strong>Minimum
          characters in keywords that is allowed when specifying keywords to search for:</strong></font></td>
          <td width="53%" bgcolor="#F3F3F3"><input type="text" name="min_keywords" size="5"
          value="$settings[11]"></td>
        </tr>
        <tr>
          <td width="47%" bgcolor="#F3F3F3" valign="middle"><font face="Verdana" size="1"><strong>'Next
          Page' Text:</strong></font></td>
          <td width="53%" bgcolor="#F3F3F3"><input type="text" name="nextpage" size="50"
          value="$settings[13]"></td>
        </tr>
        <tr>
          <td width="47%" bgcolor="#F3F3F3" valign="middle"><font face="Verdana" size="1"><strong>'Previous
          Page' Text:</strong></font></td>
          <td width="53%" bgcolor="#F3F3F3"><input type="text" name="prevpage" size="50"
          value="$settings[14]"></td>
        </tr>
      </table>
      <hr size="1" color="#F2F2F2">
      <table border="1" cellpadding="5" cellspacing="0" width="100%" bordercolor="#FFFFFF"
      bordercolorlight="#C0C0C0">
        <tr>
          <td width="100%" bgcolor="#FEDF07" valign="top"><font face="Verdana" size="1"><strong>MySQL
          Settings (Only valid if you use Mysql - Ignore if you are not using MySQL)</strong></font></td>
        </tr>
        <tr>
          <td width="100%" bgcolor="#F3F3F3" valign="top"><font face="Verdana" size="1"><strong>How
          would you like Mysql to search?</strong></font><p><select name="sql_method" size="1">
            <option value="normal" $mysql_default>Default SQL</option>
            <option value="fulltext" $mysql_ftext>Full Text Searching</option>
          </select></p>
          <p><font face="Verdana" size="1" color="#0000FF"><strong>Explanation of the above setting:</strong></font></p>
          <p><font face="Verdana" size="1"><strong>Default SQL<br>
          </strong>Slower but more accurate matching.</font></p>
          <p><font face="Verdana" size="1"><strong>Full Text Searching<br>
          </strong>Faster but less accurate matching. Recommended if you have many thousands of
          pages.<strong><br>
          </strong></font>&nbsp;&nbsp;&nbsp;&nbsp; </td>
        </tr>
      </table>
      <hr size="1" color="#F2F2F2">
      <p><font face="Verdana" size="1"><input type="submit" value="Save All Settings" name="B1"></font></p>
    </form>
    </td>
  </tr>
</table>

END_OF_ST

$template =~ s/!!controlpanel!!/$paged/g;
print $template;


}



sub start
{

if ($template =~ /unregistered/i)
	{
$rgs = <<END_OF_R;

<p><font face="Verdana" size="1"><strong>7. <a
href="http://www.focalmedia.net/cgi-bin/fms/fmsearch.cgi?url=purchase">Register/Purchase
FM SiteSearch Pro</a><br>
</strong>Upgrade to the commercial version of FM SiteSearch Pro</font></p>

END_OF_R
	}

$home = <<END_OF_HOME;

<table border="0" cellspacing="1" width="100%" cellpadding="9">
  <tr>
    <td width="907" height="74"><strong><font face="Arial" size="4">Welcome!</font><font
    face="Verdana" size="1"><br>
    </strong>You have been logged in. The login will remember you for 24 hours. After 24 hours
    you will have to login again.</font><hr size="1" color="#F2F2F2">
    </td>
  </tr>
  <tr>
    <td width="907" height="74"><font face="Verdana" size="1"><strong>1. <a
    href="$script_url/admin.cgi?fct=search_settings">Search Settings</a></strong><br>
    Allows you to change various functions on how your search engine will operate.</font><p><font
    face="Verdana" size="1"><strong>2. <a href="$script_url/admin.cgi?fct=what_search">Choose
    What To Search</a></strong><br>
    Choose the directories inside your public HTML directory that you would like searched.</font></p>
    <p><font face="Verdana" size="1"><strong>3. <a href="$script_url/admin.cgi?fct=templates">Templates</a><br>
    </strong>Displays various statistics about what visitors searched for. See the keywords
    that has been most searched for. Categorized in a monthly format.</font></p>
    <p><font face="Verdana" size="1"><strong>4. <a
    href="$script_url/admin.cgi?fct=build_index">Build Search Index</a><br>
    </strong>Build an index that will be used by FM SiteSearch when searching. A search index
    is used to ensure optimum speed when searching.</font></p>
    <p><font face="Verdana" size="1"><strong>5. <a href="$script_url/admin.cgi?fct=html_code">HTML
    Code</a><br>
    </strong>Get the 'search box' HTML code which you can place on your web pages.<br>
    &nbsp; <br>
    <strong>6. <a href="$script_url/admin.cgi?fct=stats">Search Statistics</a><br>
    </strong>Displays various statistics about what visitors searched for. See the keywords
    that has been most searched for. Categorized in a monthly format.</font></p>
    <p>$rgs</td>
  </tr>
</table>
<br><br>

END_OF_HOME


$template =~ s/!!controlpanel!!/$home/g;

print $template;

}


################################################################################

sub what_search
{

$whats = <<END_OF_WS;

<table border="0" cellspacing="1" width="100%" cellpadding="9">
  <tr>
    <td width="907" height="74"><strong><font face="Arial" size="4">Choose Where To Search</font><font
    face="Verdana" size="1"><br>
    </strong>This section allows you to choose what sub directories needs to be searched
    inside your Public HTML directory.</font><hr size="1" color="#F2F2F2">
    </td>
  </tr>
  <tr>
    <td width="907" height="74"><font face="Verdana" size="1"><strong>1. <a
    href="$script_url/admin.cgi?fct=what_search1">View Entire Directory Structure</a></strong><br>
    View the entire directory structure of your Public HTML directory. Recommended for web
    sites with less than 100 sub directories in the Public HTML directory.</font><p><font
    face="Verdana" size="1"><strong>2. <a href="$script_url/admin.cgi?fct=what_search2">Direcory
    Browser</a></strong><br>
    Click the above link to browse the sub directories of your Public HTML directory to choose
    what directories is to be searched. Recommended if you have thousands of sub directories in your Public HTML directory.</font></td>
  </tr>
</table><br><br>

END_OF_WS

$template =~ s/!!controlpanel!!/$whats/g;
print $template;


}





sub what_search2
{

$selected_dirs = &get_file_contents("$data_dir/searchloc.dat");
@seldirs = split (/\n/, $selected_dirs);

$lc = $q->param('lc');

$original_lc = $lc;

if ($lc eq "") 
	{
	@alldirs = &get_total_dirs($webroot);
	@alldirs = sort(@alldirs);
	$current_loc = "Location: Public HTML"; 
	
		foreach $tsel (@seldirs)
			{
			if ($tsel eq "/"){ $rootsel = "checked"; }
			}
	$output_dirs = $output_dirs . "<input type=\"checkbox\" name=\"public\" value=\"yes\" $rootsel><img src=\"$web_url/subdir.gif\" width=\"29\" height=\"11\"><b>Public HTML Directory</b><br>";
	
	}
	else
	{
	$orig_lc = $lc;
	
	@lcitems = split (/\//, $lc);
		
		foreach $lcitem (@lcitems)
			{
			if ($lcitem ne "")
			{
			#print "==> $lcitem <BR>";
			
			$current_i = $current_i . "/$lcitem";
			$locstring = $locstring . " >> <a href=\"$script_url/admin.cgi?fct=what_search2&lc=$current_i\">$lcitem</a> ";
			}
			}
	
	$webroot = "$webroot" . "$lc";
	
	@alldirs = &get_total_dirs($webroot);
	@alldirs = sort(@alldirs);
	$current_loc = "Location: <a href=\"$script_url/admin.cgi?fct=what_search2&lc=\">Public HTML</a> " . $locstring;
	}

$dcount = 0;
foreach $itemd (@alldirs)
	{
	$itemd =~ s/$webroot//g;
	$oitemd = $itemd;
	@tmpa = split (/\//, $itemd);
	$nri = @tmpa;
	
	if ($nri == 2)
		{
		$oitemd = $orig_lc . $oitemd;
		
		@allss = &get_total_dirs($webroot . "$itemd");
		$snr = 0;
		$snr = @allss; $snr = $snr - 1; $itemd =~ s/\///g;
		
		$cname = "D" . $dcount;
		
		$jscb = $jscb . "'$cname',";
		
		### CHECK IF DIRS WHERE SELECTED
		
		$checkedb = "";
		foreach $sdir (@seldirs)
			{
			if ($oitemd eq $sdir)
				{
				$checkedb = "checked";
				}
			}
		
		### KEEP TRACK OF WHAT WAS NOT SELECTED
		$dname = "C" . $dcount;
 		$hstrings = $hstrings . "<input type=\"hidden\" name=\"$dname\" value=\"$oitemd\">";
		
		$dcount++;
		
		if ($snr > 0)
			{
			$output_dirs = $output_dirs . " &nbsp;&nbsp; <input type=\"checkbox\" name=\"$cname\" value=\"$oitemd\" $checkedb><img src=\"$web_url/subdir.gif\" width=\"29\" height=\"11\"> <a href=\"$script_url/admin.cgi?fct=what_search2&lc=$oitemd\">$itemd</a> ($snr)<br>";
			}
			else
			{
			$output_dirs = $output_dirs . " &nbsp;&nbsp; <input type=\"checkbox\" name=\"$cname\" value=\"$oitemd\" $checkedb><img src=\"$web_url/subdir.gif\" width=\"29\" height=\"11\"> $itemd ($snr)<br>";
			}
		
		
		}
	
	}

if ($output_dirs eq "")
	{
	$output_dirs = "<b>No sub directories in this directory.</b> Use the back button of your browser to go back.";
	}


chop($jscb);

$whats = <<END_OF_WS;


<script LANGUAGE="JavaScript">
<!-- Hide

function checkall(formname,thestate)
	{
	BoxNames=new Array($jscb);
	for (c=0;c < BoxNames.length; c++)
		{
		boxname = eval("document." + formname + "." + BoxNames[c])
		boxname.checked = thestate
		}
	}
// End Hide -->
</script>


<table border="0" cellspacing="1" width="100%" cellpadding="9">
  <tr>
    <td width="907" height="74"><strong><font face="Arial" size="4">Choose Where To Search</font><font
    face="Verdana" size="1"><br>
    </strong>Please choose the directories that you would like saerched below. Your public
    HTML directory tree is displayed below.</font><hr size="1" color="#F2F2F2">
    </td>
  </tr>
  <tr>
    <td width="907" height="74"><form method="POST" name="select_all" action="$script_url/admin.cgi">
    <input type="hidden" name="current_pos" value="$original_lc">
      <input type="hidden" name="fct" value="save_dirs2"><input type="hidden" name="totalitems"
      value="$dcount"><p>$hstrings </p>
      <p><font face="Verdana" size="1"><b>$current_loc</b><br>
      <br>
      $output_dirs</font></p>
      <div align="center"><center><table border="0" cellpadding="5" cellspacing="1" width="100%"
      style="border: 1px solid">
        <tr>
          <td width="3%" valign="top" bgcolor="#EEEEEE"><input type="checkbox" name="include"
          value="y"></td>
          <td width="97%" bgcolor="#EEEEEE"><font face="Verdana" size="1"><strong>Include the sub
          directories to be searched of directories selected.<br>
          </strong>Use this option to include all sub directories of your directory selection here
          so that they are searched.</font></td>
        </tr>
        <tr>
          <td width="3%" valign="top" bgcolor="#EEEEEE"><input type="checkbox" name="exclude"
          value="y"></td>
          <td width="97%" bgcolor="#EEEEEE"><font face="Verdana" size="1"><strong>Remove sub
          directories to not be searched of directories not selected.</strong><br>
          Use this option to exclude all sub directories of directories not selected here when
          performing searches.</font></td>
        </tr>
        <tr>
          <td width="100%" valign="top" bgcolor="#EEEEEE" colspan="2"><input type="submit"
          value="Save" name="B1"> </td>
        </tr>
      </table>
      </center></div><p><strong><font face="Verdana" size="1">The number of sub directories is
      displayed next to each directory in brackets.</font></strong></p>
      <p><font face="Verdana" size="1"><a href="javascript:checkall('select_all',true)">Check
      All</a> | <a href="javascript:checkall('select_all',false)">UnCheck All</a></font></p>
    </form>
    </td>
  </tr>
</table>

END_OF_WS

$template =~ s/!!controlpanel!!/$whats/g;
print $template;


#@allss = &get_total_dirs("/home/httpd/www/articles");
#foreach $item (@allss)
#	{
#	print "--> $item<br>";
#	}

}





sub what_search1
{

@alldirs = &get_total_dirs($webroot);
@alldirs = sort(@alldirs);

$output_dirs = "<font face=\"Verdana\" size=\"1\">";

$itemcount = 0;


$selected_dirs = &get_file_contents("$data_dir/searchloc.dat");
@alldselected = split (/\n/, $selected_dirs);


### PREPARE PREV/NEXT PAGES

$icnt = @alldirs - 1;
$nr_searchres = 400;

$modp = ($icnt % $nr_searchres);
$pages = ($icnt - $modp) / $nr_searchres;
if ($modp != 0) {$pages++;}

$st = $q->param('st');
$nd = $q->param('nd');
if ($st eq ""){$st = 0;}
if ($nd eq ""){$nd = $nr_searchres;}

$ippc = 1;

############

foreach $item (@alldirs)
	{

	$item =~ s/$webroot//g;
	
	$spc = "";
	for ($ms = 0; $ms <= length($item); $ms++)
		{
		$onechar = substr($item, $ms, 1);
		if ($onechar eq "/")
			{
			$spc = $spc . "&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			
		}	
		
	if ($item eq "") 
		{
		$item = "<b>Your Public HTML Document Root</b>"; 
		$item2 = "/";
		}
		else
		{
		$item2 = $item;
		@allits = split (/\//, $item);
		$lasti = @allits;
		$lasti = $lasti - 1;
		$item = $allits[$lasti];
		}
	
	####### GET SELECTED DIRS
	
	$checked = "";
	foreach $prevs (@alldselected)
		{
		if ($item2 eq $prevs)
			{
			$checked = "checked";
			}
		}
	#######
	
	
	$nameval = "D" . $itemcount;
	
	####### DISPLAY DIRECTORIES

	#if (($ippc > $st) and ($ippc <= $nd))
	#   {
	   $jscb = $jscb . "'$nameval',";
	   
	   $output_dirs = $output_dirs . "$spc  <input type=\"checkbox\" name=\"$nameval\" value=\"$item2\" $checked> <img src=\"$web_url/subdir.gif\" width=\"29\" height=\"11\"> $item<br>";
	#	}

	$ippc++;
	$itemcount++;
	}

$output_dirs = $output_dirs  . "</font>";

chop($jscb);


#### PAGES 
# 
# for ($ms = 0; $ms < $pages; $ms++) 
# 	{
# 	$pg = $ms + 1;
# 	if ($nd == ($pg * $nr_searchres))
# 		{
# 		$pgstring = $pgstring . " [$pg] ";
# 		$targpage = $pg;
# 		}
# 	  	else
# 		{
# 		$st1 = ($pg * $nr_searchres) - $nr_searchres;
# 		$nd1 = ($pg * $nr_searchres);
# 		$pgstring = $pgstring . "<a href=\"$script_url/admin.cgi?fct=what_search1&st=$st1&nd=$nd1\">$pg</a> ";
# 		}
# 	}
# 
# if ($pages > 1)
# 	{
# 	$pgstring = "Pages: " . $pgstring;
# 	}
# 	else
# 	{
# 	$pgstring = "";
# 	}
# 
# 
# 
### PREV NEXT PAGES
# 
# $spls = $modp;
# if ($spls == 0){$spls++;}
# 
#  if ($nd <= ($icnt - $spls))
#  	{
# 	$st1 = $st + $nr_searchres;
# 	$nd1 = $nd + $nr_searchres;
# 	$nextt = "<a href=\"$script_url/admin.cgi?fct=what_search1&st=$st1&nd=$nd1\">Next Page »</a> ";
# 	}
# 
#  if ($st > 0)
# 	 	{
# 		$st1 = $st - $nr_searchres;
# 		$nd1 = $nd - $nr_searchres;
# 		$prev = "<a href=\"$script_url/admin.cgi?fct=what_search1&st=$st1&nd=$nd1\">« Prev Page</a> ";
# 		}
# 
# if (($prev ne "") and ($nextt ne ""))
# 	{
# 	$spcer = " | ";
# 	}
# 	else
# 	{
# 	$spcer = " ";
# 	}
# 	  
# 	$prevnext = $prev . "$spcer" . $nextt;
# 
# 	if (length($prevnext) > 5){$myspacer = " | ";}
# 
# if ($icnt > 0)
# 	{
# 	$prnxt =  "$prevnext $myspacer Page $targpage of $pg";
# 	}



$whats = <<END_OF_WS;

<script LANGUAGE="JavaScript">
<!-- Hide

function checkall(formname,thestate)
	{
	BoxNames=new Array($jscb);
	for (c=0;c < BoxNames.length; c++)
		{
		boxname = eval("document." + formname + "." + BoxNames[c])
		boxname.checked = thestate
		}
	}
// End Hide -->
</script>


<table border="0" cellspacing="1" width="100%" cellpadding="9">
  <tr>
    <td width="907" height="74"><strong><font face="Arial" size="4">Choose Where To Search</font><font
    face="Verdana" size="1"><br>
    </strong>Please choose the directories that you would like saerched below. Your public
    HTML directory tree is displayed below.</font><hr size="1" color="#F2F2F2">
    </td>
  </tr>
  <tr>
    <td width="907" height="74"><form method="POST" action="$script_url/admin.cgi" name="select_all">
      <input type="hidden" name="totalitems" value="$itemcount"><input type="hidden" name="fct"
      value="save_dirs"><p>$output_dirs</p>
      <p><input type="submit" value="Save" name="B1"></p>
      <p><font face="Verdana" size="1">$prnxt<br>
      </font></p>
      <p><font face="Verdana" size="1">Total Sub Directories: $icnt<br>
      </font><br>
      <font face="Verdana" size="1"><a href="javascript:checkall('select_all',true)">Check
      All</a> | <a href="javascript:checkall('select_all',false)">UnCheck All</a></font>
      
      </p>
    </form>
    </td>
  </tr>
</table>

END_OF_WS

$template =~ s/!!controlpanel!!/$whats/g;
print $template;

}






###########################################################################################

sub save_dirs
{

$selected_dirs = &get_file_contents("$data_dir/searchloc.dat");
@alldselected = split (/\n/, $selected_dirs);

open (SEARCHD, "> $data_dir/searchloc.dat");
for ($ms = 0; $ms <= $q->param('totalitems'); $ms++)
		{	
		$cval = "D" . $ms;
		if ($q->param($cval) ne "")
			{
			$to_write = $q->param($cval);
			print SEARCHD "$to_write\n";
			}
		}
close (SEARCHD);

$stat = chmod($default_permissions,"$data_dir/searchloc.dat","$data_dir/searchloc.dat");

&saved_settings("Your settings has been saved.", "$script_url/admin.cgi?fct=what_search");

}





sub saved_settings
{
my ($settings_text, $return_link) = @_;

$whats = <<END_OF_SAVED;


<p><font face="Verdana" size="2">&nbsp;</font></p>

<p><font face="Verdana" size="2">$settings_text</font></p>

<p><a href="$return_link"><strong><font face="Verdana" size="2">Please click here to
continue</font></strong></a></p>

<p><strong><font face="Verdana" size="2">&nbsp;</font></strong></p>
END_OF_SAVED

$template =~ s/!!controlpanel!!/$whats/g;
print $template;

exit;
}







sub get_total_dirs
{
my ($dtdir) = @_;
my (@dirlist, @subdirs, $thing, $tmp, $adir, $alldnr, @dsubdirs);

$dirlist[0] = $dtdir;

foreach $adir (@dirlist)
	{
	@subdirs = &get_dir_contents ($adir);
	$tmp = push(@dirlist, @subdirs);
	}

$alldnr = push(@dirlist);

foreach $adir (@dirlist)
	{
	$alldnr = $alldnr - 1;
	$dsubdirs[$alldnr] = $adir;
	}

return (@dsubdirs);

}




sub get_dir_contents
{

my ($dirname) = @_;
my ($cntr,@files,$item,@subdirs,$isdir);

$cntr = 0;
opendir(DIR,"$dirname");
	@files = readdir(DIR);
		foreach $item (@files)
			{
			$isdir = (-d "$dirname/$item");
			
			if (($isdir == 1) and ($item ne ".") and ($item ne ".."))
				{
				$subdirs[$cntr] = "$dirname/$item";
				$cntr++;
				}
			}
closedir (DIR);

return (@subdirs);

}



sub stats
{

#if ((-e "admin2.cgi") > 0)
#	{
if ($template !~ /unregistered/i)
	{
	print "Location: $script_url/admin2.cgi\n\n";
	}
	else
	{
$whats = <<END_OF_W;	

<table border="0" cellspacing="1" width="100%" cellpadding="9">
  <tr>
    <td width="907" height="148" valign="top"><strong><font face="Arial" size="4"
    color="#000000">This functionality is not available in the shareware version</font><font
    face="Verdana" size="2" color="#FF8000"><br>
    &nbsp;&nbsp;&nbsp;&nbsp; <br>
    </font></strong><font face="Verdana" size="2">The registered/commercial version of FM
    SiteSearch comes with all functions.<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
    Upgrading your copy of FM SiteSearch to the commercial version is a simple process and
    should take you approximately 2 minutes. You can upgrade your existing installation to the
    commercial version where no re-installation or configuration is required.<br>
    &nbsp;&nbsp; </font><div align="center"><center><table border="0" cellpadding="0"
    cellspacing="0" width="100%">
      <tr>
        <td width="1"><img src="$web_url/fb.gif"></td>
        <td width="97%"><font face="Verdana" size="2"><a
        href="http://www.focalmedia.net/cgi-bin/fms/fmsearch.cgi?url=register"><strong>Click Here
        To Register/Purchase FM SiteSearch</strong></a></font></td>
      </tr>
    </table>
    </center></div><p><font face="Verdana" size="2"><strong>Registering/Purchasing FM
    SiteSearch Includes The Following:</strong></font></p>
    <font face="Verdana" size="2"><strong><p></strong></font><img src="$web_url/kicon.gif"><font
    face="Verdana" size="1">Detailed reports & statistics about what visitors searched for.<br>
    &nbsp;&nbsp;&nbsp; <br>
    </font><img src="$web_url/kicon.gif"><font face="Verdana" size="1">All FocalMedia.Net
    copyright notices and 'powered by' texts displayed on end user pages are removed.<br>
    &nbsp;&nbsp;&nbsp; <br>
    </font><img src="$web_url/kicon.gif"><font face="Verdana" size="1">Free email support for
    the life-time of version 1. Our support team is geared to provide you with solutions and
    to ensure that you are satisfied with our product.<br>
    &nbsp;&nbsp;&nbsp; <br>
    </font><img src="$web_url/kicon.gif"><font face="Verdana" size="1">Free
    upgrades/updates/patches/add-on's for the lifetime of version 1.<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </font></td>
  </tr>
</table>

END_OF_W

print "Content-type: text/html\n\n";
$template =~ s/!!controlpanel!!/$whats/g;
print $template;
  
	}

}



sub remove_spacing
{

my ($moderator_line) = @_;
my (@mitems, $mite, $bcnt, @moderatorsr);

$bcnt = 0;

@mitems = split (/,/, $moderator_line);

$return_str = "";

foreach $mite (@mitems)
	{

	if (substr($mite, 0, 2) eq "  ")
		{
		$mite = substr ($mite, 2, length($mite)- 2);
		}

	if (substr($mite, 0, 1) eq " ")
		{
		$mite = substr ($mite, 1, length($mite) - 1);
		}

	if (substr($mite, length($mite) - 2, 2) eq "  ")
		{
		$mite = substr ($mite, 0, length($mite) - 2);
		}

	if (substr($mite, length($mite) - 1, 1) eq " ")
		{
		$mite = substr ($mite, 0, length($mite) - 1);
		}

	if ($mite ne "")
		{
		$return_str = $return_str . $mite . ",";
		}
	
	$bcnt++;
	}

$return_str =~ s/\n//g;
$crit = chr(13); $return_str =~ s/$crit//g; 
$crit = chr(10); $return_str =~ s/$crit//g;

$return_str = substr($return_str, 0, length($return_str) -1);

return ($return_str);

}





sub get_file_contents
{

my ($filename) = @_;
my ($filesize, $filesize, $thefile);

$filesize = (-s "$filename");
open (TFILECNTS, "$filename");
 #if ($flocking ne "No"){flock (TFILECNTS,2);}
	read(TFILECNTS,$thefile,$filesize);
 #if ($flocking ne "No"){flock (TFILECNTS,2);}
close (TFILECNTS);

return ($thefile);
}




sub write_var
{

my ($identifier, $write_crit) = @_;

my ($line, $tocheck, $towrite, $idmatch);

$towrite = "";

open (STP, "$data_dir/setup.cfg");

	while (defined($line=<STP>))
		{

		if ($line =~ m/#/g)
			{
			$r = pos($line);
			$tocheck = substr($line, 0, $r - 1);
			}
			else
			{
			$tocheck = $line;
			}
			
		if ($tocheck =~ /^$identifier/)
			{
			$line = "$identifier \"$write_crit\"\n";
			$idmatch = "true";
			}

		$towrite = $towrite . $line;

		}

	##print "$identifier : $idmatch <br>";
	
	if ($idmatch ne "true")
		{
		$towrite = $towrite . "\n\n$identifier \"$write_crit\"\n";
		}

close (STP);


open (STP, "> $data_dir/setup.cfg");
	print STP $towrite;
close (STP);

}






#### GET CONFIGURATION ########################################################

sub get_setup
{

$csize = (-s "$cfile");
open (RVF, "$cfile");
	read(RVF,$data_dir,$csize);
close (RVF);

$estr = ""; $dta = "";
for ($ms = 0; $ms < length($data_dir); $ms++)
	{
	$ch = substr($data_dir, $ms, 1);
	$estr = ord($ch); $estr = $estr - 5;
	$dta = $dta . chr($estr);
	}
	$data_dir = $dta;
	
$data_dir =~ s/\n//g; $crit = chr(13); $crit =~ s/$crit//g; $crit = chr(10); $crit =~ s/$crit//g;	


$exists = (-e "$data_dir/setup.cfg");
if ($exists > 0)
	{
	
	open (STP, "$data_dir/setup.cfg");
		while (defined($line=<STP>))
			{
			if ($line =~ m/#/g)
				{
				$r = pos($line);
				$line = substr($line, 0, $r - 1);
				}
				
				$line =~ s/\n//g;
	

if ($line =~ /^WEBROOT/){$webroot = &get_setup_line($line, WEBROOT);}
if ($line =~ /^URLROOT/){$urlroot = &get_setup_line($line, URLROOT);}
if ($line =~ /^WEB_URL/){$web_url = &get_setup_line($line, WEB_URL);}
if ($line =~ /^SCRIPT_URL/){$script_url = &get_setup_line($line, SCRIPT_URL);}
if ($line =~ /^USERNAME/){$username = &get_setup_line($line, USERNAME);}
if ($line =~ /^PASSWORD/){$password = &get_setup_line($line, PASSWORD);}

if ($line =~ /^USE_MYSQL/){$use_mysql = &get_setup_line($line, USE_MYSQL);}
if ($line =~ /^DB_NAME/){$db_name = &get_setup_line($line, DB_NAME);}
if ($line =~ /^RG/){$rg = &get_setup_line($line, RG);}
if ($line =~ /^DB_USERNAME/){$db_username = &get_setup_line($line, DB_USERNAME);}
if ($line =~ /^DB_PASSWORD/){$db_password = &get_setup_line($line, DB_PASSWORD);}


			}
	close (STP);
	
	}
}

sub get_setup_line
{
my ($setup_line, $setup_var) = @_;
$crit = "\"";
$setup_line =~ m/$crit/g;
$r1 = pos($setup_line);
$setup_line =~ m/$crit/g;
$r2 = pos($setup_line);
$setup_line = substr($setup_line, $r1, ($r2 - $r1 - 1));
$return_val = $setup_line;
return ($return_val);
}

#### END CONFIGURATION ########################################################

