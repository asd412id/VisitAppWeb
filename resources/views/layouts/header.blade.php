<header class="header-top" header-theme="dark">
  <div class="container-fluid">
    <div class="d-flex justify-content-between">
      <div class="top-menu d-flex align-items-center">
        <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
        <button type="button" id="navbar-fullscreen" class="nav-link"><i class="ik ik-maximize"></i></button>
      </div>
      <div class="top-menu d-flex align-items-center">
        <div class="dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="notiDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-bell"></i><span class="badge bg-danger {{ !count($notif)?'d-none':'' }}" id="notif-count">{{ count($notif) }}</span></a>
          <div class="dropdown-menu dropdown-menu-right notification-dropdown" aria-labelledby="notiDropdown">
            <h4 class="header">Pemberitahuan</h4>
            <div class="notifications-wrap">
              @if (count($notif))
                @foreach ($notif as $key => $nt)
                  <a href="{{ route('notif.show',['uuid'=>$nt->guest->uuid]) }}" class="media">
                    <span class="d-flex">
                      <i class="ik ik-check"></i>
                    </span>
                    <span class="media-body">
                      <span class="heading-font-family media-heading">{{ $nt->message }}</span>
                    </span>
                  </a>
                @endforeach
              @else
                <a href="javascript:void(0)" class="media" id="notif-none">
                  <span class="media-body">
                    <span class="heading-font-family media-heading">Tidak ada pemberitahuan terbaru</span>
                  </span>
                </a>
              @endif
              <a href="{{ route('notif.index') }}" class="media">
                <span class="media-body">
                  <span class="heading-font-family media-heading">Lihat Semua Pemberitahuan</span>
                </span>
              </a>
            </div>
          </div>
        </div>
        <div class="dropdown">
          <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="avatar" src="{{ $logo }}" alt=""></a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="{{ route('profile') }}"><i class="ik ik-settings dropdown-icon"></i> Pengaturan Akun</a>
            <a class="dropdown-item" href="{{ route('logout') }}"><i class="ik ik-power dropdown-icon"></i> Keluar</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
