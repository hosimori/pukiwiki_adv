<?php
// PukiWiki - Yet another WikiWikiWeb clone.
// $Id: classic.css.php,v 0.0.2 2013/02/06 16:49:30 Logue Exp $
//
// PukiWiki Adv. Mobile Theme
// Copyright (C)
//   2012 PukiWiki Advance Developer Team

ini_set('zlib.output_compression', 'Off');

$image_dir = isset($_GET['base']) ? $_GET['base']	: '../image/';
$iconset = isset($_GET['iconset']) ? $_GET['iconset']	: 'default';
$expire = isset($_GET['expire']) ? (int)$_GET['expire'] * 86400	: '604800';	// Default is 7 days.

// Send header
header('Content-Type: text/css; charset: UTF-8');
header('Cache-Control: private');
header('Expires: ' .gmdate('D, d M Y H:i:s',time() + $expire) . ' GMT');
header('Last-Modified: '.gmdate('D, d M Y H:i:s', getlastmod() ) . ' GMT');
@ob_start('ob_gzhandler');
?>
@charset "UTF-8";
@namespace url(http://www.w3.org/1999/xhtml);

/* ==|== PukiWiki Advance Standard Font Set ================================= */

.no-js {
	display:none;
}

pre, code, kbd, samp, textarea, select, option, input, var{
	font-family: monospace !important;
}

dt{
	font-weight:bold;
}

figure{
	margin: 0 auto;
	text-align:center;
}

figcaption{
	font-size:93%;
	text-align:center;
}

pre{
	border-top:silver 1px solid;
	border-bottom:grey 1px solid;
	border-left:silver 1px solid;
	border-right:grey 1px solid;
	background-color:whitesmoke;
	padding:0.5em 1em;
	margin:.5em;
	text-shadow: 1px 1px 3px rgba(0,0,0,.3);
}

q{
	border:1px dotted #999;
}

figure{
	margin: 0 auto;
	text-align:center;
}

figcaption{
	font-size:93%;
	text-align:center;
}
/* Table Tags */
.table{
	border-spacing:2px;
	padding:0px;
	border:0px;
	margin:0.1em auto;
	text-align:left;
	border-collapse:separate;
	border-spacing:1px;
	background-color:silver;
	text-shadow:none;
	text-shadow: none;
}

.table th{
	background-color:lightgrey;
	padding:5px;
	margin:1px;
	text-align:center;
}
.table td{
	background-color:whitesmoke;
	padding:5px;
	margin:1px;
}

.table td.blank-cell{
	background-color:gainsboro;
}
/* Week and Month */
.style_week, .style_month{
	border:none !important;
}

.ui-btn-up-a .ui-btn-text{
	color: white !important;
}

[aria-describedby="tooltip"]{
	cursor:help;
	border-bottom: 1px dotted;
}

/* ==|== PukiWiki Adv. Misc classes ========================================= */
.underline{
	text-decoration: underline !important;
}
.small1{
	font-size:77%;
}
.super_index{
	font-weight:bold;
	font-size:77%;
	vertical-align:super;
}
.jumpmenu{
	font-size:77%;
	text-align:right;
}

.size1 {
	font-size:xx-small;
}
.size2 {
	font-size:x-small;
}
.size3 {
	font-size:small;
}
.size4 {
	font-size:medium;
}
.size5 {
	font-size:large;
}
.size6 {
	font-size:x-large;
}
.size7 {
	font-size:xx-large;
}

/* html.php/catbody() */
.word0 {
	background-color:#FFFF66;
	text-shadow:none;
	color:black;
}
.word1 {
	background-color:#A0FFFF;
	text-shadow:none;
	color:black;
}
.word2 {
	background-color:#99FF99;
	text-shadow:none;
	color:black;
}
.word3 {
	background-color:#FF9999;
	text-shadow:none;
	color:black;
}
.word4 {
	background-color:#FF66FF;
	text-shadow:none;
	color:black;
}
.word5 {
	background-color:#880000;
	text-shadow:none;
	color:white;
}
.word6 {
	background-color:#00AA00;
	text-shadow:none;
	color:white;
}
.word7 {
	background-color:#886800;
	text-shadow:none;
	color:white;
}
.word8 {
	background-color:#004699;
	text-shadow:none;
	color:white;
}
.word9 {
	background-color:#990099;
	text-shadow:none;
	color:white;
}

/* html.php/edit_form() */
.edit_form { clear:both; }

.edit_form textarea{
	width:95%;
	min-width:99%;
	resize: vertical;
	margin:0;
}

.ie8 .edit_form textarea{
	width:780px;
}

/* Note */
.super_index {
	color:red;
	font-weight:bold;
	vertical-align:super;
	line-height:100%;
}

.note_super {
	font-size:77% !important;
	color:red !important;
	font-weight:bold;
	vertical-align:super;
	margin-right:.5em;
}


textarea, select, option, input, var, pre, code{
	font-family: monospace !important;
}
.ui-controlgroup label{
	font-size:100% !important;
}

#adarea {
	text-align:center;
	width:100%;
}

#adarea *{
	margin: 0 auto;
}

#adarea_content{
	display:none;
}
/* ==|== PukiWiki Adv. Standard Plugin classes ============================== */
/* aname.inc.php */
.anchor_super {
	height:8px;
	font-size:8px !important;
	vertical-align:super;
}

/* amazon.inc.php */
.amazon_img {
	margin:16px 10px 8px 8px;
	text-align:center;
}
.amazon_imgetc {
	margin:0px 8px 8px 8px;
	text-align:center;
}
.amazon_sub {
	font-size:93%;
}
.amazon_avail {
	margin-left:150px;
	font-size:93%;
}
.amazon_td {
	text-align:center;
	word-wrap: break-word;
}
.amazon_tbl {
	width:160px;
	font-size:93%;
	text-align:center;
}

