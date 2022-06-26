<?php
$title = "Admin - UMCATC";
require("config.php");

// Insert into Post
if (isset($_POST['save_staff'])) {
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $contact = mysqli_real_escape_string($db, $_POST['contact']);
    $position = mysqli_real_escape_string($db, $_POST['position']);
    $department = mysqli_real_escape_string($db, $_POST['department']);

    // Image Upload
    $image_folder = 'uploads/';
    $image_name = $_FILES['post_image']['name'];
    $path = $image_folder . basename($_FILES["post_image"]['name']);
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $imagesize = $_FILES["post_image"]['size'];
    $imagetmp = $_FILES["post_image"]['tmp_name'];
    if ($ext === "") {
        $query = "INSERT INTO staff(name, contact, position, department) VALUES ('$name', '$contact', '$position', '$department')";
        if ($sql = mysqli_query($db, $query)) {
            $_SESSION['status'] = "Staff added successfully";
            echo ("<script>window.location.href='index.php?tab=staff';</script>");
        } else {
            echo 'ERROR: ' . mysqli_error($db);
        }
    } elseif ($ext != "png" && $ext != "PNG" && $ext != "jpg" && $ext != 'JPG' && $ext != 'JPEG' && $ext != "jpeg") {
        echo 'File type not supported';
    } else {
        $upload = move_uploaded_file($imagetmp, $path);
        $query = "INSERT INTO staff(name, contact, position, department, image) VALUES ('$name', '$contact', '$position',  '$department', '$image_name')";
        if ($sql = mysqli_query($db, $query)) {
            $_SESSION['status'] = "Staff added successfully";
            echo ("<script>window.location.href='index.php?tab=staff';</script>");
        } else {
            $_SESSION['error'] = 'ERROR: ' . mysqli_error($db);
        }
    }
}
// Update Post
if (isset($_POST['update_staff'])) {
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $contact = mysqli_real_escape_string($db, $_POST['contact']);
    $position = mysqli_real_escape_string($db, $_POST['position']);
    $id = $_POST['id'];
    if (mysqli_query($db, "UPDATE staff SET name='$name', contact='$contact', position='$position', department='$department'  WHERE id=$id")) {
        $_SESSION['status'] = "Staff updated successfully";
        echo ("<script>window.location.href='index.php?tab=staff';</script>");
    } else {
        $_SESSION['error'] = 'ERROR: ' . mysqli_error($db);
    }
}

// Delete Post
if (isset($_GET['del_staff'])) {
    $del_id = $_GET['del_staff'];
    mysqli_query($db, "DELETE FROM staff WHERE id=$del_id");
    $_SESSION['status'] = "Staff deleted successfully";
    echo ("<script>window.location.href='index.php?tab=staff';</script>");
}

?>

<div class=" inner-section">
    <div class="inner-section-heading mb-4">
        <h4>Staff</h4>
        <a href="#staff_target"><button class="btn btn-custom btn-sm text-white">Add New <i class="fa fa-plus ml-3"></i></button></a>
    </div>
    <table class="table my-4" id="staffdataTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Conatct</th>
                <th>Position</th>
                <th>Department</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <?php while ($row = mysqli_fetch_array($staff)) { ?>
            <tr>
                <td class="col-md-3"><?php echo $row['name'] ?></td>
                <td class="col-md-2"><?php echo $row['contact'] ?></td>
                <td class="col-md-2"><?php echo $row['position'] ?></td>
                <td class="col-md-2"><?php echo $row['department'] ?></td>
                <td class="col-md-2">
                    <img src="uploads/<?php echo $row['image'] ?>" class="w-50">
                </td>
                <td class="col-md-3">

                    <!-- <a href="index.php?tab=news&edit_post=<?php echo $row['id']; ?>#posts"><button class="btn btn-custom-secondary">Edit</button></a> -->
                    <a href="index.php?tab=staff&edit_post=<?php echo $row['id']; ?>#staff_target"><button class="btn btn-custom-secondary"><i class="fas fa-edit"></i></button></a>
                    <a href="index.php?tab=staff&del_staff=<?php echo $row['id']; ?>#posts"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>
                    <!-- <a href="index.php?tab=news&del_post=<?php echo $row['id']; ?>#posts"><button class="btn btn-danger">Delete</button></a> -->
                </td>
            </tr>
        <?php }; ?>
    </table>
