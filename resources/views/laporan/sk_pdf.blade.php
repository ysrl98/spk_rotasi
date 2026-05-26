<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keputusan Mutasi Kejaksaan Negeri</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 20px 40px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 16pt;
            margin: 0;
            text-transform: uppercase;
        }
        .header h2 {
            font-size: 14pt;
            margin: 5px 0 0 0;
            text-transform: uppercase;
        }
        .header p {
            font-size: 10pt;
            margin: 5px 0 0 0;
        }
        .title {
            text-align: center;
            margin-bottom: 20px;
        }
        .title h3 {
            font-size: 14pt;
            text-decoration: underline;
            margin: 0;
        }
        .title p {
            margin: 5px 0 0 0;
        }
        .content {
            margin-bottom: 30px;
        }
        .content table {
            width: 100%;
            border-collapse: collapse;
        }
        .content table.konsideran {
            margin-bottom: 20px;
        }
        .content table.konsideran td {
            vertical-align: top;
            padding: 2px 5px;
        }
        .content table.konsideran td:first-child {
            width: 100px;
            font-weight: bold;
        }
        .content table.konsideran td:nth-child(2) {
            width: 10px;
        }
        .tabel-pegawai {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 11pt;
        }
        .tabel-pegawai th, .tabel-pegawai td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        .tabel-pegawai th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .signature {
            float: right;
            width: 300px;
            text-align: center;
            margin-top: 40px;
        }
        .signature p {
            margin: 0;
        }
        .signature .name {
            margin-top: 70px;
            font-weight: bold;
            text-decoration: underline;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>KEJAKSAAN REPUBLIK INDONESIA</h1>
        <h2>KEJAKSAAN NEGERI BANJARMASIN</h2>
        <p>Jl. Brigjend H. Hasan Basry No.3, Kec. Banjarmasin Utara, Kota Banjarmasin, Kalimantan Selatan 70123</p>
    </div>

    <div class="title">
        <h3>SURAT KEPUTUSAN KEPALA KEJAKSAAN NEGERI BANJARMASIN</h3>
        <p>Nomor: KEP-......./O.3.10/..../{{ Carbon\Carbon::now()->format('Y') }}</p>
        <br>
        <p>TENTANG</p>
        <p><strong>PEMBERHENTIAN DAN PENGANGKATAN DARI DAN DALAM JABATAN STRUKTURAL<br>DI LINGKUNGAN KEJAKSAAN NEGERI BANJARMASIN</strong></p>
    </div>

    <div class="content">
        <table class="konsideran">
            <tr>
                <td>Menimbang</td>
                <td>:</td>
                <td>
                    <ol type="a" style="margin:0; padding-left:20px;">
                        <li>bahwa untuk kepentingan dinas dan peningkatan kinerja kelembagaan, perlu dilakukan mutasi/rotasi pejabat di lingkungan Kejaksaan Negeri Banjarmasin;</li>
                        <li>bahwa Pegawai Negeri Sipil yang namanya tercantum dalam lajur 2 (dua) Keputusan ini dipandang cakap dan memenuhi syarat untuk diangkat dalam jabatan sebagaimana tercantum dalam lajur 5 (lima) Keputusan ini;</li>
                    </ol>
                </td>
            </tr>
            <tr>
                <td>Mengingat</td>
                <td>:</td>
                <td>
                    <ol style="margin:0; padding-left:20px;">
                        <li>Undang-Undang Nomor 16 Tahun 2004 tentang Kejaksaan Republik Indonesia;</li>
                        <li>Undang-Undang Nomor 20 Tahun 2023 tentang Aparatur Sipil Negara;</li>
                        <li>Peraturan Presiden Republik Indonesia Nomor 38 Tahun 2010 tentang Organisasi dan Tata Kerja Kejaksaan Republik Indonesia;</li>
                    </ol>
                </td>
            </tr>
            <tr>
                <td>Memperhatikan</td>
                <td>:</td>
                <td>Hasil penilaian Kinerja (SPK Profile Matching) dan Pertimbangan Tim Penilai Kinerja Kejaksaan Negeri Banjarmasin.</td>
            </tr>
        </table>

        <div style="text-align: center; font-weight: bold; margin: 30px 0 10px 0;">MEMUTUSKAN:</div>

        <table class="konsideran">
            <tr>
                <td>Menetapkan</td>
                <td>:</td>
                <td><strong>KEPUTUSAN KEPALA KEJAKSAAN NEGERI BANJARMASIN TENTANG PEMBERHENTIAN DAN PENGANGKATAN DARI DAN DALAM JABATAN STRUKTURAL.</strong></td>
            </tr>
        </table>

        <table class="tabel-pegawai">
            <thead>
                <tr>
                    <th width="5%">NO</th>
                    <th width="25%">NAMA / NIP</th>
                    <th width="20%">PANGKAT / GOL.</th>
                    <th width="25%">JABATAN LAMA</th>
                    <th width="25%">JABATAN BARU</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasilRotasi as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="text-align: left;">
                        <strong>{{ $row->pegawai->nama }}</strong><br>
                        NIP. {{ $row->pegawai->nip }}
                    </td>
                    <td>{{ $row->pegawai->pangkat }} <br> ({{ $row->pegawai->golongan }})</td>
                    <td>{{ $row->pegawai->jabatan->nama_jabatan ?? 'Staf / Fungsional' }}</td>
                    <td><strong>{{ $row->jabatan->nama_jabatan }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px; text-indent: 50px;">
            Keputusan ini mulai berlaku pada tanggal ditetapkan, dengan ketentuan apabila di kemudian hari terdapat kekeliruan dalam keputusan ini, akan diadakan perbaikan sebagaimana mestinya.
        </div>
    </div>

    <div class="clearfix">
        <div class="signature">
            <p>Ditetapkan di : Banjarmasin</p>
            <p>Pada tanggal : {{ $tanggal_sk }}</p>
            <p><strong>KEPALA KEJAKSAAN NEGERI BANJARMASIN</strong></p>
            
            <p class="name">NAMA KEPALA KEJARI</p>
            <p>Jaksa Utama Pratama NIP. 19700101XXXXXXXXX</p>
        </div>
    </div>

</body>
</html>
