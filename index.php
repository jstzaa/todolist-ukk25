<?php
$koneksi = mysqli_connect('localhost','root','','todolist_ukk25');

//Add Task
if (isset($_POST['add_task'])) {
    $task = $_POST['task'];
    $priority = $_POST['priority'];
    $deadline = $_POST['deadline'];

    if (!empty($task) && !empty($priority) && !empty($deadline)) {
        mysqli_query($koneksi,"INSERT INTO tasks VALUES('','$task','$priority','$deadline','0')");
        echo "<script>alert('Data Saved Successfully');</script>";
    }else{
        echo "<script>alert('All Fields Must Be Filled');</script>";
    }
}

//Menandai task selesai
if (isset($_GET['complete'])) {
    $task_id = $_GET['complete'];
    mysqli_query($koneksi, "UPDATE tasks SET status=1 WHERE task_id=$task_id");
    echo "<script>alert('Data Updated Successfully');</script>";
    header('Location:index.php');
}

//Menghapus task
if (isset($_GET['delete'])) {
    $task_id = $_GET['delete'];
    mysqli_query($koneksi, "DELETE FROM tasks WHERE task_id=$task_id");
    echo "<script>alert('Data Successfully Deleted');</script>";
    header('Location:index.php');
}

$result = mysqli_query($koneksi,"SELECT * FROM tasks ORDER BY status ASC, priority DESC, deadline ASC");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UKK TO-DO LIST 25</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-2">
        <h2 class="text-center">To-Do List App</h2>
        <form method="POST" class="border rounded bg-light p-2">
            <label class="form-label">Task Name</label>
            <input type="text" name="task" class="form-control" placeholder="Input New Task" autocomplete="off" autofocus required>
            <label class="form-label">Priority</label>
            <select name="priority" class="form-control" required>
                <option value="">--Choose Priority--</option>
                <option value="1">Urgent and Important</option>
                <option value="2">Not Urgent and Important</option>
                <option value="3">Urgent and Not Important</option>
                <option value="4">Not Urgent and Not Important</option>
            </select>
            <label class="form-label">Deadline</label>
            <input type="date" name="deadline" class="form-control" value="<?php echo date('y-m-d') ?>" required>
            <button type="submit" class="btn btn-primary w-100 mt-2" name="add_task">Add Task</button>
        </form>
        <hr>

        <table class="table table-stripped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tasks</th>
                    <th>Priority</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    $no = 1;
                    while($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $row['task']; ?></td>
                            <td>
                                <?php
                                if ($row['priority'] == 1) {
                                    echo "Urgent and Important";
                                }elseif($row['priority'] == 2) {
                                    echo "Not Urgent and Important";
                                }elseif($row['priority'] == 3) {
                                    echo "Urgent and Not Important";
                                }else{
                                    echo "Not Urgent and Not Important";
                                }
                                ?>
                            </td>
                            <td><?php echo $row['deadline']; ?></td>
                            <td>
                                <?php
                                if ($row['status'] == 0) {
                                    echo "Haven't done";
                                }else{
                                    echo "Done";
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($row['status'] == 0) { ?>
                                    <a href="?complete=<?php echo $row['task_id'] ?>" class="btn btn-success">Done</a>
                                <?php } ?>
                                <a href="?delete=<?php echo $row['task_id'] ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php }
                }else{
                    echo "No Data";
                }
                ?>
            </tbody>
        </table>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>