/* attach.inc.php / related.inc.php */
#attach, #related{
	display:block;
	float:none;
}
#attach dl, #related dl{
	margin:0 1%;
	display:block;
}
#attach dl dt, #related dl dt{
	display:inline;
	font-weight:normal;
	margin: .1em .25em;
}
#attach dl dd, #related dl dd{
	display:inline;
	margin: .1em .25em;
}
.attach_info dl{
	float:left;
	display:block;
	overflow:visible;
}
.attach_info_image{
	right:1em;
	position:absolute;
	z-index:-1;
}

/* backup.inc.php */
.add_block, .remove_block{
	display:block;
}
.backup_form{
	text-align:center;
}
.add_word, .add_block{
	background-color:#FFFF66;
}
.remove_word, .remove_block{
	background-color:#A0FFFF;
}

/* calendar.inc.php */
.style_calendar{
	width: 13em;
}
.style_calendar a{
	text-decoration: none;
}
.style_calendar a:hover{
	background-color: transparent;
}
.style_calendar a st rong{
	text-decoration:underline;
}
.style_calendar td, .style_calendar th{
	text-align: center;
	font-size: 85%;
}
.style_calendar_navi{
	display: block;
	text-align: center;
	list-style-image: none;
	list-style: none;
	margin: 0;
	padding: 0;
}
.style_calendar_title {
	display: inline;
	float: none;
}
.style_calendar_prev {
	display: inline;
	float: left;
	text-align: left;
}
.style_calendar_next {
	display: inline;
	float: right;
	text-align: right;
}
.style_calendar .style_calendar_day {
	background-color:ghostwhite;
}
.style_calendar .style_calendar_today {
	background-color: lightyellow;
}
.style_calendar .style_calendar_sat {
	background-color: aliceblue;
}
.style_calendar .style_calendar_sun, .style_calendar .style_calendar_holiday {
	background-color: lavenderblush;
}

/* week text color */
.week_sat{
	color: blue;
}
.week_day {
	color: black;
}
.week_sun, .week_holiday {
	color: red;
}
/* Fix English calendar week label */
:lang(en) .style_calendar_week{
	font-family:monospace !important;
	padding: .5em .2em;
}
.style_calendar_post p{
	padding: .25em 1em;
}
.style_calendar_post nav{
	display: none;
}

/* calendar_viewer.inc.php */
.style_calendar_viewer{
	float: left;
	width: 15em;
}
.style_calendar_post{
	margin-left: 15em;
}

/* color.inc.php */
.wikicolor{
	text-shadow:none;
}

/* counter.inc.php */
.counter {
	font-size:77%;
}

/* diff.inc.php */
.diff_added {
	color:blue;
}
.diff_removed {
	color:red;
}

/* include.inc.php */
.side_label {
	text-align:center;
}

/* navi.inc.php */
.navi {
	display:block;
	list-style-image: none;
	list-style:none;
	margin: 0 !important;
	padding:0 !important;
	text-align:center;
}
.navi_none {
	display:inline;
	float:none;
}
.navi_left {
	display:inline;
	float:left;
	text-align:left;
}
.navi_right {
	display:inline;
	float:right;
	text-align:right;
}

/* new.inc.php */
.comment_date {
	font-size:x-small;
}
.new1 {
	color:red;
	background-color:transparent;
	font-size:x-small;
}
.new5 {
	color:green;
	background-color:transparent;
	font-size:xx-small;
}

/* note */
#note ul{
	list-style:none;
}

/* ref.inc.php */
.img_margin {
	margin: 0 32px;
}

/* clear.inc.php */
.clear {
	margin:0px;
	clear:both;
}

/* counter.inc.php */
.counter { font-size:77%; }

/* tooltip.inc.php */
.tooltip, .linktip {
	border-bottom: 1px dotted;
}

/* ==|== ui icon classes ==================================================== */
.pkwk-symbol{
	display: inline-block;
	width: 8px;
	height: 8px;
	margin:0 2px;
	padding:1px;
	line-height:100%;
	background: transparent url('<?php echo $image_dir ?>iconset/default.png') -1000px -1000px no-repeat;
	vertical-align: middle;
	text-align:center;
	text-shadow:none;
	color: transparent;
}
.symbol-add			{ background-position: -36px -114px; }
.symbol-edit		{ background-position: -54px -114px; }
.symbol-attach		{ background-position: -72px -114px; }
.symbol-external	{ background-position: -90px -114px; }
.symbol-internal	{ background-position: -108px -114px; }

