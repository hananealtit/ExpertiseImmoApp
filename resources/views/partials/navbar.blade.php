<nav class="navbar  navbar-toggleable-md navbar-light bg-faded navbar-inverse bg-primary">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#nav-content" aria-controls="nav-content" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="container">
    <!-- Brand -->
    <a class="navbar-brand" href="#"><img src="" alt="" width="50" height="auto"></a>

    <!-- Links -->
    <div class="collapse navbar-collapse" id="nav-content">
        <ul class="navbar-nav">
            <li class="nav-item" style="margin-right: 50px;">
            </li>
            <li class="nav-item">
                <a class="nav-link {{Request::is('/')?'active':''}}" href="{{url('/')}}"><i class="fa fa-home fa-lg" style="color: white" aria-hidden="true"></i> الصفحة الرئيسية </a>
            </li>
        </ul>

    </div>
    <div class="collapse navbar-collapse justify-content-end" id="nav-content">
        @if (Auth::guest())
            <div class="navbar-nav">
            <a class="nav-item nav-link  {{Request::is('login')?'active':''}}" href="{{ route('login') }}"> <i style="color:white"  class="fa fa-sign-in fa-lg" aria-hidden="true"></i> الدخول  </a>
            <a class="nav-item nav-link {{Request::is('register')?'active':''}}" href="{{ route('register') }}" ><i style="color:white" class="fa fa-user-plus" aria-hidden="true"></i> إنشاء حساب </a>
            </div>
        @else
            <div class="nav-item dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownmenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   <i class="fa fa-user-o" aria-hidden="true"></i> {{ Auth::user()->name }} <span class="caret"></span>
                </button>
                <div class="dropdown-menu" aria-labelledby="Preview">
                    <a class="dropdown-item" href=""></a>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        الخروج <i class="fa fa-sign-out" aria-hidden="true"></i>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>

                </div>
            </div>
        @endif
    </div>

    </div>
</nav>

@if(auth()->guard('web')->check())
<nav id='cssmenu'>
    <div id="head-mobile"></div>
    <div class="button"></div>
    <ul>
        <li class='active'><a href=''>GUI4</a></li>
        <li><a href='#'>ادارة الملفات</a>
            <ul>
                <li><a href='#'>قائمة الملفات</a>
                    <ul>
                        <li><a href='{{route('dossier.deposerDossier')}}'>الملفات الموضوعة</a></li>
                        <li><a href='{{route('dossier.getDossier')}}'>الملفات الغير الموضوعة</a></li>
                    </ul>
                </li>
                <li><a href='{{route('convocation.index')}}'>ملف جديد</a>

                </li>
            </ul>
        </li>
        <li><a href='#'>إدارة العقارات</a>
            <ul>
                <li><a href='{{route('immobiliers.gImmobilier')}}'>نسب التملك</a>
                </li>
                <li><a href='{{route('dossier.decision')}}'>ماهية الحكم</a>

                </li>
                <li><a href='{{route('immobiliers.g_image')}}'>إدارة الصور</a>

                </li>
            </ul>
        </li>
        <li><a href='{{route('dossier.statistic')}}'>الإحصائيات</a></li>
        <li><a href='{{route('personnel.index')}}'>إدارة العاملين</a></li>
        <li><a href='{{route('personnel.index')}}'>إدارة الاطراف</a>
        <ul>
            <li><a href='{{route('procureur.index')}}'>الاطراف المدعية</a>
            </li>
            <li><a href='{{route('defendeur.index')}}'>الاطراف المدعى عليها</a>

            </li>
            <li><a href='{{route('autre.index')}}'>الأطراف الأخرى</a>

            </li>
        </ul>
        </li>
        <li><a href='{{route('avocat.index')}}'>إدارة المحامين</a></li>
        <li><a href='{{route('dossier.cms')}}' class="nav-item nav-link">إدارة محتوى التقرير</a></li>
    </ul>
</nav>
@endif
