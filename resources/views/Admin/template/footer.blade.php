 <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('/') }}vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('/') }}vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('/') }}vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('/') }}js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('/') }}vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('/') }}js/demo/chart-area-demo.js"></script>
    <script src="{{ asset('/') }}js/demo/chart-pie-demo.js"></script>
      <script src="{{ asset('/') }}vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('/') }}vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
    <script src="{{ asset('/') }}js/demo/datatables-demo.js"></script>

    <!-- Tom Select JS -->
    <script src="{{asset('/')}}js/tomselect.js"></script>
    
<script>
    new TomSelect("#Dropdown-data", {
        create: false, 
        sortField: {
            field: "text",
            direction: "asc"
        },
        maxItems: 1
        
    });
</script>

@yield('scripts')

</body>



</html>

<style>
.select-button-style {
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  padding: 0.5rem 1.5rem;
  background-color: #4d90f5;
  color: white;
  border: none;
  border-radius: 9999px;
  font-weight: 500;
  padding-right: 2.5rem;
  position: relative;
}

.select-wrapper {
  position: relative;
  display: inline-block;
}

.select-wrapper::after {
  content: "▼"; /* Panah ▼ Unicode */
  position: absolute;
  right: 1rem;
  top: 50%;
  transform: translateY(-50%);
  pointer-events: none;
  color: white;
  font-size: 0.7rem;
}
</style>


                                                        <script>
                                                        function handleSelectRedirect(selectElement) {
                                                            const selectedUrl = selectElement.value;
                                                            if (selectedUrl) {
                                                            window.location.href = selectedUrl;
                                                            }
                                                        }
                                                        </script>


