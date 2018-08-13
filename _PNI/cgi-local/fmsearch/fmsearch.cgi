#!/usr/bin/perl

##########################################################################
# COPYRIGHT NOTICE:
# 
# Copyright FocalMedia.Net 2001
# 
# This program is free to use for commercial and non commercial use. 
# This script may be used and modified by anyone, so long as this copyright 
# notice and the header above remain intact. Selling the code for this 
# program without prior written consent is expressly forbidden.
# 
# This program is distributed "as is" and without warranty of any
# kind, either express or implied.
#
##########################################################################

use FindBin;
use lib $FindBin::Bin;
use CGI;
use CGI::Carp qw(fatalsToBrowser);
#use DBI;
use acs;


## MAKE META TAG DESCRIPTION LENGTH CONFIGURABLE

### WINDOWS USERS EDIT BELOW ##############################################
$cfile = "config.cfg";
#$cfile = "e:/full/server/path/to/config.cfg";
###########################################################################


$default_permissions = 0777;  ### DEFAULT PERMISSIONS THAT IS USED FOR LOG FILES

$q = CGI->new;

print "Content-type: text/html\n\n";


#### RELEVANCE

$matched_line_length = 120;


if ($q->param('advanced') eq "advanced")
	{
	$word_number_threshold = 6;
	
	if ($q->param('phrase') eq "ON"){ $REL_phrase = 50; }

	if ($q->param('e_phrase') eq "ON"){ $REL_phrase = $REL_phrase + 10; }
	
	if ($q->param('whole_word') eq "ON"){ $REL_whole_word = 10; }
	if ($q->param('e_whole') eq "ON"){ $REL_whole_word = $REL_whole_word + 10; }
	
	if ($q->param('partial') eq "ON"){ $REL_partial_word = 2; }
	
	$REL_and = 15;
	if ($q->param('and_matches') eq "ON"){ $REL_and = $REL_and + 15; }
	
	if ($q->param('spt') eq "ON"){ $REL_title = 3; }
	if ($q->param('spmd') eq "ON"){ $REL_metadiz = 2; }
	if ($q->param('spmk') eq "ON"){ $REL_metakey = 0; } #was 2 = edit rian
	if ($q->param('spc') eq "ON"){ $REL_body = 1; }
	
	$phrase			= $q->param('phrase');
	$e_phrase		= $q->param('e_phrase');
	$whole_word		= $q->param('whole_word');
	$e_whole			= $q->param('e_whole');
	$partial			= $q->param('partial');
	$and_matches	= $q->param('and_matches');
	$spt				= $q->param('spt');
	$spmd				= $q->param('spmd');
	$spmk				= $q->param('spmk');
	$spc				= $q->param('spc');
	
	$e_phrase		= $q->param('e_phrase');
	$e_whole			= $q->param('e_whole');
	}


if ($q->param('advanced') ne "advanced")
	{
	$REL_phrase = 50;
	$REL_whole_word = 10;
	$REL_partial_word = 2;
	$REL_and = 15;

	$word_number_threshold = 6;

	$REL_title = 3;
	$REL_metadiz = 2;
	#$REL_metakey = 2; # taken out by rian (user wanted this keyword search 'off' by default - setting we should implement later)
	# - this gave 14 matches on his data no dups, though i don't think that was the exact purpose of the variable.
	$REL_body = 1;
	}

############################

$pages_prev = "3";
$pages_next = "3";

### GET SETUP

&get_setup;


$mainlayout = acs::gtemplate;

if ($use_mysql eq "Yes"){$mainlayout =~ s/fmsearch\.cgi/fmsearch2\.cgi/gi;}

if ($mainlayout eq "") { print "Could not find $data_dir/main_layout.html or the file is empty"; exit;}

$listing_layout = &get_file_contents("$data_dir/listings.html");

$settings_text = &get_file_contents("$data_dir/settings.dat");
@settings = split (/\n/, $settings_text);


##### PAGE RESULTS

$query = new CGI;
$cookie_results = $query->cookie('results');

if ($cookie_results eq "")
	{
	$nr_searchres = $settings[8];
	}
	else
	{
	$nr_searchres = $cookie_results;
	}



#### PREPARE KEYWORDS

$keywords = $q->param('keywords');

$keywords = &get_search_ready($keywords);

@kwarraytmp = split (/ /, $keywords);

$msc = 0;
foreach $kw (@kwarraytmp)
	{
	if (($kw ne "") and ($kw ne " "))
		{
		$keywords_array[$msc] = $kw;
		$msc++;
		}
	}


