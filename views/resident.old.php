<?php


session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../views/login.php');
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident CRUD with DataTables</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <style>
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 1rem;
            float: right;
        }
        .dataTables_wrapper .dataTables_filter {
            float: left;
        }
        .dataTables_wrapper .dataTables_length {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <h1 class="text-center">Resident Management</h1>
        <a href="admin.php">Home</a>
        <a href="../logout.php">Logout</a>
        <!-- Modal Trigger -->
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#residentModal">Add Resident</button>
        <table class="table table-bordered" id="residentTable" style="width: 100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Suffix Name</th>
                    <th>Age</th>
                    <th>Birthday</th>
                    <th>Purok</th>
                    <th>Occupation</th>
                    <th style="width:142px;">Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>


<!-- Modal -->
<div class="modal fade" id="residentModal" tabindex="-1" role="dialog" aria-labelledby="residentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="addResidentForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="residentModalLabel">Add Resident</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editId">
                    
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="fname">First Name</label>
                                <input type="text" class="form-control" id="fname" name="fname" style="text-transform: capitalize;" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="mname">Middle Name</label>
                                <input type="text" class="form-control" id="mname" name="mname" style="text-transform: capitalize;" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="lname">Last Name</label>
                                <input type="text" class="form-control" id="lname" name="lname" style="text-transform: capitalize;" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="suffix">Suffix Name</label>
                                <input type="text" class="form-control" id="suffix" name="suffix" style="text-transform: capitalize;">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="custom-select" id="gender" name="gender" required>
                                    <option value="">Select Option</option>
                                    <option value="Female">Female</option>
                                    <option value="Male">Male</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="date" class="form-control" id="dob" name="dob" max="<?= date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="civil_status">Civil Status</label>
                                <select class="custom-select" id="civil_status" name="civil_status" required>
                                    <option value="">Select Option</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Separated or Divorced">Separated or Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nationality">Nationality</label>
                                <input type="text" class="form-control" id="nationality" name="nationality" style="text-transform: capitalize;" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="religion">Religion</label>
                                <input type="text" class="form-control" id="religion" name="religion" style="text-transform: capitalize;" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="mobile">Mobile Number</label>
                                <input type="tel" class="form-control" id="mobile" name="mobile" maxlength="11" placeholder="09XXXXXXXXX" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="sample@gmail.com" style="text-transform: lowercase;" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="house_number">House Number/Bldg. Number</label>
                                <input type="text" class="form-control" id="house_number" name="house_number" style="text-transform: capitalize;" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="purok">Block/Purok/Sitio/Street/Zone</label>
                                <input type="text" class="form-control" id="purok" name="purok" style="text-transform: capitalize;" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="brgy">Barangay Address</label>
                                <input type="text" class="form-control" id="brgy" name="brgy" style="text-transform: capitalize;" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="head_of_family">Head of Household</label>
                                <input type="text" class="form-control" id="head_of_family" name="head_of_family" style="text-transform: capitalize;" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="household_composition">Household Composition</label>
                                <input type="text" class="form-control" id="household_composition" name="household_composition" style="text-transform: capitalize;" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="occupation">Occupation/Source of Income</label>
                                <input type="text" class="form-control" id="occupation" name="occupation" style="text-transform: capitalize;" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="educational_attainment">Educational Attainment</label>
                                <input type="text" class="form-control" id="educational_attainment" name="educational_attainment" style="text-transform: capitalize;" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="type_of_residency">Type of Residency</label>
                                <select class="custom-select" id="type_of_residency" name="type_of_residency" required>
                                    <option value="">Select Option</option>
                                    <option value="Home Owner">Home Owner</option>
                                    <option value="Renter">Renter</option>
                                    <option value="Boarder">Boarder</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="blood_type">Blood Type</label>
                                <select class="custom-select" id="blood_type" name="blood_type" required>
                                    <option value="">Select Option</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="N/A">N/A</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="disabilities">Disabilities (If any)</label>
                                <input type="text" class="form-control" id="disabilities" name="disabilities" style="text-transform: capitalize;" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- <div class="col-md-4">
                        </div> -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="beneficiary_status">Beneficiary Status</label>
                                <input type="text" class="form-control" id="beneficiary_status" name="beneficiary_status" style="text-transform: capitalize;" required>
                            </div>
                        </div>
                        <!-- <div class="col-md-4">
                        </div> -->
                    </div>
                    <div class="modal-header">
                        </div>
                            <h5 class="modal-title" id="emergencyContactInformationModalLabel">Emergency Contact Information </h5>
                        <div class="modal-header">
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="emergency_contact_person">Full Name</label>
                                <input type="text" class="form-control" id="emergency_contact_person" name="emergency_contact_person" style="text-transform: capitalize;" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="emergency_contact_relationship">Relationship</label>
                                <input type="text" class="form-control" id="emergency_contact_relationship" name="emergency_contact_relationship" style="text-transform: capitalize;" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="emergency_contact_number">Contact Number</label>
                                <input type="text" class="form-control" id="emergency_contact_number" name="emergency_contact_number" style="text-transform: capitalize;" required>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btn_addUpdate">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <!-- jQuery and Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables and Bootstrap Integration -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/js/resident_script.js"></script>
    
</body>
</html>
