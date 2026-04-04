<?php
include('config/db.php');
include('includes/header.php');
?>

<h2 class="mb-4">Business Listing</h2>

<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
    Add Business
</button>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Rating</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="businessTable">

        <?php
        $query = "SELECT b.*, 
            IFNULL(AVG(r.rating), 0) as avg_rating
            FROM businesses b
            LEFT JOIN ratings r ON b.id = r.business_id
            GROUP BY b.id";

        $result = $conn->query($query);

        while ($row = $result->fetch_assoc()):
        ?>

            <tr id="row_<?php echo $row['id']; ?>">
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['email']; ?></td>

                <td>
                    <div class="rating" data-score="<?php echo $row['avg_rating']; ?>"></div>
                </td>

                <td>
                    <button class="btn btn-warning btn-sm editBtn" data-id="<?php echo $row['id']; ?>">Edit</button>
                    <button class="btn btn-danger btn-sm deleteBtn" data-id="<?php echo $row['id']; ?>">Delete</button>
                    <button class="btn btn-info btn-sm rateBtn" data-id="<?php echo $row['id']; ?>">Rate</button>
                </td>
            </tr>

        <?php endwhile; ?>

    </tbody>
</table>

<!-- Add Business Modal -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Business</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="addBusinessForm">
                    <input type="text" name="name" class="form-control mb-2" placeholder="Business Name" required>
                    <input type="text" name="address" class="form-control mb-2" placeholder="Address">
                    <input type="text" name="phone" class="form-control mb-2" placeholder="Phone"
                        pattern="[0-9]{10}" maxlength="10" required>
                    <input type="email" name="email" class="form-control mb-2" placeholder="Email">

                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Edit Business Modal -->
<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Business</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="editBusinessForm">

                    <input type="hidden" name="id" id="edit_id">

                    <input type="text" name="name" id="edit_name" class="form-control mb-2" required>
                    <input type="text" name="address" id="edit_address" class="form-control mb-2">
                    <input type="text" name="phone" id="edit_phone"
                        class="form-control mb-2"
                        pattern="[0-9]{10}" maxlength="10">
                    <input type="email" name="email" id="edit_email" class="form-control mb-2">

                    <button type="submit" class="btn btn-success">Update</button>

                </form>
            </div>

        </div>
    </div>
</div>


<!-- Rating Modal -->
<div class="modal fade" id="ratingModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Rate Business</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form id="ratingForm">

                    <input type="hidden" name="business_id" id="rating_business_id">

                    <input type="text" name="name" class="form-control mb-2" placeholder="Your Name" required>
                    <input type="email" name="email" class="form-control mb-2" placeholder="Email">
                    <input type="text" name="phone"
                        class="form-control mb-2"
                        pattern="[0-9]{10}" maxlength="10">

                    <div id="ratingStar"></div>
                    <input type="hidden" name="rating" id="rating_value">

                    <button type="submit" class="btn btn-success mt-2">Submit Rating</button>

                </form>

            </div>

        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>