<div class="dt-responsive">
  <table class="table table-bordered table-guest">
    <thead class="nowrap">
      @if (count($data)>1 || request()->start_date!=request()->end_date)
        <th>Tanggal</th>
      @endif
      <th width="50">Waktu</th>
      <th width="235">Nama</th>
      <th width="200">Pekerjaan</th>
      <th>No. Telp</th>
      <th width="200">Alamat</th>
      <th width="200">Tujuan</th>
      <th width="200">Rating/Kesan</th>
    </thead>
    <tbody>
      @foreach ($data as $key => $d)
        <tr>
          @if (count($data)>1 || request()->start_date!=request()->end_date)
            <td rowspan="{{ count($d['data']) }}">{{ $d['tanggal']->locale('id')->translatedFormat('l, d/m/Y') }}</td>
          @endif
          @foreach ($d['data'] as $key => $g)
            <td class="text-center nowrap">{{ $g->cin->format('H:i').($g->cout?' - '.$g->cout->format('H:i'):null) }}</td>
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
            <td>{{ $g->tujuan }}</td>
            <td>Rating: <strong style="text-decoration: underline">{{ $g->rating_text??'Tidak ada' }}</strong><br>{{ $g->kesan }}</td>
            @break
          @endforeach
          @php
          array_shift($d['data']);
          @endphp
        </tr>
        @if (count($d['data']))
          @foreach ($d['data'] as $key => $g)
            <tr>
              <td class="text-center nowrap">{{ $g->cin->format('H:i').($g->cout?' - '.$g->cout->format('H:i'):null) }}</td>
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
              <td>{{ $g->tujuan }}</td>
              <td>Rating: <strong style="text-decoration: underline">{{ $g->rating_text??'Tidak ada' }}</strong><br>{{ $g->kesan }}</td>
            </tr>
          @endforeach
        @endif
      @endforeach
    </tbody>
  </table>
</div>
