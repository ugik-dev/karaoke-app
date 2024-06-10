<x-custom.app-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ $title }}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/components/modal.scss'])
        @vite(['resources/scss/dark/assets/components/modal.scss'])
        <link rel="stylesheet" href="{{ asset('plugins/animate/animate.css') }}">
        @vite(['resources/scss/light/assets/elements/alert.scss'])
        @vite(['resources/scss/dark/assets/elements/alert.scss'])
        <link rel="stylesheet" href="{{ asset('plugins/sweetalerts2/sweetalerts2.css') }}">
        @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
        <link rel="stylesheet" href="{{ asset('plugins/table/datatable/datatables.css') }}">
        @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss'])
        @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])

        <style>
            td,
            th {
                border-radius: 0px !important;
            }

            a.text-danger {
                transition: color 0.3s ease;
            }

            a.text-danger:hover {
                color: #dc3545;
            }

            .icon-trash {
                width: 30px;
                height: 30px;
                color: #dc3545;
            }

            .select2-container--open {
                z-index: 999999 !important;
            }
        </style>
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <x-slot:scrollspyConfig>
        data-bs-spy="scroll" data-bs-target="#navSection" data-bs-offset="100"
    </x-slot>

    <div class="row layout-top-spacing">
        <div class="col-lg-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area" style="min-height:50vh;">
                    <div class="p-3 container">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close text-white" data-bs-dismiss="alert"
                                    aria-label="Close"><i data-feather="x-circle"></i></button>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close text-white" data-bs-dismiss="alert"
                                    aria-label="Close"><i data-feather="x-circle"></i></button>
                            </div>
                        @endif
                    </div>

                    <div class="text-center d-flex justify-content-center justify-content-sm-start px-4">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-md w-20" data-bs-toggle="modal"
                            data-bs-target="#exampleModalCenter">
                            Input Unit Kerja
                        </button>
                    </div>

                    <div class="table-responsive px-4">
                        <table id="zero-config" class="table table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col" style="width:40px;">No.</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Kode</th>
                                    <th scope="col">PPK</th>
                                    <th scope="col">Kepala</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($workUnits as $workUnit)
                                    <tr>
                                        <td style="width:40px;">{{ $loop->iteration }}</td>
                                        <td>{{ $workUnit->name }}</td>
                                        <td>{{ $workUnit->code ?? '-' }}</td>
                                        <td>{{ $workUnit->ppkUnit->name ?? '-' }}</td>
                                        <td>{{ $workUnit->kepalaUnit->name ?? '-' }}</td>
                                        <td class="d-flex justify-content-center text-start">
                                            <button type="button" class="btn btn-primary btn-sm mx-1"
                                                onclick="openEditModal({{ $workUnit->id }}, '{{ $workUnit->name }}', '{{ $workUnit->code }}','{{ $workUnit->ppk }}','{{ $workUnit->kepala }}')">
                                                <i class="text-white" data-feather="edit-2"></i>
                                            </button>

                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm mx-1"
                                                role="button" onclick="confirmDelete({{ $workUnit->id }});">
                                                <i class="text-white" data-feather="trash-2"></i>
                                            </a>
                                            <!-- Hidden form for delete request -->
                                            <form id="delete-form-{{ $workUnit->id }}"
                                                action="{{ route('work_unit.delete', $workUnit->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Input Unit Kerja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('work_unit.store') }}" method="POST">
                        @csrf
                        <div class="form-group d-flex align-items-center my-2">
                            {{-- <button type="button" id="add-work_unit" class="btn btn-sm btn-primary py-0 px-2">
                                <i data-feather="plus"></i>
                            </button> --}}
                            <label for="work_unit" class="ms-2 py-0 mb-0">Unit Kerja</label>
                        </div>

                        <div id="work_unit-inputs" class="mt-2">
                            <div class="">
                                {{-- <span class="input-group-text">1.</span> --}}
                                <div class="mb-4 row">
                                    <label for="work_unit_name" class="col-sm-2 col-form-label">Nama Unit Kerja</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="work_unit_name" class="form-control"
                                            placeholder="Nama Unit Kerja">
                                    </div>
                                </div>
                                <div class="mb-4 row">
                                    <label for="work_unit_code" class="col-sm-2 col-form-label">Kode</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="work_unit_code" class="form-control"
                                            placeholder="Kode Unit Kerja">
                                    </div>
                                </div>
                                <div class="mb-4 row ppkWrapper">
                                    <label for="createSelectPPK" class="col-sm-2 col-form-label">PPK</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" name="ppk" id="createSelectPPK">
                                            <option selected disabled value="">Pilih PPK...</option>
                                            @foreach ($ppks as $ppk)
                                                <option value="{{ $ppk->id }}">{{ $ppk->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-4 row ppkWrapper">
                                    <label for="createSelectPPK" class="col-sm-2 col-form-label">KEPALA UNIT
                                        KERJA</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" name="kepala" id="createSelectPPK">
                                            <option selected disabled value="">Pilih KEPALA UNIT
                                                KERJA...</option>
                                            @foreach ($kepalas as $kepala)
                                                <option value="{{ $kepala->id }}">{{ $kepala->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-success text-center align-items-center mt-1 mt-2 py-auto"
                            type="submit">
                            <i data-feather="save"></i><span class="icon-name">Simpan</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTitle">Edit Unit Kerja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-form" action="" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label>Unit Kerja</label>
                            <input type="text" id="work_unit_name" name="name" class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <label>Kode</label>
                            <input type="text" id="work_unit_code" name="code" class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <label>PPK</label>
                            <select class="form-select" name="ppk" id="edit_ppk">
                                <option selected disabled value="">Pilih PPK...</option>
                                @foreach ($ppks as $ppk)
                                    <option value="{{ $ppk->id }}">{{ $ppk->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label>KEPALA UNIT
                                KERJA</label>
                            <select class="form-select" name="kepala" id="edit_kepala">
                                <option selected disabled value="">Pilih KEPALA UNIT
                                    KERJA...</option>
                                @foreach ($kepalas as $kepala)
                                    <option value="{{ $kepala->id }}">{{ $kepala->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Add other fields as needed -->
                        <button type="submit" class="btn btn-primary mt-3">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
        <script src="{{ asset('plugins/editors/quill/quill.js') }}"></script>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
        <script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/button-ext/jszip.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/button-ext/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/button-ext/buttons.print.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/pdfmake/vfs_fonts.js') }}"></script>


        <script>
            function openEditModal(id, name, code, ppk, kepala) {
                // Populate the form fields
                document.getElementById('work_unit_name').value = name;
                document.getElementById('work_unit_code').value = code;
                document.getElementById('edit_ppk').value = ppk;
                document.getElementById('edit_kepala').value = kepala;

                // Update the form action URL
                document.getElementById('edit-form').action = '/admin/pengaturan/unit-kerja/' + id + '/update';

                // Show the modal
                new bootstrap.Modal(document.getElementById('editModal')).show();
            }

            window.addEventListener('load', function() {
                feather.replace();
            })

            function confirmDelete(id) {
                Swal.fire({
                    title: 'Anda yakin ingin hapus?',
                    text: "Data tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            }

            function updateNumbering() {
                const missionInputs = document.querySelectorAll('#work_unit-inputs .input-group');
                missionInputs.forEach((input, index) => {
                    input.querySelector('.input-group-text').textContent = `${index + 1}.`;
                });
            }

            document.addEventListener('DOMContentLoaded', function() {
                $('#zero-config').DataTable({
                    "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex flex-column flex-sm-row justify-content-center align-items-center justify-content-sm-end mt-sm-0 mt-3'Bf>>>" +
                        "<'table-responsive'tr>" +
                        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                    "buttons": [{
                            text: 'PDF',
                            className: 'buttons-pdf buttons-html5 btn btn-danger',
                            action: function(e, dt, node, config) {
                                window.location.href = "{{ route('download.workunit.pdf') }}";
                            }
                        },
                        {
                            extend: 'excel',
                            text: 'Excel',
                            className: 'btn btn-success', // Warna biru
                            exportOptions: {
                                columns: [0, 1, 2] // Indeks kolom yang ingin Anda ekspor (dimulai dari 0)
                            },
                            filename: function() {
                                var d = new Date();
                                var n = d.toISOString();
                                return 'Excel_Export_' + n;
                            },
                        }
                    ],
                    "oLanguage": {
                        "oPaginate": {
                            "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                            "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                        },
                        "sInfo": "Showing page _PAGE_ of _PAGES_",
                        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                        "sSearchPlaceholder": "Search...",
                        "sLengthMenu": "Results :  _MENU_",
                    },
                    "drawCallback": function(settings) {
                        feather.replace();
                    },
                    "stripeClasses": [],
                    "lengthMenu": [7, 10, 20, 50],
                    "pageLength": 10
                });

                const workUnitContainer = document.getElementById('work_unit-inputs');

                document.getElementById('add-work_unit').addEventListener('click', function() {
                    const index = workUnitContainer.querySelectorAll('.input-group').length + 1;
                    const newInputGroup = `
                                <div class="input-group mb-2">
                                    <span class="input-group-text">${index}.</span>
                                    <input type="text" name="work_unit_name[]" class="form-control" placeholder="Nama Unit Kerja">
                                    <input type="text" name="work_unit_code[]" class="form-control" placeholder="Kode Unit Kerja">
                                    <button type="button" class="btn btn-danger remove-work_unit">
                                        <i data-feather="trash"></i>
                                    </button>
                                </div>`;
                    workUnitContainer.insertAdjacentHTML('beforeend', newInputGroup);
                    feather.replace();
                });

                workUnitContainer.addEventListener('click', function(event) {
                    if (event.target.classList.contains('remove-work_unit')) {
                        event.target.closest('.input-group').remove();
                        updateNumbering();
                    }
                });

                function updateNumbering() {
                    const inputGroups = workUnitContainer.querySelectorAll('.input-group');
                    inputGroups.forEach((group, index) => {
                        group.querySelector('.input-group-text').textContent = `${index + 1}.`;
                    });
                }
            });
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
    </x-base-layout>
