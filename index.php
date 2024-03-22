<?php
   require 'conn/conn.php';
   $todos = $conn->query("SELECT * FROM todos ORDER BY id DESC");
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>To-Do List</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <link rel="stylesheet" href="css/style.css">
   </head>
   <body style="background-image: url('img/red.gif'); background-size: 100%;">
      <div style="margin-top: 60px;">
       
      <div class="row justify-content-center">
         <div class="col-md-8" >
            <div>
               <div class="card-header text-left" >
               <h3 style="color: white; font-size: 40px; class:card-header text-center" display: flex; justify-content: space-between;">
                    <div class="card-header text-center" ><b>To-Do List</b></div>
               </h3>

                  <div class="card-body" style ="background-color: 343434;">
                     <form action="endpoint/add.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                     <div class="input-group mb-3" style="font-family: Verdana; background-color: 343434;">
                           <input type="text" name="title" class="form-control <?= isset($_GET['mess']) && $_GET['mess'] == 'error' ? 'is-invalid' : '' ?>" placeholder="<?= isset($_GET['mess']) && $_GET['mess'] == 'error' ? 'You must do something! Be Productive!' : 'Please type your task details' ?>">&nbsp;
                           <div class="input-group-append" style="font-family:verdana">
                              <button type="submit" class="btn btn-primary" name="submit">Add</button>
                           </div>
                        </div>
                     </form>
                     <?php if ($todos->rowCount() <= 0) { ?>
                     <div class="alert alert-secondary text-center" role="alert">
                        <h3 class="text-center" style="font-family:verdana">No Task for Today!</h3>
                     </div>
                     <?php } ?>
                     <div>
                        <?php while ($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
                        <div class="list-group-item" style="font-family: Verdana; background-color: 343434;">
                        <button type="button" class="btn btn-secondary remove-to-do" style="float: right; font-size: 20px; color: white; cursor: pointer;" id="<?php echo $todo['id']; ?>">Delete</button>
                           <!-- <button type="button" class="btn btn-secondary" style="float: right;" onclick="endpoint.href='delete.php';">Edit</button> -->
                           <h2 style="font-family: Verdana; font-size: 23px; background-color: 343434;" <?php echo $todo['checked'] ? 'class="checked"' : ''; ?>><?php echo $todo['title']; ?></h2>
                           <small class="date-finished">Created: <?php echo $todo['date_time']; ?></small><br>
                        </div>
                        <?php } 
                           ?>
                     </div>
                  </div>
                  <div class="card-header text-center" >
                    <p style="color:Yellow; font-size:35px;font-family:verdana"><b>Developed by Syed</b><br></p>
                    <p style="color: white; font-size:25px; font-family: Verdana;">
                        <span href="https://shyadmusthafa.github.io/portfolio/">Visit My Website</span>
                    </p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      <script>
         $(document).ready(function(){
             $('.remove-to-do').click(function(){
                 const id = $(this).attr('id');
                 alert("Are you sure you want to remove this item with ID: " + id);
                 const parent = $(this).parent();
                 $.post("endpoint/delete.php", { id: id }, function(data){
                     if (data) {
                         parent.hide(600);
                     }
                 });
             });
         
             $(".check-box").click(function(){
                 const id = $(this).attr('data-todo-id');
                 const h2 = $(this).next();
                 $.post('endpoint/done.php', { id: id }, function(data){
                     if (data !== 'error') {
                         h2.toggleClass('checked', data === '0');
                     }
                 });
             });
         });
      </script>
   </body>
   </script>
   </body>
</html>