.content_navi{
	float:right;
}
/* ==|== flag classes ====================================================== */
.flag{
	display: inline-block;
	width: 16px;
	height: 12px;
	background: transparent url('<?php echo $image_dir ?>plugin/flag.png') -1000px -1000px no-repeat;
	text-shadow:none;
	color: transparent;
}
.flag-ad{ background-position: 0 0; }
.flag-ae{ background-position: -17px 0; }
.flag-af{ background-position: -34px 0; }
.flag-ag{ background-position: -51px 0; }
.flag-ai{ background-position: -68px 0; }
.flag-al{ background-position: -85px 0; }
.flag-am{ background-position: -102px 0; }
.flag-an{ background-position: -119px 0; }
.flag-ao{ background-position: -136px 0; }
.flag-ar{ background-position: -153px 0; }
.flag-as{ background-position: -170px 0; }
.flag-at{ background-position: -187px 0; }
.flag-au{ background-position: -204px 0; }
.flag-aw{ background-position: -221px 0; }
.flag-ax{ background-position: -238px 0; }
.flag-az{ background-position: -255px 0; }
.flag-ba{ background-position: -272px 0; }
.flag-bb{ background-position: -289px 0; }
.flag-bd{ background-position: -306px 0; }
.flag-be{ background-position: -323px 0; }
.flag-bf{ background-position: -340px 0; }
.flag-bg{ background-position: -357px 0; }
.flag-bh{ background-position: -374px 0; }
.flag-bi{ background-position: -391px 0; }
.flag-bj{ background-position: -408px 0; }
.flag-bm{ background-position: -425px 0; }
.flag-bn{ background-position: -442px 0; }
.flag-bo{ background-position: -459px 0; }
.flag-br{ background-position: -476px 0; }
.flag-bs{ background-position: -493px 0; }
.flag-bt{ background-position: -510px 0; }
.flag-bv{ background-position: -527px 0; }
.flag-bw{ background-position: -544px 0; }
.flag-by{ background-position: -561px 0; }
.flag-bz{ background-position: -578px 0; }
.flag-ca{ background-position: -595px 0; }
.flag-catalonia{ background-position: -612px 0; }
.flag-cc{ background-position: -629px 0; }
.flag-cd{ background-position: -646px 0; }
.flag-cf{ background-position: -663px 0; }
.flag-cg{ background-position: -680px 0; }
.flag-ch{ background-position: -697px 0; }
.flag-ci{ background-position: -714px 0; }
.flag-ck{ background-position: -731px 0; }
.flag-cl{ background-position: -748px 0; }
.flag-cm{ background-position: -765px 0; }
.flag-cn{ background-position: -782px 0; }
.flag-co{ background-position: -799px 0; }
.flag-cr{ background-position: -816px 0; }
.flag-cs{ background-position: -833px 0; }
.flag-cu{ background-position: -850px 0; }
.flag-cv{ background-position: -867px 0; }
.flag-cx{ background-position: -884px 0; }
.flag-cy{ background-position: -901px 0; }
.flag-cz{ background-position: -918px 0; }
.flag-de{ background-position: -935px 0; }
.flag-dj{ background-position: -952px 0; }
.flag-dk{ background-position: -969px 0; }
.flag-dm{ background-position: -986px 0; }
.flag-do{ background-position: -1003px 0; }
.flag-dz{ background-position: -1020px 0; }
.flag-ec{ background-position: -1037px 0; }
.flag-ee{ background-position: -1054px 0; }
.flag-eg{ background-position: -1071px 0; }
.flag-eh{ background-position: -1088px 0; }
.flag-en{ background-position: -1105px 0; }
.flag-er{ background-position: -1122px 0; }
.flag-es{ background-position: -1139px 0; }
.flag-et{ background-position: -1156px 0; }
.flag-eu{ background-position: -1173px 0; }
.flag-fam{ background-position: -1190px 0; }
.flag-fi{ background-position: -1207px 0; }
.flag-fj{ background-position: -1224px 0; }
.flag-fk{ background-position: -1241px 0; }
.flag-fm{ background-position: -1258px 0; }
.flag-fo{ background-position: -1275px 0; }
.flag-fr{ background-position: -1292px 0; }
.flag-ga{ background-position: -1309px 0; }
.flag-gb{ background-position: -1326px 0; }
.flag-gd{ background-position: -1343px 0; }
.flag-ge{ background-position: -1360px 0; }
.flag-gf{ background-position: -1377px 0; }
.flag-gh{ background-position: -1394px 0; }
.flag-gi{ background-position: -1411px 0; }
.flag-gl{ background-position: -1428px 0; }
.flag-gm{ background-position: -1445px 0; }
.flag-gn{ background-position: -1462px 0; }
.flag-gp{ background-position: -1479px 0; }
.flag-gq{ background-position: -1496px 0; }
.flag-gr{ background-position: -1513px 0; }
.flag-gs{ background-position: -1530px 0; }
.flag-gt{ background-position: -1547px 0; }
.flag-gu{ background-position: -1564px 0; }
.flag-gw{ background-position: -1581px 0; }
.flag-gy{ background-position: -1598px 0; }
.flag-hk{ background-position: -1615px 0; }
.flag-hm{ background-position: -1632px 0; }
.flag-hn{ background-position: -1649px 0; }
.flag-hr{ background-position: -1666px 0; }
.flag-ht{ background-position: -1683px 0; }
.flag-hu{ background-position: -1700px 0; }
.flag-id{ background-position: -1717px 0; }
.flag-ie{ background-position: -1734px 0; }
.flag-il{ background-position: -1751px 0; }
.flag-in{ background-position: -1768px 0; }
.flag-io{ background-position: -1785px 0; }
.flag-iq{ background-position: -1802px 0; }
.flag-ir{ background-position: -1819px 0; }
.flag-is{ background-position: -1836px 0; }
.flag-it{ background-position: -1853px 0; }
.flag-jm{ background-position: -1870px 0; }
.flag-jo{ background-position: -1887px 0; }
.flag-jp{ background-position: -1904px 0; }
.flag-ke{ background-position: -1921px 0; }
.flag-kg{ background-position: -1938px 0; }
.flag-kh{ background-position: -1955px 0; }
.flag-ki{ background-position: -1972px 0; }
.flag-km{ background-position: -1989px 0; }
.flag-kn{ background-position: 0 -12px; }
.flag-kp{ background-position: -17px -12px; }
.flag-kr{ background-position: -34px -12px; }
.flag-kw{ background-position: -51px -12px; }
.flag-ky{ background-position: -68px -12px; }
.flag-kz{ background-position: -85px -12px; }
.flag-la{ background-position: -102px -12px; }
.flag-lb{ background-position: -119px -12px; }
.flag-lc{ background-position: -136px -12px; }
.flag-li{ background-position: -153px -12px; }
.flag-lk{ background-position: -170px -12px; }
.flag-lr{ background-position: -187px -12px; }
.flag-ls{ background-position: -204px -12px; }
.flag-lt{ background-position: -221px -12px; }
.flag-lu{ background-position: -238px -12px; }
.flag-lv{ background-position: -255px -12px; }
.flag-ly{ background-position: -272px -12px; }
.flag-ma{ background-position: -289px -12px; }
.flag-mc{ background-position: -306px -12px; }
.flag-md{ background-position: -323px -12px; }
.flag-me{ background-position: -340px -12px; width: 16px; height: 12px; }
.flag-mg{ background-position: -357px -12px; }
.flag-mh{ background-position: -374px -12px; }
.flag-mk{ background-position: -391px -12px; }
.flag-ml{ background-position: -408px -12px; }
.flag-mm{ background-position: -425px -12px; }
.flag-mn{ background-position: -442px -12px; }
.flag-mo{ background-position: -459px -12px; }
.flag-mp{ background-position: -476px -12px; }
.flag-mq{ background-position: -493px -12px; }
.flag-mr{ background-position: -510px -12px; }
.flag-ms{ background-position: -527px -12px; }
.flag-mt{ background-position: -544px -12px; }
.flag-mu{ background-position: -561px -12px; }
.flag-mv{ background-position: -578px -12px; }
.flag-mw{ background-position: -595px -12px; }
.flag-mx{ background-position: -612px -12px; }
.flag-my{ background-position: -629px -12px; }
.flag-mz{ background-position: -646px -12px; }
.flag-na{ background-position: -663px -12px; }
.flag-nc{ background-position: -680px -12px; }
.flag-ne{ background-position: -697px -12px; }
.flag-nf{ background-position: -714px -12px; }
.flag-ng{ background-position: -731px -12px; }
.flag-ni{ background-position: -748px -12px; }
.flag-nl{ background-position: -765px -12px; }
.flag-no{ background-position: -782px -12px; }
.flag-np{ background-position: -799px -12px; }
.flag-nr{ background-position: -816px -12px; }
.flag-nu{ background-position: -833px -12px; }
.flag-nz{ background-position: -850px -12px; }
.flag-om{ background-position: -867px -12px; }
.flag-pa{ background-position: -884px -12px; }
.flag-pe{ background-position: -901px -12px; }
.flag-pf{ background-position: -918px -12px; }
.flag-pg{ background-position: -935px -12px; }
.flag-ph{ background-position: -952px -12px; }
.flag-pk{ background-position: -969px -12px; }
.flag-pl{ background-position: -986px -12px; }
.flag-pm{ background-position: -1003px -12px; }
.flag-pn{ background-position: -1020px -12px; }
.flag-pr{ background-position: -1037px -12px; }
.flag-ps{ background-position: -1054px -12px; }
.flag-pt{ background-position: -1071px -12px; }
.flag-pw{ background-position: -1088px -12px; }
.flag-py{ background-position: -1105px -12px; }
.flag-qa{ background-position: -1122px -12px; }
.flag-re{ background-position: -1139px -12px; }
.flag-ro{ background-position: -1156px -12px; }
.flag-rs{ background-position: -1173px -12px; }
.flag-ru{ background-position: -1190px -12px; }
.flag-rw{ background-position: -1207px -12px; }
.flag-sa{ background-position: -1224px -12px; }
.flag-sb{ background-position: -1241px -12px; }
.flag-sc{ background-position: -1258px -12px; }
.flag-scotland{ background-position: -1275px -12px; }
.flag-sd{ background-position: -1292px -12px; }
.flag-se{ background-position: -1309px -12px; }
.flag-sg{ background-position: -1326px -12px; }
.flag-sh{ background-position: -1343px -12px; }
.flag-si{ background-position: -1360px -12px; }
.flag-sj{ background-position: -1377px -12px; }
.flag-sk{ background-position: -1394px -12px; }
.flag-sl{ background-position: -1411px -12px; }
.flag-sm{ background-position: -1428px -12px; }
.flag-sn{ background-position: -1445px -12px; }
.flag-so{ background-position: -1462px -12px; }
.flag-sr{ background-position: -1479px -12px; }
.flag-st{ background-position: -1496px -12px; }
.flag-sv{ background-position: -1513px -12px; }
.flag-sy{ background-position: -1530px -12px; }
.flag-sz{ background-position: -1547px -12px; }
.flag-tc{ background-position: -1564px -12px; }
.flag-td{ background-position: -1581px -12px; }
.flag-tf{ background-position: -1598px -12px; }
.flag-tg{ background-position: -1615px -12px; }
.flag-th{ background-position: -1632px -12px; }
.flag-tj{ background-position: -1649px -12px; }
.flag-tk{ background-position: -1666px -12px; }
.flag-tl{ background-position: -1683px -12px; }
.flag-tm{ background-position: -1700px -12px; }
.flag-tn{ background-position: -1717px -12px; }
.flag-to{ background-position: -1734px -12px; }
.flag-tr{ background-position: -1751px -12px; }
.flag-tt{ background-position: -1768px -12px; }
.flag-tv{ background-position: -1785px -12px; }
.flag-tw{ background-position: -1802px -12px; }
.flag-tz{ background-position: -1819px -12px; }
.flag-ua{ background-position: -1836px -12px; }
.flag-ug{ background-position: -1853px -12px; }
.flag-um{ background-position: -1870px -12px; }
.flag-us{ background-position: -1887px -12px; }
.flag-uy{ background-position: -1904px -12px; }
.flag-uz{ background-position: -1921px -12px; }
.flag-va{ background-position: -1938px -12px; }
.flag-vc{ background-position: -1955px -12px; }
.flag-ve{ background-position: -1972px -12px; }
.flag-vg{ background-position: -1989px -12px; }
.flag-vi{ background-position: 0 -25px; }
.flag-vn{ background-position: -17px -25px; }
.flag-vu{ background-position: -34px -25px; }
.flag-wales{ background-position: -51px -25px; }
.flag-wf{ background-position: -68px -25px; }
.flag-ws{ background-position: -85px -25px; }
.flag-ye{ background-position: -102px -25px; }
.flag-yt{ background-position: -119px -25px; }
.flag-za{ background-position: -136px -25px; }
.flag-zm{ background-position: -153px -25px; }
.flag-zw{ background-position: -170px -25px; }

