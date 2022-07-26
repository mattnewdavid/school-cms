<?php
$school = mysqli_query($db, "SELECT * FROM school ORDER BY `id` DESC");

$post = mysqli_query($db, "SELECT * FROM post ORDER BY `id` DESC");

$calendar = mysqli_query($db, "SELECT * FROM calendar ORDER BY `calendar`.`date` ASC");

$newsletter = mysqli_query($db, "SELECT * FROM newsletter ORDER BY `id` DESC");

$gallery = mysqli_query($db, "SELECT * FROM gallery ORDER BY `id` DESC");

$gallery_distinct = mysqli_query($db, "SELECT DISTINCT category FROM gallery ORDER BY `id` DESC");

$staff = mysqli_query($db, "SELECT * FROM staff ORDER BY `id` DESC");

$review = mysqli_query($db, "SELECT * FROM review ORDER BY `id` DESC");

$department = mysqli_query($db, "SELECT * FROM department ORDER BY `id` DESC");

$video = mysqli_query($db, "SELECT * FROM videos ORDER BY `id` DESC");

$journal = mysqli_query($db, "SELECT * FROM journal ORDER BY `id` DESC");



if ($data = mysqli_fetch_array($school)) {
    $school_id = $data['id'];
    $school_name = $data['name'];
    $school_address = $data['address'];
    $school_contact = $data['contact'];
    $school_email = $data['email'];
    $school_logo = $data['logo'];
    $school_link = $data['link'];
    $school_year = $data['year'];
    $school_term = $data['term'];
}