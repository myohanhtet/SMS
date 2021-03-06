@php
    if(isset($sample)) {
        $parties = explode(',', $sample->data->parties);
    } else {
        $parties = explode(',', $project->parties); //to remove later
    }
@endphp
<div class="row">
    <div class="col-sm-12 ">
        <div class='fade in' id="ballot-error">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-8">
        <table class="table table-bordered table-responsive" style="vertical-align:middle">
            <tr valign="bottom">
                <th rowspan="3" height="12">
                    <p>{!! trans('ballots.serial') !!}</p>
                </th>
                <th rowspan="3">
                    <p style="margin-bottom: 0in"><br/>

                    </p>
                    <p>{!! trans('ballots.candidate') !!}</p>
                </th>
                <th rowspan="3">
                    <p>{!! trans('ballots.party') !!}</p>
                </th>
                <th colspan="4" width="42%">
                    <p>{!! trans('ballots.votes_cast') !!}</p>
                </th>
            </tr>
            <tr valign="bottom">
                <th rowspan="2">
                    <p>{!! trans('ballots.polling_station') !!}</p>
                </th>
                <th rowspan="2">
                    <p>{!! trans('ballots.advanced_voting') !!}</p>
                </th>
                <th colspan="2" width="21%">
                    <p>{!! trans('ballots.total_cast') !!}</p>
                </th>
            </tr>
            <tr valign="bottom">
                <th>
                    <p>{!! trans('ballots.in_numbers') !!}</p>
                </th>
                <th>
                    <p>{!! trans('ballots.in_words') !!}</p>
                </th>
            </tr>
            @foreach($parties as $party)
                <tr valign="top">
                    <td>
                    </td>
                    <td>

                    </td>
                    <td>
                        <p>{!! $party !!}</p>
                    </td>
                    <td>
                        {!! Form::number("result[ballot][".trim($party)."][station]", (isset($results))?Kanaung\Facades\Converter::convert($results['section'.$section->sort]->{trim($party).'_station'},'unicode','zawgyi'):null, ['class' => 'form-control input-sm party-station']) !!}
                    </td>
                    <td>
                        {!! Form::number("result[ballot][".trim($party)."][advanced]", (isset($results))?Kanaung\Facades\Converter::convert($results['section'.$section->sort]->{trim($party).'_advanced'},'unicode','zawgyi'):null, ['class' => 'form-control input-sm party-advanced']) !!}
                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="9" width="100%" height="89" valign="top">
                    <p>{!! trans('ballots.witnesses') !!}</p>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-sm-4">
        <table class="table table-bordered table-responsive">
            <tr>
                <th colspan="2">{!! trans('ballots.remarks') !!}</th>
            </tr>

            <tr>
                <td>
                    <p>{!! trans('ballots.ballots_issued_on_e_day') !!}</p>
                </td>
                <td class="col-sm-5">
                    {!! Form::number("result[ballot_remark][rem1]", (isset($results))?Kanaung\Facades\Converter::convert($results['section'.$section->sort]->rem1,'unicode','zawgyi'):null, ['class' => 'form-control input-sm remarks', 'id' => 'rem1']) !!}
                </td>
            <tr>
            <tr>
                <td>
                    <p>{!! trans('ballots.ballots_received_for_advanced_voting') !!}</p>
                </td>
                <td class="col-sm-5">
                    {!! Form::number("result[ballot_remark][rem2]", (isset($results))?Kanaung\Facades\Converter::convert($results['section'.$section->sort]->rem2,'unicode','zawgyi'):null, ['class' => 'form-control input-sm remarks', 'id' => 'rem2']) !!}
                </td>
            <tr>
            <tr>
                <td>
                    <p>{!! trans('ballots.valid') !!}</p>
                </td>
                <td class="col-sm-5">
                    {!! Form::number("result[ballot_remark][rem3]", (isset($results))?Kanaung\Facades\Converter::convert($results['section'.$section->sort]->rem3,'unicode','zawgyi'):null, ['class' => 'form-control input-sm remarks', 'id' => 'rem3']) !!}
                </td>
            <tr>
            <tr>
                <td>
                    <p>{!! trans('ballots.invalid') !!}</p>
                </td>
                <td class="col-sm-5">
                    {!! Form::number("result[ballot_remark][rem4]", (isset($results))?Kanaung\Facades\Converter::convert($results['section'.$section->sort]->rem4,'unicode','zawgyi'):null, ['class' => 'form-control input-sm remarks', 'id' => 'rem4']) !!}
                </td>
            <tr>
            <tr>
                <td>
                    <p>{!! trans('ballots.missing') !!}</p>
                </td>
                <td class="col-sm-5">
                    {!! Form::number("result[ballot_remark][rem5]", (isset($results))?Kanaung\Facades\Converter::convert($results['section'.$section->sort]->rem5,'unicode','zawgyi'):null, ['class' => 'form-control input-sm remarks', 'id' => 'rem5']) !!}
                </td>
            <tr>

        </table>
    </div>
