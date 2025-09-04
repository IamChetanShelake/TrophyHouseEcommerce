<!-- Shared Share Modal -->
<div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content text-center">
            <div class="modal-header">
                <div class="text-start">
                    <h5 class="modal-title" id="shareModalLabel">Share Product</h5>
                    <small class="text-muted">If you like to share this with your friend</small>
                </div>
                <button type="button" class="btn-close text-danger"
                    style="filter: invert(28%) sepia(100%) saturate(4773%) hue-rotate(356deg) brightness(95%) contrast(116%);"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- Social Media Icons with Circle Backgrounds and Labels -->
                <div class="d-flex justify-content-center gap-4 mb-4">
                    <!-- Facebook -->
                    <div class="text-center">
                        <a href="#" id="facebookShare" target="_blank"
                            class="d-flex align-items-center justify-content-center rounded-circle"
                            style="background-color: skyblue; width: 50px; height: 50px;">
                            <i class="fab fa-facebook text-white fs-4"></i>
                        </a>
                        <div class="mt-1 small text-dark">Facebook</div>
                    </div>

                    <!-- Twitter -->
                    <div class="text-center">
                        <a href="#" id="twitterShare" target="_blank"
                            class="d-flex align-items-center justify-content-center rounded-circle"
                            style="background-color: skyblue; width: 50px; height: 50px;">
                            <i class="fab fa-twitter text-white fs-4"></i>
                        </a>
                        <div class="mt-1 small text-dark">Twitter</div>
                    </div>

                    <!-- WhatsApp -->
                    <div class="text-center">
                        <a href="#" id="whatsappShare" target="_blank"
                            class="d-flex align-items-center justify-content-center rounded-circle"
                            style="background-color: skyblue; width: 50px; height: 50px;">
                            <i class="fab fa-whatsapp text-white fs-4"></i>
                        </a>
                        <div class="mt-1 small text-dark">WhatsApp</div>
                    </div>
                </div>

                <!-- Link Box with Copy Icon -->
                <div class="d-flex align-items-center border border-danger rounded px-2 py-1">
                    <input type="text" class="form-control border-0" id="shareLinkInput" readonly
                        style="box-shadow: none;">
                    <i class="fas fa-copy text-danger ms-2 fs-5" style="cursor: pointer;" onclick="copyToClipboard()"
                        title="Copy Link"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.share-icon').forEach(icon => {
            icon.addEventListener('click', function() {
                const shareLink = this.getAttribute('data-share-link');

                document.getElementById('shareLinkInput').value = shareLink;
                document.getElementById('facebookShare').href =
                    `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareLink)}`;
                document.getElementById('twitterShare').href =
                    `https://twitter.com/intent/tweet?url=${encodeURIComponent(shareLink)}`;
                document.getElementById('whatsappShare').href =
                    `https://wa.me/?text=${encodeURIComponent(shareLink)}`;
            });
        });
    });

    function copyToClipboard() {
        const input = document.getElementById("shareLinkInput");
        input.select();
        input.setSelectionRange(0, 99999);
        document.execCommand("copy");
        alert("Link copied to clipboard!");
    }
</script>
