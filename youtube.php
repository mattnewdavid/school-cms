<?php
require("config.php");
$video = mysqli_query($db, "SELECT * FROM videos ORDER BY `id` DESC");
// Insert into Video
if (isset($_POST['save_video'])) {
    $title = $_POST['title'];
    $link = $_POST['link'];

    $query = "INSERT INTO videos(title, link) VALUES ('$title', '$link')";
    if ($sql = mysqli_query($db, $query)) {
        $_SESSION['status'] = "Video added successfully";
        echo ("<script>window.location.href='index.php?tab=youtube';</script>");
    } else {
        $_SESSION['status'] = 'ERROR: ' . mysqli_error($db);
        echo ("<script>window.location.href='index.php?tab=youtube';</script>");
    }
}
if (isset($_POST['update_video'])) {
    $title = $_POST['title'];
    $link = $_POST['link'];
    $id = $_POST['id'];
    $query = mysqli_query($db, "UPDATE videos SET title='$title', link='$link' WHERE id=$id");
    if ($query) {
        $_SESSION['status'] = "Post updated successfully";
        echo ("<script>window.location.href='index.php?tab=youtube';</script>");
    } else {
        $_SESSION['status'] = 'ERROR: ' . mysqli_error($db);
        echo ("<script>window.location.href='index.php?tab=youtube';</script>");
    }
}
if (isset($_GET['del_video'])) {
    $del_id = $_GET['del_video'];
    $query = mysqli_query($db, "DELETE FROM videos WHERE id=$del_id");
    if ($query) {
        $_SESSION['status'] = "Video updated successfully";
        echo ("<script>window.location.href='index.php?tab=youtube';</script>");
    } else {
        $_SESSION['status'] = 'ERROR: ' . mysqli_error($db);
        echo ("<script>window.location.href='index.php?tab=youtube';</script>");
    }
}
?>

<div class="container-info mb-5">
    <h4>How to get Youtube Video Embed Links</h4>
    <p>Follow the steps below after opening Video on Youtube</p>
    <div class="my-2">
        <p>1. Click on the <strong>Share</strong> button underneath the video</p>
        <img src="yt-1.PNG">
    </div>
    <div class="my-2">
        <p>2. Click on <strong>Embed</strong></p>
        <img src="yt-2.PNG">
    </div>
    <div class="my-2">
        <p>3. Highlight and copy the embed link which is the value of the <strong>src</strong> attribute. The link selected in the image below <i class="fa fa-arrow-down"></i></p>
        <img class="w-75" src="yt-3.PNG">
    </div>
    <div class="my-2">
        <p>4. Paste the link in the Link field under the Add New Video block below. Also copy and paste the title of the Video and paste it in the Title field.</p>
    </div>
</div>

<div class="inner-section">
    <div class="inner-section-heading mb-4">
        <h4>Video Embed Links</h4>
        <a href="#youtube_target"><button class="btn btn-custom btn-sm text-white">Add New <i class="fa fa-plus ml-3"></i></button></a>
    </div>
    <table class="table my-4">
        <tr>
            <th>Link ID</th>
            <th>Link Title</th>
            <th>Link</th>
        </tr>
        <?php while ($row = mysqli_fetch_array($video)) { ?>
            <tr>
                <td class="col-md-2"><?php echo $row['id'] ?></td>
                <td class="col-md-3">
                    <p><?php echo $row['title'] ?></p>
                </td>
                <td class="col-md-4">
                    <p><?php echo $row['link'] ?></p>
                </td>
                <td class="col-md-3">
                    <a href="index.php?tab=youtube&edit_post=<?php echo $row['id']; ?>#youtube_target"><button class="btn btn-custom-secondary"><i class="fas fa-edit"></i></button></a>
                    <a href="index.php?tab=youtube&del_video=<?php echo $row['id']; ?>#"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>
                </td>
            </tr>
        <?php }; ?>
    </table>
</div>

<!----------------------------------------------------- News & Post Form --------------------------------------------------------------------------------->
<form id="youtube_target" class="col-md-10 my-4 inner-section" method="POST" action="<?php if (isset($_GET["edit_post"])) {
                                                                                            echo "";
                                                                                        } else {
                                                                                            echo "";
                                                                                        } ?>" enctype="multipart/form-data">
    <?php if (isset($_GET["edit_post"])) { ?>
        <h4>Edit Video</h4>
    <?php } else { ?>
        <h4>Add New Video</h4>
    <?php } ?>
    <?php
    if (isset($_GET["edit_post"])) {
        $edit_id =  $_GET["edit_post"];
        $edit_state = true;

        $rec = mysqli_query($db, "SELECT * FROM videos WHERE id=$edit_id");
        $record = mysqli_fetch_array($rec);
        $new_title = $record['title'];
        $new_link = $record['link'];
        $new_id = $record["id"];
    } ?>
    <div class="sent-notification"></div>
    <div class="form-group form-cont">
        <input type="hidden" name="id" value="<?php echo $new_id; ?>">
        <input type="hidden" name="img" value="<?php echo $new_img; ?>">
        <input name="title" type="text" class="form-control mb-4" placeholder="Title" value="<?php if (isset($_GET["edit_post"])) {
                                                                                                    $edit_state == true;
                                                                                                    echo $new_title;
                                                                                                } ?>">
        <input name="link" type="text" class="form-control" placeholder="Link" value="<?php if (isset($_GET["edit_post"])) {
                                                                                            $edit_state == true;
                                                                                            echo $new_link;
                                                                                        } ?>">
    </div>


    <button class="btn btn-custom text-white" type="submit" name="<?php if (isset($_GET["edit_post"])) {
                                                                        echo "update_video";
                                                                    } else {
                                                                        echo "save_video";
                                                                    } ?>"><?php if (isset($_GET["edit_post"])) {
                                                                                echo "Update Video";
                                                                            } else {
                                                                                echo "Add to Videos";
                                                                            } ?></button>
    <?php if (isset($_GET["edit_post"])) { ?>
        <a href="index.php?tab=youtube" class="btn btn-custom-secondary">Cancel</a>
    <?php } ?>
</form>

<!----------------------------------------------------- End of News & Post Form --------------------------------------------------------------------------------->

<!--------------------------------------------- Display Table for News & Post ------------------------------------------------------->



<!--------------------------------------------- End of Display Table for News & Post ------------------------------------------------------->

<!----------------------------------------------------------- End of News & Post Section  ---------------------------------------------------------------->