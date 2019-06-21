
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Minden jog fenntartva &copy; Opibus 2019</span>
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
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Biztosan kijelentkezel?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Válassza a kijelentkezés funkciót, ha biztosan ki akar jelentkezni.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Mégse</button>
          <a class="btn btn-primary" href="/kijelentkezes">Kijelentkezés</a>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Bootstrap core JavaScript-->
  <script src="/assets/jquery/jquery.min.js"></script>
  <script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="/assets/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="/assets/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="/assets/chart.js/Chart.min.js"></script>

  <script src="/assets/datatables/jquery.dataTables.min.js"></script>
  <script src="/assets/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="/assets/datetimepicker-master/jquery.datetimepicker.js"></script>
  <script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="/assets/jquery/datepicker-hu.js"></script>
  <script src="/assets/jsmultiselect/jquery.dropdown.min.js"></script>


  <script>
  datatable = $("#table").DataTable();
  </script>
  @include("ckfinder::setup")
  @yield("scripts")
</body>

</html>
