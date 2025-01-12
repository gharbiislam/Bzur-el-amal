<?php
include('db.php');

$query = "
    SELECT r.id_request, u.name AS beneficiary_name, u.adress AS beneficiary_adress, u.phone_number AS beneficiary_phone, 
           d.name AS equipment_name, r.date_demande, r.approved, r.dateReponse,r.documents
    FROM requests r
    INNER JOIN users u ON r.user_id = u.id
    INNER JOIN dons_equipment d ON r.id_equipment = d.id_equipment
";

$res = mysqli_query($conn, $query);

if (!$res) {
    die("Error in query: " . mysqli_error($conn));
}

if (isset($_POST['update_status'])) {
    $id_request = $_POST['id_request'];
    $status = $_POST['status'];
    $dateReponse = date('Y-m-d H:i:s');

    $update_query = "UPDATE requests SET approved = ?, dateReponse = ? WHERE id_request = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('ssi', $status, $dateReponse, $id_request);
    $stmt->execute();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_POST['delete_request'])) {
    $id_request = $_POST['id_request'];

    $delete_query = "DELETE FROM requests WHERE id_request = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param('i', $id_request);
    $stmt->execute();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Page</title>
   <!-- Include the main Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
<div class="d-flex flex-column flex-lg-row ">
        <div class="col-lg-2 d-none d-lg-block ">
            <?php
            include('nav.php');

            ?>
        </div>
        <div class=" px-2 col-lg-10">

            <h2 id="back-title" class="my-4">Requests for Equipment</h2>
            <div class="table-responsive" >
            <table id="requestTable" class=" table table-striped table-bordered">
                <thead >
                    <tr class="">
                        <th>ID</th>
                        <th>Beneficiary Name</th>
                        <th>Beneficiary Address</th>
                        <th>Phone Number</th>
                        <th>Equipment Name</th>
                        <th>Documents</th>
                        <th>Request Date</th>
                        <th>Status</th>
                        <th>Date Response</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $res->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id_request']; ?></td>
                            <td><?php echo $row['beneficiary_name']; ?></td>
                            <td><?php echo $row['beneficiary_adress']; ?></td>
                            <td><?php echo $row['beneficiary_phone']; ?></td>
                            <td><?php echo $row['equipment_name']; ?></td>
                            <td> <a href="uploads/<?php echo $row['documents']; ?>" target="_blank">
                                    View Document
                                </a></td>
                            <td><?php echo $row['date_demande']; ?></td>
                            <td><?php echo $row['approved']; ?></td>
                            <td><?php echo $row['dateReponse']; ?></td>
                            <td>
                                <form method="POST" action="" class="mb-2">
                                    <input type="hidden" name="id_request" value="<?php echo $row['id_request']; ?>">
                                    <select name="status" class="form-select" required>
                                        <option value="En cours" <?php echo ($row['approved'] == 'En cours') ? 'selected' : ''; ?>>En cours</option>
                                        <option value="Acceptée" <?php echo ($row['approved'] == 'Acceptée') ? 'selected' : ''; ?>>Acceptée</option>
                                        <option value="Rejetée" <?php echo ($row['approved'] == 'Rejetée') ? 'selected' : ''; ?>>Rejetée</option>
                                        <option value="En attente" <?php echo ($row['approved'] == 'En attente') ? 'selected' : ''; ?>>En attente</option>
                                    </select>
                                    <button type="submit" name="update_status" class="btn btn-sm mt-2" id="navBtn">Update Status</button>
                                </form>

                                <form method="POST" action="" class="mb-2" onsubmit="return confirmDelete()">
                                    <input type="hidden" name="id_request" value="<?php echo $row['id_request']; ?>">
                                    <button type="submit" name="delete_request" class="btn btn-danger btn-sm"> <i class="bi bi-trash"></i></button>
                                </form>
               
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>                
        <script>
            function confirmDelete() {
                return confirm("Are you sure you want to delete this request?");
            }
        </script>
        </td>
        </tr>
    <?php endwhile; ?>
   </tbody>
    </table>
    </div></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#requestTable').DataTable({
                responsive:true
            });
        });
    </script>
</body>

</html>