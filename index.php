

<?php
include ("db.php");
// session_start();
// /* Initialize Array */
// if (!isset($_SESSION['tasks'])) {
//     $_SESSION['tasks'] = [];
// }

/* ADD TASK */
// if (isset($_POST['iiii'])) {
//     $task = trim($_POST['task']);
//     if ($task != "") {
//      array_push($_SESSION['tasks'], $task);
//     }
// }

if(isset($_POST["iiii"])){
    $task = trim($_POST['task']);
    if ($task != "") {
      $query = "insert into tasktable (taskname) values ('$task')";
      mysqli_query($conn, $query);
    }
}

$tasks = mysqli_query($conn, "SELECT * FROM tasktable");
$getData = mysqli_fetch_all($tasks, MYSQLI_ASSOC);

// echo "hello"
// echo "<pre>";
// print_r($getData);  
// echo "</pre>";
/* DELETE TASK */
if (isset($_GET['delete'])) {
    $ID = $_GET['delete'];
    // unset($_SESSION['tasks'][$id]);
    // $_SESSION['tasks'] = array_values($_SESSION['tasks']); // Reindex
    $query = "DELETE FROM tasktable WHERE id = $ID";
    mysqli_query($conn, $query);
}

/* UPDATE TASK */
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    // $_SESSION['tasks'][$id] = $_POST['task'];
    $task = trim($_POST['task']);
    $query = "UPDATE tasktable SET TaskName='$task' WHERE id=$id";
    mysqli_query($conn, $query);
    header("Location: index.php");
}

/* SEARCH TASK */
// $tasks = $_SESSION['tasks'];
if (isset($_GET['search']) && $_GET['search'] != "") {
    $search = $_GET['search'];
     $tasks = mysqli_query($conn, "SELECT * FROM tasktable WHERE TaskName LIKE '%$search%'");
   
}  else {
        $tasks = mysqli_query($conn, "SELECT * FROM tasktable");
    }
    $getData = mysqli_fetch_all($tasks, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP Array To-Do List</title>
</head>
<body>

<h1>To-Do List </h1>

<!-- ADD TASK -->
<form method="POST">
    <input type="text" name="task" required>
    <button type="submit" name="iiii">Add</button>
</form>
<br>

<!-- SEARCH -->
<form method="GET">
    <input type="text" name="search" placeholder="Search task">
    <button type="submit">Search</button>
    <br>
    <br>
     <a href="index.php">
        <button type="button">View All</button>
    </a>
</form>



<br>


<!-- TASK LIST -->
<table border="1" cellpadding="10">
<tr>
    <th>#</th>
    <th>Task</th>
    <th>Actions</th>
</tr>

<?php foreach ($getData as $item) { ?>
<tr>
    <td><?php echo $item['id']; ?></td>
    <td><?php echo htmlspecialchars($item['TaskName']); ?></td>
    <td>
        <a href="?delete=<?php echo $item['id']; ?>">Delete</a>
        |
        <a href="?edit=<?php echo $item['id']; ?>">Edit</a>
    </td>
</tr>
<?php } ?>
</table>

<br>

<!-- UPDATE FORM -->
<?php if (isset($_GET['edit'])) { 
    $id = $_GET['edit']; 
    $result = mysqli_query($conn, "SELECT * FROM tasktable WHERE id=$id");
    $row = mysqli_fetch_assoc($result);?>
<form method="POST">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <input type="text" name="task" value="<?php echo $row['TaskName']; ?>" required>
    <button type="submit" name="update">Update</button>
</form>
<?php } ?>

</body>
</html>
