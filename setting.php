<?php
require('config.php');

if (isset($_POST['save_school'])) {
    $address = mysqli_real_escape_string($db, $_POST['address']);
    $contact = mysqli_real_escape_string($db, $_POST['contact']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $year = mysqli_real_escape_string($db, $_POST['year']);
    $term = mysqli_real_escape_string($db, $_POST['term']);
    $id = mysqli_real_escape_string($db, $_POST['id']);

    if (mysqli_query($db, "UPDATE school SET address='$address', contact='$contact', email='$email', year='$year', term='$term'  WHERE id=$id")) {
        $_SESSION['status'] = "Changes saved successfully";
        echo ("<script>window.location.href='index.php?tab=setting';</script>");
    } else {
        $_SESSION['error'] = 'ERROR: ' . mysqli_error($db);
    }
}


?>

<div class="inner-section">

    <div class="inner-section-heading">
        <h4>Settings</h4>
    </div>

    <form class="col-md-12 mx-auto my-4" method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $school_id; ?>">
        <div class="row">
            <div class="col-md-5 mx-4">
                <h5>Contact Information</h5>
                <div class="form-group row">
                    <label>School Name </label>
                    <input class="form-control" value="<?php echo $school_name; ?>" readonly>
                    <small class="text-secondary">Name of school cannot be changed</small>
                </div>
                <div class="form-group row">
                    <label>School Address </label>
                    <input class="form-control" name="address" value="<?php echo $school_address; ?>">
                </div>
                <div class="form-group row">
                    <label>School Contact Number(s) </label>
                    <input class="form-control" name="contact" value="<?php echo $school_contact; ?>">
                </div>
                <div class="form-group row">
                    <label>School Email Address </label>
                    <input class="form-control" name="email" value="<?php echo $school_email; ?>">
                </div>
            </div>
            <div class="col-md-5 mx-4">
                <h5>Current Academic Information</h5>
                <div class="form-group row">
                    <label>Current Academic Year </label>
                    <input class="form-control" name="year" value="<?php echo $school_year; ?>">
                </div>
                <div class="form-group row">
                    <label>Current Semester/Term </label>

                    <select name="term" class="form-control">
                        <option value="<?php echo $school_term; ?>"><?php echo $school_term; ?></option>
                        <option value="1st Term">1st Term</option>
                        <option value="2nd Semester">2nd Semester</option>
                        <option value="1st Term">1st Term</option>
                        <option value="2nd Term">2nd Term</option>
                        <option value="3rd Term">3rd Term</option>
                    </select>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-custom text-white" name="save_school">Save</button>

    </form>

</div>