</div>

<!----------------------------------------------------- News & Post Form --------------------------------------------------------------------------------->
<div class="inner-section my-4">
    <?php if (isset($_GET["edit_post"])) { ?>
        <h4>Edit Staff</h4>
    <?php } else { ?>
        <h4>Add New Staff</h4>
    <?php } ?>
    <form id="staff_target" class="col-md-12 my-4" method="POST" action="<?php if (isset($_GET["edit_post"])) {
                                                                                echo "";
                                                                            } else {
                                                                                echo "";
                                                                            } ?>" enctype="multipart/form-data">

        <?php
        if (isset($_GET["edit_post"])) {
            $edit_id =  $_GET["edit_post"];
            $edit_state = true;
            $rec = mysqli_query($db, "SELECT * FROM staff WHERE id=$edit_id");
            $record = mysqli_fetch_array($rec);
            $new_name = $record['name'];
            $new_contact = $record['contact'];
            $new_position = $record['position'];
            $new_department = $record['department'];
            $new_id = $record["id"];
        } ?>
        <div class="sent-notification"></div>
        <div class="form-group form-cont">
            <input type="hidden" name="id" value="<?php echo $new_id; ?>">
            <input name="name" type="text" class="form-control" placeholder="Name of Staff" value="<?php if (isset($_GET["edit_post"])) {
                                                                                                        $edit_state == true;
                                                                                                        echo $new_name;
                                                                                                    } ?>">
        </div>
        <div class="form-group form-cont">
            <input name="contact" class="form-control" placeholder="Contact" value="<?php if (isset($_GET["edit_post"])) {
                                                                                        $edit_state == true;
                                                                                        echo $new_contact;
                                                                                    } ?>">

        </div>
        <div class="form-group">
            <select name="position" class="form-control">
                <option value="--Position/Category"><?php if (isset($_GET["edit_post"])) {
                                                        $edit_state == true;
                                                        echo $new_position;
                                                    } else {
                                                        echo "--Position/Category--";
                                                    } ?></option>
                <option value="Teacher">Teacher</option>
                <option value="Lecturer">Lecturer</option>
                <option value="Board of Governor">Board of Governor</option>
                <option value="Non-Academic Staff">Non-Academic Staff</option>
                <option value="HOD">HOD</option>
                <option value="Provost">Provost</option>
                <option value="Proprietor">Proprietor</option>
                <option value="Dean">Dean</option>
                <option value="Registrar">Registrar</option>
                <option value="Bursar">Bursar</option>
                <option value="Secretary">Secretary</option>
                <option value="Co-ordinator">Co-ordinator</option>
                <option value="Adviser">Adviser</option>
                <option value="Librarian">Librarian</option>
                <option value="Chaplain">Chaplain</option>
            </select>
        </div>
        <div class="form-group form-cont">
            <input name="department" class="form-control" placeholder="Department" value="<?php if (isset($_GET["edit_post"])) {
                                                                                                $edit_state == true;
                                                                                                echo $new_department;
                                                                                            } ?>">

        </div>
        <div class="form-group">
            <input name="post_image" type="file" id="gallery_images">
        </div>
        <button class="btn btn-custom text-white" type="submit" name="<?php if (isset($_GET["edit_post"])) {
                                                                            echo "update_staff";
                                                                        } else {
                                                                            echo "save_staff";
                                                                        } ?>"><?php if (isset($_GET["edit_post"])) {
                                                                                    echo "Update Staff";
                                                                                } else {
                                                                                    echo "Add to Staff";
                                                                                } ?></button>
        <?php if (isset($_GET["edit_post"])) { ?>
            <a href="index.php?tab=staff" class="btn btn-custom-secondary">Cancel</a>
        <?php } ?>

    </form>
</div>

<!----------------------------------------------------- End of News & Post Form --------------------------------------------------------------------------------->

<!--------------------------------------------- Display Table for News & Post ------------------------------------------------------->


<!--------------------------------------------- End of Display Table for News & Post ------------------------------------------------------->
<!-- </div> -->


<?php //require('footer.php') 
?>