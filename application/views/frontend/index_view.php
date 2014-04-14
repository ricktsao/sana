<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Qnap</title>
<link href="<?=base_url();?>css/index.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url();?>css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=base_url();?>js/navigation.js"></script>
<script type="text/javascript" src="<?=base_url();?>js/selectLike.js"></script>
<script type="text/javascript" src="<?=base_url();?>js/wheel.js"></script>
<script type="text/javascript" src="<?=base_url();?>js/rotation.js"></script>
<script type="text/javascript" src="<?=base_url();?>js/openIndex.js"></script>
<script type="text/javascript" src="<?=base_url();?>js/popup.js"></script>
<script type="text/javascript">
var isIE6=false;

if(navigator.userAgent.indexOf("MSIE 6")!=-1)
{
	isIE6=true;
}
</script>
</head>

<body>
<div id="wrapper">
  	<div id="header">
    	<div id="logo"><a href="index.html" title="Qnap"><img src="<?=base_url();?>images/img_logo.jpg" alt="Qnap" title="Qnap" border="0" /></a></div>
        <div id="stay">
        	<table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="home"><a href="index.html" title="Home">Home</a></td>
                <td class="separator">|</td>
                <td class="contact"><a href="#" title="Contact Us">Contact Us</a></td>
                <td class="separator">|</td>
                <td class="sitemap"><a href="sitemap.html" title="Sitemap">Sitemap</a></td>
                <td class="separator">|</td>
                <td class="login"><a href="javascript:popup('popupLoginFrame')" title="Login">Login</a></td>
              </tr>
            </table>
        </div>
        <div id="search">
        <form action="#" method="post">
        	<div class="inputFrame">
            	<div class="left"></div>
                <div class="center"><input name="" type="text" value="Search" onfocus="if(this.value=='Search'){this.value='';}" onblur="if(this.value==''){this.value='Search';}" /></div>
                <div class="right"></div>
            </div>
            <div class="btnFrame"><input value="" type="submit" /></div>
        </form>
        </div>
        <div id="language">
        	<div class="left"></div>
            <div class="center" id="languageInput">Global-English</div>
            <div class="right" onclick="openSelect('languageSelect')"></div>
            <div id="languageSelect" onmouseover="clearSelectLikeTimer()" onmouseout="immediatelyCloseDiv()" style="display:none">
            	<div onclick="putSelectValue(this,'languageInput')">繁體中文1</div>
                <div onclick="putSelectValue(this,'languageInput')">繁體中文2</div>
                <div onclick="putSelectValue(this,'languageInput')">繁體中文3</div>
                <div onclick="putSelectValue(this,'languageInput')">繁體中文4</div>
            </div>
        </div>
    </div>
    <div id="navigation">
    	<ul>
        	<li onmouseover="showNavigationChildren(this)" onmouseout="hideNavigationChildren(this)"><div class="l1"><a href="about_1.html" title="About QNAP">About QNAP<div class="left"></div></a></div></li>
            <li><div class="separator"></div></li>
            <li onmouseover="showNavigationChildren(this)" onmouseout="hideNavigationChildren(this)"><div class="l1"><a href="products.html" title="Products">Products</a></div>
            	<ul style="display:none">
                	<li><div class="l2Top"><div class="left"></div><div class="center"></div><div class="right"></div></div></li>
                    <li><div class="l2"><div class="left"></div><div class="center"><a href="products.html" title="Storage">Storage</a></div><div class="right"></div></div></li>
                    <li><div class="l2"><div class="left"></div><div class="center"><a href="#" title="Surveillance">Surveillance</a></div><div class="right"></div></div></li>
                    <li><div class="l2"><div class="left"></div><div class="center"><a href="#" title="Network Multimedia Player">Network Multimedia Player</a></div><div class="right"></div></div></li>
                    <li><div class="l2Bottom"><div class="left"></div><div class="center"></div><div class="right"></div></div></li>
                </ul>
            </li>
            <li><div class="separator"></div></li>
            <li onmouseover="showNavigationChildren(this)" onmouseout="hideNavigationChildren(this)"><div class="l1"><a href="solutions.html" title="Solutions">Solutions</a></div>
            	<ul style="display:none">
                	<li><div class="l2Top"><div class="left"></div><div class="center"></div><div class="right"></div></div></li>
                    <li><div class="l2"><div class="left"></div><div class="center"><a href="#" title="Storage">Storage</a></div><div class="right"></div></div></li>
                    <li><div class="l2"><div class="left"></div><div class="center"><a href="#" title="Surveillance">Surveillance</a></div><div class="right"></div></div></li>
                    <li><div class="l2"><div class="left"></div><div class="center"><a href="#" title="Network Multimedia Player">Network Multimedia Player</a></div><div class="right"></div></div></li>
                    <li><div class="l2"><div class="left"></div><div class="center"><a href="#" title="Storage">Storage</a></div><div class="right"></div></div></li>
                    <li><div class="l2"><div class="left"></div><div class="center"><a href="#" title="Surveillance">Surveillance</a></div><div class="right"></div></div></li>
                    <li><div class="l2"><div class="left"></div><div class="center"><a href="#" title="Network Multimedia Player">Network Multimedia Player</a></div><div class="right"></div></div></li>
                    <li><div class="l2Bottom"><div class="left"></div><div class="center"></div><div class="right"></div></div></li>
                </ul>
            </li>
            <li><div class="separator"></div></li>
            <li onmouseover="showNavigationChildren(this)" onmouseout="hideNavigationChildren(this)"><div class="l1"><a href="news.html" title="News Center">News Center</a></div></li>
            <li><div class="separator"></div></li>
            <li onmouseover="showNavigationChildren(this)" onmouseout="hideNavigationChildren(this)"><div class="l1"><a href="community.html" title="Community">Community</a></div></li>
            <li><div class="separator"></div></li>
            <li onmouseover="showNavigationChildren(this)" onmouseout="hideNavigationChildren(this)"><div class="l1"><a href="support.html" title="Support">Support</a></div></li>
            <li><div class="separator"></div></li>
            <li onmouseover="showNavigationChildren(this)" onmouseout="hideNavigationChildren(this)"><div class="l1"><a href="where.html" title="Where to Buy">Where to Buy</a></div></li>
            <li><div class="separator"></div></li>
            <li onmouseover="showNavigationChildren(this)" onmouseout="hideNavigationChildren(this)"><div class="l1"><a href="store.html" title="Store">Store</a></div></li>
            <li><div class="separator"></div></li>
            <li onmouseover="showNavigationChildren(this)" onmouseout="hideNavigationChildren(this)"><div class="l1"><a href="resource.html" title="Resources">Resources<div class="right"></div></a></div></li>
        </ul>
        <script type="text/javascript">initNavigation();</script>
    </div>
