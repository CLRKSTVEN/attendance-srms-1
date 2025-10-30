<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<?php $isStudent = ($this->session->userdata('level') === 'Student'); ?>

<link rel="stylesheet" href="<?= base_url('assets/css/request-bell.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/public.css'); ?>">
<script src="<?= base_url('assets/js/req-bell.js'); ?>"></script>

<body>
    <div id="wrapper">
        <?php include('includes/top-nav-bar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <!-- Header -->
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
                                    <span class="page-tag">FBMSO Officials</span>
                                </div>
                            </div>
                            <hr class="fbmso-hr">
                            <?php if ($this->session->flashdata('success')): ?>
                                <div class="alert alert-success"><?= html_escape($this->session->flashdata('success')) ?></div>
                            <?php endif; ?>
                            <?php if ($this->session->flashdata('danger')): ?>
                                <div class="alert alert-danger"><?= html_escape($this->session->flashdata('danger')) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- People (read-only) -->
                    <div class="people-grid">
                        <?php foreach ($people as $p): ?>
                            <?php
                            $id      = (int)$p->id;
                            $full    = (string)($p->bio ?? '');
                            $plain   = trim(strip_tags($full));
                            $isLong  = mb_strlen($plain) > 120;
                            $modalId = 'personViewPublic' . $id;
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

                                <?php if ($isStudent): ?>
                                    <div class="person-actions mt-3 text-right">
                                        <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#publicReviewModal"
                                            data-person="<?= $id ?>">
                                            Leave a Review
                                        </button>
                                    </div>
                                <?php endif; ?>

                            </div>

                            <!-- See more modal -->
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
                                            <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div><!-- /people-grid -->

                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="card shadow-sm border-0 review-board">
                                <div class="card-header d-flex justify-content-between align-items-center bg-white border-0">
                                    <h5 class="mb-0">Student Feedback</h5>
                                    <?php if ($isStudent): ?>
                                        <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#publicReviewModal" data-person="">
                                            Share Feedback
                                        </button>
                                    <?php endif; ?>

                                </div>
                                <div class="card-body pt-0">
                                    <?php
                                    $hasPersonReviews = false;
                                    if (!empty($reviews_by_person)) {
                                        foreach ($reviews_by_person as $set) {
                                            if (!empty($set)) {
                                                $hasPersonReviews = true;
                                                break;
                                            }
                                        }
                                    }
                                    $hasAnyReviews = !empty($general_reviews) || $hasPersonReviews;
                                    ?>
                                    <?php if ($hasAnyReviews): ?>
                                        <?php if (!empty($general_reviews)): ?>
                                            <div class="mb-4">
                                                <h6 class="text-uppercase small text-muted">For the Organization</h6>
                                                <?php foreach ($general_reviews as $rev): ?>
                                                    <?php
                                                    $created = '';
                                                    if (!empty($rev->created_at)) {
                                                        $ts = strtotime($rev->created_at);
                                                        $created = $ts ? date('M d, Y', $ts) : '';
                                                    }
                                                    ?>
                                                    <div class="review-item mb-3 p-3 border rounded bg-light">
                                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                                            <strong><?= html_escape($rev->reviewer_name) ?></strong>
                                                            <?php if ($created): ?>
                                                                <small class="text-muted"><?= $created ?></small>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="text-secondary"><?= nl2br(html_escape($rev->review_text)) ?></div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php foreach ($people as $p): ?>
                                            <?php $personReviews = isset($reviews_by_person[$p->id]) ? $reviews_by_person[$p->id] : []; ?>
                                            <?php if (!empty($personReviews)): ?>
                                                <div class="mb-4">
                                                    <h6 class="text-uppercase small text-muted"><?= html_escape($p->full_name) ?></h6>
                                                    <?php foreach ($personReviews as $rev): ?>
                                                        <?php
                                                        $created = '';
                                                        if (!empty($rev->created_at)) {
                                                            $ts = strtotime($rev->created_at);
                                                            $created = $ts ? date('M d, Y', $ts) : '';
                                                        }
                                                        ?>
                                                        <div class="review-item mb-3 p-3 border rounded bg-light">
                                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                                <strong><?= html_escape($rev->reviewer_name) ?></strong>
                                                                <?php if ($created): ?>
                                                                    <small class="text-muted"><?= $created ?></small>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="text-secondary"><?= nl2br(html_escape($rev->review_text)) ?></div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p class="text-muted mb-0">No reviews yet. Be the first to share your experience.</p>
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
    <script src="<?= base_url('assets/js/vendor.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/app.min.js'); ?>"></script>

    <?php if ($isStudent): ?>
        <script>
            // Prefill the modal when opened (officer-specific or org-wide)
            $('#publicReviewModal').on('show.bs.modal', function(e) {
                const btn = $(e.relatedTarget);
                const person = btn && btn.data('person') != null ? String(btn.data('person')) : '';
                // clear all fields to enforce create-only
                this.querySelector('form').reset();
                document.getElementById('pub_review_person_select').value = person || '';
                document.getElementById('pub_review_text').value = '';
            });
        </script>

        <!-- Add Review Modal (public) -->
        <div class="modal fade" id="publicReviewModal" tabindex="-1" role="dialog" aria-hidden="true">
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
                            <!-- reviewer name is forced by controller; show read-only identity -->
                            <div class="form-group">
                                <label>Submitting as</label>
                                <div class="form-control-plaintext font-weight-bold">
                                    <?= html_escape($currentStudentName ?? 'UNKNOWN USER') ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Officer / Organization</label>
                                <select class="form-control" name="personnel_id" id="pub_review_person_select">
                                    <option value="">Organization</option>
                                    <?php foreach ($people as $person): ?>
                                        <option value="<?= $person->id ?>"><?= html_escape($person->full_name) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Feedback</label>
                                <textarea class="form-control" name="review_text" id="pub_review_text" rows="5" required maxlength="1000"></textarea>
                                <small class="text-muted">New lines are preserved.</small>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-warning" type="submit">Submit Review</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>

</body>

</html>