</div>

@push('document-ready')


    var rem1 = parseInt($('#rem1').val(), 10);
    var rem2 = parseInt($('#rem2').val(), 10);
    var rem3 = parseInt($('#rem3').val(), 10);
    var rem4 = parseInt($('#rem4').val(), 10);
    var rem5 = parseInt($('#rem5').val(), 10);

    var totalrem = rem1 + rem2;

    var rvotes = $( "input[name='result[registered_voters]']" ).val();
    var avotes = $( "input[name='result[advanced_voters]']" ).val();
    var rv = parseInt(rvotes,10);
    var av = parseInt(avotes,10);
    var votes = av / (rv + av);

    var party_advanced = 0;
    $('.party-advanced').each(function() {
    var each_advanced = parseInt($(this).val(),10);
    if(each_advanced){
    party_advanced += each_advanced;
    }
    });
    var error = false;
    if(party_advanced > rem2){
    error = true;
    $('#ballot-error').append('
    <div id="log1">{{ trans('ballots.log1') }}<br></div>');
    }

    if( ( !isNaN((rem1 + rem2) ) && !isNaN((rem3 + rem4 + rem5)) ) && ((rem1 + rem2) != (rem3 + rem4 + rem5) ) ){
    error = true;
    $('#ballot-error').append('
    <div id="log2">{{ trans('ballots.log2') }}<br></div>');
    }
    if( ( rem4 / (rem1 + rem2 )) > 0.15 ) {
    error = true;
    $('#ballot-error').append('
    <div id="log3">{{ trans('ballots.log3') }} ' + (rem4 / (rem1 + rem2 ) ) + '<br></div>');
    }
    if( ( rem5 / (rem1 + rem2 )) > 0.15 ) {
    error = true;
    $('#ballot-error').append('
    <div id="log4">{{ trans('ballots.log4') }} ' + (rem5 / (rem1 + rem2 )) + '<br></div>');
    }
    if( ( rem2 / (rem1 + rem2 )) > 0.1 ) {
    error = true;
    $('#ballot-error').append('
    <div id="log5">{{ trans('ballots.log5') }} ' + (rem2 / (rem1 + rem2 )) + '<br></div>');
    }
    if( rvotes && totalrem && rvotes < totalrem ) {
    error = true;
    $('#ballot-error').append('
    <div id="log6">{{ trans('ballots.log6') }}<br></div>' );
    }
    if( rem2 && avotes && avotes != rem2 ) {
    error = true;
    $('#ballot-error').append('
    <div id="log7">{{ trans('ballots.log7') }}<br></div>' );
    }

    if(error && !$('#ballot-error').is(':empty')) {
    $('#ballot-error').addClass('alert alert-danger ');
    } else {
    $('#ballot-error').removeClass('alert alert-danger ').html('');
    }


    $( "input[name='result[registered_voters]']" ).on('keyup', function(e){
    var rvotes = $( "input[name='result[registered_voters]']" ).val();
    var avotes = $( "input[name='result[advanced_voters]']" ).val();
    var rem1 = parseInt($('#rem1').val(), 10);
    var rem2 = parseInt($('#rem2').val(), 10);
    var totalrem = rem1 + rem2;
    var rv = parseInt(rvotes,10);
    var av = parseInt(avotes,10);
    var votes = av / (rv + av);

    if(rvotes && avotes && (votes > 0.1)) {
    error = true;
    $('#log8').remove();
    $('#ballot-error').append('
    <div id="log8">{{ trans('ballots.log8') }} ' + votes + '<br></div>');
    } else {
    error = false;
    $('#log8').remove();
    }
    if( rvotes < totalrem ) {
    error = true;
    $('#log6').remove();
    $('#ballot-error').append('
    <div id="log6">{{ trans('ballots.log6') }}<br></div>' );
    } else {
    error = false;
    $('#log6').remove();
    }
    if(error && !$('#ballot-error').is(':empty')) {
    $('#ballot-error').addClass('alert alert-danger ');
    } else {
    $('#ballot-error').removeClass('alert alert-danger ').html('');
    }
    })

    $( "input[name='result[advanced_voters]']" ).on('keyup', function(e){
    var rvotes = $( "input[name='result[registered_voters]']" ).val();
    var avotes = $( "input[name='result[advanced_voters]']" ).val();
    var rem2 = parseInt($('#rem2').val(), 10);
    var rv = parseInt(rvotes,10);
    var av = parseInt(avotes,10);
    var votes = av / (rv + av);

    if(rvotes && avotes && (votes > 0.1)) {
    error = true;
    $('#log8').remove();
    $('#ballot-error').append('
    <div id="log8">{{ trans('ballots.log8') }} ' + votes + '<br></div>');
    } else {
    $('#log8').remove();
    }
    if( rem2 && avotes != rem2 ) {
    error = true;
    $('#log7').remove();
    $('#ballot-error').append('
    <div id="log7">{{ trans('ballots.log7') }}<br></div>' );
    } else {
    $('#log7').remove();
    }

    if(error && !$('#ballot-error').is(':empty')) {
    $('#ballot-error').addClass('alert alert-danger ');
    } else {
    $('#ballot-error').removeClass('alert alert-danger ').html('');
    }
    })

    $('.remarks').on('keyup', function(e){
    var rem1 = parseInt($('#rem1').val(), 10);
    var rem2 = parseInt($('#rem2').val(), 10);
    var rem3 = parseInt($('#rem3').val(), 10);
    var rem4 = parseInt($('#rem4').val(), 10);
    var rem5 = parseInt($('#rem5').val(), 10);

    var totalrem = rem1 + rem2;

    var rvotes = $( "input[name='result[registered_voters]']" ).val();
    var avotes = $( "input[name='result[advanced_voters]']" ).val();
    var rv = parseInt(rvotes,10);
    var av = parseInt(avotes,10);
    var votes = av / (rv + av);

    var party_advanced = 0;
    $('.party-advanced').each(function() {
    var each_advanced = parseInt($(this).val(),10);
    if(each_advanced){
    party_advanced += each_advanced;
    }
    });

    if(party_advanced > rem2){
    error = true;
    $('#log1').remove();
    $('#ballot-error').append('
    <div id="log1">{{ trans('ballots.log1') }}<br></div>');
    } else {
    $('#log1').remove();
    }

    if( ( !isNaN((rem1 + rem2) ) && !isNaN((rem3 + rem4 + rem5)) ) && ((rem1 + rem2) != (rem3 + rem4 + rem5) ) ){
    error = true;
    $('#log2').remove();
    $('#ballot-error').append('
    <div id="log2">{{ trans('ballots.log2') }}<br></div>');
    } else {
    $('#log2').remove();
    }
    if( ( rem4 / (rem1 + rem2 )) > 0.15 ) {
    error = true;
    $('#log3').remove();
    $('#ballot-error').append('
    <div id="log3"> {{ trans('ballots.log3') }} ' + (rem4 / (rem1 + rem2 ) ) + '<br></div>');
    } else {
    $('#log3').remove();
    }
    if( ( rem5 / (rem1 + rem2 )) > 0.15 ) {
    error = true;
    $('#log4').remove();
    $('#ballot-error').append('
    <div id="log4">{{ trans('ballots.log4') }} ' + (rem5 / (rem1 + rem2 )) + '<br></div>');
    } else {
    $('#log4').remove();
    }
    if( ( rem2 / (rem1 + rem2 )) > 0.1 ) {
    error = true;
    $('#log5').remove();
    $('#ballot-error').append('
    <div id="log5">{{ trans('ballots.log5') }} ' + (rem2 / (rem1 + rem2 )) + '<br></div>');
    } else {
    $('#log5').remove();
    }
    if( rvotes && totalrem && rvotes < totalrem ) {
    error = true;
    $('#log6').remove();
    $('#ballot-error').append('
    <div id="log6">{{ trans('ballots.log6') }}<br></div>' );
    } else {
    $('#log6').remove();
    }
    if( rem2 && avotes && avotes != rem2 ) {
    error = true;
    $('#log7').remove();
    $('#ballot-error').append('
    <div id="log7">{{ trans('ballots.log7') }}<br></div>' );
    } else {
    $('#log7').remove();
    }

    if(error && !$('#ballot-error').is(':empty')) {
    $('#ballot-error').addClass('alert alert-danger ');
    } else {
    $('#ballot-error').removeClass('alert alert-danger ').html('');
    }
    });


    $('.party-advanced').on('keyup', function(e){
    var rem2 = parseInt($('#rem2').val(),10);
    var party_advanced = 0;
    $('.party-advanced').each(function() {
    var each_advanced = parseInt($(this).val(),10);
    if(each_advanced){
    party_advanced += each_advanced;
    }
    });
    if(rem2 && party_advanced > rem2){
    error = true;
    $('#log1').remove()
    $('#ballot-error').addClass('alert alert-danger ').html('
    <div id="log1">{{ trans('ballots.log1') }}<br></div>');
    } else {
    $('#log1').remove()
    }

    if(error && !$('#ballot-error').is(':empty')) {
    $('#ballot-error').addClass('alert alert-danger ');
    } else {
    $('#ballot-error').removeClass('alert alert-danger ').html('');
    }
    });



@endpush
