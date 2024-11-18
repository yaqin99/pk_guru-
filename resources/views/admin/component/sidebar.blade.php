<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">Daftar Menu</li>
            
           
            <li><a href="/" aria-expanded="false"><i class="bi bi-house"></i>
                <span class="nav-text">Dashboard</span></a>
            </li>
            @if (Auth::user()->role == 2)
            <li><a href="/guru" aria-expanded="false"><i class="bi bi-person-fill"></i><span
                class="nav-text">Data Guru</span></a>
             </li>
            @endif
            
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="bi bi-file-earmark-bar-graph"></i>
            </i><span class="nav-text">Data Kinerja</span></a>
            <ul aria-expanded="false">
                <li><a href="/pengajuan">Data Pengajuan</a></li>
                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Data Aspek Mengajar</a>
                    <ul aria-expanded="false">
                        <li><a href="/aspek/pedagogik">Pedagogik</a></li>
                        <li><a href="/aspek/kepribadian">Kepribadian</a></li>
                        <li><a href="/aspek/profesional">Profesional</a></li>
                        <li><a href="/aspek/sosial">Sosial</a></li>
                    </ul>
                </li>
            </ul>
            </li>
            
            <li><a href="/surat" aria-expanded="false"><i class="bi bi-envelope"></i><span
                        class="nav-text">Data Surat</span></a>
            </li>
        </ul>
    </div>
</div>