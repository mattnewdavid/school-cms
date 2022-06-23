<?php if (isset($_SESSION['status'])) { ?>
    <div class="alert alert-success alert-dismissible px-5 py-2 mx-4" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <p>
            <i class="fa fa-check mr-3"></i>
            <?php echo $_SESSION['status'];
            unset($_SESSION['status']);
            ?>
        </p>
    </div>
<?php  }  ?>
<?php if (isset($_SESSION['error'])) { ?>

    <div class="alert alert-danger alert-dismissible px-5 mx-4" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <p>
            <i class="fa fa-exclamation-triangle mr-3"></i>
            <?php echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?><br>
            Contact Support for help

        </p>
    </div>
<?php } ?>
<script>
    // window.setTimeout(function(){
    //     $(".alert").fadeTo(5000, 0).slideUp(500, function(){
    //         $(this).remove();
    //     })
    // })
</script>