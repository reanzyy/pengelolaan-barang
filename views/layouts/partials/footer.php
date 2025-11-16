<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="./../../assets/vendor/libs/jquery/jquery.js"></script>
<script src="./../../assets/vendor/libs/popper/popper.js"></script>
<script src="./../../assets/vendor/js/bootstrap.js"></script>
<script src="./../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="./../../assets/vendor/js/menu.js"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="./../../assets/vendor/libs/apex-charts/apexcharts.js"></script>

<!-- Main JS -->
<script src="./../../assets/js/main.js"></script>

<!-- Page JS -->
<script src="./../../assets/js/dashboards-analytics.js"></script>

<!-- Data Table JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>

<!-- Dropify JS -->
<script src="./../../assets/vendor/libs/dropify-master/dist/js/dropify.min.js"></script>

<!-- Sweetalert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('body').on('click', '.btn-delete', function() {
        const title = $(this).data('confirm-title') || "Anda yakin?";
        const text = $(this).data('confirm-text') || "Anda yakin menghapus data ini?";
        const icon = $(this).data('confirm-icon') || "warning";
        const action = $(this).data('action');

        if (!action) {
            return;
        }

        swal({
                title,
                text,
                icon,
                buttons: [
                    "Batalkan",
                    "Ya, Lakukan"
                ]
            })
            .then(function(willDelete) {
                if (willDelete) {
                    const form = $(`<form action="${action}" method="POST">
                        </form>`);
                    $('body').append(form);
                    form.submit();
                }
            });
    });
</script>

<script>
    if ($('.datatable').length > 0) {
        // Append row on thead for place search box
        $('table.datatable:not(.noinit):not(.no-init):not(.nofilter) thead tr')
            .clone(true)
            .appendTo('table.datatable:not(.noinit) thead');

        // Add a search box in thead, to search by individual column
        $('table.datatable thead tr:eq(1) th').each(function(i) {
            let title = $(this).text();
            if ($(this).attr('datatable-skip-search')) {
                return;
            }

            if (title && !['#', 'Aksi'].includes(title)) {
                $(this).html(
                    '<input type="text" class="form-control form-control-sm" placeholder="&#x1F50D;" style="min-width:100px">'
                );
                $('input', this).on('keyup change', function() {
                    if (table.column(i).search() !== this.value) {
                        table.column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            } else {
                $(this).html('');
            }
        });

        // Init datatable with export buttons
        const dtLang = {
            config: {
                "sEmptyTable": "Tidak ada data yang tersedia pada tabel ini",
                "sProcessing": "Sedang memproses...",
                "sLengthMenu": "&nbsp;_MENU_",
                "sLoadingRecords": '<i class="fa fa-spinner fa-spin fa-fw"></i><span class="sr-only">Memuat</span> Memuat...',
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ditemukan data yang sesuai",
                "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                "sInfoPostFix": "",
                "sSearch": "Cari:",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "Pertama",
                    "sPrevious": "Sebelumnya",
                    "sNext": "Selanjutnya",
                    "sLast": "Terakhir"
                }
            },
            menu: {
                entries: "entri",
                allEntries: "Semua entri",
            }
        };

        const useKeyTable = $('.datatable.datatable-keytable').length > 0 || $('.datatable.datatable-scroll-x').length >
            0 ?
            true :
            false;

        let table = $('.datatable').DataTable({
            keys: useKeyTable,
            orderCellsTop: true,
            dom: '<"row"<"col-md-5 dt-feat-right"Bl><"col-md-7 dt-toolbar-right">>rtip',
            lengthMenu: [
                [25, 50, 100, -1],
                [`25 ${dtLang.menu.entries}`, `50 ${dtLang.menu.entries}`, `100 ${dtLang.menu.entries}`,
                    dtLang.menu.allEntries
                ]
            ],
            oLanguage: dtLang.config,
        });
    }
</script>