/* ==|== os classes ======================================================== */
.os{
	display: inline-block;
	width: 16px;
	height: 16px;
	background: transparent url('<?php echo $image_dir ?>plugin/os.png') -1000px -1000px no-repeat;
	text-shadow:none;
	color: transparent;
}
.os-aix{ background-position: 0 0; width: 16px; height: 16px; }
.os-amigaos{ background-position: -17px 0; width: 16px; height: 16px; }
.os-apple{ background-position: -34px 0; width: 16px; height: 16px; }
.os-atari{ background-position: -51px 0; width: 16px; height: 16px; }
.os-beos{ background-position: -68px 0; width: 16px; height: 16px; }
.os-blackberry{ background-position: -85px 0; width: 16px; height: 16px; }
.os-bsd{ background-position: -102px 0; width: 16px; height: 16px; }
.os-bsddflybsd{ background-position: -119px 0; width: 16px; height: 16px; }
.os-bsdfreebsd{ background-position: -136px 0; width: 16px; height: 16px; }
.os-bsdi{ background-position: -153px 0; width: 14px; height: 14px; }
.os-bsdkfreebsd{ background-position: -168px 0; width: 15px; height: 16px; }
.os-bsdnetbsd{ background-position: -184px 0; width: 16px; height: 16px; }
.os-bsdopenbsd{ background-position: -201px 0; width: 16px; height: 16px; }
.os-commodore{ background-position: -218px 0; width: 16px; height: 16px; }
.os-cpm{ background-position: -235px 0; width: 16px; height: 16px; }
.os-debian{ background-position: -252px 0; width: 16px; height: 16px; }
.os-digital{ background-position: -269px 0; width: 14px; height: 14px; }
.os-dos{ background-position: -284px 0; width: 16px; height: 16px; }
.os-dreamcast{ background-position: -301px 0; width: 16px; height: 16px; }
.os-freebsd{ background-position: -318px 0; width: 16px; height: 16px; }
.os-gnu{ background-position: -335px 0; width: 16px; height: 16px; }
.os-hpux{ background-position: -352px 0; width: 16px; height: 16px; }
.os-ibm{ background-position: -369px 0; width: 16px; height: 16px; }
.os-imode{ background-position: -386px 0; width: 16px; height: 16px; }
.os-inferno{ background-position: -403px 0; width: 16px; height: 16px; }
.os-ios{ background-position: -420px 0; width: 16px; height: 16px; }
.os-iphone{ background-position: -437px 0; width: 16px; height: 16px; }
.os-irix{ background-position: -454px 0; width: 16px; height: 16px; }
.os-j2me{ background-position: -471px 0; width: 16px; height: 16px; }
.os-java{ background-position: -488px 0; width: 16px; height: 16px; }
.os-kfreebsd{ background-position: -505px 0; width: 15px; height: 16px; }
.os-linux{ background-position: -521px 0; width: 16px; height: 16px; }
.os-linuxandroid{ background-position: -538px 0; width: 16px; height: 16px; }
.os-linuxasplinux{ background-position: -555px 0; width: 16px; height: 16px; }
.os-linuxcentos{ background-position: -572px 0; width: 16px; height: 16px; }
.os-linuxdebian{ background-position: -589px 0; width: 16px; height: 16px; }
.os-linuxfedora{ background-position: -606px 0; width: 16px; height: 16px; }
.os-linuxgentoo{ background-position: -623px 0; width: 15px; height: 16px; }
.os-linuxmandr{ background-position: -639px 0; width: 16px; height: 16px; }
.os-linuxpclinuxos{ background-position: -656px 0; width: 16px; height: 16px; }
.os-linuxredhat{ background-position: -673px 0; width: 16px; height: 16px; }
.os-linuxsuse{ background-position: -690px 0; width: 16px; height: 16px; }
.os-linuxubuntu{ background-position: -707px 0; width: 16px; height: 16px; }
.os-linuxvine{ background-position: -724px 0; width: 16px; height: 16px; }
.os-linuxzenwalk{ background-position: -741px 0; width: 16px; height: 16px; }
.os-mac{ background-position: -758px 0; width: 16px; height: 16px; }
.os-macintosh{ background-position: -775px 0; width: 16px; height: 16px; }
.os-macosx{ background-position: -792px 0; width: 16px; height: 16px; }
.os-netbsd{ background-position: -809px 0; width: 16px; height: 16px; }
.os-netware{ background-position: -826px 0; width: 16px; height: 16px; }
.os-next{ background-position: -843px 0; width: 16px; height: 16px; }
.os-openbsd{ background-position: -860px 0; width: 16px; height: 16px; }
.os-os2{ background-position: -877px 0; width: 16px; height: 16px; }
.os-osf{ background-position: -894px 0; width: 16px; height: 16px; }
.os-palmos{ background-position: -911px 0; width: 16px; height: 16px; }
.os-psp{ background-position: -928px 0; width: 16px; height: 16px; }
.os-qnx{ background-position: -945px 0; width: 16px; height: 16px; }
.os-riscos{ background-position: -962px 0; width: 16px; height: 16px; }
.os-sco{ background-position: -979px 0; width: 16px; height: 16px; }
.os-sunos{ background-position: -996px 0; width: 16px; height: 16px; }
.os-syllable{ background-position: -1013px 0; width: 16px; height: 16px; }
.os-symbian{ background-position: -1030px 0; width: 16px; height: 16px; }
.os-unix{ background-position: -1047px 0; width: 16px; height: 16px; }
.os-unknown{ background-position: -1064px 0; width: 16px; height: 16px; }
.os-vms{ background-position: -1081px 0; width: 16px; height: 16px; }
.os-webtv{ background-position: -1098px 0; width: 16px; height: 16px; }
.os-wii{ background-position: -1115px 0; width: 16px; height: 16px; }
.os-win{ background-position: -1132px 0; width: 16px; height: 16px; }
.os-win16{ background-position: -1149px 0; width: 16px; height: 16px; }
.os-win2000{ background-position: -1166px 0; width: 16px; height: 15px; }
.os-win2003{ background-position: -1183px 0; width: 16px; height: 16px; }
.os-win2008{ background-position: -1200px 0; width: 16px; height: 16px; }
.os-win7{ background-position: -1217px 0; width: 16px; height: 16px; }
.os-win95{ background-position: -1234px 0; width: 16px; height: 14px; }
.os-win98{ background-position: -1251px 0; width: 16px; height: 14px; }
.os-wince{ background-position: -1268px 0; width: 16px; height: 16px; }
.os-winlong{ background-position: -1285px 0; width: 16px; height: 16px; }
.os-winme{ background-position: -1302px 0; width: 16px; height: 16px; }
.os-winnt{ background-position: -1319px 0; width: 16px; height: 14px; }
.os-winunknown{ background-position: -1336px 0; width: 16px; height: 16px; }
.os-winvista{ background-position: -1353px 0; width: 16px; height: 16px; }
.os-winxbox{ background-position: -1370px 0; width: 16px; height: 16px; }
.os-winxp{ background-position: -1387px 0; width: 16px; height: 16px; }

