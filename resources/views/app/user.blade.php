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
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

        <style>
            .input-group .toggle-password {
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
                border-right: 0;
            }

            /* td,
            th {
                border-radius: 0px !important;
            } */

            .table {
                thead tr th {
                    font-size: 10px !important;
                }

                /* Tambahkan CSS khusus untuk border radius */


                tbody tr td {
                    font-size: 10px !important;
                }

                tbody .btn-sm {
                    height: 25.6px;
                    width: 56.6px;
                }
            }

            a.text-danger {
                transition: color 0.3s ease;
            }

            a.text-danger:hover {
                color: #dc3545;
            }

            /* .icon-trash {
                width: 30px;
                height: 30px;
                color: #dc3545;
            } */

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
            <x-custom.statbox>
                <x-custom.alerts />

                <div class="table-responsive px-4">
                    <div class="me-1 mt-4">
                        <button type="button" class="btn btn-primary btn-md w-20" data-bs-toggle="modal"
                            data-bs-target="#createModal">
                            Input User
                        </button>
                    </div>
                    <table id="user-table" class="table table-bordered">
                        <thead class="bg-primary text-center">
                            <tr>
                                <th scope="col" style="width:40px;">No.</th>
                                <th scope="col">User Role</th>
                                <th scope="col">Nama Lengkap</th>
                                <th scope="col">NIP/NIK/NIDN</th>
                                <th scope="col">Jabatan</th>
                                <th scope="col">Unit Kerja</th>
                                <th scope="col">Email</th>
                                <th scope="col" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td style="width:40px;">{{ $loop->iteration }}</td>
                                    <td>
                                        @foreach ($user->roles as $role)
                                            <span>{{ $role->name }}</span>{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->employee->id ?? '-' }}</td>
                                    <td>{{ $user->employee->position ?? '-' }}</td>
                                    {{-- @dd($user->employee->workUnit) --}}
                                    <td>{{ $user->employee->workUnit->name ?? '-' }}</td>
                                    <td>{{ $user->email ?? '-' }}
                                        ({{ $user->email_verified_at ? 'Terverifikasi' : 'Belum Terverifikasi' }})</td>
                                    <td class="text-start">
                                        {{-- <button type="button" class="btn btn-sm btn-info"
                                            data-bs-target="#changePasswordModal" data-bs-toggle="modal">
                                            <i data-feather="key"></i>
                                        </button> --}}
                                        <button type="button"
                                            class="btn btn-primary btn-sm d-flex align-items-center my-1"
                                            data-bs-target="#editModal" data-bs-toggle="modal"
                                            data-user="{{ $user }}"
                                            data-update-url="{{ route('user.update', $user) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="feather feather-edit-2">
                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                </path>
                                            </svg>
                                        </button>

                                        <a href="javascript:void(0);"
                                            class="btn btn-danger btn-sm d-flex align-items-center my-1" role="button"
                                            onclick="confirmDelete({{ $user->id }});">
                                            <i class="text-white" data-feather="trash-2"></i>
                                        </a>
                                        <!-- Hidden form for delete request -->
                                        <form id="delete-form-{{ $user->id }}"
                                            action="{{ route('user.delete', $user->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                        <a href="javascript:void(0);"
                                            class="btn btn-success btn-sm d-flex align-items-center my-1"
                                            style="font-size:4px" role="button"
                                            onclick="resendMail({{ $user->id }});">
                                            <i class="text-white" data-feather="send"></i>
                                        </a>
                                        <!-- Hidden form for delete request -->
                                        <form id="resend-form-{{ $user->id }}"
                                            action="{{ route('user.resend-mail', $user->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('POST')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-custom.statbox>
        </div>
    </div>
    <x-modal modalId="createModal" modalTitle="Tambahkan User" size="lg">
        <x-user.create-form :workUnits="$work_units" :identityTypes="$identity_types" :roles="$roles" />
    </x-modal>
    <x-modal modalId="editModal" modalTitle="Edit User">
        <x-user.edit-form :workUnits="$work_units" :identityTypes="$identity_types" :roles="$roles" />
    </x-modal>
    <!-- TODO: Finish Change Password -->
    {{-- <x-modal modalId="changePasswordModal" modalTitle="Ganti Password">
        <form id="form-change-password" action="" method="post" autocomplete="off">
            @csrf
            <label class="form-label">Password</label>
            <div class="input-group has-validation">
                <input name="password" type="password" class="form-control" id="password-field"
                    autocomplete="new-password" required>
                <span class="input-group-text">
                    <i data-feather="eye" class="feather icon-eye" id="togglePassword" style="cursor: pointer;"></i>
                </span>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-warning my-3">Ganti Password</button>
        </form>
    </x-modal> --}}


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
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            window.addEventListener('load', function() {
                feather.replace();
            })

            function resendMail(id) {
                Swal.fire({
                    title: "Anda yakin?",
                    icon: "warning",
                    showCancelButton: true,
                    // confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Kirim!",
                    cancelButtonText: "Batalkan",
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("resend-form-" + id).submit();
                    }
                });
            }
            document.addEventListener('DOMContentLoaded', function() {

                $("#changePasswordModal").on('shown.bs.modal', function() {
                    document.getElementById('togglePassword').addEventListener('click', function(e) {
                        // toggle the type attribute
                        const password = document.getElementById('password-field');
                        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                        password.setAttribute('type', type);
                        // toggle the eye / eye off icon
                        this.classList.toggle('feather-icon-eye-off');
                    });
                })
                $('#user-table').DataTable({
                    "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex flex-column flex-sm-row justify-content-center align-items-center justify-content-sm-end mt-sm-0 mt-3'Bf>>>" +
                        "<'table-responsive'tr>" +
                        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                    "buttons": [{
                            text: 'PDF',
                            className: 'buttons-pdf buttons-html5 btn btn-danger',
                            action: function(e, dt, node, config) {
                                window.location.href = "{{ route('download.user.pdf') }}";
                            }
                        },
                        {
                            extend: 'excel',
                            text: 'Excel',
                            className: 'btn btn-success', // Warna biru
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            },
                            filename: function() {
                                var d = new Date();
                                var n = d.toISOString();
                                return 'User_Data_' + n;
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
                    // "responsive": true,
                    // "scrollX": true,
                    // "columnDefs": [{
                    //         width: '40px',
                    //         targets: 0
                    //     }, // Mengatur lebar kolom 'No.'
                    //     {
                    //         width: '150px',
                    //         targets: 1
                    //     } // Contoh: Menetapkan lebar untuk kolom 'User Role'
                    //     // Tambahkan pengaturan lebar lebih lanjut untuk kolom lain jika diperlukan
                    // ],
                    "scrollX": true,
                    "scrollY": '368px',
                    "scrollCollapse": true,
                    " paging": false,
                    "stripeClasses": [],
                    "lengthMenu": [7, 10, 20, 50],
                    "pageLength": 10
                });
                $("#createModal").on('shown.bs.modal', async function(e) {
                    const formCreate = $("#form-create");
                    formCreate.find('#selectHeadOf').select2({
                        dropdownParent: formCreate.find('.headOfWrapper'),
                        placeholder: 'Pilih Staff',
                        theme: 'bootstrap-5',
                        ajax: {
                            transport: function(params, success, failure) {
                                axios.get(`{{ route('employees.heads') }}`, {
                                        params: {
                                            search: params.data.term,
                                            limit: 10
                                        }
                                    })
                                    .then(function(response) {
                                        success({
                                            results: response.data.map(function(
                                                item) {
                                                return {
                                                    id: item.id,
                                                    text: item.name +
                                                        ' - ' +
                                                        item
                                                        .id
                                                };
                                            })
                                        });
                                    })
                                    .catch(function(error) {
                                        // Call the `failure` function in case of an error
                                        failure(error);
                                    });
                            },
                            delay: 250,
                            cache: true
                        }
                    });
                    formCreate.find('#selectTypeRole').val('').trigger('change');
                    formCreate.find('#selectTypeRole').on('change', function() {
                        if (formCreate.find('#selectTypeRole').val() == 'PPK') {
                            formCreate.find('#selectHeadOf').prop('disabled', false)
                            formCreate.find('#letter_reference').prop('disabled', false)
                        } else {
                            formCreate.find('#selectHeadOf')
                                .val('', '')
                                .trigger('change')
                                .prop('disabled', true)
                            formCreate.find('#letter_reference').prop('disabled', true)
                        }
                    })
                })
                $("#editModal").on('shown.bs.modal', async function(e) {
                    let updateUrl = $(e.relatedTarget).data('updateUrl');
                    const formEdit = $("#form-edit");
                    const user = $(e.relatedTarget).data('user');
                    formEdit.attr('action', updateUrl);
                    formEdit.find('#selectTypeRole').val(user.roles[0].name ?? null).trigger('change');
                    formEdit.find('input[name="user_name"]').val(user.name);
                    formEdit.find('input[name="position"]').val(user.employee?.position);
                    formEdit.find('input[name="identity_number"]').val(user.employee?.id);
                    formEdit.find('#selectWorkUnit').val(user.employee?.work_unit_id ?? null);
                    formEdit.find('input[name="email"]').val(user.email);
                    formEdit.find('#selectIdentityType').val(user.employee?.identity_type);
                    formEdit.find('#inputPassword').val('');


                    formEdit.find('input[name="letter_reference"]').val(user.employee?.letter_reference);

                    console.log(user);
                    if (user.roles[0].name == 'PPK') {
                        var selectedTreasurerOption = new Option(
                            `${user.employee?.head_id  ?? ''} `,
                            user.employee?.head_id ?? null, true, true);
                        formEdit.find('#editSelectStaff').append(selectedTreasurerOption).trigger('change');

                    } else {
                        formEdit.find('#letter_reference').prop('disabled', true)
                    }
                    formEdit.find('#editSelectStaff').select2({
                        dropdownParent: formEdit.find('.staffWrapper'),
                        placeholder: 'Pilih PPK',
                        theme: 'bootstrap-5',
                        ajax: {
                            transport: function(params, success, failure) {
                                axios.get(`{{ route('employees.heads') }}`, {
                                        params: {
                                            search: params.data.term,
                                            limit: 10
                                        }
                                    })
                                    .then(function(response) {
                                        success({
                                            results: response.data.map(function(
                                                item) {
                                                return {
                                                    id: item
                                                        .id,
                                                    text: item.name +
                                                        ' - ' +
                                                        item
                                                        .id
                                                };
                                            })
                                        });
                                    })
                                    .catch(function(error) {
                                        failure(error);
                                    });
                            },
                            delay: 250,
                            cache: true
                        }
                    });
                    formEdit.find('#selectTypeRole').on('change', function() {
                        if (formEdit.find('#selectTypeRole').val() == 'PPK') {
                            formEdit.find('#editSelectStaff').prop('disabled', false)
                            formEdit.find('input[name="letter_reference"]').prop('disabled', false)
                        } else {
                            formEdit.find('input[name="letter_reference"]').prop('disabled', true)
                            formEdit.find('#editSelectStaff')
                                .val('', '')
                                .trigger('change')
                                .prop('disabled', true)

                        }
                    }).trigger('change')

                });
            });
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
    </x-base-layout>
