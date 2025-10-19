<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Attendance MS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Responsive bootstrap 4 admin template" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/Attendance.png">

    <!-- Plugins css-->
    <link href="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
    <link href="<?= base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />

    <script src="<?= base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>

    <style>
        .card-simple {border:1px solid #e6ecf5;border-radius:14px;box-shadow:0 6px 18px rgba(36,59,83,.06)}
        .section-title{font-weight:700;color:#243b53;margin:8px 0 14px}
        .label-req::after{content:" *"; color:#e55353}

        /* CSS grid for tidy alignment */
        .form-grid{
            display:grid;
            grid-template-columns:repeat(4, minmax(0, 1fr));
            grid-column-gap:16px;
            grid-row-gap:14px;
        }
        .span-2{grid-column:span 2}
        .span-3{grid-column:span 3}
        .span-4{grid-column:span 4}
        @media (max-width:1199.98px){ .form-grid{grid-template-columns:repeat(3,1fr)} }
        @media (max-width:991.98px){ .form-grid{grid-template-columns:repeat(2,1fr)} }
        @media (max-width:575.98px){ .form-grid{grid-template-columns:1fr} .span-2,.span-3,.span-4{grid-column:span 1} }

        /* Select2 height match */
        .select2-container .select2-selection--single{height:38px}
        .select2-selection__rendered{line-height:36px}
        .select2-selection__arrow{height:36px}
    </style>

    <script>
        function calculateAge(dateInputId, resultInputId) {
            const v = document.getElementById(dateInputId).value;
            if (!v) { document.getElementById(resultInputId).value=''; return; }
            const b = new Date(v), n = new Date();
            let age = n.getFullYear()-b.getFullYear();
            const m = n.getMonth()-b.getMonth();
            if (m<0 || (m===0 && n.getDate()<b.getDate())) age--;
            document.getElementById(resultInputId).value = isFinite(age)?age:'';
        }
    </script>
</head>
<body>
<?php
$profileData = $data ?? null;
if (is_array($profileData)) {
    $profileData = $profileData[0] ?? null;
}
if (is_array($profileData)) {
    $profileData = (object)$profileData;
}
if (!is_object($profileData)) {
    $profileData = (object)[];
}
$data = $profileData;

$pickField = function ($keys) use ($data) {
    foreach ($keys as $key) {
        if (isset($data->$key) && trim((string)$data->$key) !== '') {
            return trim((string)$data->$key);
        }
    }
    return '';
};

$provinceVal = $pickField(['Province', 'province', 'provincePresent']);
$cityVal     = $pickField(['City', 'city', 'CityPresent', 'cityPresent']);
$brgyVal     = $pickField(['Brgy', 'brgy', 'Barangay', 'barangay', 'BrgyPresent', 'brgyPresent']);
$sitioVal    = $pickField(['Sitio', 'sitio', 'SitioPresent', 'sitioPresent']);
?>
<div id="wrapper">
    <?php include('includes/top-nav-bar.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <div class="content-page">
        <div class="content">

            <?php if ($this->session->flashdata('success')) : ?>
                <?= '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>'.$this->session->flashdata('success').'</div>'; ?>
            <?php endif; ?>

            <?php if ($this->session->flashdata('danger')) : ?>
                <?= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>'.$this->session->flashdata('danger').'</div>'; ?>
            <?php endif; ?>

            <div class="container-fluid">
                <!-- title -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-title-box">
                            <h4 class="page-title">UPDATE PROFILE</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb p-0 m-0">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item"><a href="#">Update Student</a></li>
                                    <li class="breadcrumb-item"><a href="#"></a></li>
                                </ol>
                            </div>
                            <div class="clearfix"></div>
                            <hr style="border:0;height:2px;background:linear-gradient(to right,#4285F4 60%,#FBBC05 80%,#34A853 100%);border-radius:1px;margin:20px 0;" />
                        </div>
                    </div>
                </div>

                <!-- form -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-simple">
                            <div class="card-body">
                                <form class="parsley-examples" method="post" enctype="multipart/form-data">
                                    <h5 class="section-title">Personal Data</h5>

                                    <div class="form-grid">
                                      <!-- Student No -->
                                      <div class="form-group span-2">
                                          <input type="hidden" value="<?= $data->StudentNumber; ?>" name="oldStudentNo" required>
                                          <label class="label-req">Student No.</label>
                                          <input type="text" class="form-control" value="<?= $data->StudentNumber; ?>" name="StudentNumber" readonly required>
                                      </div>

                                      <!-- Names -->
                                      <div class="form-group">
                                          <label class="label-req">First Name</label>
                                          <input type="text" class="form-control" name="FirstName" value="<?= $data->FirstName; ?>" required>
                                      </div>
                                      <div class="form-group">
                                          <label>Middle Name</label>
                                          <input type="text" class="form-control" name="MiddleName" value="<?= $data->MiddleName; ?>">
                                      </div>
                                      <div class="form-group">
                                          <label class="label-req">Last Name</label>
                                          <input type="text" class="form-control" name="LastName" value="<?= $data->LastName; ?>" required>
                                      </div>
                                      <div class="form-group">
                                          <label>Name Extn</label>
                                          <input type="text" class="form-control" name="nameExtn" value="<?= !empty($data->nameExtn) ? $data->nameExtn : ''; ?>">
                                      </div>

                                      <!-- Sex / Civil / Mobile -->
                                      <div class="form-group">
                                          <label class="label-req">Sex</label>
                                          <select name="Sex" class="form-control" required>
                                              <option value=""></option>
                                              <option value="Female" <?= ($data->Sex == 'Female') ? 'selected' : ''; ?>>Female</option>
                                              <option value="Male"   <?= ($data->Sex == 'Male') ? 'selected' : ''; ?>>Male</option>
                                          </select>
                                      </div>
                                      <div class="form-group">
                                          <label class="label-req">Civil Status</label>
                                          <select name="CivilStatus" class="form-control" required>
                                              <option value=""></option>
                                              <option value="Single"  <?= ($data->CivilStatus == 'Single') ? 'selected' : ''; ?>>Single</option>
                                              <option value="Married" <?= ($data->CivilStatus == 'Married') ? 'selected' : ''; ?>>Married</option>
                                          </select>
                                      </div>
                                      <div class="form-group span-2">
                                          <label>Mobile No.</label>
<input type="text" class="form-control" name="contactNo" value="<?= isset($data->contactNo) ? $data->contactNo : ''; ?>">
                                      </div>

                                 <!-- Birth Date / Age -->
<div class="form-group">
    <label class="label-req">Birth Date</label>
    <input type="date" name="birthDate" id="bday" class="form-control"
    onchange="calculateAge('bday','resultBday')" required value="<?= isset($data->birthDate) ? $data->birthDate : ''; ?>">
</div>
<div class="form-group">
    <label class="label-req">Age</label>
    <input type="text" name="Age" id="resultBday" class="form-control" readonly required value="<?= isset($data->Age) ? $data->Age : ''; ?>">
</div>


                                      <!-- Address Fields -->
                                      <div class="span-4"><h6 class="section-title">Address</h6></div>
<div class="form-group">
    <label class="label-req" for="province">Province</label>
    <select id="province" name="Province" class="form-control" required>
        <option value="">Select Province</option>
        <?php foreach ($provinces as $province): ?>
            <option value="<?= htmlspecialchars($province->Province, ENT_QUOTES, 'UTF-8'); ?>" <?= ($province->Province == $provinceVal) ? 'selected' : ''; ?>>
                <?= htmlspecialchars($province->Province, ENT_QUOTES, 'UTF-8'); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
<div class="form-group">
    <label class="label-req" for="city">City/Municipality</label>
    <select id="city" name="City" class="form-control" required>
        <option value="">Select City/Municipality</option>
        <?php foreach ($cities as $city): ?>
            <option value="<?= htmlspecialchars($city->City, ENT_QUOTES, 'UTF-8'); ?>" <?= ($city->City == $cityVal) ? 'selected' : ''; ?>>
                <?= htmlspecialchars($city->City, ENT_QUOTES, 'UTF-8'); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
<div class="form-group">
    <label class="label-req" for="barangay">Barangay</label>
    <select id="barangay" name="Brgy" class="form-control" required>
        <option value="">Select Barangay</option>
        <?php foreach ($barangays as $brgy): ?>
            <option value="<?= htmlspecialchars($brgy->Brgy, ENT_QUOTES, 'UTF-8'); ?>" <?= ($brgy->Brgy == $brgyVal) ? 'selected' : ''; ?>>
                <?= htmlspecialchars($brgy->Brgy, ENT_QUOTES, 'UTF-8'); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
<div class="form-group">
    <label for="sitio">Sitio</label>
    <input type="text" id="sitio" class="form-control" name="Sitio" placeholder="Sitio" value="<?= htmlspecialchars($sitioVal, ENT_QUOTES, 'UTF-8'); ?>">
</div>


                                    </div><!-- /.form-grid -->

                                    <input type="hidden" id="StudentNumber" name="StudentNumber" value="<?= $data->StudentNumber; ?>">
                                    <div class="mt-2">
                                        <input type="submit" name="submit" class="btn btn-info" value="Update Profile">
                                    </div>
                                </form>
                            </div><!-- /.card-body -->
                        </div><!-- /.card -->
                    </div>
                </div>
            </div><!-- /.container-fluid -->

        </div><!-- /.content -->

        <?php include('includes/footer.php'); ?>
    </div><!-- /.content-page -->

    <?php include('includes/themecustomizer.php'); ?>
</div><!-- /#wrapper -->

<script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/moment/moment.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/jquery-scrollto/jquery.scrollTo.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="<?= base_url(); ?>assets/js/app.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>

<!-- Province → City → Barangay chaining -->
<script>
$(function () {
    $('#province, #city, #barangay').select2({ width: '100%' });

   const savedProvince = <?= json_encode($provinceVal) ?>;
const savedCity     = <?= json_encode($cityVal) ?>;
const savedBrgy     = <?= json_encode($brgyVal) ?>;

function enable(el, on = true) { $(el).prop('disabled', !on); }

function setSelectValue($el, val, label) {
    if (!val) return;
    if ($el.find('option').filter((_, o) => $(o).val() == val).length === 0) {
        $el.append($('<option/>', { value: val, text: label || val }));
    }
    $el.val(val).trigger('change.select2');
}

function fillOptions($el, items, valueKey, textKey, placeholder) {
    $el.empty();
    if (placeholder) $el.append($('<option/>', { value: '', text: placeholder }));
    (items || []).forEach(function (it) {
        const v = it[valueKey] ?? '';
        const t = it[textKey] ?? v;
        if (v) $el.append($('<option/>', { value: v, text: t }));
    });
    $el.trigger('change.select2');
}

function loadProvinces() {
    $.ajax({
        url: '<?= site_url('Page/get_provinces'); ?>',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            const $prov = $('#province');
            fillOptions($prov, data, 'Province', 'Province', 'Select Province');

            if (savedProvince) {
                setSelectValue($prov, savedProvince);
                enable('#city', true);
                loadCities(savedProvince, function () {
                    if (savedCity) {
                        setSelectValue($('#city'), savedCity);
                        enable('#barangay', true);
                        loadBarangays(savedCity, function () {
                            if (savedBrgy) setSelectValue($('#barangay'), savedBrgy);
                        });
                    }
                });
            } else {
                enable('#city', false);
                enable('#barangay', false);
            }
        },
        error: function (_x, _s, err) { alert("Error loading provinces: " + err); }
    });
}

function loadCities(province, done) {
    $.ajax({
        url: '<?= site_url('Page/get_cities'); ?>',
        type: 'POST',
        dataType: 'json',
        data: { province: province },
        success: function (data) {
            const $city = $('#city');
            fillOptions($city, data, 'City', 'City', 'Select City/Municipality');
            if (typeof done === 'function') done();
        },
        error: function (_x, _s, err) { alert("Error loading cities: " + err); }
    });
}

function loadBarangays(city, done) {
    $.ajax({
        url: '<?= site_url('Page/get_barangays'); ?>',
        type: 'POST',
        dataType: 'json',
        data: { city: city },
        success: function (data) {
            const $brgy = $('#barangay');
            fillOptions($brgy, data, 'Brgy', 'Brgy', 'Select Barangay');
            if (typeof done === 'function') done();
        },
        error: function (_x, _s, err) { alert("Error loading barangays: " + err); }
    });
}

$('#province').on('change', function () {
    const prov = $(this).val();
    fillOptions($('#city'), [], 'City', 'City', 'Select City/Municipality');
    fillOptions($('#barangay'), [], 'Brgy', 'Brgy', 'Select Barangay');
    enable('#barangay', false);

    if (prov) { enable('#city', true); loadCities(prov); }
    else { enable('#city', false); }
});

$('#city').on('change', function () {
    const city = $(this).val();
    fillOptions($('#barangay'), [], 'Brgy', 'Brgy', 'Select Barangay');
    if (city) { enable('#barangay', true); loadBarangays(city); }
    else { enable('#barangay', false); }
});


    // Ensure disabled selects submit values
    $('form').on('submit', function () {
        ['#city','#barangay'].forEach(function (sel) {
            const $el = $(sel);
            if ($el.is(':disabled')) {
                if (!$el.val()) {
                    const selected = $el.find('option:selected').val() || $el.find('option:first').val();
                    if (selected) $el.val(selected);
                }
                $el.prop('disabled', false);
            }
        });
    });

    loadProvinces();
});
</script>
</body>
</html>
