<!-- MAIN -->
        <div class="main">
            <!-- MAIN CONTENT -->
            <div class="main-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Hasil Perhitungan Fuzzy SAW</h1> 
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Ranking Sifat Tanah
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="Tahun">Tahun</label>
                                                <?php 
                                                    $thn = []; 
                                                    foreach ( $tahun as $row ) {
                                                        $thn[$row->{'year(create_at)'}] = $row->{'year(create_at)'};
                                                    }
                                                    echo form_dropdown('tahun', $thn, date('Y'), ['id' => 'tahun', 'class' => 'form-control']);
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Kode Lab</th>
                                                <!-- <th>Kode Sampel</th> -->
                                                <th>Nama Tanaman</th>
                                                <th>Tahun Tanaman</th>
                                                <th>Hasil</th>
                                            </tr>
                                        </thead>
                                        <tbody id="data-perhitungan">
                                            <?php foreach ($hasil as $row): ?>
                                                <tr>
                                                    <td><?= $row['kode_lab'] ?></td>
                                                    <!-- <td><?= $row['kode_sampel'] ?></td> -->
                                                    <td><?= $row['nama_tanaman'] ?></td>
                                                    <td><?= $row['tahun_tanaman'] ?></td>
                                                    <td><?= $row['hasil'] ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <a class="btn btn-success" href="<?= base_url('kepala-bagian/laporan-cara-perhitungan') ?>"><i class="fa fa-download"></i> Unduh Laporan</a>
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#dataTables-example').dataTable({
                    ordering: false,
                    filter:false
                });

                $( '#tahun' ).on('change', function() {

                    var tahun = $(this).val();
                    // ajax disini
                    $.ajax({
                        url: '<?= base_url('kepala-bagian/hasil') ?>',
                        type: 'POST',
                        data: {
                            tahun: tahun,
                            ubah: true
                        },
                        success: function(response) {
                            var json = $.parseJSON(response);
                            $('#data-perhitungan').html('');
                            var html = '';

                            for ( var i = 0; i < json.length; i++ ) {
                                html += '<tr>' +
                                '<td>' + json[i].kode_lab + '</td>' +
                                '<td>' + json[i].nama_tanaman + '</td>' +
                                '<td>' + json[i].tahun_tanaman + '</td>' +
                                '<td>' + json[i].hasil + '</td>' +
                            '</tr>';
                            }
                            $('#data-perhitungan').html(html);
                        },
                        error: function( error ) {
                            console.log(error.responseText);
                        }
                    });   
                });
            });
        </script>