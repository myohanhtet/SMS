@can('index', \App\Models\Project::class)
<li class="{{ Request::is('projects*') ? 'active' : '' }}">
    <a href="{!! route('projects.index') !!}"><i class="fa fa-briefcase"></i><span>{!! trans_choice('messages.projects', 2) !!}</span></a>
</li>
@endcan
@can('index', \App\Models\SampleData::class)
<li class="{{ Request::is('sampleDatas*') ? 'active' : '' }}">
    <a href="{!! route('sampleDatas.index') !!}"><i class="fa fa-database"></i><span>{!! trans_choice('messages.sample_datas', 2) !!}</span></a>
</li>

<li class="{{ Request::is('observers*') ? 'active' : '' }}">
    <a href="{!! route('observers.index') !!}"><i class="fa fa-users"></i><span>Observers</span></a>
</li>
@endcan
@can('index', \App\Models\SmsLog::class)
<li class="{{ Request::is('smsLogs*') ? 'active' : '' }}">
    <a href="{!! route('smsLogs.index') !!}"><i class="fa fa-comment"></i><span>{!! trans_choice('messages.sms_logs', 2) !!}</span></a>
</li>
@endcan
@can('index', \App\Models\User::class)
<li class="{{ Request::is('users*') ? 'active' : '' }}">
    <a href="{!! route('users.index') !!}"><i class="fa fa-user"></i><span>{!! trans_choice('messages.users', 2) !!}</span></a>
</li>
@endcan
@can('index', \App\Models\Role::class)
<li class="{{ Request::is('roles*') ? 'active' : '' }}">
    <a href="{!! route('roles.index') !!}"><i class="fa fa-address-card"></i><span>{!! trans_choice('messages.roles', 2) !!}</span></a>
</li>
@endcan
@can('index', \App\Models\Setting::class)
    <li class="{{ Request::is('projectPhones*') ? 'active' : '' }}">
        <a href="{!! route('projectPhones.index') !!}"><i class="fa fa-building"></i><span>ProjectPhones</span></a>
    </li>
    <li class="{{ Request::is('settings*') ? 'active' : '' }}">
        <a href="{!! route('settings.index') !!}"><i class="fa fa-cog"></i><span>{!! trans_choice('messages.settings', 2) !!}</span></a>
    </li>
@endcan




<li class="{{ Request::is('locationMetas*') ? 'active' : '' }}">
    <a href="{!! route('locationMetas.index') !!}"><i class="fa fa-map-marker"></i><span>Location Metas</span></a>
</li>


<li class="{{ Request::is('translations*') ? 'active' : '' }}">
    <a href="{!! route('translations.index') !!}"><i class="fa fa-edit"></i><span>Translations</span></a>
</li>

