<div class="col-9">
    <div class="panel">
        <ul class="dropdown-list-items p-0">
            @if(count($rows)> 0)
                @include('Core::admin.notification.notification-loop-item')
            @else
                <li class="notification">{{__("You don't have any notifications")}}</li>
            @endif
        </ul>

        <div class="d-flex justify-content-end">
            {{$rows->links()}}
        </div>
    </div>
</div>
