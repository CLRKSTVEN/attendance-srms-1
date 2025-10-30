<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<?php
$isStudent = ($this->session->userdata('level') === 'Student');
$isAdmin   = ($this->session->userdata('level') === 'Administrator');
?>

<link rel="stylesheet" href="<?= base_url('assets/css/request-bell.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/manage.css'); ?>">
<script src="<?= base_url('assets/js/req-bell.js'); ?>"></script>

<body>
    <div id="wrapper">
        <?php include('includes/top-nav-bar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box page-title-box-white">
                                <div>
                                    <h4 class="page-title">
                                        <?= htmlspecialchars($data18[0]->SchoolName ?? '') ?><br>
                                        <small><?= htmlspecialchars($data18[0]->SchoolAddress ?? '') ?></small>
                                    </h4>
                                </div>
                                <div class="page-title-right">
                                    <span class="page-tag"> FBMSO Officers </span>
                                    <button class="btn btn-gold ml-2" data-toggle="modal" data-target="#personModal">Add Officials
                                    </button>
                                </div>
                            </div>
                            <hr style="border:0;height:2px;background:linear-gradient(to right,#4285F4 60%,#FBBC05 80%,#34A853 100%);border-radius:1px;margin:16px 0 24px;">
                        </div>
                    </div>

                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success"><?= html_escape($this->session->flashdata('success')); ?></div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('danger')): ?>
                        <div class="alert alert-danger"><?= html_escape($this->session->flashdata('danger')); ?></div>
                    <?php endif; ?>

                    <div class="people-grid">
                        <?php foreach ($people as $p): ?>
                            <?php
                            $id      = (int)$p->id;
                            $full    = (string)($p->bio ?? '');
                            $plain   = trim(strip_tags($full));
                            $isLong  = mb_strlen($plain) > 120;
                            $modalId = 'personView' . $id;
                            $active  = (int)$p->is_active === 1;
                            ?>
                            <div class="person-card">
                                <div class="person-avatar">
                                    <div class="thumb">
                                        <img src="<?= base_url('upload/banners/' . ($p->photo ?: 'placeholder.png')) ?>" alt="">
                                    </div>
                                </div>

                                <div class="person-header">
                                    <h6 class="name"><?= html_escape($p->full_name) ?></h6>
                                    <div class="title"><?= html_escape($p->title) ?></div>
                                </div>

                                <div class="person-body">
                                    <div class="bio"><?= nl2br(html_escape($full)) ?></div>
                                    <?php if ($isLong): ?>
                                        <a href="#<?= $modalId ?>" class="see-more" data-toggle="modal">See more</a>
                                    <?php endif; ?>
                                </div>

                                <div class="card-foot">
                                    <span class="badge badge-pill <?= $active ? 'badge-soft-success' : 'badge-soft-secondary' ?>">
                                        <?= $active ? 'Active' : 'Hidden' ?>
                                    </span>

                                    <div class="icon-actions">
                                        <a href="javascript:void(0)" class="action-btn btn-edit" data-toggle="modal" data-target="#personModal"
                                            data-id="<?= $p->id ?>"
                                            data-name="<?= html_escape($p->full_name) ?>"
                                            data-title="<?= html_escape($p->title) ?>"
                                            data-bio="<?= html_escape($p->bio) ?>"
                                            data-sort="<?= (int)$p->sort_order ?>"
                                            data-active="<?= (int)$p->is_active ?>" title="Edit" aria-label="Edit">
                                            <i class="mdi mdi-pencil"></i><span class="tooltip-label">Edit</span>
                                        </a>

                                        <a class="action-btn btn-toggle"
                                            href="<?= base_url('FbmsoPersonnels/toggle/' . $p->id . '?v=' . ($active ? 0 : 1)) ?>"
                                            onclick="return confirm('Are you sure you want to <?= $active ? 'hide' : 'show' ?> this record?');"
                                            title="<?= $active ? 'Hide' : 'Show' ?>" aria-label="<?= $active ? 'Hide' : 'Show' ?>">
                                            <?php if ($active): ?>
                                                <i class="mdi mdi-eye-off"></i><span class="tooltip-label">Hide</span>
                                            <?php else: ?>
                                                <i class="mdi mdi-eye"></i><span class="tooltip-label">Show</span>
                                            <?php endif; ?>
                                        </a>

                                        <a class="action-btn btn-delete"
                                            href="<?= base_url('FbmsoPersonnels/delete/' . $p->id) ?>"
                                            onclick="return confirm('Delete this record?');"
                                            title="Delete" aria-label="Delete">
                                            <i class="mdi mdi-delete"></i><span class="tooltip-label">Delete</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="<?= $modalId ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header sheet">
                                            <h5 class="modal-title">
                                                <?= html_escape($p->full_name) ?> — <?= html_escape($p->title) ?>
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body vscroll">
                                            <div class="row">
                                                <div class="col-md-4 mb-3 mb-md-0">
                                                    <img class="img-fluid rounded" src="<?= base_url('upload/banners/' . ($p->photo ?: 'placeholder.png')) ?>" alt="">
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="bio-full"><?= nl2br(html_escape($full)) ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-brand" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="card shadow-sm border-0 review-board">
                                <div class="card-header d-flex justify-content-between align-items-center bg-white border-0">
                                    <h5 class="mb-0">Student Reviews</h5>
                                    <?php if ($isStudent): ?>
                                        <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#reviewModal"
                                            data-review-id="" data-person="" data-name="" data-text="">Add Review</button>
                                    <?php endif; ?>
                                </div>

                                <div class="card-body pt-0">
                                    <?php if (!empty($reviews_list)): ?>
                                        <div class="list-group list-group-flush">
                                            <?php foreach ($reviews_list as $rev): ?>
                                                <?php
                                                $created = '';
                                                if (!empty($rev->created_at)) {
                                                    $ts = strtotime($rev->created_at);
                                                    $created = $ts ? date('M d, Y', $ts) : '';
                                                }
                                                $target = $rev->personnel_id ? ($rev->personnel_name ?? 'Officer') : 'Organization';
                                                ?>
                                                <div class="list-group-item px-0">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div>
                                                            <div class="font-weight-bold"><?= html_escape($rev->reviewer_name) ?></div>
                                                            <div class="text-muted small">For: <?= html_escape($target) ?></div>
                                                        </div>
                                                        <?php if ($created): ?>
                                                            <small class="text-muted"><?= $created ?></small>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="mt-2 text-secondary"><?= nl2br(html_escape($rev->review_text)) ?></div>
                                                    <?php if ($isStudent): ?>
                                                        <div class="mt-3 d-flex justify-content-end align-items-center">
                                                            <form method="post" action="<?= base_url('FbmsoPersonnels/review_delete/' . $rev->id) ?>" class="d-inline">
                                                                <input type="hidden" name="return_to" value="FbmsoPersonnels/manage">
                                                                <button type="submit" class="btn btn-link btn-sm text-danger" onclick="return confirm('Delete this review?');">
                                                                    <i class="mdi mdi-trash-can"></i> Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted mb-0">No reviews recorded yet.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <?php include('includes/footer.php'); ?>
        </div>
    </div>

    <?php include('includes/themecustomizer.php'); ?>
    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>

    <!-- Add/Edit Official Modal -->
    <div class="modal fade" id="personModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form method="post" action="<?= base_url('FbmsoPersonnels/save') ?>" enctype="multipart/form-data">
                    <div class="modal-header white">
                        <h5 class="modal-title">Add / Edit Official</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="id" id="p_id">

                        <div class="form-row">
                            <div class="form-group col-md-7">
                                <label>Full name</label>
                                <input type="text" class="form-control" name="full_name" id="p_name" required>
                            </div>
                            <div class="form-group col-md-5">
                                <label>Title/Position</label>
                                <input type="text" class="form-control" name="title" id="p_title" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-7">
                                <label>Short Bio / Description</label>
                                <textarea class="form-control" name="bio" id="p_bio" rows="7"></textarea>
                                <small class="text-muted">New lines are preserved.</small>
                            </div>

                            <div class="form-group col-md-5">
                                <label>Photo (jpg/png/webp)</label>
                                <div class="img-preview mb-2" id="p_preview">
                                    <span class="text-muted">No image selected</span>
                                </div>

                                <input type="file" class="form-control-file" name="photo" id="p_photo"
                                    accept=".jpg,.jpeg,.png,.webp">
                            </div>
                        </div>
                        <input type="hidden" name="sort_order" id="p_sort" value="100">
                        <input type="hidden" name="is_active" id="p_active" value="1">
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-warning" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('#personModal').on('show.bs.modal', function(e) {
            const b = $(e.relatedTarget);
            $('#p_id').val(b && b.data('id') || '');
            $('#p_name').val(b && b.data('name') || '');
            $('#p_title').val(b && b.data('title') || '');
            $('#p_bio').val(b && b.data('bio') || '');
            $('#p_sort').val(b && b.data('sort') || 100);
            $('#p_active').val((b && b.data('active')) != null ? b.data('active') : 1);

            document.getElementById('p_preview').innerHTML =
                '<span class="text-muted">No image selected</span>';
            document.getElementById('p_photo').value = '';
        });

        document.addEventListener('change', function(e) {
            if (e.target && e.target.id === 'p_photo') {
                const box = document.getElementById('p_preview');
                const f = e.target.files && e.target.files[0];
                if (!f) {
                    box.innerHTML = '<span class="text-muted">No image selected</span>';
                    return;
                }
                const reader = new FileReader();
                reader.onload = ev => {
                    box.innerHTML = '<img src="' + ev.target.result + '" alt="preview">';
                };
                reader.readAsDataURL(f);
            }
        });

        (function() {
            const btns = document.querySelectorAll('.action-btn');
            btns.forEach(btn => {
                let hideT;
                btn.addEventListener('mouseenter', () => {
                    clearTimeout(hideT);
                    btn.classList.add('tt-show');
                });
                btn.addEventListener('mouseleave', () => {
                    hideT = setTimeout(() => btn.classList.remove('tt-show'), 180);
                });
                btn.addEventListener('focus', () => btn.classList.add('tt-show'));
                btn.addEventListener('blur', () => btn.classList.remove('tt-show'));
            });
        })();

        // Review modal: create-only (no edit)
        $('#reviewModal').on('show.bs.modal', function(e) {
            const btn = $(e.relatedTarget);
            const person = btn && btn.data('person') != null ? String(btn.data('person')) : '';
            $('#review_id').val(''); // force create mode
            $('#review_person_select').val(person || '');
            $('#review_text').val('');
        }).on('hidden.bs.modal', function() {
            const form = this.querySelector('form');
            if (form) form.reset();
            document.getElementById('review_id').value = '';
        });
    </script>

    <!-- Student Review Modal (manage page) -->
    <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="<?= base_url('FbmsoPersonnels/review_save') ?>">
                    <div class="modal-header white">
                        <h5 class="modal-title">Add Review</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <!-- keep review_id hidden for compatibility, controller ignores edits -->
                        <input type="hidden" name="review_id" id="review_id">
                        <input type="hidden" name="return_to" value="FbmsoPersonnels/manage">

                        <div class="form-group">
                            <label>Submitting as</label>
                            <div class="form-control-plaintext font-weight-bold">
                                <?= html_escape($currentStudentName ?? 'UNKNOWN USER') ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Officer / Organization</label>
                            <select class="form-control" name="personnel_id" id="review_person_select">
                                <option value="">Organization</option>
                                <?php foreach ($people as $person): ?>
                                    <option value="<?= $person->id ?>"><?= html_escape($person->full_name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Feedback</label>
                            <textarea class="form-control" name="review_text" id="review_text" rows="5" required maxlength="1000"></textarea>
                            <small class="text-muted">New lines are preserved.</small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-warning" type="submit">Save Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>