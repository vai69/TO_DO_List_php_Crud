<?php
    include("config.php");
    $errors="";
    $id=0;
    $update=false;
    $t="";
    if (isset($_POST['submit'])) {
		if (empty($_POST['task'])) {
			$errors = "You must fill in the task";
		}else{
			$task = $_POST['task'];
			$sql = "INSERT INTO task (tasks) VALUES ('$task')";
			mysqli_query($conn, $sql);
			header('location: index.php');
		}
	}

    if (isset($_GET['del_task'])) {
        $i = $_GET['del_task'];
        mysqli_query($conn, "DELETE FROM task WHERE id=".$i);
        header('location: index.php');
    }

    if (isset($_GET['update'])) {
	            $id = $_GET['update'];
            $r=mysqli_query($conn,"SELECT * FROM task WHERE ID=$id") ;
            $update=true;
            $row=$r->fetch_array();
            $t=$row['tasks'];
    }
    if(isset($_POST['edit'])){
        $id=$_POST['id'];
        $k=$_POST['task'];
        echo "<h1>".$t."</h1>";
         mysqli_query($conn, "UPDATE task SET tasks='$k' WHERE ID=$id");
    }
?>




<!DOCTYPE html>
<html>
<head>
	<title>ToDo List Application PHP and MySQL</title>
	<script src="https://kit.fontawesome.com/86b87c343b.js" crossorigin="anonymous"></script>
	<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Courgette&family=Pacifico&family=Sigmar+One&display=swap" rel="stylesheet">
 <link href="index.css" rel="stylesheet">   

</head>

<body>
	<h1 class="title">To-Do List</h1>
	<div class="main">
        <form method="post" action="index.php" class="input_form">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <?php if (isset($errors)) { ?>
            <p><?php echo $errors; ?></p>
            <?php } ?>
            <input type="text" placeholder="Enter Task" value="<?php echo $t ?>" name="task" class="task_input">
            <?php if($update==true): ?>
                <button type="submit" name="edit" id="add_btn" class="add_btn">update</button>
            <?php else: ?>
                <button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>
            <?php endif; ?>
        </form>
            <?php 
            // select all tasks if page is visited or refreshed
                $tasks = mysqli_query($conn, "SELECT * FROM task");

                $i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
                    
                    <div class="row"> 
                        <div class="font">
                            <?php echo $i; ?>
                            <?php echo $row['tasks']; ?> 
                            </div>
                            <div class="icons">
                            <a class="delete-icon" href="index.php?del_task=<?php echo $row['ID']; ?>"><i class="fas fa-trash"></i></a> 
                        
                            <a class="edit-icon" href="index.php?update=<?php echo $row['ID']; ?>"><i class="fas fa-edit"></i></a> 
                        </div>
                </div>	
        
                    
            <?php $i++; }?>


	
    </div>
</body>
</html>

