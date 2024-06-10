<div class="receipt">
    <div class="receipt-header">
        <h2>KUITANSI PEMBAYARAN LANGSUNG</h2>
    </div>
    <div class="receipt-body">
        <div class="section">
            <div class="table-container">
                <table class="fullwidth text-top" style="max-width: 50%">
                    <tr>
                        <td style="width: 120px">Tahun Anggaran</td>
                        <td>:</td>
                        <td style="width: 320px">{{ \Carbon\Carbon::parse($receipt->activity_date)->format('Y') }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Bukti</td>
                        <td>:</td>
                        <td>{{ $receipt->reference_number ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Mata Anggaran</td>
                        <td>:</td>
                        <td>{{ $receipt->mata_anggaran ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <br>
        <div class="section">
            <table class="fullwidth text-top">
                <tr>
                    <td style="width: 200px">Sudah Terima Dari</td>
                    <td style="10px">:</td>
                    <td>Pejabat Pembuat Komitmen IAIN SAS Babel</td>
                </tr>
                <tr>
                    <td>Jumlah Uang</td>
                    <td>:</td>
                    <td>{{ number_format($penerima['total'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Terbilang</td>
                    <td>:</td>
                    <td>{{ ucwords(terbilang($penerima['total'])) }} Rupiah</td>
                </tr>
                <tr>
                    <td>Untuk Pembayaran</td>
                    <td>:</td>
                    <td>{{ $receipt->description }}</td>
                </tr>
            </table>
        </div>
        <div class="height: 100px">&nbsp;</div>
        <div class="section fullwidth">
            <table class="text-top fullwidth">
                <tr>
                    @php
                        if ($receipt->type == 'direct') {
                            $width = [40, 10, 50];
                        } else {
                            $width = [50, 10, 40];
                        }
                    @endphp
                    <td style="width: {{ $width[0] }}%">An. Kuasa Pengguna Anggaran</td>
                    <td style="width: {{ $width[1] }}%"></td>
                    <td style="width: {{ $width[2] }}%">Bangka,
                        {{ \Carbon\Carbon::now()->translatedFormat('j F Y') }}
                    </td>
                </tr>
                <tr>
                    <td>Pejabat Pembuat Komitmen,
                    </td>
                    <td></td>
                    <td>{{ $receipt->type == 'direct' ? 'Penerima Uang,' : 'Bendahara Pengeluaran' }}
                    </td>
                </tr>
                <tr>
                    <td style="height: 90px"></td>

                </tr>
                <tr>
                    <td>{{ $receipt->ppk->name }}</td>
                    <td></td>
                    <td>{{ $receipt->type == 'direct' ? $penerima['name'] : $receipt->treasurer->name }}</td>
                </tr>
                <tr>
                    <td>{{ strtoupper($receipt->ppk->employee->identity_type) }}.
                        {{ $receipt->ppk->employee->id }}</td>
                    <td></td>
                    <td>{{ $receipt->type == 'direct' ? $penerima['sub'] ?? '' : strtoupper($receipt->treasurer->employee->identity_type) . '. ' . $receipt->treasurer->employee->id }}
                    </td>
                </tr>
            </table>
        </div>
        <hr>
        @if ($receipt->type == 'treasurer')
            <table class="text-top fullwidth">
                <tr>
                    <td style="width: 50%">
                        {{-- Penerima Uang --}}
                        Barang/pekerjaan telah diterima/diselesaikan dengan baik dan lengkap
                    </td>
                    <td style="width: 50%">
                    </td>
                </tr>
                <tr>
                    <td>Pejabat yang bertanggung jawab,</td>
                    <td></td>

                </tr>
                <tr>
                    <td style="height: 90px"></td>
                    <td style="height: 90px"></td>
                </tr>
                <tr>
                    <td>{{ $receipt->pelaksana->name }}</td>
                    <td>
                        {{-- {{ $penerima['name'] }} --}}
                    </td>
                </tr>
                <tr>
                    <td>{{ strtoupper($receipt->pelaksana->employee->identity_type) }}.
                        {{ strtoupper($receipt->pelaksana->employee->id) }}</td>
                    <td>
                        {{-- {{ $receipt->provider_organization ?? $penerima['sub'] }} --}}
                    </td>
                </tr>
            </table>
        @else
            <table class="text-top fullwidth">
                <tr>
                    <td style="width: 50%">Barang/pekerjaan telah diterima/diselesaikan dengan baik dan lengkap
                    </td>
                </tr>
                <tr>
                    <td>Pejabat yang bertanggung jawab,</td>
                </tr>
                <tr>
                    <td style="height: 90px"></td>
                </tr>
                <tr>
                    <td>{{ $receipt->type == 'direct' ? $penerima['name'] : $receipt->treasurer->name }}
                    </td>
                </tr>
                <tr>
                    <td>{{ $receipt->type == 'direct' ? $penerima['sub'] ?? '' : strtoupper($receipt->treasurer->employee->identity_type) . '. ' . $receipt->treasurer->employee->id }}
                    </td>
                </tr>
            </table>
        @endif
    </div>

</div>
