@if(Active::checkUriPattern('/'))
<header id="header" class="header default">
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 xs-mb-10">
                    <div class="topbar-call text-center text-md-left">
                        <ul>
                            <li><i class="fa fa-envelope-o theme-color"></i> tnbbussiness@gmail.com</li>
                            <li><i class="fa fa-phone"></i> <a href="tel:+7069229475"> <span>+(706) 922-9475 </span> </a> </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="topbar-social text-center text-md-right">
                        <div class="menu-bar">
                            <ul class="menu-links">
                                @auth
                                <li><a href="#"><span>{{ ucfirst($logged_in_user->name) }} </span></a></li>
                                <li><a href="#"><span>Code:{{$logged_in_user->referral_code}} </span></a></li>
                                <li><a href="#"><span>Credit:{{$user_credit['credit']}} </span></a></li>
                                @else
                                <li><a href="{{route('frontend.auth.login')}}" ><span>{{ __('navs.frontend.login') }}</span></a></li>

                                @if (config('access.registration'))
                                <li><a href="{{route('frontend.auth.register')}}" ><span>{{ __('navs.frontend.register') }}</span></a></li>
                                @endif
                                @endauth
                                <li><a href="#"><span class="ti-facebook"></span></a></li>
                                <li><a href="#"><span class="ti-instagram"></span></a></li>
                                <li><a href="#"><span class="ti-google"></span></a></li>
                    <!--            <li><a href="#"><span class="ti-twitter"></span></a></li>
                                <li><a href="#"><span class="ti-linkedin"></span></a></li>-->
                                <!--<li><a href="#"><span class="ti-dribbble"></span></a></li>-->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="menu">  
            <!-- menu start -->
            <nav id="menu" class="mega-menu">
                <!-- menu list items container -->
                <section class="menu-list-items">
                    <div class="container"> 
                        <div class="row"> 
                            <div class="col-lg-12 col-md-12"> 
                                <!-- menu logo -->
                                <ul class="menu-logo">
                                    <li>
                                        <a href="{{ route('frontend.index') }}"><img id="logo_img" src="/img/frontend/logo.png" alt="logo" style="height: 60px"></a>
                                    </li>
                                </ul>
                                <!-- menu links -->
                                <div class="menu-bar">
                                    <ul class="menu-links">
                                        <li><a href="{{ route('frontend.index') }}">Home </a></li>
                                        <li><a href="#">About Us</a></li>
                                        @auth
                                        <li><a href="{{ route('frontend.user.dashboard') }}"> Dashboard </a></li>
                                        @endauth
                                        <li><a href="{{ route('frontend.opportunities') }}"> Opportunities </a></li>
                                        <li><a href="{{ route('frontend.grievance') }}"> Grievance </a></li>
                            <!--            <li><a href="javascript:void(0)">Contact Us <i class="fa fa-angle-down fa-indicator"></i></a>
                                             drop down multilevel  
                                            <ul class="drop-down-multilevel">
                                                <li><a href="{{route('frontend.contact')}}">Contact Us</a></li>
                                                <li><a href="{{ route('frontend.grievance') }}">Grievance</a></li>                
                                            </ul>
                                        </li>-->
                                        @auth
                                        <li><a href="javascript:void(0)">Account
                                                <i class="fa fa-angle-down fa-indicator"></i>
                                            </a>
                                            <!-- drop down multilevel  -->
                                            <ul class="drop-down-multilevel">
                                                @can('view backend')
                                                <li><a href="{{ route('admin.dashboard') }}">{{ __('navs.frontend.user.administration') }}</a></li>
                                                @endcan
                                                <li><a href="{{route('frontend.user.account')}}">My Account</a></li>
                                                <li><a href="{{ route('frontend.auth.logout') }}">Log Out</a></li>                
                                            </ul>
                                        </li>
                                        @endauth
                                    </ul>
                                    <!--        <div class="search-cart">
                                              <div class="search">
                                                <a class="search-btn not_click" href="javascript:void(0);"></a>
                                                  <div class="search-box not-click">
                                                     <form action="search.html" method="get">
                                                      <input type="text"  class="not-click form-control" name="search" placeholder="Search.." value="" >
                                                      <button class="search-button" type="submit"> <i class="fa fa-search not-click"></i></button>
                                                    </form>
                                               </div>
                                              </div>
                                            </div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </nav>
            <!-- menu end -->
        </div>
</header>
@else

<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4" style="padding-bottom: 0">
    <a href="{{ route('frontend.index') }}" class="navbar-brand"><div></div></a>

    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('labels.general.toggle_navigation') }}">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-start" >
        <ul class="navbar-nav nav-tabs" style="border-bottom: 0">
            @auth
            <li class="nav-item" ><a href="{{route('frontend.user.dashboard')}}" class="nav-link {{ active_class(Active ::checkRoute('frontend.user.dashboard')) }}">{{ __('navs.frontend.dashboard') }}</a></li>
            @endauth
            <!--<li class="nav-item" ><a href="{{route('frontend.contact')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.contact')) }}">{{ __('navs.frontend.contact') }}</a></li>-->
            <li class="nav-item" ><a href="{{route('frontend.grievance')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.grievance')) }}">{{ __('navs.frontend.grievance') }}</a></li>
            <li class="nav-item" ><a href="{{route('frontend.opportunities')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.opportunities')) }}">{{ __('navs.frontend.opportunities') }}</a></li>
        </ul>
    </div>
    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
        <ul class="navbar-nav">
<!--                        @if (config('locale.status') && count(config('locale.languages')) > 1)
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownLanguageLink" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">{{ __('menus.language-picker.language') }} ({{ strtoupper(app()->getLocale()) }})</a>
            
                                @include('includes.partials.lang')
                            </li>
                        @endif-->



            @guest
            <li class="nav-item"><a href="{{route('frontend.auth.login')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.auth.login')) }}">{{ __('navs.frontend.login') }}</a></li>

            @if (config('access.registration'))
            <li class="nav-item"><a href="{{route('frontend.auth.register')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.auth.register')) }}">{{ __('navs.frontend.register') }}</a></li>
            @endif
            @else
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuUser" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false" style="padding-bottom: 0;margin-bottom: 0">
                    <label title="Profile Code" style="font-weight: bold;font-size: 14px">{{ ucfirst($logged_in_user->name) }}</label>
                    <label title="Profile Code" style="font-weight: bold;font-size: 12px">Code:{{$logged_in_user->referral_code}}</label>
                    <label title="Available Credit" class="label-success" style="font-weight: bold;font-size: 12px">Credit:{{$user_credit['credit']}}</label>
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuUser">
                    @can('view backend')
                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item">{{ __('navs.frontend.user.administration') }}</a>
                    @endcan

                    <a href="{{ route('frontend.user.account') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.user.account')) }}">{{ __('navs.frontend.user.account') }}</a>
                    <a href="{{ route('frontend.auth.logout') }}" class="dropdown-item">{{ __('navs.general.logout') }}</a>
                </div>
            </li>
            @endguest
        </ul>
    </div>
    <button class="navbar-toggler aside-menu-toggler" type="button">☰</button>
</nav>
@endif
