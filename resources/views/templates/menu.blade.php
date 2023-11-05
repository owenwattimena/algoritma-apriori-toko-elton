<ul class="nav">
    <li class="nav-item nav-category">Menu</li>
    <li class="nav-item">
      <a href="dashboard.html" class="nav-link">
        <i class="link-icon" data-feather="box"></i>
        <span class="link-title">Dashboard</span>
      </a>
    </li>
    {{-- <li class="nav-item nav-category">Master</li> --}}
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#transaksi" role="button" aria-expanded="false" aria-controls="transaksi">
        <i class="link-icon" data-feather="dollar-sign"></i>
        <span class="link-title">Transaksi</span>
        <i class="link-arrow" data-feather="chevron-down"></i>
      </a>
      <div class="collapse" id="transaksi">
        <ul class="nav sub-menu">
          <li class="nav-item">
            <a href="{{ route('transaksi.penjualan') }}" class="nav-link">Penjulaan</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('transaksi.pembelian') }}" class="nav-link">Pembelian</a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#master" role="button" aria-expanded="false" aria-controls="master">
        <i class="link-icon" data-feather="list"></i>
        <span class="link-title">Master</span>
        <i class="link-arrow" data-feather="chevron-down"></i>
      </a>
      <div class="collapse" id="master">
        <ul class="nav sub-menu">
          <li class="nav-item">
            <a href="{{ route('master.kategori') }}" class="nav-link">Kategori</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('master.satuan') }}" class="nav-link">Satuan</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('master.produk') }}" class="nav-link">Produk</a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a href="pages/apps/chat.html" class="nav-link">
        <i class="link-icon" data-feather="file-text"></i>
        <span class="link-title">Laporan</span>
      </a>
    </li>
    {{-- <li class="nav-item">
      <a href="pages/apps/calendar.html" class="nav-link">
        <i class="link-icon" data-feather="calendar"></i>
        <span class="link-title">Calendar</span>
      </a>
    </li> --}}

  </ul>
