<?php

namespace App\DataTables;

use App\Models\SampleData;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Services\DataTable;

class SampleDataDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        $table = $this->datatables
            ->eloquent($this->query());
        if (Auth::user()->role->level > 5) {
            $table->addColumn('action', 'sample_datas.datatables_actions');
        }
        return $table->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $sampleDatas = SampleData::query();

        return $this->applyScopes($sampleDatas);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        $builder = $this->builder()
            ->columns($this->getColumns())
            ->ajax('')
            ->parameters([
                'dom' => 'Bfrtip',
                'scrollX' => true,
                'language' => [
                    "decimal" => trans('messages.decimal'),
                    "emptyTable" => trans('messages.emptyTable'),
                    "info" => trans('messages.info'),
                    "infoEmpty" => trans('messages.infoEmpty'),
                    "infoFiltered" => trans('messages.infoFiltered'),
                    "infoPostFix" => trans('messages.infoPostFix'),
                    "thousands" => trans('messages.thousands'),
                    "lengthMenu" => trans('messages.lengthMenu'),
                    "loadingRecords" => trans('messages.loadingRecords'),
                    "processing" => trans('messages.processing'),
                    "search" => trans('messages.search'),
                    "zeroRecords" => trans('messages.zeroRecords'),
                    "paginate" => [
                        "first" => trans('messages.paginate.first'),
                        "last" => trans('messages.paginate.last'),
                        "next" => trans('messages.paginate.next'),
                        "previous" => trans('messages.paginate.previous'),
                    ],
                    "aria" => [
                        "sortAscending" => trans('messages.aria.sortAscending'),
                        "sortDescending" => trans('messages.aria.sortDescending'),
                    ],
                    "buttons" => [
                        'print' => trans('messages.print'),
                        'reset' => trans('messages.reset'),
                        'reload' => trans('messages.reload'),
                        'export' => trans('messages.export'),
                        'colvis' => trans('messages.colvis'),
                    ],
                ],
                'buttons' => [
                    'print',
                    'reset',
                    'reload',
                    [
                        'extend' => 'collection',
                        'text' => '<i class="fa fa-download"></i> ' . trans('messages.export'),
                        'buttons' => [
                            'csv',
                            'excel',
                            'pdf',
                        ],
                    ],
                    'colvis',
                ],
                'initComplete' => "function () {
                            this.api().columns(['0, 1']).every(function () {
                                var column = this;
                                var br = document.createElement(\"br\");
                                var input = document.createElement(\"input\");
                                input.className = 'form-control input-sm';
                                input.style.width = '90%';
                                $(br).appendTo($(column.header()));
                                $(input).appendTo($(column.header()))
                                .on('change', function () {
                                    column.search($(this).val(), false, false, true).draw();
                                });
                            });
                            this.api().columns([2]).every( function () {
                              var column = this;
                              var select = $('<select style=\"width:80px !important\"><option value=\"\">-</option><option value=\"enumerator\">Enumerator</option><option value=\"spotchecker\">Spot Checker</option><option value=\"location\">Location</option><option value=\"voter\">Voter</option></select>')
                              .appendTo( $(column.header()) )
                              .on( 'change', function () {
                              var val = $.fn.dataTable.util.escapeRegex(
                                          $(this).val()
                                          );

                                  column
                                  .search( val ? val : '', false, false )
                                  .draw();
                              } );
                              select.addClass('form-control input-sm');
                              } );

                              this.api().columns([3]).every( function () {
                              var column = this;
                              var select = $('<select style=\"width:80% !important\"><option value=\"\">-</option><option value=\"1\">Group 1</option><option value=\"2\">Group 2</option><option value=\"3\">Group 3</option><option value=\"4\">Group 4</option><option value=\"5\">Group 5</option></select>')
                              .appendTo( $(column.header()) )
                              .on( 'change', function () {
                              var val = $.fn.dataTable.util.escapeRegex(
                                          $(this).val()
                                          );

                                  column
                                  .search( val ? val : '', false, false )
                                  .draw();
                              } );
                              select.addClass('form-control input-sm');
                              } );
                        }",
            ]);
        if (Auth::user()->role->level > 5) {
            $builder->addAction(['width' => '10%', 'title' => trans('messages.action')]);
        }

        return $builder;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns()
    {
        return [
            'idcode' => ['name' => 'idcode', 'data' => 'idcode', 'orderable' => false, 'title' => trans('messages.idcode')],
            'spotchecker_code' => ['name' => 'spotchecker_code', 'data' => 'spotchecker_code', 'orderable' => false, 'title' => trans('messages.spotchecker_code')],
            'type' => ['name' => 'type', 'data' => 'type', 'orderable' => false, 'title' => trans('messages.type')],
            'dbgroup' => ['name' => 'dbgroup', 'data' => 'dbgroup', 'orderable' => false, 'title' => trans('messages.dbgroup')],
            'sample' => ['name' => 'sample', 'data' => 'sample', 'orderable' => false, 'title' => trans('messages.sample')],
            'area_type' => [
                'name' => 'area_type',
                'data' => 'area_type',
                'title' => trans('messages.area_type'),
                'render' => function () {
                    return "function(data,type,full,meta){
                                        var html;
                                        if(type === 'display') {
                                            if(data == 1) {
                                                html = '" . trans('messages.urban') . "';
                                            } else if(data == 2) {
                                                html = '" . trans('messages.rural') . "';
                                            }  else {
                                                html = '" . trans('messages.unknown') . "';
                                            }
                                        } else {
                                            html = data;
                                        }

                                        return html;
                                    }";
                },
            ],
            'code' => ['name' => 'code', 'data' => 'code', 'title' => trans('messages.observer_id'), 'orderable' => false],
            'name' => ['name' => 'name', 'data' => 'name', 'title' => trans('messages.name'), 'orderable' => false],
            'gender' => ['name' => 'gender', 'data' => 'gender', 'title' => trans('messages.gender'), 'orderable' => false],
            'nrc_id' => ['name' => 'nrc_id', 'data' => 'nrc_id', 'title' => trans('messages.nrc_id'), 'orderable' => false],
            'dob' => ['name' => 'dob', 'data' => 'dob', 'title' => trans('messages.dob'), 'orderable' => false],
            'father' => ['name' => 'father', 'data' => 'father', 'title' => trans('messages.father'), 'orderable' => false],
            'mother' => ['name' => 'mother', 'data' => 'mother', 'title' => trans('messages.mother'), 'orderable' => false],
            'address' => ['name' => 'address', 'data' => 'address', 'title' => trans('messages.address'), 'orderable' => false],
            'village' => ['name' => 'village', 'data' => 'village', 'title' => trans('messages.village'), 'orderable' => false],
            'ward' => ['name' => 'ward', 'data' => 'ward', 'title' => trans('messages.ward'), 'orderable' => false],
            'village_tract' => ['name' => 'village_tract', 'data' => 'village_tract', 'title' => trans('messages.village_tract'), 'orderable' => false],
            'township' => ['name' => 'township', 'data' => 'township', 'title' => trans('messages.township'), 'orderable' => false],
            'district' => ['name' => 'district', 'data' => 'district', 'title' => trans('messages.district'), 'orderable' => false],
            'state' => ['name' => 'state', 'data' => 'state', 'title' => trans('messages.state'), 'orderable' => false],
            'education' => ['name' => 'education', 'data' => 'education', 'title' => trans('messages.education'), 'orderable' => false],
            'language' => ['name' => 'language', 'data' => 'language', 'title' => trans('messages.language'), 'orderable' => false],
            'bank_information' => ['name' => 'bank_information', 'data' => 'bank_information', 'title' => trans('messages.bank'), 'orderable' => false],
            'mobile_provider' => ['name' => 'mobile_provider', 'data' => 'mobile_provider', 'title' => trans('messages.mobile_provider'), 'orderable' => false],
            //'parent_id' => ['name' => 'parent_id', 'data' => 'parent_id'],
            //'created_at' => ['name' => 'created_at', 'data' => 'created_at'],
            //'updated_at' => ['name' => 'updated_at', 'data' => 'updated_at'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'sampleDatas';
    }
}