/* ==|== browser classes ====================================================== */
.browser{
	display: inline-block;
	width: 16px;
	height: 16px;
	background: transparent url('<?php echo $image_dir ?>plugin/browser.png') -1000px -1000px no-repeat;
	text-shadow:none;
	color: transparent;
}
.browser-abilon{ background-position: 0 0; width: 16px; height: 16px; }
.browser-adobe{ background-position: -17px 0; width: 16px; height: 16px; }
.browser-akregator{ background-position: -34px 0; width: 16px; height: 16px; }
.browser-alcatel{ background-position: -51px 0; width: 16px; height: 16px; }
.browser-amaya{ background-position: -68px 0; width: 16px; height: 16px; }
.browser-amigavoyager{ background-position: -85px 0; width: 16px; height: 16px; }
.browser-analogx{ background-position: -102px 0; width: 16px; height: 16px; }
.browser-android{ background-position: -119px 0; width: 16px; height: 16px; }
.browser-apt{ background-position: -136px 0; width: 16px; height: 16px; }
.browser-avant{ background-position: -153px 0; width: 16px; height: 16px; }
.browser-aweb{ background-position: -170px 0; width: 16px; height: 16px; }
.browser-bpftp{ background-position: -187px 0; width: 16px; height: 16px; }
.browser-bytel{ background-position: -204px 0; width: 16px; height: 16px; }
.browser-chimera{ background-position: -221px 0; width: 16px; height: 16px; }
.browser-chrome{ background-position: -238px 0; width: 16px; height: 16px; }
.browser-cyberdog{ background-position: -255px 0; width: 16px; height: 16px; }
.browser-da{ background-position: -272px 0; width: 16px; height: 16px; }
.browser-dillo{ background-position: -289px 0; width: 16px; height: 16px; }
.browser-doris{ background-position: -306px 0; width: 16px; height: 16px; }
.browser-dreamcast{ background-position: -323px 0; width: 16px; height: 16px; }
.browser-ecatch{ background-position: -340px 0; width: 16px; height: 16px; }
.browser-encompass{ background-position: -357px 0; width: 16px; height: 16px; }
.browser-epiphany{ background-position: -374px 0; width: 16px; height: 16px; }
.browser-ericsson{ background-position: -391px 0; width: 16px; height: 16px; }
.browser-feeddemon{ background-position: -408px 0; width: 16px; height: 16px; }
.browser-feedreader{ background-position: -425px 0; width: 16px; height: 16px; }
.browser-firefox{ background-position: -442px 0; width: 16px; height: 16px; }
.browser-flashget{ background-position: -459px 0; width: 16px; height: 16px; }
.browser-flock{ background-position: -476px 0; width: 16px; height: 16px; }
.browser-fpexpress{ background-position: -493px 0; width: 16px; height: 16px; }
.browser-fresco{ background-position: -510px 0; width: 14px; height: 14px; }
.browser-freshdownload{ background-position: -525px 0; width: 16px; height: 16px; }
.browser-frontpage{ background-position: -542px 0; width: 16px; height: 16px; }
.browser-galeon{ background-position: -559px 0; width: 16px; height: 16px; }
.browser-getright{ background-position: -576px 0; width: 16px; height: 16px; }
.browser-gnome{ background-position: -593px 0; width: 16px; height: 16px; }
.browser-gnus{ background-position: -610px 0; width: 16px; height: 16px; }
.browser-gozilla{ background-position: -627px 0; width: 16px; height: 16px; }
.browser-hotjava{ background-position: -644px 0; width: 16px; height: 16px; }
.browser-httrack{ background-position: -661px 0; width: 16px; height: 16px; }
.browser-ibrowse{ background-position: -678px 0; width: 16px; height: 16px; }
.browser-icab{ background-position: -695px 0; width: 16px; height: 16px; }
.browser-icecat{ background-position: -712px 0; width: 16px; height: 16px; }
.browser-iceweasel{ background-position: -729px 0; width: 16px; height: 16px; }
.browser-java{ background-position: -746px 0; width: 16px; height: 16px; }
.browser-jetbrains_omea{ background-position: -763px 0; width: 16px; height: 16px; }
.browser-kmeleon{ background-position: -780px 0; width: 16px; height: 16px; }
.browser-konqueror{ background-position: -797px 0; width: 16px; height: 16px; }
.browser-leechget{ background-position: -814px 0; width: 16px; height: 16px; }
.browser-lg{ background-position: -831px 0; width: 16px; height: 16px; }
.browser-lotusnotes{ background-position: -848px 0; width: 16px; height: 16px; }
.browser-lynx{ background-position: -865px 0; width: 16px; height: 16px; }
.browser-macweb{ background-position: -882px 0; width: 16px; height: 16px; }
.browser-mediaplayer{ background-position: -899px 0; width: 16px; height: 16px; }
.browser-motorola{ background-position: -916px 0; width: 16px; height: 16px; }
.browser-mozilla{ background-position: -933px 0; width: 16px; height: 16px; }
.browser-mplayer{ background-position: -950px 0; width: 16px; height: 16px; }
.browser-msie{ background-position: -967px 0; width: 16px; height: 16px; }
.browser-multizilla{ background-position: -984px 0; width: 16px; height: 16px; }
.browser-ncsa_mosaic{ background-position: -1001px 0; width: 16px; height: 16px; }
.browser-neon{ background-position: -1018px 0; width: 16px; height: 16px; }
.browser-netnewswire{ background-position: -1035px 0; width: 16px; height: 16px; }
.browser-netpositive{ background-position: -1052px 0; width: 16px; height: 16px; }
.browser-netscape{ background-position: -1069px 0; width: 16px; height: 16px; }
.browser-netshow{ background-position: -1086px 0; width: 16px; height: 16px; }
.browser-newsfire{ background-position: -1103px 0; width: 16px; height: 16px; }
.browser-newsgator{ background-position: -1120px 0; width: 16px; height: 16px; }
.browser-newzcrawler{ background-position: -1137px 0; width: 16px; height: 16px; }
.browser-nokia{ background-position: -1154px 0; width: 16px; height: 16px; }
.browser-notavailable{ background-position: -1171px 0; width: 14px; height: 14px; }
.browser-omniweb{ background-position: -1186px 0; width: 16px; height: 16px; }
.browser-opera{ background-position: -1203px 0; width: 16px; height: 16px; }
.browser-panasonic{ background-position: -1220px 0; width: 16px; height: 16px; }
.browser-pdaphone{ background-position: -1237px 0; width: 16px; height: 16px; }
.browser-philips{ background-position: -1254px 0; width: 16px; height: 16px; }
.browser-phoenix{ background-position: -1271px 0; width: 16px; height: 16px; }
.browser-pluck{ background-position: -1288px 0; width: 16px; height: 16px; }
.browser-pulpfiction{ background-position: -1305px 0; width: 16px; height: 16px; }
.browser-real{ background-position: -1322px 0; width: 16px; height: 16px; }
.browser-rss{ background-position: -1339px 0; width: 16px; height: 16px; }
.browser-rssbandit{ background-position: -1356px 0; width: 16px; height: 16px; }
.browser-rssowl{ background-position: -1373px 0; width: 16px; height: 16px; }
.browser-rssreader{ background-position: -1390px 0; width: 16px; height: 16px; }
.browser-rssxpress{ background-position: -1407px 0; width: 16px; height: 16px; }
.browser-safari{ background-position: -1424px 0; width: 16px; height: 16px; }
.browser-sagem{ background-position: -1441px 0; width: 16px; height: 16px; }
.browser-samsung{ background-position: -1458px 0; width: 16px; height: 16px; }
.browser-seamonkey{ background-position: -1475px 0; width: 16px; height: 16px; }
.browser-sharp{ background-position: -1492px 0; width: 16px; height: 16px; }
.browser-sharpreader{ background-position: -1509px 0; width: 16px; height: 16px; }
.browser-shrook{ background-position: -1526px 0; width: 16px; height: 16px; }
.browser-siemens{ background-position: -1543px 0; width: 16px; height: 16px; }
.browser-sony{ background-position: -1560px 0; width: 16px; height: 16px; }
.browser-staroffice{ background-position: -1577px 0; width: 16px; height: 16px; }
.browser-subversion{ background-position: -1594px 0; width: 16px; height: 16px; }
.browser-teleport{ background-position: -1611px 0; width: 16px; height: 16px; }
.browser-trium{ background-position: -1628px 0; width: 16px; height: 16px; }
.browser-unknown{ background-position: -1645px 0; width: 16px; height: 16px; }
.browser-w3c{ background-position: -1662px 0; width: 16px; height: 16px; }
.browser-webcopier{ background-position: -1679px 0; width: 16px; height: 16px; }
.browser-webreaper{ background-position: -1696px 0; width: 16px; height: 16px; }
.browser-webtv{ background-position: -1713px 0; width: 16px; height: 16px; }
.browser-webzip{ background-position: -1730px 0; width: 16px; height: 16px; }
.browser-winxbox{ background-position: -1747px 0; width: 16px; height: 16px; }
.browser-wizz{ background-position: -1764px 0; width: 16px; height: 16px; }

