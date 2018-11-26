<?php
define('URL',dirname($_SERVER['SCRIPT_NAME']).'/'.$_SERVER['HTTP_HOST'].'/');
$url=str_replace('web','',URL);
var_dump($url);
$isloged=false;
$user='';

if(isset($_COOKIE['remember'])){
    if(!isset($_SESSION['auth']))
    {
        $cookie=explode('==',$_COOKIE['remember']);
        $user= \App::getInstance()->getdb()->prepare('select * from users WHERE cin=?',[$cookie[0]],true);

    }
    else{

        $user=$_SESSION['auth'];
    }
}
if(isset($_SESSION['auth'])){
    $user=$_SESSION['auth'];
}
if($user){
    $isloged=true;
}
?>
<!DOCTYPE html>

<html lang="en-US" class="css3transitions">

<!-- Mirrored from www.sivexo.ma/web/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Jun 2017 11:51:16 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>

<!-- Mirrored from newthemes.themeple.co/solveto/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 27 Nov 2014 10:16:41 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<!-- /Added by HTTrack -->



    <meta charset="UTF-8" />


    <!-- Title -->
    
    <title>Sivexo | Facilities Management
</title>
    
    <meta name="keywords" content="Sivexo, Facility Management, Facility, Management, Services" />
<meta name="description" content="Bienvenue dans notre le site de Sivexo Facility Management" />

    <!-- Responsive Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Pingback $url -->

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->

    <!--[if lt IE 9]>

    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>

    <![endif]-->



    <link rel='stylesheet' id='flick-css' href="bundles/sivexoplatform/plugins/mailchimp/css/flick/flick.css" type='text/css' media='all' />
    

    <link rel='stylesheet' id='rs-plugin-settings-css' href="bundles/sivexoplatform/plugins/revslider/rs-plugin/css/settings.css" type='text/css' media='all' />

    <style type='text/css'>
        @import url(http://fonts.googleapis.com/css?family=Open+Sans:400,800,300,700);
        .tp-caption a {
            color: #ff7302;
            text-shadow: none;
            -webkit-transition: all 0.2s ease-out;
            -moz-transition: all 0.2s ease-out;
            -o-transition: all 0.2s ease-out;
            -ms-transition: all 0.2s ease-out
        }
        .tp-caption a:hover {
            color: #ffa902
        }
    </style>
    
    <link rel='stylesheet' id="style-css" href="bundles/sivexoplatform/css/style.css" />
    <link rel='stylesheet' id='bootstrap-responsive-css' href="bundles/sivexoplatform/css/bootstrap-responsive.css" type='text/css' media='all' />
    
    <link rel='stylesheet' id='vector-icons-css' href="bundles/sivexoplatform/css/vector-icons.css" type='text/css' media='all' />
    <link rel='stylesheet' id='font-awesome-css' href="bundles/sivexoplatform/css/font-awesome.min.css" type='text/css' media='all' />
    <link rel='stylesheet' id='linecon-css' href="bundles/sivexoplatform/css/linecon.css" type='text/css' media='all' />

    <link rel='stylesheet' id='js_composer_front-css' href="bundles/sivexoplatform/plugins/js_composer/assets/css/js_composer.css" type='text/css' media='all' />

<link rel="icon" href="bundles/sivexoplatform/images/favicon.ico" />






    <script type='text/javascript' src="bundles/sivexoplatform/js/jquery/jquery.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/jquery/jquery-migrate.min.js"></script>

    <script type='text/javascript' src="bundles/sivexoplatform/js/jquery/jquery.form.min.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/jquery/ui/jquery.ui.core.min.js"></script>

    <script type='text/javascript' src="bundles/sivexoplatform/plugins/revslider/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/plugins/revslider/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/jquery.easy-pie-chart.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/jquery.appear.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/modernizr.custom.66803.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/odometer.min.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/animations.js"></script>

    <script type='text/javascript' src="bundles/sivexoplatform/js/bootstrap.min.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/jquery.easing.1.1.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/jquery.easing.1.3.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/jquery.mobilemenu.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/isotope.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/layout-mode.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/masonry.pkgd.min.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/jquery.cycle.all.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/customSelect.jquery.min.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/jquery.flexslider-min.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/fancybox/source/jquery.fancybox.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/fancybox/source/helpers/jquery.fancybox-media.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/jquery.carouFredSel-6.1.0-packed.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/tooltip.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/jquery.hoverex.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/imagesloaded.pkgd.min.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/jquery.parallax.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/jquery.cookie.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/main.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/jquery.placeholder.min.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/jquery.livequery.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/jquery.countdown.min.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/waypoints.min.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/background-check.min.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/idangerous.swiper.min.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/jquery.infinitescroll.js"></script>
                 

    <script type='text/javascript' src="bundles/sivexoplatform/js/jquery/ui/jquery.ui.widget.min.js"></script>
    <script type='text/javascript' src="bundles/sivexoplatform/js/jquery/ui/jquery.ui.accordion.min.js"></script>












    <meta name="generator" content="Powered by Visual Composer - drag and drop page builder for WordPress." />
    
</head>
<body>

<div class="top_nav">

    <div class="container">
        <div class="row-fluid">
            <div class="span6"></div>
            <div class="span6">
                <div class="pull-right">

                    <div id="text-3" class="widget widget_text">
                        <div class="textwidget"><a href="emploi-stage.html">Emploi | Stage</a></div>

                    </div>
                    <div id="text-3" class="widget widget_text">
                        <div class="textwidget"><a href="contact-devis.html">Contact</a></div>

                    </div>
                    <div id="text-3" class="widget widget_text">
                        <div class="textwidget"><a href="extranet/login.html">Extranet</a></div>

                    </div>
                    <div id="text-3" class="widget widget_text">
                        <?php if(!$isloged) {?>
                            <div class="textwidget"><a href="<?=$url?>users/register" ><span class="glyphicon glyphicon-user"></span> Inscription</a> | <a href="<?=$url?>users/login" ><span class="glyphicon glyphicon-log-in"></span> Se connecter</a></div>
                        <?php } else {?>
                            <ul class="">
                                <li class="dropdown" style="margin-top: -5%;">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="" style="color:#000;"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;<?=$user->nomComplet?>&nbsp; <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <?php if($user->role==1){?>
                                            <li><a href="<?=$url?>intervention/interventionRegister"> <span class="glyphicon glyphicon-list-alt"></span> Demander une Intervention</a></li>
                                            <li><a href="<?=$url?>intervention/interventionClient"> <span class="glyphicon glyphicon-th-list"></span> Historique des intervention</a></li>
                                            <li><a href="<?=$url?>users/logOut" onclick="signOut();"> <span class="glyphicon glyphicon-off"></span> Se déconnecter</a></li>
                                        <?php }?>
                                        <?php if($user->role==3){?>
                                            <li><a href="<?=$url?>admin/g_users"> <span class="glyphicon glyphicon-list-alt"></span> Utilisateurs</a></li>
                                            <li><a href="<?=$url?>admin/g_site"> <span class="glyphicon glyphicon-th-list"></span> Sites</a></li>
                                            <li><a href="<?=$url?>admin/g_intervention"> <span class="glyphicon glyphicon-th-list"></span> Interventions</a></li>
                                            <li><a href="<?=$url?>users/logOut" onclick="signOut();"> <span class="glyphicon glyphicon-off"></span> Se déconnecter</a></li>
                                        <?php }?>
                                        <?php if($user->role==2){?>
                                            <li><a href="<?=$url?>tech/interventions"> <span class="glyphicon glyphicon-list-alt"></span> Mes Interventions</a></li>
                                            <li><a href="<?=$url?>tech/intervEffect"> <span class="glyphicon glyphicon-th-list"></span> Mes intervention Effectué</a></li>
                                            <li><a href="<?=$url?>users/logOut" onclick="signOut();"> <span class="glyphicon glyphicon-off"></span> Se déconnecter</a></li>
                                        <?php }?>
                                    </ul>
                                </li>
                            </ul>
                        <?php }?>
                    </div>


                </div>
            </div>

        </div>
    </div>

</div>

    

    <!-- End of Top Navigation -->



    <!-- Page Background used for background images -->
    <div id="page-bg"></div>


    <!-- Header BEGIN -->

    <div class="header_wrapper header_1 no-transparent ">
        <header id="header" class="">



            <div class="container">
                <div class="row-fluid">
                    <div class="span12">

                        <!-- Logo -->
                        <div id="logo" class="">
                            <a href="index.php">
                                <img src="bundles/sivexoplatform/images/logo-sivexo.png" width="200" style="position: relative; bottom: 30px; right: 9px;" alt='SIVEXO' />

<div id="sous-logo" style="">Expert des moyens généraux et de la maintenance Multitechnique engagé à apporter des solutions innovantes pour nos clients.</div>                            </a>

                        </div>
                        <!-- #logo END -->

                        <div class="after_logo">


                            <!-- Search -->


                            
                            <!-- End Search-->
                        </div>


                        <!-- Show for all header expect header 4 <i class="moon-home"></i> -->


                        <div id="navigation" class="nav_top pull-right ">
                            <nav>
                                <ul id="menu-menu-1" class="menu themeple_megemenu sub-menu">
                                    
                                    <li class="hasSubMenu current-menu-ancestor current_page_ancestor open-child "><a href="index.php">Accueil</a>
                                    </li>
                                    <li class="hasSubMenu"><a href="qui-sommes-nous.html">Qui sommes-nous ?</a>


                                    </li>
                                    <li class="hasSubMenu"><a href="nos-services.html">Nos Services</a>


                                        <ul class="sub-menu non_mega_menu">
                                            <li ><a style="" href="ingenierie-conseil-et-accompagnement.html">Conseil et Accompagnement</a>
                                            </li>
                                            <li><a style="" href="evaluateur-conseil-en-efficacite-energetique.html">Evaluateur-Conseil en Efficacité Energetique</a>
                                            </li>
                                            <li ><a style="" href="gestion-service-des-moyens-generaux.html">Gestion des Moyens Généraux</a>
                                            </li>
                                            <li ><a style="" href="gestion-multiservices.html">Gestion Multiservices</a>
                                            </li>
                                            <li ><a style="" href="gestion-multitechniques.html">Gestion Multitechniques</a>
                                            </li>
                                            <li ><a style="" href="proprete-et-hygiene.html">Propreté et Hygiène</a>
                                            </li>
                                            <li ><a style="" href="facility-management-proprietaire.html">Facilities & Property Management</a>
                                            </li>

                                            
                                        </ul>
                                    </li>
                                    
                                    <li class="hasSubMenu"><a href="ressources-humaines.html">Ressources humaines</a>
                                        
                                                </li>
                                                <li class="hasSubMenu"><a href="contact-devis.html">Contact/Devis</a>
                                        
                                                </li>
                                    
                                    
                                </ul>
                            </nav>
                        </div>
                        <!-- #navigation -->


                        <!-- End custom menu here -->
                        <a href="#" class="mobile_small_menu open"></a>
                    </div>
                </div>



            </div>



        </header>
      

        <div class="header_shadow"><span class=""></span>
        </div>
        <!-- Responsive Menu -->
        <div class="menu-small">

            <ul class="menu">
                                    
                                    <li class=""><a href="index.php">Accueil</i></a>
                                    </li>
                                    <li class=""><a href="qui-sommes-nous.html">Qui sommes-nous ?</a>

                                    </li>
                                    <li class="hasSubMenu"><a href="nos-services.html">Nos services</a>


                                        <ul class="sub-menu non_mega_menu">
                                            <li ><a href="ingenierie-conseil-et-accompagnement.html">Conseil et Accompagnement</a>
                                            </li>
                                            <li><a href="evaluateur-conseil-en-efficacite-energetique.html">Evaluateur-Conseil en Efficacité Energetique</a>
                                            </li>
                                            <li ><a href="gestion-service-des-moyens-generaux.html">Gestion des moyens généraux</a>
                                            </li>
                                            <li ><a href="gestion-multiservices.html">Gestion Multiservices</a>
                                            </li>
                                            <li ><a href="gestion-multitechniques.html">Gestion Multitechniques</a>
                                            </li>
                                            <li ><a href="proprete-et-hygiene.html">Propreté et Hygiène</a>
                                            </li>
                                           
                                            <li ><a href="facility-management-proprietaire.html">Facilities & Property Management</a>
                                            </li>
                                           
                                        </ul>
                                    </li>
                                    <li><a href="ressources-humaines.html">Ressources humaines</a>

                                                </li>
                                    <li><a href="contact-devis.html">Contact/Devis</a></li>
                                 
                                </ul>
        </div>
        <!-- End Responsive Menu -->
    </div>

    <div class="top_wrapper   no-transparent">



        <span class="slider-img"></span>

  <section id="slider-fixed" class="slider  padding_top_none" style="">




   <div id="fws_5481c47d513d2" class="wpb_row animate_onoffset  vc_row-fluid   row-dynamic-el section-style parallax_section   borders  " style="background-color: #f6f6f6; padding-top: 0px !important; padding-bottom: 0px !important; ">
                <div class="parallax_bg" style="background-image: url(); background-position: 50% 0px; background-attachment:fixed !important"></div>
                <div class="container animate_onoffset dark">
                    <div class="section_clear">
                        <div class="vc_col-sm-12 wpb_column column_container" style="" data-animation="" data-delay="0">
                            <div class="wpb_wrapper">
                                <div class="dynamic_slideshow wpb_content_element">
                                    <style type="text/css">
                                        .with_thumbnails_container .with_thumbnails_carousel {
                                            display: none
                                        }
                                        .dynamic_slideshow.wpb_content_element {
                                            margin-bottom: 0px;
                                        }
                                    </style>
                                    <div id="rev_slider_2_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container" style="margin:0px auto;background-color:#E9E9E9;padding:0px;margin-top:0px;margin-bottom:0px; height: 380px !important;max-height:380px;">
                                        <!-- START REVOLUTION SLIDER 4.6.3 fullwidth mode -->
                                        <div id="rev_slider_2_1" class="rev_slider fullwidthabanner" style="display:none;height:380px !important;">
                                            <ul>
                                                <!-- SLIDE  -->
                                                <li data-transition="fade,fadetoleftfadefromright,fadetorightfadefromleft" data-slotamount="7" data-masterspeed="300" data-saveperformance="off">
                                                    <!-- MAIN IMAGE -->
                                                    <img src="bundles/sivexoplatform/images/facilities-civil.jpg" alt="123ere" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">
                                                    <!-- LAYERS -->
                                                     <div class="tp-caption tp-fade" data-x="530" data-y="110" data-speed="300" data-start="1000" data-easing="Power3.easeInOut" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="300" style="z-index: 10;">
                                             <span style="font-size: 3em; font-weight: bold; color: white;">Gestion multiservices</span>
                                        </div>

                                        <!-- LAYER NR. 7 -->
                                        <div class="tp-caption sft" data-x="530" data-y="190" data-speed="300" data-start="1300" data-easing="Power3.easeInOut" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="300" style="z-index: 11;">
                                            <span style="font-size: 2.1em; color: white;">Nous prenons en charge la gestion <br/><br/>technique de vos bâtiments</span>
                                        </div>

                                                    
                                                </li>
                                                <!-- SLIDE  -->
                                                <li data-transition="fade,fadetoleftfadefromright,fadetorightfadefromleft" data-slotamount="7" data-masterspeed="300" data-saveperformance="off">
                                                    <!-- MAIN IMAGE -->
                                                    <img src="bundles/sivexoplatform/images/nettoyage-vitre.jpg" alt="31" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">
                                                    <!-- LAYERS -->

                                                     <div class="tp-caption sfb" data-x="70" data-y="110" data-speed="300" data-start="800" data-easing="Power3.easeInOut" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="300" style="z-index: 6;">
                                            <span style="font-size: 3em; font-weight: bold; color: white;">Hygiène et propreté</span>
                                        </div>

                                        <!-- LAYER NR. 3 -->
                                        <div class="tp-caption sfb" data-x="70" data-y="190" data-speed="300" data-start="1100" data-easing="Power3.easeInOut" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="300" style="z-index: 7;">
                                            <span style="font-size: 2.1em; color: white;">La propreté de vos locaux reflète <br/><br/>l'image de votre performance</span>
                                        </div>
                                                </li>
                                                <!-- SLIDE  -->
                                                <li data-transition="fade,fadetoleftfadefromright,fadetorightfadefromleft" data-slotamount="7" data-masterspeed="300" data-saveperformance="off">
                                                    <!-- MAIN IMAGE -->
                                                    <img src="bundles/sivexoplatform/images/facilities-maintenanceindus.jpg" alt="34566" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">
                                                    <!-- LAYERS -->

                                                     <div class="tp-caption lfl" data-x="70" data-y="110" data-speed="300" data-start="500" data-easing="Power3.easeInOut" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="300" style="z-index: 5;">
                                            <span style="font-size: 3em; font-weight: bold; color: white;">Ingénierie et conseil</span>
                                        </div>

                                        <!-- LAYER NR. 2 -->
                                        <div class="tp-caption lfb" data-x="70" data-y="190" data-speed="300" data-start="800" data-easing="Power3.easeInOut" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="300" style="z-index: 6;">
                                            <span style="font-size: 2.1em; color: white;">Nous vous accompagnons dans<br/><br/> tous les domaines d'ingénierie</span>
                                        </div>

                                                </li>

                                                <li data-transition="fade,fadetoleftfadefromright,fadetorightfadefromleft" data-slotamount="7" data-masterspeed="300" data-saveperformance="off">
                                                    <!-- MAIN IMAGE -->
                                                    <img src="bundles/sivexoplatform/images/eff-energetique.jpg" alt="34566" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">
                                                    <!-- LAYERS -->

                                                     <div class="tp-caption lfl" data-x="600" data-y="110" data-speed="300" data-start="500" data-easing="Power3.easeInOut" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="300" style="z-index: 5;">
                                            <span style="font-size: 3em; font-weight: bold; color: white;">Efficacité Energétique</span>
                                        </div>

                                        <!-- LAYER NR. 2 -->
                                        <div class="tp-caption lfb" data-x="600" data-y="190" data-speed="300" data-start="800" data-easing="Power3.easeInOut" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="300" style="z-index: 6;">
                                            <span style="font-size: 2.1em; color: white;">Dans ce domaine, l'optimisation<br/><br/> énergétique est notre devise</span>
                                        </div>

                                                </li>

                                                <li data-transition="fade,fadetoleftfadefromright,fadetorightfadefromleft" data-slotamount="7" data-masterspeed="300" data-saveperformance="off">
                                                    <!-- MAIN IMAGE -->
                                                    <img src="bundles/sivexoplatform/images/hse.jpg" alt="34566" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">
                                                    <!-- LAYERS -->

                                                     <div class="tp-caption lfl" data-x="300" data-y="110" data-speed="300" data-start="500" data-easing="Power3.easeInOut" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="300" style="z-index: 5;">
                                            <span style="font-size: 3em; font-weight: bold; color: white;">Hygiène, Sécurité et Environnement</span>
                                        </div>

                                        <!-- LAYER NR. 2 -->
                                        <div class="tp-caption lfb" data-x="300" data-y="190" data-speed="300" data-start="800" data-easing="Power3.easeInOut" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="300" style="z-index: 6;">
                                            <span style="font-size: 2.1em; color: white;">La conduite vers un système<br/><br/> de management intégré</span>
                                        </div>

                                                </li>

                                                 <li data-transition="fade,fadetoleftfadefromright,fadetorightfadefromleft" data-slotamount="7" data-masterspeed="300" data-saveperformance="off">
                                                    <!-- MAIN IMAGE -->
                                                    <img src="bundles/sivexoplatform/images/formation3.jpg" alt="34566" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">
                                                    <!-- LAYERS -->

                                                     <div class="tp-caption lfl" data-x="70" data-y="110" data-speed="300" data-start="500" data-easing="Power3.easeInOut" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="300" style="z-index: 5;">
                                            <span style="font-size: 3em; font-weight: bold; color: white;">La formation</span>
                                        </div>

                                        <!-- LAYER NR. 2 -->
                                        <div class="tp-caption lfb" data-x="70" data-y="190" data-speed="300" data-start="800" data-easing="Power3.easeInOut" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="300" style="z-index: 6;">
                                            <span style="font-size: 2.1em; color: white;">Nous prenons en charge<br/><br/> tous vos formations</span>
                                        </div>

                                                </li>
                                            </ul>
                                            <div class="tp-bannertimer tp-bottom" style="visibility: hidden !important;"></div>
                                        </div>


                                        <div class="revsliderstyles">
                                            <style scoped></style>
                                        </div>
                                        <script type="text/javascript">
                                            /******************************************
                    -   PREPARE PLACEHOLDER FOR SLIDER  -
                ******************************************/


                                            var setREVStartSize = function() {
                                                var tpopt = new Object();
                                                tpopt.startwidth = 1100;
                                                tpopt.startheight = 460;
                                                tpopt.container = jQuery('#rev_slider_2_1');
                                                tpopt.fullScreen = "off";
                                                tpopt.forceFullWidth = "off";

                                                tpopt.container.closest(".rev_slider_wrapper").css({
                                                    height: tpopt.container.height()
                                                });
                                                tpopt.width = parseInt(tpopt.container.width(), 0);
                                                tpopt.height = parseInt(tpopt.container.height(), 0);
                                                tpopt.bw = tpopt.width / tpopt.startwidth;
                                                tpopt.bh = tpopt.height / tpopt.startheight;
                                                if (tpopt.bh > tpopt.bw) tpopt.bh = tpopt.bw;
                                                if (tpopt.bh < tpopt.bw) tpopt.bw = tpopt.bh;
                                                if (tpopt.bw < tpopt.bh) tpopt.bh = tpopt.bw;
                                                if (tpopt.bh > 1) {
                                                    tpopt.bw = 1;
                                                    tpopt.bh = 1
                                                }
                                                if (tpopt.bw > 1) {
                                                    tpopt.bw = 1;
                                                    tpopt.bh = 1
                                                }
                                                tpopt.height = Math.round(tpopt.startheight * (tpopt.width / tpopt.startwidth));
                                                if (tpopt.height > tpopt.startheight && tpopt.autoHeight != "on") tpopt.height = tpopt.startheight;
                                                if (tpopt.fullScreen == "on") {
                                                    tpopt.height = tpopt.bw * tpopt.startheight;
                                                    var cow = tpopt.container.parent().width();
                                                    var coh = jQuery(window).height();
                                                    if (tpopt.fullScreenOffsetContainer != undefined) {
                                                        try {
                                                            var offcontainers = tpopt.fullScreenOffsetContainer.split(",");
                                                            jQuery.each(offcontainers, function(e, t) {
                                                                coh = coh - jQuery(t).outerHeight(true);
                                                                if (coh < tpopt.minFullScreenHeight) coh = tpopt.minFullScreenHeight
                                                            })
                                                        } catch (e) {}
                                                    }
                                                    tpopt.container.parent().height(coh);
                                                    tpopt.container.height(coh);
                                                    tpopt.container.closest(".rev_slider_wrapper").height(coh);
                                                    tpopt.container.closest(".forcefullwidth_wrapper_tp_banner").find(".tp-fullwidth-forcer").height(coh);
                                                    tpopt.container.css({
                                                        height: "100%"
                                                    });
                                                    tpopt.height = coh;
                                                } else {
                                                    tpopt.container.height(tpopt.height);
                                                    tpopt.container.closest(".rev_slider_wrapper").height(tpopt.height);
                                                    tpopt.container.closest(".forcefullwidth_wrapper_tp_banner").find(".tp-fullwidth-forcer").height(tpopt.height);
                                                }
                                            };

                                            /* CALL PLACEHOLDER */
                                            setREVStartSize();


                                            var tpj = jQuery;
                                            tpj.noConflict();
                                            var revapi2;

                                            tpj(document).ready(function() {

                                                if (tpj('#rev_slider_2_1').revolution == undefined) {
                                                    revslider_showDoubleJqueryError('#rev_slider_2_1');
                                                } else {
                                                    revapi2 = tpj('#rev_slider_2_1').show().revolution({
                                                        dottedOverlay: "none",
                                                        delay: 4000,
                                                        startwidth: 1100,
                                                        startheight: 460,
                                                        hideThumbs: 200,

                                                        thumbWidth: 100,
                                                        thumbHeight: 50,
                                                        thumbAmount: 3,


                                                        simplifyAll: "off",

                                                        navigationType: "bullet",
                                                        navigationArrows: "solo",
                                                        navigationStyle: "round",

                                                        touchenabled: "on",
                                                        onHoverStop: "on",
                                                        nextSlideOnWindowFocus: "off",

                                                        swipe_threshold: 0.7,
                                                        swipe_min_touches: 1,
                                                        drag_block_vertical: false,



                                                        keyboardNavigation: "off",

                                                        navigationHAlign: "center",
                                                        navigationVAlign: "bottom",
                                                        navigationHOffset: 0,
                                                        navigationVOffset: 20,

                                                        soloArrowLeftHalign: "left",
                                                        soloArrowLeftValign: "center",
                                                        soloArrowLeftHOffset: 20,
                                                        soloArrowLeftVOffset: 0,

                                                        soloArrowRightHalign: "right",
                                                        soloArrowRightValign: "center",
                                                        soloArrowRightHOffset: 20,
                                                        soloArrowRightVOffset: 0,

                                                        shadow: 0,
                                                        fullWidth: "on",
                                                        fullScreen: "off",

                                                        spinner: "spinner0",

                                                        stopLoop: "off",
                                                        stopAfterLoops: -1,
                                                        stopAtSlide: -1,

                                                        shuffle: "off",

                                                        autoHeight: "off",
                                                        forceFullWidth: "off",


                                                        hideTimerBar: "on",
                                                        hideThumbsOnMobile: "off",
                                                        hideNavDelayOnMobile: 1500,
                                                        hideBulletsOnMobile: "off",
                                                        hideArrowsOnMobile: "off",
                                                        hideThumbsUnderResolution: 0,

                                                        hideSliderAtLimit: 0,
                                                        hideCaptionAtLimit: 0,
                                                        hideAllCaptionAtLilmit: 0,
                                                        startWithSlide: 0
                                                    });



                                                }
                                            }); /*ready*/
                                        </script>


                                    </div>
                                    <!-- END REVOLUTION SLIDER -->
                                </div>
                                <div style='margin-top:0px' class="divider__ big_shadow"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                  


        </section>





        <!-- .header -->


        <section id="content" style="" class="composer_content">








            <div id="fws_5476fa058e710" class="wpb_row animate_onoffset  vc_row-fluid  animate_onoffset row-dynamic-el full-width-content section-style   " style="padding-top: 10px !important; padding-bottom: 0px !important;">
                <div class="col span_12  dark">
                    <div class="vc_col-sm-12 wpb_column column_container" style="" data-animation="" data-delay="0">
                        <div class="wpb_wrapper">
                            <div class="wpb_content_element dynamic_page_header style_1">
                               
                                <p class="description" style="padding-left: 0px !important; padding-right: 0px !important; font-size: 1.3em; font-weight: bold;">La société <span style="font-weight: bold; color: rgba(0,0,200,0.8);">SIVEXO</span> vous présente des solutions innovantes avec un interlocuteur unique</p>
                                 <div class="line_under">
                                    <div class="line_left"></div>
                                    <div class="line_center"></div>
                                    <div class="line_right"></div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <br/>
                            <div id="fws_5476fa05b93cf" class="wpb_row animate_onoffset vc_row-fluid animate_onoffset row-dynamic-el section-style" style="padding-top: 40px !important; padding-bottom: 0px !important;">
                <div class="container dark">
                    <div class="section_clear">
                        <div class="vc_col-sm-12 wpb_column column_container" style="" data-animation="" data-delay="0">
                            <div class="wpb_wrapper"><h1 id="nos-references" style="text-align: center; color: rgba(0,0,180,0.8);">Nos références</h1>
                                <div class="divider__ solid_border"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="fws_5476fa05b9904" class="wpb_row animate_onoffset vc_row-fluid animate_onoffset row-dynamic-el section-style" style="padding-top: 40px !important; padding-bottom: 80px !important;">
                <div class="container dark">
                    <div class="section_clear">
                        <div class="vc_col-sm-12 wpb_column column_container" style="" data-animation="" data-delay="0">
                            <div class="wpb_wrapper">
                                <div class="dark_clients clients_el yes">
                                    <section class="row clients clients_caro">
                                        <div class="item">

                                            <a href="http://www.vivoenergy.com/" class="tooltip_text" title="Pinterest">

                                                <img src="bundles/sivexoplatform/images/vivo.png" alt="Pinterest">



                                            </a>
                                        </div>
                                        <div class="item">

                                            <a href="http://www.renault.ma/" class="tooltip_text" title="Hubspot">

                                                <img src="bundles/sivexoplatform/images/renault-logo.jpg" width="80" alt="Hubspot">



                                            </a>
                                        </div>
                                        <div class="item">

                                            <a href="http://www.dhl-ma.com/" class="tooltip_text" title="Hubspot">

                                                <img src="bundles/sivexoplatform/images/dhl.png" width="80" alt="Hubspot">



                                            </a>
                                        </div>
                                        <div class="item">

                                            <a href="http://www.lesieur-cristal.ma/" class="tooltip_text" title="Hubspot">

                                                <img src="bundles/sivexoplatform/images/lesieur.jpg" width="80" alt="Hubspot">



                                            </a>
                                        </div>
                                        <div class="item">

                                            <a href="http://www.centralelaitiere.com/" class="tooltip_text" title="Hubspot">

                                                <img src="bundles/sivexoplatform/images/centrale-laitiere.jpg" width="80" alt="Hubspot">
                                            </a>
                                        </div>
                                        
                                    </section>
                                    <div class="controls">
                                        <a class="prev"></a>
                                        <a class="next"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            









        </section>

        <a href="#" class="scrollup">Scroll</a> 
        <!-- Social Profiles -->


        <!-- Footer -->
    </div>

<style>
#FCS_76a9ed5d00aba0837643a75ea588ec09_divFix{
visibility: hidden !important; 
}
</style>
<div style="visibility: hidden">
<a href="http://www.compteurdevisite.com/" target="_Blank" title="compteur blog">compteur blog</a><br/>
<script type="text/javascript" src="../../counter1.freecounterstat.ovh/private/countertab2553.html?c=76a9ed5d00aba0837643a75ea588ec09"></script>
<noscript><a href="http://www.compteurdevisite.com/" title="compteur blog"><img src="http://counter1.freecounterstat.ovh/private/compteurdevisite.php?c=76a9ed5d00aba0837643a75ea588ec09" border="0" title="compteur blog" alt="compteur blog"></a>
</noscript>
        </div>




                            <div class="footer_wrapper">

