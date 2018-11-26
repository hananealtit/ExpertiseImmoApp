<head>
    <title>@yield('title','Expertise immobilière')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 4 alpha CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    {{ Html::style('css/style.css') }}
    <style>
        nav{
            margin-bottom:3rem;
        }
        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;

            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }




        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
            color: white;
            cursor: pointer;
        }
        #main {
            transition: margin-left .5s;
            padding: 16px;
        }

        @media screen and (max-height: 450px) {
            .sidenav {padding-top: 15px;}
            .sidenav a {font-size: 18px;}
        }


        /*webcoderskull */
        *{margin:0;padding:0;text-decoration:none}


        nav{position:relative;margin:0 auto;}
        #cssmenu,#cssmenu ul,#cssmenu ul li,#cssmenu ul li a,#cssmenu #head-mobile{border:0;list-style:none;line-height:1;display:block;position:relative;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}
        #cssmenu:after,#cssmenu > ul:after{content:"";display:block;clear:both;visibility:hidden;line-height:0;height:0}
        #cssmenu #head-mobile{display:none}
        #cssmenu{font-family:sans-serif;background:#f7f7f7}
        #cssmenu > ul > li{float:left}
        #cssmenu > ul > li > a{padding:17px;font-size:16px;letter-spacing:1px;text-decoration:none;color:#000;font-weight:700;}
        #cssmenu > ul > li:hover > a,#cssmenu ul li.active a{color:#fff}
        #cssmenu > ul > li:hover,#cssmenu ul li.active:hover,#cssmenu ul li.active,#cssmenu ul li.has-sub.active:hover{background:#327ea3!important;-webkit-transition:background .3s ease;-ms-transition:background .3s ease;transition:background .3s ease;}
        #cssmenu > ul > li.has-sub > a{padding-right:30px}
        #cssmenu > ul > li.has-sub > a:after{position:absolute;top:22px;right:11px;width:8px;height:2px;display:block;background:#ddd;content:''}
        #cssmenu > ul > li.has-sub > a:before{position:absolute;top:19px;right:14px;display:block;width:2px;height:8px;background:#ddd;content:'';-webkit-transition:all .25s ease;-ms-transition:all .25s ease;transition:all .25s ease}
        #cssmenu > ul > li.has-sub:hover > a:before{top:23px;height:0}
        #cssmenu ul ul{position:absolute;left:-9999px}
        #cssmenu ul ul li{height:0;-webkit-transition:all .25s ease;-ms-transition:all .25s ease;background:#f7f7f7;transition:all .25s ease}
        #cssmenu ul ul li:hover{background:#327ea3!important;}
        #cssmenu li:hover > ul{left:auto}
        #cssmenu li:hover > ul > li{height:35px}
        #cssmenu ul ul ul{margin-left:100%;top:0}
        #cssmenu ul ul li a{border-bottom:1px solid rgba(150,150,150,0.15);padding:11px 15px;width:170px;font-size:16px;text-decoration:none;color:#000;font-weight:400;}
        #cssmenu ul ul li:last-child > a,#cssmenu ul ul li.last-item > a{border-bottom:0}
        #cssmenu ul ul li:hover > a,#cssmenu ul ul li a:hover{color:#fff}
        #cssmenu ul ul li.has-sub > a:after{position:absolute;top:16px;right:11px;width:8px;height:2px;display:block;background:#ddd;content:''}
        #cssmenu ul ul li.has-sub > a:before{position:absolute;top:13px;right:14px;display:block;width:2px;height:8px;background:#ddd;content:'';-webkit-transition:all .25s ease;-ms-transition:all .25s ease;transition:all .25s ease}
        #cssmenu ul ul > li.has-sub:hover > a:before{top:17px;height:0}
        #cssmenu ul ul li.has-sub:hover,#cssmenu ul li.has-sub ul li.has-sub ul li:hover{background:#327ea3!important;}
        #cssmenu ul ul ul li.active a{border-left:1px solid #333}
        #cssmenu > ul > li.has-sub > ul > li.active > a,#cssmenu > ul ul > li.has-sub > ul > li.active> a{border-top:1px solid #333}

        @media screen and (max-width:1000px){

            nav{width:100%;}
            #cssmenu{width:100%}
            #cssmenu ul{width:100%;display:none}
            #cssmenu ul li{width:100%;border-top:1px solid #444}
            #cssmenu ul li:hover{background:#363636;}
            #cssmenu ul ul li,#cssmenu li:hover > ul > li{height:auto}
            #cssmenu ul li a,#cssmenu ul ul li a{width:100%;border-bottom:0}
            #cssmenu > ul > li{float:none}
            #cssmenu ul ul li a{padding-left:25px}
            #cssmenu ul ul li{background:#333!important;}
            #cssmenu ul ul li:hover{background:#363636!important}
            #cssmenu ul ul ul li a{padding-left:35px}
            #cssmenu ul ul li a{color:#ddd;background:none}
            #cssmenu ul ul li:hover > a,#cssmenu ul ul li.active > a{color:#fff}
            #cssmenu ul ul,#cssmenu ul ul ul{position:relative;left:0;width:100%;margin:0;text-align:left}
            #cssmenu > ul > li.has-sub > a:after,#cssmenu > ul > li.has-sub > a:before,#cssmenu ul ul > li.has-sub > a:after,#cssmenu ul ul > li.has-sub > a:before{display:none}
            #cssmenu #head-mobile{display:block;padding:23px;color:#ddd;font-size:12px;font-weight:700}
            .button{width:55px;height:46px;position:absolute;right:0;top:0;cursor:pointer;z-index: 12399994;}
            .button:after{position:absolute;top:22px;right:20px;display:block;height:4px;width:20px;border-top:2px solid #dddddd;border-bottom:2px solid #dddddd;content:''}
            .button:before{-webkit-transition:all .3s ease;-ms-transition:all .3s ease;transition:all .3s ease;position:absolute;top:16px;right:20px;display:block;height:2px;width:20px;background:#ddd;content:''}
            .button.menu-opened:after{-webkit-transition:all .3s ease;-ms-transition:all .3s ease;transition:all .3s ease;top:23px;border:0;height:2px;width:19px;background:#fff;-webkit-transform:rotate(45deg);-moz-transform:rotate(45deg);-ms-transform:rotate(45deg);-o-transform:rotate(45deg);transform:rotate(45deg)}
            .button.menu-opened:before{top:23px;background:#fff;width:19px;-webkit-transform:rotate(-45deg);-moz-transform:rotate(-45deg);-ms-transform:rotate(-45deg);-o-transform:rotate(-45deg);transform:rotate(-45deg)}
            #cssmenu .submenu-button{position:absolute;z-index:99;right:0;top:0;display:block;border-left:1px solid #444;height:46px;width:46px;cursor:pointer}
            #cssmenu .submenu-button.submenu-opened{background:#262626}
            #cssmenu ul ul .submenu-button{height:34px;width:34px}
            #cssmenu .submenu-button:after{position:absolute;top:22px;right:19px;width:8px;height:2px;display:block;background:#ddd;content:''}
            #cssmenu ul ul .submenu-button:after{top:15px;right:13px}
            #cssmenu .submenu-button.submenu-opened:after{background:#fff}
            #cssmenu .submenu-button:before{position:absolute;top:19px;right:22px;display:block;width:2px;height:8px;background:#ddd;content:''}
            #cssmenu ul ul .submenu-button:before{top:12px;right:16px}
            #cssmenu .submenu-button.submenu-opened:before{display:none}
            #cssmenu ul ul ul li.active a{border-left:none}
            #cssmenu > ul > li.has-sub > ul > li.active > a,#cssmenu > ul ul > li.has-sub > ul > li.active > a{border-top:none}
        }













    </style>
</head>