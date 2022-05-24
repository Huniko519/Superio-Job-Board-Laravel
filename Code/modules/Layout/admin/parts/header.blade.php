<?php
$user = Auth::user();
$checkNotify = \Modules\Core\Models\NotificationPush::query();
if (is_admin()) {
    $checkNotify->where(function ($query) {
        $query->where('data', 'LIKE', '%"for_admin":1%');
        $query->orWhere('notifiable_id', Auth::id());
    });
} else {
    $checkNotify->where('data', 'LIKE', '%"for_admin":0%');
    $checkNotify->where('notifiable_id', Auth::id());
}

$notifications = $checkNotify->orderBy('created_at', 'desc')->limit(5)->get();
$countUnread = $checkNotify->where('read_at', null)->count();

$languages = \Modules\Language\Models\Language::getActive();
$locale = App::getLocale();
?>

<div class="header-logo flex-shrink-0">
    <h3 class="logo-text"><a href="{{url('/admin')}}">{{__('Superio')}} <span class="app-version">{{config('app.version')}}</span></a></h3>
</div>
<div class="header-widgets d-flex flex-grow-1">
    <div class="widgets-left d-flex flex-grow-1 align-items-center">
        <div class="header-widget">
            <span class="btn-toggle-admin-menu btn btn-sm btn-link"><i class="icon ion-ios-menu"></i></span>
        </div>
        <div class="header-widget search-widget">
            <a href="{{url('/')}}" class="btn btn-sm btn-default ml-2" target="_blank">{{__('Home')}}
            </a>
        </div>
    </div>
    <div class="widgets-right flex-shrink-0 d-flex">
        @if(!empty($languages) and is_enable_multi_lang())
        <div class="dropdown header-widget widget-user widget-language flex-shrink-0">
            <div data-toggle="dropdown" class="user-dropdown d-flex align-items-center" aria-haspopup="true" aria-expanded="false">
                @foreach($languages as $language)
                    @if($locale == $language->locale)
                        <div class="user-info flex-grow-1 d-flex">
                            @if($language->flag)
                                <span class="flag-icon mr-2 flag-icon-{{$language->flag}}"></span>
                            @endif
                            {{$language->name}}
                        </div>
                    @endif
                @endforeach
                <i class="fa fa-angle-down"></i>
            </div>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @foreach($languages as $language)
                    @php if($language->locale == $locale) continue; @endphp

                    <a class="dropdown-item" href="{{route('language.set-admin-lang',['locale'=>$language->locale])}}">
                        @if($language->flag)
                            <span class="flag-icon flag-icon-{{$language->flag}}"></span>
                        @endif
                        {{$language->name}}
                    </a>
                @endforeach
            </div>
        </div>
        @endif
        <div class="dropdown header-widget widget-user pt-2 dropdown-notifications flex-shrink-0" style="min-width: 0">
            <div data-toggle="dropdown" class="user-dropdown d-flex align-items-center" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-lg fa-bell m-1 p-1"></i>
                <span class="badge badge-danger notification-icon">{{$countUnread}}</span>
            </div>
            <div class="dropdown-menu overflow-auto notify-items dropdown-container dropdown-menu-right dropdown-large" aria-labelledby="dropdownMenuButton">
                <div class="dropdown-toolbar">
                    <div class="dropdown-toolbar-actions">
                        <a href="#" class="markAllAsRead">{{__('Mark all as read')}}</a>
                    </div>
                    <h3 class="dropdown-toolbar-title">{{__('Notifications')}} (<span class="notif-count">{{$countUnread}}</span>)</h3>
                </div>
                <ul class="dropdown-list-items p-0">
                    @if(count($notifications)> 0)
                        @foreach($notifications as $oneNotification)
                            @php
                                $active = $class = '';
                                $data = json_decode($oneNotification['data']);

                                $idNotification = @$data->id;
                                $forAdmin = @$data->for_admin;
                                $usingData = @$data->notification;

                                $services = @$usingData->type;
                                $idServices = @$usingData->id;
                                $title = @$usingData->message;
                                $name = @$usingData->name;
                                $avatar = @$usingData->avatar;
                                $link = @$usingData->link;

                                if(empty($oneNotification->read_at)){
                                    $class = 'markAsRead';
                                    $active = 'active';
                                }

                            @endphp
                            <li class="notification {{$active}}">
                                <div class="media">
                                        <div class="media-left">
                                              <div class="media-object">
                                                  @if($avatar)
                                                    <img class="image-responsive" src="{{$avatar}}" alt="{{$name}}">
                                                  @else
                                                      <span class="avatar-text">{{ucfirst($name[0])}}</span>
                                                  @endif
                                              </div>
                                            </div>
                                        <div class="media-body">
                                            <a class="{{$class}}" data-id="{{$idNotification}}" href="{{$link}}">{!! $title !!}</a>
                                              <div class="notification-meta">
                                                    <small class="timestamp">{{format_interval($oneNotification->created_at)}}</small>
                                                  </div>
                                            </div>
                                      </div>
                                </li>
                        @endforeach
                    @endif
                </ul>
                <div class="dropdown-footer text-center">
                    <a href="{{route('core.admin.notification.loadNotify')}}">{{__('View More')}}</a>
                </div>
            </div>
        </div>
        <div class="dropdown header-widget widget-user flex-shrink-0">
            <div data-toggle="dropdown" class="user-dropdown d-flex align-items-center" aria-haspopup="true" aria-expanded="false">
                <span class="user-avatar flex-shrink-0">
                     @if($avatar_url = $user->getAvatarUrl())
                        <div class="avatar avatar-cover" style="background-image: url('{{$user->getAvatarUrl()}}')"></div>
                    @else
                        <span class="avatar-text">{{ucfirst($user->getDisplayName()[0])}}</span>
                    @endif
                </span>
                <div class="user-info flex-grow-1">
                    <div class="user-name">{{$user->getDisplayName()}}</div>
                    <div class="user-role">{{ucfirst($user->roles[0]->name ?? '')}}</div>
                </div>
                <i class="fa fa-angle-down"></i>
            </div>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ route('user.profile.index') }}">{{__('Edit Profile')}}</a>
                <a class="dropdown-item" href="{{ url('admin/module/user/password/'.$user->id)}}">{{__('Change Password')}}</a>
                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> {{__('Logout')}}
                </a>
            </div>
            <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
    </div>
</div>
