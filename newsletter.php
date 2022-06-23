<?php

$title = "Edit Newsletter - Cherub Schools";
require("config.php");

// Insert into Newsletter
if (isset($_POST['save_new'])) {
    $title = mysqli_real_escape_string($db, $_POST['title']);
    $body = mysqli_real_escape_string($db, $_POST['body']);
    $query = "INSERT INTO newsletter(title, body) VALUES ('$title', '$body')";
    if ($sql = mysqli_query($db, $query)) {
        $_SESSION['status'] = "Information Added successfully";
        echo ("<script>window.location.href='index.php?tab=newsletter';</script>");
    } else {
        $_SESSION['error'] = 'ERROR: ' . mysqli_error($db);
    }
}
// Update Newsletter
if (isset($_POST['update_new'])) {
    $title = mysqli_real_escape_string($db, $_POST['title']);
    $body = mysqli_real_escape_string($db, $_POST['body']);
    $id = $_POST['id'];

    if (mysqli_query($db, "UPDATE newsletter SET title='$title', body='$body' WHERE id=$id")) {
        $_SESSION['status'] = "Information Updated successfully";
        echo ("<script>window.location.href='index.php?tab=newsletter';</script>");
    } else {
        $_SESSION['error'] = 'ERROR: ' . mysqli_error($db);
    }
}

// Delete Newsletter
if (isset($_GET['del_new'])) {
    $del_id = $_GET['del_new'];

    if (mysqli_query($db, "DELETE FROM newsletter WHERE id=$del_id")) {
        $_SESSION['status'] = "Information deleted successfully";
        echo ("<script>window.location.href='index.php?tab=newsletter';</script>");
    } else {
        $_SESSION['error'] = 'ERROR: ' . mysqli_error($db);
    }
}

if (isset($_POST['save_newsletter'])) {
    $school_id = mysqli_real_escape_string($db, $_POST['school_id']);
    $file_folder = 'uploads/';
    $file_name = $_FILES['newsletter']['name'];
    $path = $file_folder . basename($_FILES["newsletter"]['name']);
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $filesize = $_FILES["newsletter"]['size'];
    $filetmp = $_FILES["newsletter"]['tmp_name'];
    if ($ext != "pdf" && $ext != "PDF" && $ext != "jpg" && $ext != 'JPG' && $ext != 'JPEG' && $ext != "jpeg") {
        echo 'File type not supported';
    } else {
        $upload = move_uploaded_file($filetmp, $path);
        $query = "UPDATE school SET  newsletter='$file_name'  WHERE id=$school_id";
        if ($sql = mysqli_query($db, $query)) {
            $_SESSION['status'] = "Newsletter uploaded successfully";
            echo ("<script>window.location.href='index.php?tab=newsletter';</script>");
        } else {
            $_SESSION['error'] = 'ERROR: ' . mysqli_error($db);
        }
    }
}
?>
<?php //require('header.php') 
?>


<div class="inner-section">
    <div class="inner-section-heading mb-4">
        <h4>NewsLetter</h4>
        <div>
            <a href="#add_newsletter"><button class="btn btn-custom btn-sm text-white">Add New <i class="fa fa-plus ml-3"></i></button></a>
            <a href="#upload_newsletter"><button class="btn btn-custom btn-sm text-white">Upload <i class="fa fa-arrow-up ml-3"></i></button></a>
        </div>
    </div>
    <table class="table my-4" id="newsletterdataTable">
        <thead>
            <tr>
                <th>Title</th>
                <th>Body</th>
                <th>Action</th>
            </tr>
        </thead>
        <?php while ($row = mysqli_fetch_array($newsletter)) { ?>
            <tr>
                <td><?php echo $row['title'] ?></td>
                <td><?php echo $row['body'] ?></td>
                <td class="col-md-2">
                    <a href="index.php?tab=newsletter&edit_new=<?php echo $row['id']; ?>#add_newsletter"><button class="btn btn-custom-secondary"><i class="fas fa-edit"></i></button></a>
                    <a href="index.php?tab=newsletter&del_new=<?php echo $row['id']; ?>#newsletter"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>
                </td>
            </tr>
        <?php }; ?>
    </table>
</div>

<!----------------------------------------------------- Newsletter  Form --------------------------------------------------------------------------------->
<form id="add_newsletter" class="col-md-12 my-4 inner-section" method="POST" action="<?php if (isset($_GET["edit_new"])) {
                                                                                        echo "";
                                                                                    } else {
                                                                                        echo "";
                                                                                    } ?>">
    <?php if (isset($_GET["edit_new"])) { ?>
        <h4>Edit Information</h4>
    <?php } else { ?>
        <h4>Add Information</h4>
    <?php } ?>
    <?php
    if (isset($_GET["edit_new"])) {
        $edit_id =  $_GET["edit_new"];
        $edit_state = true;

        $rec = mysqli_query($db, "SELECT * FROM newsletter WHERE id=$edit_id");
        $record = mysqli_fetch_array($rec);
        $news_title = $record['title'];
        $news_body = $record['body'];
        $cal_id = $record["id"];
    }
    ?>
    <div class="sent-notification"></div>
    <div class="form-group form-cont">
        <?php  ?>
        <input type="hidden" name="id" value="<?php echo $cal_id; ?>">
        <input name="title" type="text" class="form-control" placeholder="Title" value="<?php if (isset($_GET["edit_new"])) {
                                                                                            $edit_state == true;
                                                                                            echo $news_title;
                                                                                        } ?>">
    </div>
    <div class="form-group form-cont">
        <textarea id="newslettertextarea" name="body" class="form-control" placeholder="Body"><?php if (isset($_GET["edit_new"])) {
                                                                                                    $edit_state == true;
                                                                                                    echo $news_body;
                                                                                                } ?>
                                                                                                </textarea>
    </div>
    <button class="btn btn-custom text-white" type="submit" name="<?php if (isset($_GET["edit_new"])) {
                                                                        echo "update_new";
                                                                    } else {
                                                                        echo "save_new";
                                                                    } ?>"><?php if (isset($_GET["edit_new"])) {
                                                                                echo "Update Info";
                                                                            } else {
                                                                                echo "Add Info";
                                                                            } ?></button>
    <?php if (isset($_GET["edit_new"])) { ?>
        <a href="index.php?tab=newsletter" class="btn btn-custom-secondary">Cancel</a>
    <?php } ?>
</form>

<form id="upload_newsletter" class="inner-section my-4" action="" method="POST" enctype="multipart/form-data">
    <h4>Upload NewsLetter</h4>
    <input type="hidden" name="school_id" value="<?php echo $school_id; ?>">
    <div class="form-group">
        <label>News Letter </label>
        <input type="file" name="newsletter" class="form-control" required>
        <small class="text-secondary">Upload file should be in either 'PDF' or 'JPG' format</small>
    </div>

    <button type="submit" class="btn btn-custom text-white" name="save_newsletter">Upload</button>
</form>

<!----------------------------------------------------- End of Newsletter Form --------------------------------------------------------------------------------->

<!--------------------------------------------- Display Table for Newsletter ------------------------------------------------------->

<!--------------------------------------------- End of Display Table for Newsletter ------------------------------------------------------->

<!----------------------------------------------------------- End of Newsletter Section  ---------------------------------------------------------------->
<?php //require('footer.php') 
?>