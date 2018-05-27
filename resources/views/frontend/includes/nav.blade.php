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
              <li class="nav-item" ><a href="{{route('frontend.contact')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.contact')) }}">{{ __('navs.frontend.contact') }}</a></li>
              <li class="nav-item" ><a href="{{route('frontend.grievance')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.grievance')) }}">{{ __('navs.frontend.grievance') }}</a></li>
        </ul>
    </div>
    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
        <ul class="navbar-nav">
            @if (config('locale.status') && count(config('locale.languages')) > 1)
<!--                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownLanguageLink" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">{{ __('menus.language-picker.language') }} ({{ strtoupper(app()->getLocale()) }})</a>

                    @include('includes.partials.lang')
                </li>-->
            @endif

           

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
                        <label title="Available Credit" class="label-success" style="font-weight: bold;font-size: 12px">Credit:{{$user_credit}}</label>
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