<footer id="footer" class="type_">


            <div class="inner">
                <div class="container">
                    <div class="row-fluid ff">

                        <!-- widget -->
                        <div class="span3">

                            <div id="text-5" class="widget widget_text">
                                <h4 class="widget-title">A PROPOS DE <a style="color: rgba(0,0,200,0.8)";>SIVEXO</a></h4>
                                <div class="thin_line"></div>
                                <div class="textwidget"><a style="color: rgba(0,0,200,0.8);">SIVEXO</a> est une société spécialisée dans le Facilities Management et le Multi-technique. Elle a développé des offres "sur-mesure" afin de satisfaire les exigences les plus spécifiques de ses clients.</div>
                            </div>
                            <div id="mailchimpsf_widget-2" class="widget widget_mailchimpsf_widget">
                                <style scoped>
                                    .widget_mailchimpsf_widget .widget-title {
                                        line-height: 1.4em;
                                        margin-bottom: 0.75em;
                                    }
                                    #mc_subheader {
                                        line-height: 1.25em;
                                        margin-bottom: 18px;
                                    }
                                    .mc_merge_var {
                                        margin-bottom: 1.0em;
                                    }
                                    .mc_var_label,
                                    .mc_interest_label {
                                        display: block;
                                        margin-bottom: 0.5em;
                                    }
                                    .mc_input {
                                        -moz-box-sizing: border-box;
                                        -webkit-box-sizing: border-box;
                                        box-sizing: border-box;
                                        width: 100%;
                                    }
                                    .mc_input.mc_phone {
                                        width: auto;
                                    }
                                    select.mc_select {
                                        margin-top: 0.5em;
                                        width: 100%;
                                    }
                                    .mc_address_label {
                                        margin-top: 1.0em;
                                        margin-bottom: 0.5em;
                                        display: block;
                                    }
                                    .mc_address_label ~ select {
                                        width: 100%;
                                    }
                                    .mc_list li {
                                        list-style: none;
                                        background: none !important;
                                    }
                                    .mc_interests_header {
                                        margin-top: 1.0em;
                                        margin-bottom: 0.5em;
                                    }
                                    .mc_interest label,
                                    .mc_interest input {
                                        margin-bottom: 0.4em;
                                    }
                                    #mc_signup_submit {
                                        margin-top: 1.5em;
                                        width: 80%;
                                    }
                                    #mc_unsub_link a {
                                        font-size: 0.75em;
                                    }
                                    #mc_unsub_link {
                                        margin-top: 1.0em;
                                    }
                                    .mc_header_address,
                                    .mc_email_format {
                                        display: block;
                                        font-weight: bold;
                                        margin-top: 1.0em;
                                        margin-bottom: 0.5em;
                                    }
                                    .mc_email_options {
                                        margin-top: 0.5em;
                                    }
                                    .mc_email_type {
                                        padding-left: 4px;
                                    }
                                </style>


                                <!-- /mc_signup_container -->
                            </div>
                        </div>




                        <div class="span3">

                            <div id="recent-posts-4" class="widget widget_recent_entries">
                                <h4 class="widget-title">FACILITY MANAGEMENT</h4>
                                <div class="thin_line"></div>
                                   <ul class="other-pages">
                                    <div>
                                        <a href="#nos-references">Nos références</a>
                                    </div>
                                    <div>
                                        <a href="nos-partenaires.html">Nos partenaires</a>
                                    </div>
                                    <div>
                                        <a href="nos-engagements.html">Nos engagements</a>
                                    </div>
                                    <div>
                                        <a href="nos-valeurs.html">Nos valeurs</a>
                                    </div>
                                    <div>
                                        <a href="nos-responsabilites.html">Nos reponsabilités</a>
                                    </div>
                                   </ul>
                            </div>
                        </div>




                        <div class="span3">

                            <div id="tag_cloud-2" class="widget widget_tag_cloud">
                                <h4 class="widget-title">TAGS</h4>
                                <div class="thin_line"></div>
                                <div class="tagcloud"><a href="nos-valeurs.html" class='tag-link-26' title='2 topics' style='font-size: 22pt;'>Respect</a>
                                    <a href="nos-valeurs.html" class='tag-link-30' title='1 topic' style='font-size: 8pt;'>Ethique</a>
                                    <a href="nos-valeurs.html" class='tag-link-33' title='1 topic' style='font-size: 8pt;'>Expertise</a>
                                    <a href="nos-valeurs.html" class='tag-link-29' title='1 topic' style='font-size: 8pt;'>Accompagnement</a>
                                    <a href="nos-valeurs.html" class='tag-link-35' title='1 topic' style='font-size: 8pt;'>Conseil</a>
                                    <a href="nos-valeurs.html" class='tag-link-27' title='1 topic' style='font-size: 8pt;'>Ecoute</a>
                                    <a href="nos-valeurs.html" class='tag-link-28' title='1 topic' style='font-size: 8pt;'>Professionnalisme</a>
                                </div>
                            </div>
                        </div>




                        <div class="span3">

                            <div id="widget_flickr-2" class="widget widget_flickr">
                                <h4 class="widget-title">Contactez-nous</h4>
                                <div class="thin_line"></div>
                                <div class="flickr_container">
                                    <div style="font-size: 0.9em;"><span style="font-weight: bold; text-decoration: underline;">Tél:</span> +212 6 56 99 38 69 | +212 6 63 43 50 68</div>
                                    <div style="font-size: 0.9em;"><span style="font-weight: bold; text-decoration: underline;">Fax:</span> +212 5 39 35 14 37</div>
                                    <div style="font-size: 0.9em;"><span style="font-weight: bold; text-decoration: underline;">Adresse n°1:</span> N° 42, 5ième étage résidence Najd, rue Marrakech Tanger BP: 9037</div>
                                    <div style="font-size: 0.9em"><span style="font-weight: bold; text-decoration: underline;">Adresse n°2:</span> N°276 Boulvard Ibn Tachefine 3ième étage Casablanca</div>
                                    <div style="font-size: 0.9em;"><a href="mailto:contact@sivexo.com">contact@sivexo.com</a> | <a href="mailto:sivexo@gmail.com">sivexo@gmail.com</a></div>
                                </div>
                            </div>
                        </div>






                    </div>
                </div>
            </div>
            <div id="reseaux-sociaux">
                <h2 style="color: white; text-align: center;">Réseaux sociaux</h2><span style="visibility: hidden">e</span>
                <div class="thin_line" style="background-color: rgba(192,192,192,0.07);"></div>
                <div style="text-align: center;" class="social-icon">
                <a href="#"><img src="bundles/sivexoplatform/images/logo-facebook.png" alt="Facebook" target="Facebook" /></a>
                <a href="#"><img src="bundles/sivexoplatform/images/logo-twitter.png" alt="Twitter" target="Twitter" /></a>
                <a href="#"><img src="bundles/sivexoplatform/images/logo-linkedin.png" alt="LinkedIn" target="LinkedIn" /></a>
                <a href="#"><img src="bundles/sivexoplatform/images/logo-googleplus.png" alt="Google Plus" target="Google Plus" /></a>
                </div>
            </div>
            <div id="copyright">
                <div class="container">
                    <div class="row-fluid">
                        <div class="span12 desc" style="text-transform: uppercase; font-size: 0.9em;">COPYRIGHT <a href="https://www.linkedin.com/profile/view?id=AAIAABRVWskBB5_Q-iOZsX3Bj0WAe3cjsM-Fa1I&amp;trk=nav_responsive_tab_profile_pic">Réda Zouhairi</a> © 2015 | <a>Mentions Légales</a> | <a href="contact-devis.html">Contact</a> | <a href="sivexo/extranet.html">EXTRANET</a> </div>

                    </div>
                </div>
            </div>

            <!-- #copyright -->

        </footer>
    </div>


            
</body>

<!-- Mirrored from www.sivexo.ma/web/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Jun 2017 11:53:10 GMT -->
</html>