if (length($keywords) < ($settings[11] + 1))
	{
	$mainlayout =~ s/!!pages!!/0/gi;
	$mainlayout =~ s/!!next_prev_pages!!/$prevnext/g;
	
	$mainlayout =~ s/!!keywords!!/$keywords/gi;
	$mainlayout =~ s/!!matches!!/0/gi;
	$mainlayout =~ s/!!results!!/0/gi;
			
	$mainlayout =~ s/!!searchresults!!/$settings[10]/gi;
	print $mainlayout; exit;
	}

##### RECORD STATS
$sst = $q->param('st');
$nnd = $q->param('nd');



if (($keywords ne "") and ($sst eq "") and ($nnd eq ""))
	{
	($sec,$min,$hour,$mday,$mon,$year,$wday,$ydat,$isdst) = localtime();
	$mon++;
	$year = "20" . substr($year, 1, 2);
	$logfile = "$mon" . "_" . "$year" . ".log";
	$countfile = "$mon" . "_" . "$year" . ".cnt";
	
	$timep = time();

		if ((-e "$data_dir/$logfile") < 1)
		{
		open (STT, "> $data_dir/$logfile");
			print STT "";
		close (STT);

		open (CNT, "> $data_dir/$countfile");
			print CNT "0";
		close (CNT);
		
		$stat = chmod($default_permissions,"$data_dir/$logfile","$data_dir/$logfile");
		$stat = chmod($default_permissions,"$data_dir/$countfile","$data_dir/$countfile");
		}
		
		$rkeywords = lc($keywords);

	open (STT, ">> $data_dir/$logfile");
		print STT $rkeywords . "\t" . $mday . "\n";
	close (STT);
	
	$cnt = &get_file_contents("$data_dir/$countfile");
	$cnt++;

	open (CNT, "> $data_dir/$countfile");
		print CNT $cnt;
	close (CNT);
	
	}



##### HOW TO SEARCH

if ($use_mysql ne "Yes")
	{
	$fms_script = "fmsearch.cgi";
	}
	else
	{
	$fms_script = "fmsearch2.cgi";
	}


if ($use_mysql ne "Yes")
	{
	if ($settings[12] eq "index")
		{
		$sindex = &get_file_contents("$data_dir/index.dat");
		@sindex_lines = split (/\n/, $sindex);
		}
		elsif ($settings[12] eq "plain")
		{
		$icounter = 0;
		&compile_index;
		}
	}
	else
	{

	#$dsn = "DBI:mysql:$db_name";
	#$dbh = DBI->connect("$dsn", "$db_username", "$db_password");
	#if ( !defined $dbh ) {die "Cannot connect to MySQL server: $DBI::errstr\n"; }
	# ExternHOST
	if ($mysql_hostname eq ""){$dsn = "DBI:mysql:$db_name";}else{$dsn = "DBI:mysql:$db_name:$mysql_hostname:$mysql_port";}
	$dbh = DBI->connect("$dsn", "$db_username", "$db_password");
	if ( !defined $dbh ) {die "Cannot connect to MySQL server: $DBI::errstr\n"; }

	if ($settings[15] eq "fulltext")
		{
		$sth = $dbh->prepare("SELECT * FROM fmidx WHERE MATCH(title, description, keywords, pagecontents) AGAINST ('$keywords')");
		if ( !defined $dbh ) {die "Cannot connect to MySQL server: $DBI::errstr\n"; }
		$sth->execute;
		}
		else
		{
		#### BUILD MYSQL QUERY
		$sql_statement = "";
		foreach $skwd (@keywords_array)
			{
			$skwd =~ s/'/\'/g;
			
			$sql_statement = $sql_statement . "(title like '%$skwd%' or
															description like '%$skwd%' or
															keywords like '%$skwd%' or 
															pagecontents like '%$skwd%') or";
			}
		$sql_statement = substr($sql_statement, 0, length($sql_statement) - 2);

		$sth = $dbh->prepare("SELECT * FROM fmidx WHERE $sql_statement");
		if ( !defined $dbh ) {die "Cannot connect to MySQL server: $DBI::errstr\n"; }
		$sth->execute;
		}
	
	$icnt = $sth->rows();
	
		$siac = 0;
		while ( @row = $sth->fetchrow() )
		{	
		$sindex_lines[$siac] = $row[0] . "\t" .
									  $row[1] . "\t" .
									  $row[2] . "\t" .
									  $row[3] . "\t" .
									  $row[4];

		$siac++;
		}	
	$sth->finish;
	$dbh->disconnect;
	}




$acnt = 0;
$highsr = 0;



