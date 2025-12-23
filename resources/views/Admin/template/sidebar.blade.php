            <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="/Admin/Home">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Main
            </div>


          

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Barang</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Barang:</h6>
                        <a class="collapse-item" href="/Admin/Barang/DataBarang">Data Barang</a>
                        <a class="collapse-item" href="/Admin/Barang/Kategori">Kategori Barang</a>
                        <a class="collapse-item" href="/Admin/Barang/BarangOff">Barang Off</a>
                       
                    </div>
                </div>
            </li>
                  <!-- Nav Item - Charts -->
             <li class="nav-item">
                <a class="nav-link" href="/Admin/Pembelian">
                    <i class="fas fa-fw fa-cart-plus"></i>
                    <span>Pembelian Barang</span></a>
            </li> 

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Penjualan</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Penjualan:</h6>
                         {{-- <a class="collapse-item" href="/Admin/PO/DataPO">Data Purchase Order</a>
                        <a class="collapse-item" href="/Admin/PreOrder/AddPreOrder">Input Purchase Order</a> --}}
                        <a class="collapse-item" href="/Admin/Sales/WorkOrder">Work Order</a>
                        <a class="collapse-item" href="/Admin/Sales/Nota">Nota</a>
                        <a class="collapse-item" href="/Admin/Sales/Sales">Laporan Penjualan</a>
                        
                    </div>
                </div>
            </li>

           
            <li class="nav-item">
                <a class="nav-link" href="/Admin/laporan">
                    <i class="fas fa-fw fa-calculator"></i>
                    <span>Laporan</span></a>
            </li>

             <li class="nav-item">
                <a class="nav-link" href="/Admin/JurnalManual">
                    <i class="fas fa-fw fa-bookmark"></i>
                    <span>Jurnal Manual</span></a>
            </li> 




            

                <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Stock</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Stock:</h6>
                        <a class="collapse-item" href="/Admin/JumlahStokBarang">Jumlah Stok Barang</a>
                        <a class="collapse-item" href="/Admin/StokControll">Stok Control</a>
                       
                    </div>
                </div>
            </li>



               <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="/Admin/Rekanan">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Rekanan</span></a>
            </li>


              <li class="nav-item">
                <a class="nav-link" href="/Admin/ChartOfAccount">
                    <i class="fas fa-fw fa-balance-scale"></i>
                    <span>Chart Of Account</span></a>
            </li>

              <li class="nav-item">
                <a class="nav-link" href="/Admin/metodepembayaran">
                    <i class="fa fa-credit-card" aria-hidden="true"></i>
                    <span>Metode Pembayaran</span></a>
            </li>

          
              <li class="nav-item">
                <a class="nav-link" href="/Admin/Operator">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Operator</span></a>



            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


           
     

        </ul>
        <!-- End of Sidebar -->