/* ==|== ui icon classes ==================================================== */
.pkwk-icon{
	display: inline-block;
	width: 16px;
	height: 16px;
	line-height: 100%;
	background: transparent url('<?php echo $image_dir ?>iconset/<?php echo $iconset ?>.png') -1000px -1000px no-repeat;
	vertical-align: middle;
	margin:0 2px;
	text-align: center;
	text-shadow: none;
	color: transparent;
}

.icon-new			{ background-position: 0 0; }
.icon-page			{ background-position: -18px 0; }
.icon-add			{ background-position: -36px 0; }
.icon-copy			{ background-position: -54px 0; }
.icon-newsub		{ background-position: -72px 0; }
.icon-edit			{ background-position: -90px 0; }
.icon-diff			{ background-position: -108px 0; }

.icon-source		{ background-position: 0 -18px; }
.icon-rename		{ background-position: -18px -18px; }
.icon-upload		{ background-position: -36px -18px; }
.icon-backup		{ background-position: -54px -18px; }
.icon-reload		{ background-position: -72px -18px; }
.icon-freeze		{ background-position: -90px -18px; }
.icon-unfreeze		{ background-position: -108px -18px; }

.icon-pdf			{ background-position: 0 -36px; }
.icon-list			{ background-position: -18px -36px; }
.icon-filelist		{ background-position: -36px -36px; }
.icon-login			{ background-position: -54px -36px; }
.icon-logout		{ background-position: -72px -36px; }
.icon-referer		{ background-position: -90px -36px; }
/*
.icon-linklist		{ background-position: -108px -36px; }
*/

