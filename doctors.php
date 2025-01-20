<?php 
$page_title="Doctors";
$page_name="Doctor";
$fname="doctors.php";
include('header.php'); 

// Assuming you have a valid connection in $conn
// Make sure to connect to your database before using the query

// Check if the connection is established
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Getting all records from the doctor table
$result = mysqli_query($conn, "SELECT * FROM doctor"); 
?>   
<?php
// Display success message if added successfully
if (isset($_GET['s']) && $_GET['s'] == 'success') {
    echo '<p style="color:green;">Doctor successfully added!</p>';
}
?>
<style>
.innerTitle {
    margin-bottom: 0px;
}
</style>
<section class="content px-2">
    <div class="row">
        <div class="col-md-12">
            <div class="filterOuter">
                <h5>Filter</h5>
                <div class="filterinner d-flex align-items-center">
                    <select class="selectpicker">
                        <option>Status</option>
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>
                    <div class="serchBar">
                        <input type="text" class="form-control" placeholder="Global Search">
                        <i class="fa-light fa-magnifying-glass"></i>
                    </div>
                </div>
            </div>
            <div class="mainTitle innerTitle mt-3 d-flex align-items-center justify-content-between">
                <h3>Doctor</h3>
                <a href="#" class="btn ms-auto filterBtn"><i class="fa-light fa-print"></i> Print</a>
                <div class="dropdown mx-2">
                    <button class="btn filterBtn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-light fa-file-lines"></i> Export
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="#"><i class="fa-light fa-file-lines"></i> Export CSV</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fa-light fa-file-lines"></i> Export JSON</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fa-light fa-file-lines"></i> Export XLSX</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fa-light fa-file-lines"></i> Export HTML</a></li>
                    </ul>
                </div>
                <a href="add_doctor.php" class="btn btn-primary">Add New User</a>
            </div>
            <div class="table-responsive">
                <table id="example1" class="table" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Images</th>
                            <th>Doctor</th>
                            <th>Speciality</th>
                            <th>Contact No</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>City</th>
                            <th>About</th>
                            <th>Education</th>
                            <th>Experience</th>
                            <th>Added At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Loop through the results and display each doctor's data
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
								$abtus = substr($row['about'], 0, 100);
								$abtus = $abtus.'...';
                                echo "<tr>";
                               // Action links: edit and delete
                               echo "<td><a href='edit_doctors.php?id=" . $row['id'] . "' class='text-warning ms-2'><i class='fa-solid fa-edit'></i></a>
                                <a href='delete_doctors.php?id=" . $row['id'] . "' class='text-danger ms-2' onclick=\"return confirm('Are you sure you want to delete this doctors?');\"><i class='fa-solid fa-trash-can'></i></a></td>";
                                echo "<td><img src='img/user-image.png' alt='Doctor Image'></td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['speciality'] . "</td>";
                                echo "<td>" . $row['contact_no'] . "</td>";
                                echo "<td>" . $row['email_address'] . "</td>";
                                echo "<td><div class='form-check form-switch'><input class='form-check-input' type='checkbox' role='switch' id='flexSwitchCheckChecked' " . ($row['status'] == 'active' ? 'checked' : '') . "><label class='form-check-label' for='flexSwitchCheckChecked'>Active</label></div></td>";
                                echo "<td>" . $row['city'] . "</td>";
                                echo "<td>" . $abtus . "</td>";
                                echo "<td>" . $row['education'] . "</td>";
                                echo "<td>" . $row['exp_in_year'] . "</td>";
                                echo "<td>" . $row['created_at'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='12' class='text-center'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php 
include('footer.php'); 
?> 

