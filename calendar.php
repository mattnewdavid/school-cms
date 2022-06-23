<?php
require("config.php");

// Insert into Calendar
if (isset($_POST['save'])) {
    $date = mysqli_real_escape_string($db, $_POST['date']);
    $activity = mysqli_real_escape_string($db, $_POST['activity']);
    $query = "INSERT INTO calendar(date, activity) VALUES ('$date', '$activity')";
    if ($sql = mysqli_query($db, $query)) {
        $_SESSION['status'] = "Calendar Added successfully";
        echo ("<script>window.location.href='index.php?tab=calendar';</script>");
    } else {
        $_SESSION['error'] = 'ERROR: ' . mysqli_error($db);
    }
}
// Update Calendar
if (isset($_POST['update'])) {
    $date = mysqli_real_escape_string($db, $_POST['date']);
    $activity = mysqli_real_escape_string($db, $_POST['activity']);
    $id = $_POST['id'];

    if (mysqli_query($db, "UPDATE calendar SET date='$date', activity='$activity' WHERE id=$id")) {
        $_SESSION['status'] = "Calendar Updated successfully";
        echo ("<script>window.location.href='index.php?tab=calendar';</script>");
    } else {
        $_SESSION['error'] = 'ERROR: ' . mysqli_error($db);
    }
}

// Delete Calendar
if (isset($_GET['del'])) {
    $del_id = $_GET['del'];

    if (mysqli_query($db, "DELETE FROM calendar WHERE id=$del_id")) {
        $_SESSION['status'] = "Calendar deleted successfully";
        echo ("<script>window.location.href='index.php?tab=calendar';</script>");
    } else {
        $_SESSION['error'] = 'ERROR: ' . mysqli_error($db);
    }
}

if (isset($_POST['save_calendar'])) {
    $school_id = mysqli_real_escape_string($db, $_POST['school_id']);
    $file_folder = 'uploads/';
    $file_name = $_FILES['calendar']['name'];
    $path = $file_folder . basename($_FILES["calendar"]['name']);
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $filesize = $_FILES["calendar"]['size'];
    $filetmp = $_FILES["calendar"]['tmp_name'];
    if ($ext != "pdf" && $ext != "PDF" && $ext != "jpg" && $ext != 'JPG' && $ext != 'JPEG' && $ext != "jpeg") {
        echo 'File type not supported';
    } else {
        $upload = move_uploaded_file($filetmp, $path);
        $query = "UPDATE school SET  calendar='$file_name'  WHERE id=$school_id";
        if ($sql = mysqli_query($db, $query)) {
            $_SESSION['status'] = "Calendar uploaded successfully";
            echo ("<script>window.location.href='index.php?tab=calendar';</script>");
        } else {
            $_SESSION['error'] = 'ERROR: ' . mysqli_error($db);
        }
    }
}

?>

<div class="inner-section">
    <div class="inner-section-heading mb-4">
        <h4>Calendar</h4>
        <div>
            <a href="#calendar_target"><button class="btn btn-custom btn-sm text-white">Add New <i class="fa fa-plus ml-3"></i></button></a>
            <a href="#upload_calendar"><button class="btn btn-custom btn-sm text-white">Upload <i class="fa fa-arrow-up ml-3"></i></button></a>
        </div>

    </div>
    <table class="table my-4" id="calendardataTable">
        <thead>
            <tr>
                <th>Date</th>
                <th>Activity</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = mysqli_fetch_array($calendar)) { ?>
                <tr>
                    <td><?php echo $row['date'] ?></td>
                    <td><?php echo $row['activity'] ?></td>
                    <td>
                        <a href="index.php?tab=calendar&edit=<?php echo $row['id']; ?>#calendar_target"><button class="btn btn-custom-secondary"><i class="fas fa-edit"></i></button></a>
                        <a href="index.php?tab=calendar&del=<?php echo $row['id']; ?>#calendar"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>
                    </td>
                </tr>
            <?php }; ?>
        </tbody>
    </table>
</div>

<!----------------------------------------------------- Calendar Form --------------------------------------------------------------------------------->
<form id="calendar_target" class="col-md-12 my-4 inner-section" method="POST" action="<?php if (isset($_GET["edit"])) {
                                                                                            echo "";
                                                                                        } else {
                                                                                            echo "";
                                                                                        } ?>">
    <?php if (isset($_GET["edit"])) { ?>
        <h4>Edit Event</h4>
    <?php } else { ?>
        <h4>Add New Event</h4>
    <?php } ?>
    <?php
    if (isset($_GET["edit"])) {
        $edit_id =  $_GET["edit"];
        $edit_state = true;

        $rec = mysqli_query($db, "SELECT * FROM calendar WHERE id=$edit_id");
        $record = mysqli_fetch_array($rec);
        $cal_date = $record['date'];
        $cal_activity = $record['activity'];
        $cal_id = $record["id"];
    }
    ?>
    <div class="sent-notification"></div>
    <div class="form-group form-cont">
        <?php  ?>
        <input type="hidden" name="id" value="<?php echo $cal_id; ?>">
        <input name="date" type="date" class="form-control" placeholder="Date" value="<?php if (isset($_GET["edit"])) {
                                                                                            $edit_state == true;
                                                                                            echo $cal_date;
                                                                                        } ?>">
    </div>
    <div class="form-group form-cont">
        <input name="activity" class="form-control" placeholder="Activity" value="<?php if (isset($_GET["edit"])) {
                                                                                        $edit_state == true;
                                                                                        echo $cal_activity;
                                                                                    } ?>">
    </div>
    <button class="btn btn-custom text-white" type="submit" name="<?php if (isset($_GET["edit"])) {
                                                                        echo "update";
                                                                    } else {
                                                                        echo "save";
                                                                    } ?>"><?php if (isset($_GET["edit"])) {
                                                                                echo "Update";
                                                                            } else {
                                                                                echo "Add to Calendar";
                                                                            } ?></button>
    <?php if (isset($_GET["edit"])) { ?>
        <a href="index.php?tab=calendar" class="btn btn-custom-secondary">Cancel</a>
    <?php } ?>
</form>

<form id="upload_calendar" class="inner-section my-4" action="" method="POST" enctype="multipart/form-data">
    <h4>Upload Calendar</h4>
    <input type="hidden" name="school_id" value="<?php echo $school_id; ?>">
    <div class="form-group">
        <label>Calendar </label>
        <input type="file" name="calendar" class="form-control" required>
        <small class="text-secondary">Upload file should be in either 'PDF' or 'JPG' format</small>
    </div>

    <button type="submit" class="btn btn-custom text-white" name="save_calendar">Upload</button>
</form>

<!----------------------------------------------------- End of Calendar Form --------------------------------------------------------------------------------->

<!--------------------------------------------- Display Table for Calendar ------------------------------------------------------->

<!--------------------------------------------- End of Display Table for Calendar ------------------------------------------------------->

<?php // require('footer.php') 
?>
<!----------------------------------------------------------- End of Calndar Section  ---------------------------------------------------------------->