</div>
<div id="wrapper_container">
	<div id="container">
    	<div id="kv">
        	<div class="imgsFrame" style="display:none"></div>
            <div class="imgsFrame" style="display:none">
            	<div class="textFrame">
                	<span style="font-size:18px; color:#900">這是字的位置,編輯器要自己設定行高,否則IE67會被沏掉</span>
                </div>
            </div>
            <div class="imgsFrame" style="display:none">
            	<div class="textFrame">
                	<span style="font-size:30px; color:#fff">1234圖檔最高350px,</span>
                </div>
            </div>
       		<div id="pageFrame"></div>
        </div>
        <script type="text/javascript">
		createRotationObj('index');
		setRotationObjValue('index','mainId','kv');
		setRotationObjValue('index','imgsFrame','imgsFrame');
		setRotationObjValue('index','imgPath',new Array('<?=base_url();?>upload/index_05.png','<?=base_url();?>upload/kv1.jpg','<?=base_url();?>upload/kv2.jpg'));
		setRotationObjValue('index','pageOnClassName','pageOn');
		setRotationObjValue('index','pageOffClassName','pageOff');
		setRotationObjValue('index','pageFrameId','pageFrame');
		setRotationObjValue('index','pageDigit',2);
		initRotation('index');
		</script>
        <div id="promotion">
        	<a class="promotion" href="#" title="promotion1"><img src="<?=base_url();?>upload/index_16.jpg" alt="promotion1" title="promotion1" border="0" /></a>
            <a class="promotion" href="#" title="promotion2"><img src="<?=base_url();?>upload/index_18.jpg" alt="promotion2" title="promotion2" border="0" /></a>
            <a class="promotion last" href="#" title="promotion3"><img src="<?=base_url();?>upload/index_20.jpg" alt="promotion3" title="promotion3" border="0" /></a>
            <div class="clear"></div><!--增加 clear 2011/06/10 ***********************************************************************-->
        </div>
        <div id="primary">
        	<div id="left">
            	<div id="wheel">	
                	<div class="titleLine">Awards</div>
                    <div id="image"><table><tr><td><a href="#" title="Best Product of 2010 - PCWorld.com (US)"><img src="<?=base_url();?>upload/index_37.jpg" alt="Best Product of 2010 - PCWorld.com (US)" title="Best Product of 2010 - PCWorld.com (US)" border="0" /></a></td></tr></table></div>
                    <div id="title"><a href="#" title="Best Product of 2010 - PCWorld.com (US)">Best Product of 2010 - PCWorld.com (US)</a></div>
                    <div id="desc"><a href="#" title="Best Product of 2010 - PCWorld.com (US)">QNAP TS-259 Pro Turbo NAS TS-259 Pro Turbo NAS QNAP TS-259 Pro Turbo NAS TS-259 Pro Turbo NAS</a></div>
                    <div id="wheelFrame">
                    	<div id="wheelAvail">
                        	<div id="wheelBody">
                            	<div class="eachItem" onclick=""><table><tr><td><img src="<?=base_url();?>upload/index_53.jpg" alt="Award1" title="Award1" /></td></tr></table></div>
                                <div class="eachItem" onclick=""><table><tr><td><img src="<?=base_url();?>upload/index_56.jpg" alt="Award2" title="Award2" /></td></tr></table></div>
                                <div class="eachItem" onclick=""><table><tr><td><img src="<?=base_url();?>upload/index_59.jpg" alt="Award3" title="Award3" /></td></tr></table></div>
                                <div class="eachItem" onclick=""><table><tr><td><img src="<?=base_url();?>upload/index_62.jpg" alt="Award4" title="Award4" /></td></tr></table></div>
                                <div class="eachItem" onclick=""><table><tr><td><img src="<?=base_url();?>upload/index_56.jpg" alt="Award5" title="Award5" /></td></tr></table></div>
                                <div class="eachItem" onclick=""><table><tr><td><img src="<?=base_url();?>upload/index_56.jpg" alt="Award6" title="Award6" /></td></tr></table></div>
                                <div class="eachItem" onclick=""><table><tr><td><img src="<?=base_url();?>upload/index_56.jpg" alt="Award7" title="Award7" /></td></tr></table></div>
                                <div class="eachItem" onclick=""><table><tr><td><img src="<?=base_url();?>upload/index_56.jpg" alt="Award8" title="Award8" /></td></tr></table></div>
                                <div class="eachItem" onclick=""><table><tr><td><img src="<?=base_url();?>upload/index_56.jpg" alt="Award9" title="Award9" /></td></tr></table></div>
                            </div>
                        </div>
                        <div id="wheelLeft"><img src="<?=base_url();?>images/index/bg_index_award_left_off.png" alt="" title="" onmouseover="this.src='<?=base_url();?>images/index/bg_index_award_left_on.png'" onmouseout="this.src='<?=base_url();?>images/index/bg_index_award_left_off.png'" /></div>
                        <div id="wheelRight"><img src="<?=base_url();?>images/index/bg_index_award_right_off.png" alt="" title="" onmouseover="this.src='<?=base_url();?>images/index/bg_index_award_right_on.png'" onmouseout="this.src='<?=base_url();?>images/index/bg_index_award_right_off.png'" /></div>
                    </div>
                    <div class="more" onclick=""></div>
                </div>
                <script type="text/javascript">
				createWheelObj('index');
				setWheelObjValue('index','moveId','wheelBody');
				setWheelObjValue('index','availRange',264);
				setWheelObjValue('index','availUnitCount',4);
				setWheelObjValue('index','unitRange',66);
				setWheelObjValue('index','unitClassName','eachItem');
				setWheelObjValue('index','loopWay','toFirst');
				setWheelObjValue('index','moveWay','page');
				setWheelObjValue('index','leftBtn',new Array('wheelLeft'));
				setWheelObjValue('index','RightBtn',new Array('wheelRight'));
				initWheel('index');
				</script>
                <div id="openClose">
                	<div class="titleLine">User Area</div>
                    <div class="openItem">
                    	<div class="opened">
                        	<div class="image"><table><tr><td><a href="#" title="Compatibility List"><img src="<?=base_url();?>upload/index_34.jpg" alt="Compatibility List" title="Compatibility List" border="0" /></a></td></tr></table></div>
                            <div class="title"><a href="#" title="Compatibility List">Compatibility List</a></div>
                            <div class="desc">HDD, Network Camera, External Storage Device, Network Camera, USB Printer, UPS, 3rd party Software , USB Wireless... HDD, Network Camera, External Storage Device, Network Camera, USB Printer, UPS, 3rd party Software , USB Wireless...</div>
                            <div class="more" onclick=""></div>
                        </div>
                        <div class="closed" style="display:none">Compatibility List<div class="openBtn" onclick="OpenThisBlock(this,'openClose')"></div></div>
                    </div>
                    <div class="openItem">
                    	<div class="opened" style="display:none">
                        	<div class="image"><table><tr><td><a href="#" title="Online Tutorials"><img src="<?=base_url();?>upload/index_34.jpg" alt="Online Tutorials" title="Online Tutorials" border="0" /></a></td></tr></table></div>
                            <div class="title"><a href="#" title="Online Tutorials">Online Tutorials</a></div>
                            <div class="desc">HDD, Network Camera, External Storage Device, Network Camera, USB Printer, UPS, 3rd party Software , USB Wireless... HDD, Network Camera, External Storage Device, Network Camera, USB Printer, UPS, 3rd party Software , USB Wireless...</div>
                            <div class="more" onclick=""></div>
                        </div>
                        <div class="closed">Online Tutorials Online Tutorials Online Tutorials<div class="openBtn" onclick="OpenThisBlock(this,'openClose')"></div></div>
                    </div>
                    <div class="openItem">
                    	<div class="opened" style="display:none">
                        	<div class="image"><table><tr><td><a href="#" title="Comparison Table"><img src="<?=base_url();?>upload/index_34.jpg" alt="Comparison Table" title="Comparison Table" border="0" /></a></td></tr></table></div>
                            <div class="title"><a href="#" title="Comparison Table">Comparison Table</a></div>
                            <div class="desc">HDD, Network Camera, External Storage Device, Network Camera, USB Printer, UPS, 3rd party Software , USB Wireless... HDD, Network Camera, External Storage Device, Network Camera, USB Printer, UPS, 3rd party Software , USB Wireless...</div>
                            <div class="more" onclick=""></div>
                        </div>
                        <div class="closed">Comparison Table<div class="openBtn" onclick="OpenThisBlock(this,'openClose')"></div></div>
                    </div>
                    <div class="openItem">
                    	<div class="opened" style="display:none">
                        	<div class="image"><table><tr><td><a href="#" title="Live Demo"><img src="<?=base_url();?>upload/index_34.jpg" alt="Live Demo" title="Live Demo" border="0" /></a></td></tr></table></div>
                            <div class="title"><a href="#" title="Live Demo">Live Demo</a></div>
                            <div class="desc">HDD, Network Camera, External Storage Device, Network Camera, USB Printer, UPS, 3rd party Software , USB Wireless... HDD, Network Camera, External Storage Device, Network Camera, USB Printer, UPS, 3rd party Software , USB Wireless...</div>
                            <div class="more" onclick=""></div>
                        </div>
                        <div class="closed">Live Demo<div class="openBtn" onclick="OpenThisBlock(this,'openClose')"></div></div>
                    </div>
                    <div class="openItem last">
                    	<div class="opened" style="display:none">
                        	<div class="image"><table><tr><td><a href="#" title="Forum"><img src="<?=base_url();?>upload/index_34.jpg" alt="Forum" title="Forum" border="0" /></a></td></tr></table></div>
                            <div class="title"><a href="#" title="Forum">Forum</a></div>
                            <div class="desc">HDD, Network Camera, External Storage Device, Network Camera, USB Printer, UPS, 3rd party Software , USB Wireless... HDD, Network Camera, External Storage Device, Network Camera, USB Printer, UPS, 3rd party Software , USB Wireless...</div>
                            <div class="more" onclick=""></div>
                        </div>
                        <div class="closed">Forum<div class="openBtn" onclick="OpenThisBlock(this,'openClose')"></div></div>
                    </div>
                </div>
            </div>
            <div id="right">
            	<div class="titleline">News Center</div>
                <div class="lists">
                	<div class="each bottomLine">
                    	<div class="date">[ 2011/01/03 ]</div>
                        <div class="title"><a href="#" title="A Wide Range of ONVIF-conformant Cameras Are Now Supported by QNAP VioStor NVR 3.3.1...">A Wide Range of ONVIF-conformant Cameras Are Now Supported by QNAP VioStor NVR 3.3.1...</a></div>
                    </div>
                    <div class="each bottomLine">
                    	<div class="date">[ 2011/01/03 ]</div>
                        <div class="title"><a href="#" title="A Wide Range of ONVIF-conformant Cameras Are Now Supported by QNAP VioStor NVR 3.3.1...">A Wide Range of ONVIF-conformant Cameras Are Now Supported by QNAP VioStor NVR 3.3.1...</a></div>
                    </div>
                    <div class="each">
                    	<div class="date">[ 2011/01/03 ]</div>
                        <div class="title"><a href="#" title="A Wide Range of ONVIF-conformant Cameras Are Now Supported by QNAP VioStor NVR 3.3.1...">A Wide Range of ONVIF-conformant Cameras Are Now Supported by QNAP VioStor NVR 3.3.1...</a></div>
                    </div>
                </div>
                <div class="more"></div>
            </div>
            <div class="clear"></div><!--增加 clear 2011/06/10 *****************************************************************************-->
        </div>
  	</div>
