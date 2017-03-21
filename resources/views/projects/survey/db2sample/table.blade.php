@section('css')
    @include('layouts.datatables_css')
@endsection

<table  class="table table-striped table-bordered" id="dataTableBuilder" width="100%">
<thead>
<tr>
<th rowspan="2" width="80px">State</th>
<th rowspan="2" width="70px">Total Forms</th>
<th rowspan="2" width="70px">Total</th>
@foreach($project->sectionsDb as $section)
<th colspan="4" width="250px">{{$section->sectionname}}</th>
@endforeach
</tr>
<tr>
@foreach($project->sectionsDb as $section)
<th>C</th>
<th>I</th>
<th>M</th>
<th>E</th>
@endforeach
</tr>
</thead>
</table>

@section('scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
@endsection
