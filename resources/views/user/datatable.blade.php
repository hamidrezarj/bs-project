@extends('layouts.base')

@section('content')
    <table id="test" class="table table-striped table-bordered table-self-design" style="width: 100%">
        <thead>
            <tr>
                <th class="filter-none">ردیف</th>
                <th class="filter-text">شماره تیکت</th>
                <th class="filter-text">نام درس</th>
                <th class="filter-text">کد درس</th>
                <th class="filter-text">شرح درخواست</th>
                {{-- <th class="filter-select" data-select-name='["غیرفعال", "فعال"]' data-select-value='[0,1]'>وضعیت</th> --}}
                <th class="filter-date">تاریخ انقضا</th>
                <th class="filter-date">تاریخ ثبت</th>
                <th class="filter-date">تاریخ بروزرسانی</th>
                <th class="filter-none">عملیات</th>
            </tr>
        </thead>
    </table>
@endsection

@section('script')
    <script>
        const url = `https://sbu-ticket.ir/user/show_tickets`
        const columns = [{
                className: "text-center text-nowrap align-middle",
                data: null,
                render: function(data, type, row, meta) {
                    return (meta.settings._iDisplayStart + meta.row) + 1
                },
                name: {
                    name: 'No',
                    type: 'option'
                },
                searchable: false,
                orderable: false,
            },
            {
                data: "id",
                name: {
                    name: 'tickets.id',
                    type: 'text'
                },
                searchable: true,
                orderable: true,
            },
            {
                data: "course_name",
                name: {
                    name: 'tickets.course_name',
                    type: 'text'
                },
                searchable: true,
                orderable: true,
            },
            {
                data: "course_id",
                name: {
                    name: 'tickets.course_id',
                    type: 'text'
                },
                searchable: true,
                orderable: true,
            },
            {
                data: "description",
                name: {
                    name: 'tickets.description',
                    type: 'text'
                },
                searchable: true,
                orderable: true,
            },
            // {
            //     data: "status",
            //     name:{
            //         name:'tickets.status',
            //         type:'select'
            //     },
            //     searchable: true,
            //     orderable: true,
            // },
            {
                data: "expire_date",
                name: {
                    name: 'tickets.expire_date',
                    type: 'between'
                },
                searchable: true,
                orderable: true,
            },
            {
                data: "created_at",
                name: {
                    name: 'tickets.created_at',
                    type: 'between'
                },
                searchable: true,
                orderable: true,
            },
            {
                data: "updated_at",
                name: {
                    name: 'tickets.updated_at',
                    type: 'between'
                },
                searchable: true,
                orderable: true,
            },
            {
                className: "text-center text-nowrap align-middle",
                data: null,
                render: function() {
                    return ''
                },
                name: {
                    name: 'options',
                    type: 'option'
                },
                searchable: false,
                orderable: false
            },

        ]

        $(`#test thead tr`)
            .clone(true)
            .addClass('filters')
            .appendTo(`#test thead`);

        $('#test').DataTable({
            dom: "<'search-lentgh-parent'<'.dataTable-title'>l>t<'paginate-summary-parent'pi>r",
            pagingType: "simple_numbers",
            scrollX: false,
            processing: true,
            serverSide: true,
            ordering: true,
            orderCellsTop: true,
            fixedHeader: true,
            language: {
                sEmptyTable: "هیچ داده‌ای در جدول وجود ندارد",
                sInfo: "نمایش _START_ تا _END_ از _TOTAL_ ردیف",
                sInfoEmpty: "نمایش 0 تا 0 از 0 ردیف",
                sInfoFiltered: "(فیلتر شده از _MAX_ ردیف)",
                sInfoPostFix: "",
                sInfoThousands: ",",
                sLengthMenu: "نمایش _MENU_ ردیف",
                sLoadingRecords: "در حال بارگذاری...",
                processing: "<i class='fa fa-spinner fa-spin'></i> در حال دریافت اطلاعات...",
                sSearch: "جستجو: ",
                sZeroRecords: "داده ای با این مشخصات پیدا نشد",
                oPaginate: {
                    sFirst: "برگه‌ی نخست",
                    sLast: "برگه‌ی آخر",
                    sNext: "بعدی",
                    sPrevious: "قبلی",
                },
                oAria: {
                    sSortAscending: ": فعال سازی نمایش به صورت صعودی",
                    sSortDescending: ": فعال سازی نمایش به صورت نزولی",
                },
            },
            ajax: {
                url: url,
                type: "GET",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                dataSrc: function(res) {
                    return res.data;
                },
                error: function(request) {
                    // ajax_error(request.responseJSON, request.status);
                    return request.responseJSON;
                },
            },
            columns: columns,
            order: [1, 'desc'],
            initComplete: function() {
                var api = this.api();
                var filterDate = [];

                api.columns()
                    .eq(0)
                    .each(function(colIdx) {

                        var cell = $('.filters th').eq(
                            $(api.column(colIdx).header()).index()
                        );

                        var title = $(cell).text();

                        $(cell).hasClass('filter-text') ? $(cell).html(
                            `<input class="form-control form-control-sm" type="search" ${$(cell).hasClass('filter-placeholder-none') ? '' : `placeholder="جستجو ${title}"`} />`
                            ) : false

                        if ($(cell).hasClass('filter-date')) {
                            $(cell).html(
                                `<div class="d-flex" col-index ="${colIdx}" ><input class="col form-date-from form-control form-control-sm me-1" type="search" ${$(cell).hasClass('filter-placeholder-none') ? '' : `placeholder="از تاریخ"`} /><input class="col form-date-to form-control form-control-sm ms-1" type="search" ${$(cell).hasClass('filter-placeholder-none') ? '' : `placeholder="تا تاریخ"`} /></div>`
                                )

                            filterDate[colIdx] = {
                                from: {
                                    datetime: $(cell).find('input.form-date-from').pDatepicker({
                                        format: "YYYY/MM/DD",
                                        initialValue: false,
                                        autoClose: true,
                                        toolbox: {
                                            calendarSwitch: {
                                                enabled: false
                                            }
                                        },
                                        onSelect: function(unix) {
                                            filterDate[colIdx].from.datetime.touched = true;

                                            filterDate[colIdx].to.selector.prop("disabled",
                                                false);

                                            if (
                                                filterDate[colIdx].from.datetime.getState()
                                                .selected.unixDate >=
                                                filterDate[colIdx].to.datetime.getState()
                                                .selected.unixDate
                                            ) {
                                                filterDate[colIdx].to.datetime.setDate(
                                                    filterDate[colIdx].from.datetime
                                                    .getState().selected.unixDate);
                                            }

                                            if (filterDate[colIdx].to.datetime &&
                                                filterDate[colIdx].to.datetime.options &&
                                                filterDate[colIdx].to.datetime.options
                                                .minDate != unix) {
                                                let cachedValue = filterDate[colIdx].to
                                                    .datetime.getState().selected.unixDate;

                                                filterDate[colIdx].to.datetime.options = {
                                                    minDate: unix
                                                };

                                                if (filterDate[colIdx].from.datetime
                                                    .touched) {
                                                    filterDate[colIdx].to.datetime.setDate(
                                                        cachedValue);
                                                }
                                            }

                                            if (!(filterDate[colIdx].from.selector.val() ==
                                                    "" ^ filterDate[colIdx].to.selector
                                                    .val() == "")) {
                                                const sendDate =
                                                    `${moment(filterDate[colIdx].from.datetime.getState().selected.unixDate).format('YYYY-MM-DD')}&${moment(filterDate[colIdx].to.datetime.getState().selected.unixDate).format('YYYY-MM-DD')}`

                                                api.column(colIdx)
                                                    .search(sendDate)
                                                    .draw();
                                            }

                                            if (filterDate[colIdx].to.selector.val() != '')
                                                filterDate[colIdx].to.selector.val(moment(
                                                        filterDate[colIdx].to.datetime
                                                        .getState().selected.unixDate)
                                                    .format('jYYYY/jMM/jDD'))
                                        }
                                    }),
                                    selector: $(cell).find('input.form-date-from')
                                },
                                to: {
                                    datetime: $(cell).find('input.form-date-to').prop('disabled', true)
                                        .pDatepicker({
                                            format: "YYYY/MM/DD",
                                            initialValue: false,
                                            autoClose: true,
                                            toolbox: {
                                                calendarSwitch: {
                                                    enabled: false
                                                }
                                            },
                                            onSelect: function(unix) {
                                                filterDate[colIdx].to.datetime.touched = true;

                                                if (!(filterDate[colIdx].from.selector.val() ==
                                                        "" ^ filterDate[colIdx].to.selector
                                                        .val() == "")) {
                                                    const sendDate =
                                                        `${moment(filterDate[colIdx].from.datetime.getState().selected.unixDate).format('YYYY-MM-DD')}&${moment(filterDate[colIdx].to.datetime.getState().selected.unixDate).format('YYYY-MM-DD')}`

                                                    api.column(colIdx)
                                                        .search(sendDate)
                                                        .draw();
                                                }

                                                if (filterDate[colIdx].from.selector.val() !=
                                                    '') filterDate[colIdx].from.selector.val(
                                                    moment(filterDate[colIdx].from.datetime
                                                        .getState().selected.unixDate)
                                                    .format('jYYYY/jMM/jDD'))
                                            }
                                        }),
                                    selector: $(cell).find('input.form-date-to')
                                }
                            }

                            $(cell).find('input.form-date-from').on('input', function() {
                                if ($(this).val() == '') {
                                    $(cell).find('input.form-date-to').val('')
                                    $(cell).find('input.form-date-to').prop('disabled', true)
                                    api.column(colIdx)
                                        .search('')
                                        .draw();
                                }
                            })
                        }

                        if ($(cell).hasClass('filter-select')) {
                            let content = `<select class="form-select form-select-sm">`
                            content += `<option value="-1">انتخاب ${title}</option>`
                            for (let index = 0; index < $(cell).data('selectValue').length; index++) {
                                const name = $(cell).data('selectName')[index]
                                const value = $(cell).data('selectValue')[index]
                                content += `<option value="${value}">${name}</option>`
                            }
                            content += `</select>`
                            $(cell).html(content)
                        }

                        $('select', $('.filters th').eq($(api.column(colIdx).header()).index())).on(
                            'change',
                            function(e) {
                                e.stopPropagation();
                                const value = this.value != -1 ? this.value : ''
                                console.log(this.value);

                                api.column(colIdx).search(value).draw()
                            });

                        $('input', $('.filters th').eq($(api.column(colIdx).header()).index())).on('input',
                            function(e) {
                                e.stopPropagation();

                                if ($(this).parents('.filter-date').length != 0) return false

                                $(this).attr('title', $(this).val());

                                var cursorPosition = this.selectionStart;

                                api.column(colIdx).search(this.value).draw()

                                $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                            });
                    });

                $('.filter-none').each(function(index, element) {
                    $(element).parents('tr').hasClass('filters') ? $(element).remove() : $(element)
                        .attr('rowspan', 2)
                })

                var tooltipTriggerListDataTable = [].slice.call(
                    document.querySelectorAll('table.dataTable [data-bs-toggle="tooltip"]')
                );
                var tooltipListDataTable = tooltipTriggerListDataTable.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });

                if (typeof initComplete !== "undefined") {
                    if (typeof initComplete === "function") {
                        initComplete.call()
                    } else {
                        console.error('initComplete is function()')
                    }
                }
            },
        });
    </script>
@endsection