</div>
<div id="wrapper_footer">
	<div id="footer">
    	<div id="quick">| <a href="#" title="About QNAP">About QNAP</a> | <a href="#" title="Privacy Policy">Privacy Policy</a> | <a href="#" title="Terms of Use">Terms of Use</a> | <a href="#" title="E-Paper">E-Paper</a> |</div>
        <div id="info">Asia - Taiwan QNAP Systems, Inc. &nbsp;&nbsp;&nbsp;&nbsp; TEL: +886-2-8698 2000 &nbsp;&nbsp;&nbsp;&nbsp; FAX: +886-2-8698 2270</div>
        <div id="copyright">Copyright ©2011; QNAP Systems, Inc. All Rights Reserved. </div>
        <div id="community">
        	<div><img src="<?=base_url();?>images/icon_facebook.gif" alt="Facebook" title="Facebook" onclick="" /></div>
            <div><img src="<?=base_url();?>images/icon_plunk.gif" alt="Plunk" title="Plunk" onclick="" /></div>
            <div><img src="<?=base_url();?>images/icon_twitter.gif" alt="Twitter" title="Twitter" onclick="" /></div>
        </div>
    </div>
</div>
<div id="popupLoginFrame" style="display:none; background-image:url(<?=base_url();?>upload/login_07.jpg)">
	<div id="titleLine">Login</div>
    <div id="contentLogin">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="left">Account : </td>
            <td><input name="" class="inputs" /></td>
          </tr>
          <tr>
            <td class="left">Password : </td>
            <td><input name="" class="inputs" /></td>
          </tr>
          <tr>
            <td class="left">Verification Code : </td>
            <td><input name="" class="verification" />&nbsp;&nbsp;<img align="absmiddle" src="http://demo.akacia.com.tw/~qnap/include/verifying_code/show_veri_code_pic.php" /> (<a href="#">Retype</a>)</td>
          </tr>
        </table>
        <div id="functionLine"><a href="#">Forget Password</a> | <a href="#">Register Free Account</a></div>
        <div id="buttonLine"><input value="Login" type="submit" class="btn" /></div>
        <div id="closePopup" onclick="closePopup('popupLoginFrame')"></div>
    </div>
</div>
</body>
</html>
