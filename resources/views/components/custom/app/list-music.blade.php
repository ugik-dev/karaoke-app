<div class="card-body">
    <div class="table-responsive">
        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <div class="row">
                <div class="col-sm-12">
                    <table id="datatable" class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Artis</th>
                                <th>Genre</th>
                                <th>Negara</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
        var dataRow = [];
        var status_slect2 = false;
        datatable = $('#datatable').DataTable({
            processing: true,
            paggination: true,
            responsive: false,
            serverSide: true,
            searching: true,
            ordering: true,
            ajax: {
                url: "{{ route('app.search-music') }}",
                dataSrc: function(response) {
                    dataRes = response.data;
                    dataRow = [];
                    dataRes.forEach(function(data) {
                        dataRow[data.id] = data;
                    });
                    return response.data;
                }
            },
            columns: [{
                data: "title",
                name: "title"
            }, {
                data: "artist",
                name: "artist"
            }, {
                data: "country",
                name: "country"
            }, {
                data: "genre",
                name: "genre"
            }, {
                data: "aksi",
                name: "aksi"
            }]
        });
        $('#datatable tbody').on('click', 'tr', function() {
            console.log('clicked')
            var data = datatable.row(this).data();
            console.log(data)
            var musicId = data.id; // Assuming 'id' is available in your data

            // Perform the GET request
            $.ajax({
                url: '/app/play/' + musicId, // Adjust this route accordingly
                type: 'GET',
                success: function(response) {
                    // Handle the response from the server
                    console.log(response.videoHtml);
                    $('#videoContainer').html(response.videoHtml);
                    $('#videoModal').show();
                    $('#videoPlayer')[0].play();
                },
                error: function(xhr, status, error) {
                    // Handle any errors
                    console.error(error);
                }
            });
        });
    })
</script>
