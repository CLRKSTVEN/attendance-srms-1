<link rel="stylesheet" href="<?= base_url('assets/css/request-bell.css'); ?>">
<script src="<?= base_url('assets/js/req-bell.js'); ?>"></script>

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Clickable trigger (Bootstrap 4 data-API) -->
                <p class="mb-0" style="cursor:pointer" data-toggle="modal" data-target="#fbmsoVisionMissionModal">
                    © 2025 <b>Faculty of Business and Management Student Organization.</b> All rights reserved.
                </p>
            </div>
        </div>
    </div>
    <!-- If jQuery is already loaded, keep this commented -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
</footer>

<!-- =================== Black & Yellow Theme for the Modal =================== -->
<style>
    :root {
        --fbm-black: #101214;
        /* deep black */
        --fbm-yellow: #ffcc00;
        /* brand yellow */
        --fbm-yellow-soft: #fff6cc;
        --fbm-gray: #6c757d;
    }

    /* Keep the modal above custom layers */
    #fbmsoVisionMissionModal.modal {
        z-index: 20000;
    }

    .modal-backdrop {
        z-index: 19990;
    }

    /* Header: black → yellow gradient */
    #fbmsoVisionMissionModal .modal-header {
        border-bottom: 0;
        background: linear-gradient(90deg, var(--fbm-black) 0%, var(--fbm-yellow) 100%);
        color: #fff;
        padding: .85rem 1rem;
    }

    #fbmsoVisionMissionModal .modal-title {
        color: #fff;
    }

    #fbmsoVisionMissionModal .brand-wrap small {
        color: rgba(255, 255, 255, .9);
    }

    /* Logo styles + hover */
    #fbmsoVisionMissionModal .brand-wrap img {
        width: 54px;
        height: 54px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, .22);
        border: 2px solid rgba(255, 255, 255, .7);
        transition: transform .15s ease, box-shadow .15s ease;
    }

    #fbmsoVisionMissionModal .brand-wrap a:hover img {
        transform: translateY(-1px) scale(1.02);
        box-shadow: 0 8px 20px rgba(0, 0, 0, .28);
    }

    /* Section labels */
    #fbmsoVisionMissionModal .section-title {
        letter-spacing: .08em;
        font-weight: 800;
        font-size: .78rem;
        color: var(--fbm-black);
    }

    /* Vision callout */
    #fbmsoVisionMissionModal .lead-vision {
        font-style: italic;
        background: var(--fbm-yellow-soft);
        border-left: 4px solid var(--fbm-yellow);
        padding: .8rem 1rem;
        border-radius: .35rem;
    }

    /* Mission list with subtle left rule */
    #fbmsoVisionMissionModal .mission-wrap {
        border-left: 3px solid rgba(16, 18, 20, .08);
        padding-left: .9rem;
    }

    #fbmsoVisionMissionModal ol>li {
        margin-bottom: .45rem;
    }

    /* Modal body: subtle black–yellow overlay (low opacity) */
    #fbmsoVisionMissionModal .fbm-body {
        position: relative;
        background: #fff;
        border-radius: .35rem;
        overflow: hidden;
    }

    #fbmsoVisionMissionModal .fbm-body::before {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;
        z-index: 0;
        /* Layer 1: soft yellow→charcoal gradient */
        background:
            linear-gradient(180deg,
                rgba(255, 204, 0, .10) 0%,
                rgba(255, 204, 0, .06) 35%,
                rgba(16, 18, 20, .05) 100%),
            /* Layer 2: very light diagonal texture */
            repeating-linear-gradient(135deg,
                rgba(255, 204, 0, .06) 0 14px,
                rgba(255, 204, 0, 0) 14px 28px);
    }

    #fbmsoVisionMissionModal .fbm-body>* {
        position: relative;
        z-index: 1;
    }

    /* Footer button accent */
    #fbmsoVisionMissionModal .btn-close-fbm {
        background: var(--fbm-yellow);
        border-color: var(--fbm-yellow);
        color: #101214;
        font-weight: 600;
    }

    #fbmsoVisionMissionModal .btn-close-fbm:hover {
        filter: brightness(.95);
        color: #101214;
    }
</style>

<!-- ===================== Vision & Mission Modal (Bootstrap 4) ===================== -->
<div class="modal fade" id="fbmsoVisionMissionModal" tabindex="-1" role="dialog" aria-labelledby="fbmsoVmTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <div class="brand-wrap d-flex align-items-center">
                    <!-- CLICKABLE LOGO (opens full image in new tab) -->
                    <a href="<?= base_url('upload/banners/footer.jpg'); ?>" target="_blank" rel="noopener" class="mr-2">
                        <img src="<?= base_url('upload/banners/footer.jpg'); ?>" alt="FBMSO Logo">
                    </a>
                    <div>
                        <h5 id="fbmsoVmTitle" class="modal-title mb-0">Vision &amp; Mission — FBMSO</h5>
                        <small>Faculty of Business and Management Student Organization</small>
                    </div>
                </div>
                <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- body with subtle overlay -->
            <div class="modal-body pt-3 fbm-body">
                <div class="section-title mb-2">VISION</div>
                <p class="lead-vision mb-3">
                    To be a catalyst for innovation and entrepreneurial spirit within the business and hospitality fields,
                    empowering students to create and lead transformative ventures.
                </p>

                <div class="section-title mb-2 mt-3">MISSION</div>
                <div class="mission-wrap">
                    <ol class="pl-3 mb-0">
                        <li>Empower BSBA-FM and BSHM students to become successful and ethical leaders in the business and hospitality industries.</li>
                        <li>Foster a supportive community that enhances students’ academic, professional, and personal growth.</li>
                        <li>Bridge theory and practice by providing real-world experiences and strong industry connections.</li>
                        <li>Advocate for student interests while promoting academic excellence and professional development.</li>
                        <li>Cultivate innovative thinkers and problem-solvers through engaging programs and collaborative initiatives.</li>
                        <li>Develop globally minded professionals equipped to thrive in evolving business and hospitality landscapes.</li>
                        <li>Enrich the university experience through events, workshops, and networking opportunities.</li>
                        <li>Promote ethical and sustainable practices via student-led initiatives and community engagement.</li>
                        <li>Prepare students for successful careers by providing essential skills, knowledge, and resources.</li>
                        <li>Build a strong alumni and industry network to support the ongoing success of graduates.</li>
                    </ol>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-close-fbm" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<!-- Safety: move modal under <body> to avoid clipping; keep on top -->
<script>
    (function() {
        function ready(fn) {
            document.readyState !== 'loading' ? fn() : document.addEventListener('DOMContentLoaded', fn);
        }
        ready(function() {
            var m = document.getElementById('fbmsoVisionMissionModal');
            if (m && m.parentElement.tagName.toLowerCase() !== 'body') document.body.appendChild(m);
        });
    })();
</script>

<!-- If your layout does NOT already load these (order matters), add before </body>:
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
-->