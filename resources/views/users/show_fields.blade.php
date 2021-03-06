<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{!! $user->name !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('code', 'Code:') !!}
    <p>{!! $user->code !!}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>{!! $user->email !!}</p>
</div>

@if(!empty($user->api_token))
<!-- Email Field -->
<div class="form-group">
    {!! Form::label('api_token', 'API Token:') !!}
    <p>{!! $user->api_token !!}</p>
</div>
@endif
<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Registered since:') !!}
    <p>{!! $user->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Profile last updated:') !!}
    <p>{!! $user->updated_at !!}</p>
</div>