.icon-download		{ background-position: 0 -54px; }
.icon-search		{ background-position: -18px -54px; }
.icon-log			{ background-position: -36px -54px; }
/*
.icon-log_check		{ background-position: -54px -54px; }
.icon-log_down		{ background-position: -72px -54px; }
.icon-log_login		{ background-position: -90px -54px; }
.icon-log_update	{ background-position: -108px -54px; }
*/

.icon-top			{ background-position: 0 -72px; }
.icon-home			{ background-position: -18px -72px; }
.icon-recent		{ background-position: -36px -72px; }
.icon-help			{ background-position: -54px -72px; }
.icon-alias			{ background-position: -72px -72px; }
.icon-glossary		{ background-position: -90px -72px; }
.icon-deleted		{ background-position: -108px -72px; }

.icon-rss			{ background-position: 0 -90px; }
.icon-opml			{ background-position: -18px -90px; }
.icon-share			{ background-position: -36px -90px; }
.icon-canonical		{ background-position: -54px -90px; }
.icon-trackback		{ background-position: -72px -90px; }
.icon-tags			{ background-position: -90px -90px; }
.icon-toc			{ background-position: -108px -90px; }

.icon-interwiki		{ background-position: 0 -108px; }
.icon-mail			{ background-position: -18px -108px; }

