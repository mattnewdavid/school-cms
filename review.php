<?php
require("config.php");

// Insert into Newsletter
if (isset($_POST['save_review'])) {
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $review_body = mysqli_real_escape_string($db, $_POST['review']);
    $query = "INSERT INTO review(name, review) VALUES ('$name', '$review_body')";
    if ($sql = mysqli_query($db, $query)) {
        $_SESSION['status'] = "Review Added successfully";
        echo ("<script>window.location.href='index.php?tab=review';</script>");
    } else {
        $_SESSION['error'] = 'ERROR: ' . mysqli_error($db);
        echo ("<script>window.location.href='index.php?tab=review';</script>");
    }
}
// Update Newsletter
if (isset($_POST['update_review'])) {
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $review = mysqli_real_escape_string($db, $_POST['review']);
    $id = $_POST['id'];

    if (mysqli_query($db, "UPDATE review SET name='$name', review='$review' WHERE id=$id")) {
        $_SESSION['status'] = "Review Updated successfully";
        echo ("<script>window.location.href='index.php?tab=review';</script>");
    } else {
        $_SESSION['error'] = 'ERROR: ' . mysqli_error($db);
        echo ("<script>window.location.href='index.php?tab=review';</script>");
    }
}

// Delete Newsletter
if (isset($_GET['del_review'])) {
    $del_id = $_GET['del_review'];

    if (mysqli_query($db, "DELETE FROM review WHERE id=$del_id")) {
        $_SESSION['status'] = "Review deleted successfully";
        echo ("<script>window.location.href='index.php?tab=review';</script>");
    } else {
        $_SESSION['error'] = 'ERROR: ' . mysqli_error($db);
        echo ("<script>window.location.href='index.php?tab=review';</script>");
    }
}

?>


<div class="inner-section">
    <div class="inner-section-heading mb-4">
        <h4>Review</h4>
        <a href="#review_target"><button class="btn btn-custom btn-sm text-white">Add New <i class="fa fa-plus ml-3"></i></button></a>
    </div>
    <table class="table my-4" id="reviewdataTable">
        <thead>
            <tr>
                <th>Review</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_array($review)) { ?>
                <tr>
                    <td><?php echo $row['review'] ?></td>
                    <td><?php echo $row['name'] ?></td>
                    <td class="col-md-2">
                        <a href="index.php?tab=review&edit_new=<?php echo $row['id']; ?>#review_target"><button class="btn btn-custom-secondary"><i class="fas fa-edit"></i></button></a>
                        <a href="index.php?tab=review&del_review=<?php echo $row['id']; ?>#"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>
                    </td>
                </tr>
            <?php }; ?>
        </tbody>
    </table>
</div>

<!----------------------------------------------------- Newsletter  Form --------------------------------------------------------------------------------->
<form id="review_target" class="col-md-12 my-4 inner-section" method="POST" action="<?php if (isset($_GET["edit_new"])) {
                                                                                        echo "";
                                                                                    } else {
                                                                                        echo "";
                                                                                    } ?>">
    <?php if (isset($_GET["edit_new"])) { ?>
        <h4>Edit Information</h4>
    <?php } else { ?>
        <h4>New Review</h4>
    <?php } ?>
    <?php
    if (isset($_GET["edit_new"])) {
        $edit_id =  $_GET["edit_new"];
        $edit_state = true;

        $rec = mysqli_query($db, "SELECT * FROM review WHERE id=$edit_id");
        $record = mysqli_fetch_array($rec);
        $news_name = $record['name'];
        $news_review = $record['review'];
        $cal_id = $record["id"];
    }
    ?>

    <div class="form-group form-cont">
        <textarea name="review" class="form-control" rows="10"><?php if (isset($_GET["edit_new"])) {
                                                                    $edit_state == true;
                                                                    echo $news_review;
                                                                } else {
                                                                    echo "Write Your Review Here...";
                                                                } ?>
                                                                                                </textarea>
    </div>
    <div class="form-group form-cont">
        <input type="hidden" name="id" value="<?php echo $cal_id; ?>">
        <input name="name" type="text" class="form-control" placeholder="Name" value="<?php if (isset($_GET["edit_new"])) {
                                                                                            $edit_state == true;
                                                                                            echo $news_name;
                                                                                        } ?>">
    </div>
    <button class="btn btn-custom text-white" type="submit" name="<?php if (isset($_GET["edit_new"])) {
                                                                        echo "update_review";
                                                                    } else {
                                                                        echo "save_review";
                                                                    } ?>"><?php if (isset($_GET["edit_new"])) {
                                                                                echo "Update Review";
                                                                            } else {
                                                                                echo "Add Review";
                                                                            } ?></button>
    <?php if (isset($_GET["edit_new"])) { ?>
        <a href="index.php?tab=review" class="btn btn-custom-secondary">Cancel</a>
    <?php } ?>
</form>

<!----------------------------------------------------- End of Newsletter Form --------------------------------------------------------------------------------->

<!--------------------------------------------- Display Table for Newsletter ------------------------------------------------------->

<!--------------------------------------------- End of Display Table for Newsletter ------------------------------------------------------->

<!----------------------------------------------------------- End of Newsletter Section  ---------------------------------------------------------------->
<?php //require('footer.php') 
?>