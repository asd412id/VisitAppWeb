<form action="{{ route('configs.update') }}" method="post" enctype="multipart/form-data">
  @csrf
  <div class="card ">
    <div class="card-header">INFORMASI UMUM</div>
    <div class="card-body">
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label>Nama ruang</label>
            <input type="text" class="form-control" name="config[nama_instansi]" value="{{ @$config->nama_instansi }}" placeholder="UPTD SMPN 39 Sinjai">
          </div>
          <div class="form-group">
            <label>Alamat/Telp/Kodepos</label>
            <textarea name="config[alamat]" rows="5" class="form-control" placeholder="{{ "Alamat: Jl. Persatuan Raya Dusun Bongki-Bongki Desa Bonto Sinala Kec. Sinjai Borong - 92662\nwebsite: www.smpn39sinjai.sch.id" }}">{{ old('config')['alamat']??@$config->alamat }}</textarea>
          </div>
          <div class="form-group">
            <label>Kota</label>
            <input type="text" class="form-control" name="config[kota]" value="{{ old('config')['kota']??@$config->kota }}" placeholder="Sinjai">
          </div>
          <div class="form-group">
            <label>Info Pimpinan</label>
            <textarea name="config[pimpinan]" rows="5" class="form-control" placeholder="{{ "Nama Pimpinan\nNIP. 19930323 201903 1 012" }}">{{ old('config')['pimpinan']??@$config->pimpinan }}</textarea>
          </div>
          <div class="form-group">
            <label>Kop Dokumen</label>
            <textarea name="config[kop]" rows="5" class="form-control" placeholder="{{ "PEMERINTAH KABUPATEN SINJAI\nDINAS PENDIDIKAN" }}">{{ old('config')['kop']??@$config->kop }}</textarea>
          </div>
          <div class="form-group">
            <label>Background Halaman Login</label>
            @if (@$config->login_bg)
              <a href="{{ route('configs.delete.img',['img'=>'login_bg']) }}" class="text-danger confirm" data-text="Hapus Background Login?">Hapus</a>
              <div class="clearfix"></div>
              <img src="{{ asset('uploaded/'.@$config->login_bg) }}" alt="" class="img-fluid" style="width: 100%;max-height: 250px;object-fit: cover">
              <div class="clearfix mb-2"></div>
            @endif
            <input type="file" name="login_bg" class="file-upload-default" accept=".jpeg,.jpg,.png">
            <div class="input-group col-xs-12">
              <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload jika ingin mengubah gambar background lama">
              <span class="input-group-append">
                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <label>Logo Instansi</label>
            @if (@$config->logo)
              <a href="{{ route('configs.delete.img',['img'=>'logo']) }}" class="btn-link text-danger confirm" data-text="Hapus Logo 1?">Hapus</a>
              <div class="clearfix"></div>
              <img src="{{ asset('uploaded/'.@$config->logo) }}" alt="" class="img-fluid rounded" width="150" height="225">
              <div class="clearfix mb-2"></div>
            @endif
            <input type="file" name="logo" class="file-upload-default" accept=".jpeg,.jpg,.png">
            <div class="input-group col-xs-12">
              <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload logo jika ingin mengubah logo lama">
              <span class="input-group-append">
                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer text-right">
      <button type="submit" class="btn btn-danger">SIMPAN PENGATURAN</button>
    </div>
  </div>
</form>
