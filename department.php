<?php
require("config.php");

// Insert into department
if (isset($_POST['save_department'])) {
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $detail = mysqli_real_escape_string($db, $_POST['detail']);
    $hod = mysqli_real_escape_string($db, $_POST['hod']);
    $query = "INSERT INTO department(name, detail, hod) VALUES ('$name', '$detail', '$hod')";
    if ($sql = mysqli_query($db, $query)) {
        $_SESSION['status'] = "Information Added successfully";
        echo ("<script>window.location.href='index.php?tab=department';</script>");
    } else {
        $_SESSION['error'] = 'ERROR: ' . mysqli_error($db);
    }
}
// Update department
if (isset($_POST['update_department'])) {
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $detail = mysqli_real_escape_string($db, $_POST['detail']);
    $id = $_POST['id'];

    if (mysqli_query($db, "UPDATE department SET name='$name', detail='$detail' WHERE id=$id")) {
        $_SESSION['status'] = "Information Updated successfully";
        echo ("<script>window.location.href='index.php?tab=department';</script>");
    } else {
        $_SESSION['error'] = 'ERROR: ' . mysqli_error($db);
    }
}

// Delete department
if (isset($_GET['del_department'])) {
    $del_id = $_GET['del_department'];

    if (mysqli_query($db, "DELETE FROM department WHERE id=$del_id")) {
        $_SESSION['status'] = "Information deleted successfully";
        echo ("<script>window.location.href='index.php?tab=department';</script>");
    } else {
        $_SESSION['error'] = 'ERROR: ' . mysqli_error($db);
    }
}

?>



<div class="inner-section">
    <div class="inner-section-heading mb-4">
        <h4>Departments</h4>
        <a href="#form_target"><button class="btn btn-custom btn-sm text-white">Add New <i class="fa fa-plus ml-3"></i></button></a>
    </div>
    <table class="table my-4" id="departmentdataTable">
        <thead>
            <tr>
                <th>Department</th>
                <th>Details</th>
                <th>HOD</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = mysqli_fetch_array($department)) { ?>
                <tr>
                    <td><?php echo $row['name'] ?></td>
                    <td><?php echo ( substr( $row['detail'], 0, 500)) ?></td>
                    <td><?php echo $row['hod'] ?></td>
                    <td class="col-md-2">
                        <a href="index.php?tab=department&edit_department=<?php echo $row['id']; ?>#form_target"><button class="btn btn-custom-secondary"><i class="fas fa-edit"></i></button></a>
                        <a href="index.php?tab=department&del_department=<?php echo $row['id']; ?>#department"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>
                    </td>
                </tr>
            <?php }; ?>
        </tbody>
    </table>
</div>

<!----------------------------------------------------- department  Form --------------------------------------------------------------------------------->
<form id="form_target" class="col-md-12 my-4 inner-section" method="POST" action="<?php if (isset($_GET["edit_department"])) {
                                                                        echo "";
                                                                    } else {
                                                                        echo "";
                                                                    } ?>">
    <?php if (isset($_GET["edit_department"])) { ?>
        <h4>Edit Departmentn</h4>
    <?php } else { ?>
        <h4>Add Department</h4>
    <?php } ?>
    <?php
    if (isset($_GET["edit_department"])) {
        $edit_id =  $_GET["edit_department"];
        $edit_state = true;

        $rec = mysqli_query($db, "SELECT * FROM department WHERE id=$edit_id");
        $record = mysqli_fetch_array($rec);
        $news_name = $record['name'];
        $news_detail = $record['detail'];
        $news_hod = $record['hod'];

        $cal_id = $record["id"];
    }
    ?>
    <div class="sent-notification"></div>
    <div class="form-group form-cont">
        <?php  ?>
        <input type="hidden" name="id" value="<?php echo $cal_id; ?>">
        <input name="name" type="text" class="form-control" placeholder="Name of Department" value="<?php if (isset($_GET["edit_department"])) {
                                                                                                        $edit_state == true;
                                                                                                        echo $news_name;
                                                                                                    } ?>">
    </div>
    <div class="form-group form-cont">
        <?php  ?>
        <input type="hidden" name="id" value="<?php echo $cal_id; ?>">
        <input name="hod" type="text" class="form-control" placeholder="Head of Department" value="<?php if (isset($_GET["edit_department"])) {
                                                                                                        $edit_state == true;
                                                                                                        echo $news_hod;
                                                                                                    } ?>">
    </div>
    <div class="form-group form-cont">
        <textarea id="departmenttextarea" name="detail" class="form-control" placeholder="Department's Detail"><?php if (isset($_GET["edit_department"])) {
                                                                                                                    $edit_state == true;
                                                                                                                    echo $news_detail;
                                                                                                                } ?>
                                                                                                </textarea>
    </div>
    <button class="btn btn-custom text-white" type="submit" name="<?php if (isset($_GET["edit_department"])) {
                                                                        echo "update_department";
                                                                    } else {
                                                                        echo "save_department";
                                                                    } ?>"><?php if (isset($_GET["edit_department"])) {
                                                                                echo "Update Department";
                                                                            } else {
                                                                                echo "Add Department";
                                                                            } ?></button>
    <?php if (isset($_GET["edit_department"])) { ?>
        <a href="index.php?tab=department" class="btn btn-custom-secondary">Cancel</a>
    <?php } ?>
</form>

<!----------------------------------------------------- End of department Form --------------------------------------------------------------------------------->

<!--------------------------------------------- Display Table for department ------------------------------------------------------->

<!--------------------------------------------- End of Display Table for department ------------------------------------------------------->

<!----------------------------------------------------------- End of department Section  ---------------------------------------------------------------->
<?php //require('footer.php') 
?>