.pkwk-symbol{
	display: inline-block;
	width: 8px;
	height: 8px;
	margin:0 2px;
	padding:1px;
	line-height:100%;
	background: transparent url('<?php echo $image_dir ?>iconset/default.png') -1000px -1000px no-repeat;
	vertical-align: middle;
	text-align:center;
	text-shadow:none;
	color: transparent;
}
.symbol-add			{ background-position: -36px -114px; }
.symbol-edit		{ background-position: -54px -114px; }
.symbol-attach		{ background-position: -72px -114px; }
.symbol-external	{ background-position: -90px -114px; }
.symbol-internal	{ background-position: -108px -114px; }

/* ==|== Helper classes ===================================================== */
.ir {background-color: transparent;border: 0;overflow: hidden;*text-indent: -9999px;}
.ir:before {content: "";display: block;width: 0;height: 100%;}

.hidden {display: none !important;visibility: hidden;}
.visuallyhidden {border: 0;clip: rect(0 0 0 0);height: 1px;margin: -1px;overflow: hidden;padding: 0;position: absolute;width: 1px;}
.visuallyhidden.focusable:active,.visuallyhidden.focusable:focus {clip: auto;height: auto;margin: 0;overflow: visible;position: static;width: auto;}

.invisible {visibility: hidden;}

.clearfix:before,.clearfix:after {content: " ";display: table;}
.clearfix:after {clear: both;}
.clearfix {*zoom: 1;}

/* ==|== jQuery Mobile Override classes ============================== */
.content-secondary .ui-listview {
	margin : 0 -15px !important;
}
@media all and (min-width: 650px){
	.two-colums{
		margin:0;
		padding:0 !important;
	}

	.two-colums .content-secondary {
		border-right:1px #CCC solid;
		text-align: left;
		float: left;
		width: 28%;
		background: none;
	}
	.two-colums .content-primary {
		padding: 0 5px;
		width: 70%;
		float: right;
	}
	/* fix up the collapsibles - expanded on desktop */
	.two-colums .content-secondary .ui-collapsible {
		margin: 0;
		padding: 0;
	}
	.two-colums .content-secondary .ui-collapsible-heading {
		display: none;
	}
	.two-colums .content-secondary .ui-collapsible-contain {
		margin:0;
	}
	.two-colums .content-secondary .ui-collapsible-content {
		display: block;
		margin: 0;
		padding: 0;
	}
	.two-colums .type-interior .content-secondary .ui-li-divider {
		padding-top: 1em;
		padding-bottom: 1em;
	}
	.two-colums .type-interior .content-secondary {
		margin: 0;
		padding: 0;
	}
	.two-colums .content-secondary .ui-listview {
		margin : 0 !important;
	}
}
<?php
@ob_end_flush();

/* End of file mobile.ini.php */
/* Location: ./webroot/skin/theme/mobile/mobile.ini.php */