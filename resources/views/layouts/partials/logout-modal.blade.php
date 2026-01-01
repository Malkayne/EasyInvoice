<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="mb-3">
                    <i class="ti ti-alert-triangle text-warning" style="font-size: 3rem;"></i>
                </div>
                <p class="mb-0 fs-5">Are you sure you want to logout?</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="{{ route('logout') }}" type="button" class="btn btn-danger">
                    <i class="ti ti-logout me-2"></i>
                    Logout
                </a>
            </div>
        </div>
    </div>
</div>
<!-- / Logout Modal -->