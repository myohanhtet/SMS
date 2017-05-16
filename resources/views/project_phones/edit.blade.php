@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Project Phone
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($projectPhone, ['route' => ['projectPhones.update', $projectPhone->id], 'method' => 'patch']) !!}

                        @include('project_phones.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection