<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); // ensure head.php has <meta charset="utf-8"> ?>

<style>
  #vamContent{ display:flex; gap:16px; align-items:flex-start; flex-wrap:nowrap; }
  #vamText{ flex:1; max-height:60vh; overflow:auto; }
  #vamAside{ width:38%; min-width:260px; display:none; }
  #vamAside img{ width:100%; height:auto; border-radius:8px; display:block; object-fit:contain; }

  @media (max-width: 768px){
    #vamContent{ flex-direction:column; flex-wrap:wrap; }
    #vamAside{ width:100%; min-width:0; }
    #vamText{ max-height:none; }
  }

  .ann-item{display:flex;align-items:center;gap:14px;border:1px solid #1f3b5a;background:#f8fbff;border-radius:6px;padding:12px 14px;margin-bottom:12px;box-shadow:0 1px 0 rgba(0,0,0,.03);transition:box-shadow .2s ease}
  .ann-item:hover{box-shadow:0 8px 20px rgba(0,0,0,.12)}
  .ann-thumb{width:110px;min-width:110px}
  .ann-thumb img{width:100%;height:100px;object-fit:cover;border-radius:4px;display:block}
  .ann-body{flex:1}
  .ann-title{margin:0 0 4px;font-weight:700;color:#b10000}
  .ann-meta{font-size:.85rem;color:#6c757d;margin-bottom:6px}
  .ann-actions a{margin-left:8px}
  .ann-item.no-image .ann-body{margin-left:0}
</style>

<body>
<div id="wrapper">
  <?php include('includes/top-nav-bar.php'); ?>
  <?php include('includes/sidebar.php'); ?>

  <?php
  // Tiny sanitizer to allow basic formatting in message (for display only)
  if (!function_exists('ann_sanitize_html')) {
    function ann_sanitize_html($html) {
      $allowed = '<p><br><strong><em><u><span><div><h1><h2><h3><h4><h5><h6>'
               . '<ul><ol><li><blockquote><hr><a><img><b><i>';
      $clean = strip_tags((string)$html, $allowed);
      $clean = preg_replace('/<a\s+/i', '<a rel="noopener noreferrer" target="_blank" ', $clean);
      $clean = preg_replace_callback('/<img[^>]*src="([^"]+)"[^>]*>/i', function($m){
        return (preg_match('#^(https?:|data:image/)#i', $m[1])) ? $m[0] : '';
      }, $clean);
      return $clean;
    }
  }
  ?>

  <div class="content-page">
    <div class="content">
      <div class="container-fluid">

        <div class="row">
          <div class="col-md-12">
            <div class="page-title-box">
              <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <?= $this->session->flashdata('success'); ?>
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
              <?php endif; ?>
              <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?= $this->session->flashdata('error'); ?>
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
              <?php endif; ?>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>

        <div class="row mb-4">
          <div class="col-md-12">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#announcementModal">
              Post New Announcement
            </button>
          </div>
        </div>

        <!-- Create Modal -->
        <div class="modal fade" id="announcementModal" tabindex="-1" role="dialog" aria-labelledby="announcementModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="announcementModalLabel"><b>Announcement Posting</b></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <form class="form-horizontal" action="<?= base_url('Announcement/uploadAnnouncement'); ?>" enctype="multipart/form-data" method="POST">
                <div class="modal-body">
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label">Title</label>
                    <div class="col-md-8">
                      <input type="text" class="form-control" name="title" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-md-4 col-form-label">Text / Message</label>
                    <div class="col-md-8">
                      <textarea name="message" class="form-control" rows="4" placeholder="Write the announcement details here…" required></textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-md-4 col-form-label">Attach Image (optional)</label>
                    <div class="col-md-8">
                      <input type="file" class="form-control" name="nonoy" accept=".jpg,.jpeg,.png,.gif">
                      <p class="text-muted small mt-2 mb-0">Optional. Recommended max size: width=900px, height=600px. Allowed: jpg, png, gif.</p>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-md-4 col-form-label">Audience</label>
                    <div class="col-md-8">
                      <select name="audience" class="form-control" required>
                        <option value="All">All</option>
                        <option value="Students">Students</option>
                        <option value="Registrar">Registrar</option>
                        <option value="Instructors">Instructors</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-md-4 col-form-label">Expire Date</label>
                    <div class="col-md-8">
                      <input type="date" name="date_expire" class="form-control">
                      <small class="text-muted">Leave blank to show indefinitely.</small>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <input type="submit" name="submit" class="btn btn-info" value="Save">
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editAnnouncementModal" tabindex="-1" role="dialog" aria-labelledby="editAnnouncementModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
<form class="modal-content"
      action="<?= site_url('Page/updateAnnouncement'); ?>"
      enctype="multipart/form-data" method="POST">
              <div class="modal-header">
                <h4 class="modal-title" id="editAnnouncementModalLabel"><b>Edit Announcement</b></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <div class="modal-body">
                <input type="hidden" name="aID" id="edit_aID">
                <input type="hidden" name="old_image" id="edit_old_image">

                <div class="form-group row">
                  <label class="col-md-4 col-form-label">Title</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control" name="title" id="edit_title" required>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-md-4 col-form-label">Text / Message</label>
                  <div class="col-md-8">
                    <textarea name="message" id="edit_message" class="form-control" rows="5" required></textarea>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-md-4 col-form-label">Current Image</label>
                  <div class="col-md-8">
                    <div id="edit_image_wrap" class="mb-2" style="display:none">
                      <img id="edit_preview" src="" alt="Current image" style="max-width:220px;border-radius:4px;">
                      <div class="small text-muted mt-1" id="edit_image_name"></div>
                    </div>
                    <div class="form-check mb-3">
                      <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1">
                      <label class="form-check-label" for="remove_image">Remove current image</label>
                    </div>
                    <label class="col-form-label pt-0">Replace with new image (optional)</label>
                    <input type="file" class="form-control" name="nonoy" accept=".jpg,.jpeg,.png,.gif">
                    <small class="text-muted d-block mt-2">Allowed: jpg, png, gif. Max 5MB.</small>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-md-4 col-form-label">Audience</label>
                  <div class="col-md-8">
                    <select name="audience" id="edit_audience" class="form-control" required>
                      <option value="All">All</option>
                      <option value="Students">Students</option>
                      <option value="Registrar">Registrar</option>
                      <option value="Instructors">Instructors</option>
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-md-4 col-form-label">Expire Date</label>
                  <div class="col-md-8">
                    <input type="date" name="date_expire" id="edit_date_expire" class="form-control">
                    <small class="text-muted">Leave blank to show indefinitely.</small>
                  </div>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" name="submit" class="btn btn-primary">Update</button>
              </div>
            </form>
          </div>
        </div>

        <!-- List -->
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <h4 class="header-title"><b>Announcement List</b></h4>
                <span class="badge badge-purple">
                  SY <?= $this->session->userdata('sy'); ?> <?= $this->session->userdata('semester'); ?>
                </span>
                <br><br>

                <?php if (!empty($announcement)): ?>
                  <?php foreach ($announcement as $row):
                    $title      = htmlspecialchars($row->title ?? '', ENT_QUOTES, 'UTF-8');
                    $rawMsg     = htmlspecialchars($row->message ?? '', ENT_QUOTES, 'UTF-8');
                    $msgHtml    = ann_sanitize_html(nl2br($row->message ?? ''));
                    $img        = trim($row->image ?? '');
                    $imagePath  = FCPATH . 'upload/announcements/' . $img;
                    $hasImage   = ($img !== '' && file_exists($imagePath));
                    $imageURL   = $hasImage ? base_url('upload/announcements/' . $img) : '';
                    $dateExpire = !empty($row->date_expire) ? date('Y-m-d', strtotime($row->date_expire)) : '';
                  ?>
                    <div class="ann-item <?= $hasImage ? '' : 'no-image' ?>">
                      <?php if ($hasImage): ?>
                        <div class="ann-thumb">
                          <img src="<?= $imageURL; ?>" alt="<?= $title; ?>">
                        </div>
                      <?php endif; ?>

                      <div class="ann-body">
                        <div class="ann-title"><?= $title; ?></div>
                        <div class="ann-meta">
                          Posted on <?= date('F d, Y', strtotime($row->datePosted)); ?>
                          • Audience: <?= htmlspecialchars($row->audience ?? '', ENT_QUOTES, 'UTF-8'); ?>
                          <?php if (!empty($row->date_expire)): ?>
                            • <span class="text-danger">Expires: <?= date('F d, Y', strtotime($row->date_expire)); ?></span>
                          <?php endif; ?>
                        </div>

                        <!-- Hidden container with both sanitized + raw (for edit) -->
                        <div id="ann-<?= $row->aID; ?>" class="d-none"
                             data-id="<?= (int)$row->aID; ?>"
                             data-title="<?= $title; ?>"
                             data-message-raw="<?= $rawMsg; ?>"
                             data-audience="<?= htmlspecialchars($row->audience ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                             data-date-expire="<?= $dateExpire; ?>"
                             data-image="<?= $imageURL; ?>"
                             data-image-name="<?= htmlspecialchars($img, ENT_QUOTES, 'UTF-8'); ?>"
                             data-hasimage="<?= $hasImage ? '1' : '0'; ?>">
                          <div class="ann-content"><?= $msgHtml; ?></div>
                        </div>

                        <a href="#" class="ann-view" data-toggle="modal" data-target="#viewAnnouncementModal" data-id="<?= $row->aID; ?>">
                          View Details
                        </a>
                      </div>

                      <div class="ann-actions">
                        <a href="#" class="btn btn-outline-primary btn-sm ann-edit"
                           data-toggle="modal" data-target="#editAnnouncementModal"
                           data-id="<?= (int)$row->aID; ?>">
                          <i class="mdi mdi-pencil"></i> Edit
                        </a>
                        <a href="<?= base_url('Announcement/delete/' . $row->aID); ?>" class="btn btn-outline-danger btn-sm"
                           onclick="return confirm('Delete this announcement?');">
                          <i class="mdi mdi-delete"></i> Delete
                        </a>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <p class="text-muted mb-0">No announcements to display at this time.</p>
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

<!-- View Modal -->
<div class="modal fade" id="viewAnnouncementModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header text-white">
        <h5 class="modal-title" id="vamTitle">Announcement</h5>
        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div id="vamContent" style="display:flex; gap:16px; align-items:flex-start; flex-wrap:wrap;">
          <div id="vamText" style="flex:1; font-size:1rem; line-height:1.6; max-height:60vh; overflow:auto;"></div>
          <aside id="vamAside" style="width:38%; min-width:260px; display:none;">
            <img id="vamImage" src="" alt="Announcement Image" style="width:100%; height:auto; border-radius:8px; object-fit:contain;">
            <div class="text-right mt-2">
              <a id="vamDownload" class="btn btn-outline-secondary btn-sm" href="#" download>Download image</a>
            </div>
          </aside>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
<script src="<?= base_url(); ?>assets/js/app.min.js"></script>

<script>
  // View modal
  $('#viewAnnouncementModal').on('show.bs.modal', function (e) {
    var t   = $(e.relatedTarget);
    var id  = t.data('id');
    var box = $('#ann-' + id);

    var title  = box.data('title') || '';
    var img    = box.data('image') || '';
    var hasImg = (String(box.data('hasimage')) === '1');
    var html   = box.find('.ann-content').html() || '';

    $('#vamTitle').text(title);
    $('#vamText').html(html);

    if (hasImg && img) {
      $('#vamImage').attr('src', img);
      $('#vamDownload').attr('href', img);
      $('#vamAside').show();
    } else {
      $('#vamImage').attr('src', '');
      $('#vamDownload').attr('href', '#');
      $('#vamAside').hide();
    }
  });

  // Edit modal prefill
  $('#editAnnouncementModal').on('show.bs.modal', function (e) {
    var t  = $(e.relatedTarget);
    var id = t.data('id');
    var box = $('#ann-' + id);
    if (!box.length) return;

    var title      = box.data('title') || '';
    var raw        = box.data('message-raw') || '';
    var audience   = box.data('audience') || 'All';
    var dateExpire = box.data('date-expire') || '';
    var imgUrl     = box.data('image') || '';
    var imgName    = box.data('image-name') || '';
    var hasImg     = (String(box.data('hasimage')) === '1');

    $('#edit_aID').val(id);
    $('#edit_title').val(title);
    $('#edit_message').val(raw);
    $('#edit_audience').val(audience);
    $('#edit_date_expire').val(dateExpire);
    $('#edit_old_image').val(imgName);
    $('#remove_image').prop('checked', false);

    if (hasImg && imgUrl) {
      $('#edit_image_wrap').show();
      $('#edit_preview').attr('src', imgUrl);
      $('#edit_image_name').text(imgName);
    } else {
      $('#edit_image_wrap').hide();
      $('#edit_preview').attr('src', '');
      $('#edit_image_name').text('');
    }
  });
</script>
</body>
</html>