#### SPECIALISED SEARCHES
$dirl = $q->param('dir');
$fulldir = $webroot . $dirl;

$ssearch_locations = &get_file_contents("$data_dir/searchloc.dat");
@search_locations = split (/\n/, $ssearch_locations);

	if (($dirl ne "") and (lc($dirl) ne "all"))
		{
		$pathexists = "";
		foreach $slx(@search_locations)
				{
				if ($slx eq "$fulldir"){$pathexists = "true";}
				}
		}


if (($dirl ne "") and ((-e $fulldir) < 1) and (lc($dirl) ne "all") and ($pathexists eq "true"))
		{
		$mainlayout =~ s/!!pages!!/0/gi;
		$mainlayout =~ s/!!next_prev_pages!!/$prevnext/g;
		
		$mainlayout =~ s/!!keywords!!/$keywords/gi;
		$mainlayout =~ s/!!matches!!/0/gi;
		$mainlayout =~ s/!!results!!/0/gi;
				
		$crit = "The directory path for a specialised search is not available or not indexed for searching. Please contact the webmaster of this web site.";
		$mainlayout =~ s/!!searchresults!!/$crit/gi;
		print $mainlayout; exit;
		}



########################

foreach $line (@sindex_lines)
	{
	($url_location, $title, $meta_diz, $meta_key, $page_contents) = split (/\t/, $line);
	
	$relevance = 0;
	
	############################	
	
	if (($dirl ne "") and (lc($dirl) ne "all"))
		{
		
		@uitems = split (/\//, $url_location);
		$uit = @uitems;
		$match_loc = "";
		for ($dms = 0; $dms < ($uit - 1) ; $dms++) 
			{
			$match_loc = $match_loc . $uitems[$dms] . "/";
			}
			if (length($match_loc) != 1){chop($match_loc);}
			
			if ($match_loc eq $dirl)
				{
				### GET TITLE RELEVANCE
				$relevance = $relevance + &get_relevance("TITLE");
				### GET METADIZ RELEVANCE
				$relevance = $relevance + &get_relevance("DIZ");
				### GET METAKEY RELEVANCE
				$relevance = $relevance + &get_relevance("KEY");
				### GET BODY RELEVANCE
				$relevance = $relevance + &get_relevance("BODY");
				}
		
		}
		else
		{

		### GET TITLE RELEVANCE
		$relevance = $relevance + &get_relevance("TITLE");
	
		### GET METADIZ RELEVANCE
		$relevance = $relevance + &get_relevance("DIZ");
	
		### GET METAKEY RELEVANCE
		$relevance = $relevance + &get_relevance("KEY");
		
		### GET BODY RELEVANCE
		$relevance = $relevance + &get_relevance("BODY");
		
		}
		
	
	
	
	
	
	if ($relevance > 0)
		{
		
		$real_relv = $relevance;
		
		if ($highsr < $relevance){$highsr = $relevance;}
				
		$relevance = 100000 - $relevance;
		
		$relevance = &decode_id($relevance);
		
		if ($title eq "") { $title = $url_location; }
		
		$matched_array[$acnt] = 	$relevance . "\t" . 
											$real_relv . "\t" .
											$title . "\t" . 
											$meta_diz . "\t" .
											$url_location . "\t" .
											$mlns;
											
		$acnt++;
		}
	}



##### PAGE DISPLAY
	@matched_array = sort (@matched_array);
	
	$no = 0;
	$realno = 1;


	#####

	$icnt = @matched_array;
	
	if ($icnt == 0)
		{
		$mainlayout =~ s/!!pages!!/0/gi;
		$mainlayout =~ s/!!next_prev_pages!!/$prevnext/g;
		
		$mainlayout =~ s/!!keywords!!/$keywords/gi;
		$mainlayout =~ s/!!matches!!/0/gi;
		$mainlayout =~ s/!!results!!/0/gi;
				
		$mainlayout =~ s/!!searchresults!!/$settings[10]/gi;
		print $mainlayout; exit;
		}
	
	$modp = ($icnt % $nr_searchres);
	$pages = ($icnt - $modp) / $nr_searchres;
	if ($modp != 0) {$pages++;}
	
	$st = $q->param('st');
	$nd = $q->param('nd');

	$main_nd = $nd;
	$main_st = $st;

	
	if ($st eq ""){$st = 0;}
	if ($nd eq ""){$nd = $nr_searchres;}
	
	$ippc = 1;

	#####


foreach $item (@matched_array)
{

if (($ippc > $st) and ($ippc <= $nd))
    {		
		
		($relevance, $real_relv, $title, $meta_diz, $url_location, $matchlines) = split (/\t/, $item);
		
		$perc = int($real_relv / $highsr * 100);
		
		if ($perc == 100) { $perc = 99; }
		if ($perc == 0) { $perc = 1; }
		
		$ores = $listing_layout;
		$ores =~ s/!!no!!/$realno/gi;
			$url_location2 = $urlroot . $url_location;
			
			$newwin = $query->cookie('new_window');
			
			if (($newwin eq "") and ($settings[9] eq "Yes")){$newwin = "Yes";}
			
			if ($newwin eq "Yes")
				{
				$title = "<a href=\"$url_location2\" target=\"_blank\">$title</a> $new_wincrit";
				}
				else
				{
				$title = "<a href=\"$url_location2\">$title</a> $new_wincrit";
				}
			
			
		$ores =~ s/!!title_with_link!!/$title/gi;
		
		if (($meta_diz ne "") and ($settings[6] ne ""))
			{
			$meta_diz = "<img src=\"$web_url/dicon.gif\"> <span style=\"background-color: $settings[6]; color: $settings[7];\">$meta_diz</span>";
			}
		
		$ores =~ s/!!description!!/$meta_diz/g;
		$ores =~ s/!!URL!!/$url_location2/g;
		
		if ($perc < 100) { $rgraphic = "<img src=\"$web_url/100.gif\">"; }
		if ($perc < 91) { $rgraphic = "<img src=\"$web_url/90.gif\">"; }
		if ($perc < 81) { $rgraphic = "<img src=\"$web_url/80.gif\">"; }
		if ($perc < 71) { $rgraphic = "<img src=\"$web_url/70.gif\">"; }
		if ($perc < 61) { $rgraphic = "<img src=\"$web_url/60.gif\">"; }
		if ($perc < 51) { $rgraphic = "<img src=\"$web_url/50.gif\">"; }
		if ($perc < 41) { $rgraphic = "<img src=\"$web_url/40.gif\">"; }
		if ($perc < 31) { $rgraphic = "<img src=\"$web_url/30.gif\">"; }
		if ($perc < 21) { $rgraphic = "<img src=\"$web_url/20.gif\">"; }
		if ($perc < 11) { $rgraphic = "<img src=\"$web_url/10.gif\">"; }
		
		$ores =~ s/!!rgraphic!!/$rgraphic/g;
		$ores =~ s/!!rpercent!!/$perc/g;
		
		#####
		
		if ($matchlines ne "")
			{
			@mtlns = split (/ /, $matchlines);
			$mc = 0;
			$mclen = @mtlns;
			$rmlns = "";
			foreach $mt(@mtlns)
				{
				if (($mc != 0) and $mc != ($mclen - 1))
					{
					$rmlns = $rmlns . $mt . " ";
					}
				$mc++;
				}
			$rmlns = $rmlns . "...";
			
			$crit = "<span style=\"background-color:$settings[3];color:$settings[4];\">";
			$rmlns=~ s/--HGHL--/$crit/g;
			$crit = "</span>";
			$rmlns=~ s/--HGHLEND--/$crit/g;
			
			$rmlns = "<img src=\"$web_url/kicon.gif\"> $rmlns";
			}
		
		
		#####	
		
		$ores =~ s/!!matching_text!!/$rmlns/g;
		
		$total_list = $total_list . $ores;
		
		###<b style="background-color: #ff0000; color: #ffff00;">
		}

$realno++;
$no++;
$ippc++;
}



if (($dirl ne "") and (lc($dirl) ne "all")) {$dval = $dirl;}

##### PAGES

	for ($ms = 0; $ms < $pages; $ms++) 
		{
		$pg = $ms + 1;
		if ($nd == ($pg * $nr_searchres)){ $cnposition = $pg; }
		}
	if ($cnposition < $pages_next) { $pages_next = $pages_next + $pages_next - ($cnposition - 1); }

	$hiddenstr = "";
	$pgstring = "";
	
	if ($main_nd eq "") {$main_nd = $nr_searchres;}
	
	for ($ms = 0; $ms < $pages; $ms++)
		{
		$pg = $ms + 1;
		
			if ($main_nd == ($pg * $nr_searchres))
				{
				$pgstring = $pgstring . " [$pg] ";
				}
			  	elsif (($pg >= ($cnposition - $pages_prev)) and ($pg <= ($cnposition + $pages_next)))
				{
				$st = ($pg * $nr_searchres) - $nr_searchres;
				$nd = ($pg * $nr_searchres);
			
				if ($q->param('advanced') eq "advanced")
						{
						$pgstring = $pgstring . "<a href=\"$script_url/$fms_script?st=$st&nd=$nd&keywords=$keywords&phrase=$phrase&e_phrase=$e_phrase&whole_word=$whole_word&e_whole=$e_whole&partial=$partial&and_matches=$and_matches&spt=$spt&spmd=$spmd&spmk=$spmk&spc=$spc&e_phrase=$e_phrase&e_whole=$e_whole&advanced=advanced&dir=$dval\">$pg</a> ";
						}
						else
						{
						$pgstring = $pgstring . "<a href=\"$script_url/$fms_script?st=$st&nd=$nd&keywords=$keywords&dir=$dval\">$pg</a> ";
						}

			 }

		  }

			#### « PAGES NAVIGATION
			if (($cnposition - $pages_prev) > 1)
				{
				$prev_ppos = $cnposition - $pages_prev;
				$prev_ppos = $prev_ppos - 2;
				$pvst = $prev_ppos * $nr_searchres;
				$pvnd = ($prev_ppos * $nr_searchres) + $nr_searchres;

				if ($q->param('advanced') eq "advanced")
						{
						$pgstring = "<a href=\"$script_url/$fms_script?st=$pvst&nd=$pvnd&keywords=$keywords&phrase=$phrase&e_phrase=$e_phrase&whole_word=$whole_word&e_whole=$e_whole&partial=$partial&and_matches=$and_matches&spt=$spt&spmd=$spmd&spmk=$spmk&spc=$spc&e_phrase=$e_phrase&e_whole=$e_whole&advanced=advanced&dir=$dval\">«</a> " . $pgstring;
						}
						else
						{
						$pgstring = " <a href=\"$script_url/$fms_script?st=$pvst&nd=$pvnd&keywords=$keywords&dir=$dval\">«</a> " . $pgstring; 
						}
				
				}

			#### » PAGES NAVIGATION
			if (($cnposition + $pages_next) < $pages)
				{
				$next_ppos = $cnposition + $pages_next;
				$pvst = $next_ppos * $nr_searchres;
				$pvnd = ($next_ppos * $nr_searchres) + $nr_searchres;

				if ($q->param('advanced') eq "advanced")
						{
						$pgstring = $pgstring . "<a href=\"$script_url/$fms_script?st=$pvst&nd=$pvnd&keywords=$keywords&phrase=$phrase&e_phrase=$e_phrase&whole_word=$whole_word&e_whole=$e_whole&partial=$partial&and_matches=$and_matches&spt=$spt&spmd=$spmd&spmk=$spmk&spc=$spc&e_phrase=$e_phrase&e_whole=$e_whole&advanced=advanced&dir=$dval\">»</a> ";
						}
						else
						{
						$pgstring = $pgstring . " <a href=\"$script_url/$fms_script?st=$pvst&nd=$pvnd&keywords=$keywords&dir=$dval\">»</a> ";
						}
				
				}

	$mainlayout =~ s/!!pages!!/$pgstring/gi;



#### NEXT PREV

	$st = $q->param('st');
	$nd = $q->param('nd');
	if ($nd eq "") {$nd = $nr_searchres; }
	

$spls = $modp;
if ($spls == 0){$spls++;}

 if ($nd <= ($icnt - $spls))
	 	{
		$st1 = $st + $nr_searchres;
		$nd1 = $nd + $nr_searchres;
		
		if ($nd1 == $nr_searchres) { $nd1 = $nd1 + $nr_searchres;}
		
		if ($q->param('advanced') eq "advanced")
			{
			$nextt = "<a href=\"$script_url/$fms_script?st=$st1&nd=$nd1&keywords=$keywords&phrase=$phrase&e_phrase=$e_phrase&whole_word=$whole_word&e_whole=$e_whole&partial=$partial&and_matches=$and_matches&spt=$spt&spmd=$spmd&spmk=$spmk&spc=$spc&e_phrase=$e_phrase&e_whole=$e_whole&advanced=advanced&dir=$dval\">$settings[13]</a> ";
			}
			else
			{
			$nextt = "<a href=\"$script_url/$fms_script?st=$st1&nd=$nd1&keywords=$keywords&dir=$dval\">$settings[13]</a> ";
			}

		}

 if ($st > 0)
	 	{
		$st1 = $st - $nr_searchres;
		$nd1 = $nd - $nr_searchres;
		
		if ($q->param('advanced') eq "advanced")
			{
			$prev = "<a href=\"$script_url/$fms_script?st=$st1&nd=$nd1&keywords=$keywords&phrase=$phrase&e_phrase=$e_phrase&whole_word=$whole_word&e_whole=$e_whole&partial=$partial&and_matches=$and_matches&spt=$spt&spmd=$spmd&spmk=$spmk&spc=$spc&e_phrase=$e_phrase&e_whole=$e_whole&advanced=advanced&dir=$dval\">$settings[14]</a> ";
			}
			else
			{
			$prev = "<a href=\"$script_url/$fms_script?st=$st1&nd=$nd1&keywords=$keywords&dir=$dval\">$settings[14]</a> ";
			}
		}


if (($prev ne "") and ($nextt ne ""))
	{
	$spcer = " | ";
	}
	else
	{
	$spcer = " ";
	}
	  
	$prevnext = $prev . "$spcer" . $nextt;

$mainlayout =~ s/!!next_prev_pages!!/$prevnext/g;


##########

$mainlayout =~ s/!!searchresults!!/$total_list/gi;
$mainlayout =~ s/!!keywords!!/$keywords/gi;

$ippc = $ippc - 1;
$mainlayout =~ s/!!matches!!/$ippc/gi;

$mainlayout =~ s/!!results!!/$nr_searchres/gi;


print $mainlayout;	


################################################


sub compile_index
{

$ssearch_locations = &get_file_contents("$data_dir/searchloc.dat");
@search_locations = split (/\n/, $ssearch_locations);

@s_extionsions = split (/,/, $settings[0]);
@s_exlusions = split (/,/, $settings[1]);


foreach $item (@search_locations)
	{
	if ($item eq "/")
		{
		$dname = $webroot;
		}
		else
		{
		$dname = $webroot . $item;
		}

	opendir(DIR,"$dname");
	@files = readdir(DIR);
	
	foreach $filename (@files)
		{
		if (($filename ne ".") and ($filename ne ".."))
			{
			foreach $ext (@s_extionsions)
				{
				if (lc($ext) eq lc(substr($filename, (length($filename) - length($ext)), length($ext))))
					{
			   	&do_index($dname, $filename);
			   	$pgic++;
					}
				}

			}
		}

	}
  

}








sub do_index
{
my ($path, $flname) = @_;

#### WE NOW HAVE THE FILE NAME TO BE INDEXED

$toind = "";

#### DO NOT INDEX EXCLUSIONS

foreach $exclu (@s_exlusions)
	{
	if ($flname eq $exclu)
		{
		$toind = "false";
		}
	}

#### IF NOT AN EXCLUSION

if ($toind ne "false")
	{
	&do_index2("$path", "$flname");
	}

}




sub do_index2
{

my ($path2, $flname2) = @_;


$ftoindex = "$path2/$flname2";

$fcnts = &get_file_contents("$ftoindex");


### REMOVE CARRIAGE RETURNS

$fcnts =~ s/\n//g;
$crit = chr(13); $fcnts =~ s/$crit//g; 
$crit = chr(10); $fcnts =~ s/$crit//g;
$fcnts =~ s/\t//g;


### TITLE

$title = &parse_link_listing($fcnts, "<title>", "</title>");
$title =~ s/<[^>]*>//g;


### META DESCRIPTION

$meta_diz = &parse_link_listing($fcnts, "<META NAME=\"description\"", "\">");

if ($meta_diz eq ""){$meta_diz = &parse_link_listing($fcnts, "<META NAME= \"description\"", "\">");}
if ($meta_diz eq ""){$meta_diz = &parse_link_listing($fcnts, "<META NAME =\"description\"", "\">");}
if ($meta_diz eq ""){$meta_diz = &parse_link_listing($fcnts, "<META NAME = \"description\"", "\">");}


$crit = "content=\""; $meta_diz =~ s/$crit//gi;
$crit = "content =\""; $meta_diz =~ s/$crit//gi;
$crit = "content = \""; $meta_diz =~ s/$crit//gi;
$crit = "content= \""; $meta_diz =~ s/$crit//gi;

$meta_diz =~ s/<[^>]*>//g;



## META KEYWORDS
$meta_keys = &parse_link_listing($fcnts, "<META NAME=\"keywords\"", "\">");
if ($meta_keys eq ""){$meta_keys = &parse_link_listing($fcnts, "<META NAME =\"keywords\"", "\">");}
if ($meta_keys eq ""){$meta_keys = &parse_link_listing($fcnts, "<META NAME= \"keywords\"", "\">");}
if ($meta_keys eq ""){$meta_keys = &parse_link_listing($fcnts, "<META NAME = \"keywords\"", "\">");}
$crit = "content=\""; $meta_keys =~ s/$crit//gi;
$crit = "content =\""; $meta_keys =~ s/$crit//gi;
$crit = "content = \""; $meta_keys =~ s/$crit//gi;
$crit = "content= \""; $meta_keys =~ s/$crit//gi;
$meta_keys =~ s/<[^>]*>//g;


### ENTIRE PAGE

$fcnts =~ s/<[^>]*>//g;

$path2 =~ s/$webroot//g;

###################################

$fcnts =~ s/&gt;/ /g;
$fcnts =~ s/&lt;/ /g;
$fcnts =~ s/&amp;/ /g;
$fcnts =~ s/&nbsp;/ /g;
$fcnts =~ s/         / /gi;
$fcnts =~ s/        / /gi;
$fcnts =~ s/       / /gi;
$fcnts =~ s/      / /gi;
$fcnts =~ s/     / /gi;
$fcnts =~ s/    / /gi;
$fcnts =~ s/   / /gi;
$fcnts =~ s/  / /gi;

$sindex_lines[$icounter] =  "$path2/$flname2" . "\t" . 		#### 0 Location of file
									  $title . "\t" . 					#### 1 Title
									  $meta_diz . "\t" . 				#### 2 Meta Description
									  $meta_keys . "\t" . 				#### 3 Meta Keywords
									  $fcnts . "\n";						#### 4 Entire page
$icounter++;

}






sub parse_link_listing
{
my ($tobeparsed, $c_start, $c_end) = @_;

$foundmatch = "false";
  
if ($tobeparsed =~ m/$c_start/gi)
{
$r = pos($tobeparsed);
$tobeparsed = substr($tobeparsed, $r, length($tobeparsed) - $r);
$foundmatch = "true";
}

if (($c_end ne "DIZ") and ($foundmatch eq "true"))
	{
		if ($tobeparsed =~ m/$c_end/gi)
		{
		$r = pos($tobeparsed);
		$tobeparsed= substr($tobeparsed, 0, $r - length($c_end));
		}
	}
	else
	{
	$tobeparsed = "";
	}

return ($tobeparsed);

}




sub get_file_contents
{

my ($filename) = @_;
my ($filesize, $filesize, $thefile);

$filesize = (-s "$filename");
if ($filesize > 0)
	{
	open (TFILECNTS, "$filename");
		read(TFILECNTS,$thefile,$filesize);
	close (TFILECNTS);
	}

return ($thefile);
}






sub get_matchlines
{

my ($mpos, $matched_string, $before_text, $after_text) = @_;

$rmml = "";

$strlenght = $matched_line_length / 2;

$left = substr ($before_text, $mpos - length($matched_string) - $strlenght, $strlenght + length($matched_string));
$right = substr ($after_text, 0, $strlenght);

	$rmml =	$left . $matched_string . $right;

	foreach $mkwr (@keywords_array)
		{ 
		$colorc = "--HGHL--$mkwr--HGHLEND--"; #highlight each match
		$rmml =~ s/$mkwr/$colorc/gi; #replace...
		}

return ($rmml);

}




sub decode_id
{

my ($decid) = @_;

if (length($decid) == 1) {$decid = "000000000000" . $decid;}
if (length($decid) == 2) {$decid = "00000000000" . $decid;}
if (length($decid) == 3) {$decid = "0000000000" . $decid;}
if (length($decid) == 4) {$decid = "000000000" . $decid;}
if (length($decid) == 5) {$decid = "00000000" . $decid;}
if (length($decid) == 6) {$decid = "0000000" . $decid;}
if (length($decid) == 7) {$decid = "000000" . $decid;}
if (length($decid) == 8) {$decid = "00000" . $decid;}
if (length($decid) == 9) {$decid = "0000" . $decid;}
if (length($decid) == 10){$decid = "000" . $decid;}
if (length($decid) == 11){$decid = "00" . $decid;}
if (length($decid) == 12){$decid = "0" . $decid;}	

return ($decid);

}




sub get_relevance
{

my ($rpointer) = @_;

$return_relevance = 0;

if ($rpointer eq "TITLE")	{$multiplier = $REL_title;		$matchcrit = $title;				}
if ($rpointer eq "DIZ")		{$multiplier = $REL_metadiz; 	$matchcrit = $meta_diz;			}
if ($rpointer eq "KEY")		{$multiplier = $REL_metakey; 	$matchcrit = $meta_key;			}
if ($rpointer eq "BODY")	{$multiplier = $REL_body; 		$matchcrit = $page_contents;	}

	
	# $url_location, $title, $meta_diz, $meta_key, $page_contents

$mlns = "";
	
	### PHRASE RELEVANCE
	if ($REL_phrase > 0)
		{
		if ($keywords =~ / /)
			{
			if ($matchcrit =~ m/$keywords/gi)
				{
				if ($mlns eq "") {$r = pos($matchcrit); $mlns = &get_matchlines($r, $&, $`, $');}
				$return_relevance = $return_relevance + $REL_phrase;
				}
			}
		}


	$matchf = 0;
	foreach $kwr (@keywords_array)
		{
		
		$rmatch = "false";
		
		### WHOLE WORD MATCH
		if ($REL_whole_word > 0)
		{
		
		if ($matchcrit =~ m/^$kwr /gi)
			{
			if ($mlns eq "") {$r = pos($matchcrit); $mlns = &get_matchlines($r, $&, $`, $');}
			
			$return_relevance = $return_relevance + $REL_whole_word;
			if ($rmatch eq "false"){ $matchf++; $rmatch = "true"; }

			$nrm = $matchcrit =~ s/$kwr $/matched/gi;
			if ($nrm > $word_number_threshold){$nrm = $word_number_threshold;}
			$return_relevance = $return_relevance + ($REL_whole_word * $nrm);
			}

		if ($matchcrit =~ m/ $kwr /gi)
			{
			if ($mlns eq "") {$r = pos($matchcrit); $mlns = &get_matchlines($r, $&, $`, $');}
			
			$return_relevance = $return_relevance + $REL_whole_word;
			if ($rmatch eq "false"){ $matchf++; $rmatch = "true"; }

			$nrm = $matchcrit =~ s/ $kwr /matched/gi;
			if ($nrm > $word_number_threshold){$nrm = $word_number_threshold;}
			$return_relevance = $return_relevance + ($REL_whole_word * $nrm);
			}

		if ($matchcrit =~ / $kwr$/gi)
			{
			if ($mlns eq "") {$r = pos($matchcrit); $mlns = &get_matchlines($r, $&, $`, $');}
			
			$return_relevance = $return_relevance + $REL_whole_word;
			if ($rmatch eq "false"){ $matchf++; $rmatch = "true"; }
			
			$nrm = $matchcrit =~ s/ $kwr$/matched/gi;
			if ($nrm > $word_number_threshold){$nrm = $word_number_threshold;}
			$return_relevance = $return_relevance + ($REL_whole_word * $nrm);
			}

		}

		### PARTIAL WORD MATCH

		if ($REL_partial_word > 0)
			{
			if ($matchcrit =~ m/$kwr/gi)
				{
				if ($mlns eq "") {$r = pos($matchcrit); $mlns = &get_matchlines($r, $&, $`, $');}
				
				$return_relevance = $return_relevance + $REL_partial_word;
				if ($rmatch eq "false"){ $matchf++; $rmatch = "true"; }
				
				$nrm = $matchcrit =~ s/$kwr/matched/gi;
				if ($nrm > $word_number_threshold){$nrm = $word_number_threshold;}
				$return_relevance = $return_relevance + ($REL_partial_word * $nrm);
				}
			}

		### AND RELEVANCE
		if ($REL_and > 0)
			{
			if ($matchf > 1)
				{
				$return_relevance = $return_relevance + $REL_and;
				}
			}

		}

$return_relevance = ($return_relevance * $multiplier);

return ($return_relevance);
}





sub get_search_ready
{
my ($search_line) = @_;

$reline = $search_line;

$reline =~ s/\+//g;
$reline =~ s/\[//g;
$reline =~ s/\]//g;
$reline =~ s/\)//g;
$reline =~ s/\(//g;
$reline =~ s/\*//g;
$reline =~ s/\^//g;
$reline =~ s/\.//g;
$reline =~ s/\$//g;
$reline =~ s/\?//g;
$reline =~ s/\\//g;
$reline =~ s/\~//g;
$reline =~ s/<//g;
$reline =~ s/>//g;
$reline =~ s/;//g;

return ($reline);
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
if ($line =~ /^DB_USERNAME/){$db_username = &get_setup_line($line, DB_USERNAME);}
if ($line =~ /^DB_PASSWORD/){$db_password = &get_setup_line($line, DB_PASSWORD);}
if ($line =~ /^MYSQL_HOSTNAME/){$mysql_hostname = &get_setup_line($line, MYSQL_HOSTNAME);}
if ($line =~ /^MYSQL_PORT/){$mysql_port = &get_setup_line($line, MYSQL_PORT);}

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
