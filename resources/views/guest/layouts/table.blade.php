<div class="dt-responsive">
  <table class="table table-bordered table-guest">
    <thead class="nowrap">
    <tr>
      @if (count($data)>1 || request()->start_date!=request()->end_date)
        <th>Tanggal</th>
      @endif
      <th width="155">Nama</th>
      <th>Pekerjaan</th>
      <th>No. Telp</th>
      <th>Alamat</th>
      <th>Ruang/Bidang</th>
      <th>Tujuan</th>
      <th>Status</th>
      <th>Oleh</th>
    </tr>
    </thead>
    <tbody>
      @foreach ($data as $key => $d)
        <tr>
          @if (count($data)>1 || request()->start_date!=request()->end_date)
            <td rowspan="{{ count($d['data']) }}">{{ $d['tanggal']->locale('id')->translatedFormat('l, d/m/Y') }}</td>
          @endif
          @foreach ($d['data'] as $key => $g)
            <td>
              <strong>{{ $g->nama }}</strong>
              @if ($g->anggota && count($g->anggota))
                <br><span style="text-decoration: underline">bersama dengan:</span>
                <ol style="margin: 0;padding: 0 15px;">
                  @foreach ($g->anggota as $k1 => $ag)
                    <li>{{ $ag }}</li>
                  @endforeach
                </ol>
              @endif
            </td>
            <td>{{ $g->pekerjaan }}</td>
            <td class="nowrap">{{ $g->telp }}</td>
            <td>{{ $g->alamat }}</td>
            <td>{{ $g->ruang->nama }}</td>
            <td>{{ $g->tujuan }}</td>
            <td>
              @if (is_null($g->status))
                Belum Dikonfirmasi
              @else
                <b style="text-decoration: underline">{{ $g->status?'Diterima':'Ditolak' }}</b>
              @endif
              <br>
              <b>Keterangan:</b><br>
              <em>{{ $g->keterangan }}</em>
            </td>
            <td>{{ $g->approved_by }}</td>
            @break
          @endforeach
          @php
          array_shift($d['data']);
          @endphp
        </tr>
        @if (count($d['data']))
          @foreach ($d['data'] as $key => $g)
            <tr>
              <td>
                <strong>{{ $g->nama }}</strong>
              </td>
              <td>{{ $g->pekerjaan }}</td>
              <td class="nowrap">{{ $g->telp }}</td>
              <td>{{ $g->alamat }}</td>
              <td>{{ $g->ruang->nama }}</td>
              <td>{{ $g->tujuan }}</td>
              <td>
                @if (is_null($g->status))
                  Belum Dikonfirmasi
                @else
                  <b style="text-decoration: underline">{{ $g->status?'Diterima':'Ditolak' }}</b>
                @endif
                <br>
                <b>Keterangan:</b><br>
                <em>{{ $g->keterangan }}</em>
              </td>
              <td>{{ $g->approved_by }}</td>
            </tr>
          @endforeach
        @endif
      @endforeach
    </tbody>
  </table>
</div>
