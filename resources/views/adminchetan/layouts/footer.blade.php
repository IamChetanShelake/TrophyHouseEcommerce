<!-- ========= FOOTER ========= -->
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
                        Copyright&nbsp;©&nbsp;{{ now()->format('Y') }}
                        <a href="#" target="_relative">Trophy House</a>. All rights reserved.
                    </span>
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
                        Hand-crafted&nbsp;&amp;&nbsp;made with <i class="mdi mdi-heart text-danger"></i>
                        by TechMET&nbsp;IT&nbsp;Solutions&nbsp;PVT.&nbsp;LTD
                    </span>
                </div>
            </footer>
            <!-- ========= /FOOTER ========= -->
        </div><!-- /main-panel -->
    </div><!-- /page-body-wrapper -->
</div><!-- /container-scroller -->

{{-- ========== CORE JS BUNDLE ========== --}}
<script src="{{ asset('admin/assets/vendors/js/vendor.bundle.base.js') }}"></script>

{{-- ========== PAGE-LEVEL VENDORS ========== --}}
<script src="{{ asset('admin/assets/vendors/chart.js/chart.umd.js') }}"></script>
<script src="{{ asset('admin/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

{{-- ========== TEMPLATE HELPERS ========== --}}
<script src="{{ asset('admin/assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('admin/assets/js/misc.js') }}"></script>
<script src="{{ asset('admin/assets/js/settings.js') }}"></script>
<script src="{{ asset('admin/assets/js/todolist.js') }}"></script>
<script src="{{ asset('admin/assets/js/jquery.cookie.js') }}"></script>

{{-- ========== PAGE-SPECIFIC HELPERS ========== --}}
<script src="{{ asset('admin/assets/js/dashboard.js') }}"></script>
<script src="{{ asset('admin/assets/js/file-upload.js') }}"></script>
<script src="{{ asset('admin/assets/js/typeahead.js') }}"></script>
<script src="{{ asset('admin/assets/js/select2.js') }}"></script>

{{-- ========== SUMMERNOTE ========== --}}
{{-- <script src="{{ asset('admin/asset/summernote/summernote-bs4.min.js') }}"></script> --}}
<script src="{{ asset('admin/assets/summernote/summernote-lite.min.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    /* Summernote init */
   $(document).ready(function () {
        $('#summernote').summernote({
            height: 200
        });
    });

    /* Sidebar active-state logic */
    document.addEventListener('DOMContentLoaded', () => {
        const current = window.location.pathname.replace(/^\\//, '').toLowerCase();
        document.querySelectorAll('#sidebar .nav-item').forEach(item => {
            const list = (item.dataset.keywords || '')
                .toLowerCase()
                .split(',')
                .map(k => k.trim())
                .filter(Boolean);
            item.classList.toggle('active', list.some(k => current.startsWith(k)));
        });
    });
</script>

@stack('scripts') {{-- Extra per-page scripts go here --}}
</body>
</html>