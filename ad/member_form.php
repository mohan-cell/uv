<?php 
session_start();
require_once('master.php');
$master = new Master();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['id']) && is_numeric($_POST['id']) && $_POST['id'] > 0){
        $save = $master->update_json_data();
    }else{
        $save = $master->insert_to_json();
    }
    if(isset($save['status'])){
        if($save['status'] == 'success'){
            if(isset($_POST['id']) && is_numeric($_POST['id']) && $_POST['id'] > 0)
            $_SESSION['msg_success'] = 'New Customer has been added Successfully';
            else
            $_SESSION['msg_success'] = 'Customer Details has been updated Successfully';
            header('location:indxe.php');
            exit;
        }
    }else{
        $_SESSION['msg_error'] = 'Details has failed to save due to some error.';
    }
}
$data = $master->get_data(isset($_GET['id']) ? $_GET['id'] :'');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Form</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js" integrity="sha512-naukR7I+Nk6gp7p5TMA4ycgfxaZBJ7MO5iC3Fp6ySQyKFHOGfpkSZkYVWV5R7u7cfAicxanwYQ5D1e17EfJcMA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    <style>
        html, body{
            min-height:100%;
            width:100%;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-gradient">
        <div class="container">
            <a class="navbar-brand" href="./">MS Telecom</a>
            <div>
                <a href="https://sourcecodester.com" class="text-light fw-bolder h6 text-decoration-none" target="_blank">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container px-5 my-3">
        <h2 class="text-center">Customer Form</h2>
        <div class="row">
            <!-- Page Content Container -->
            <div class="col-lg-10 col-md-11 col-sm-12 mt-4 pt-4 mx-auto">
                <div class="container-fluid">
                    <!-- Handling Messages Form Session -->
                    <?php if(isset($_SESSION['msg_success']) || isset($_SESSION['msg_error'])): ?>
                        <?php if(isset($_SESSION['msg_success'])): ?>
                            <div class="alert alert-success rounded-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="col-auto flex-shrink-1 flex-grow-1"><?= $_SESSION['msg_success'] ?></div>
                                    <div class="col-auto">
                                        <a href="#" onclick="$(this).closest('.alert').remove()" class="text-decoration-none text-reset fw-bolder mx-3">
                                            <i class="fa-solid fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php unset($_SESSION['msg_success']); ?>
                        <?php endif; ?>
                        <?php if(isset($_SESSION['msg_error'])): ?>
                            <div class="alert alert-danger rounded-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="col-auto flex-shrink-1 flex-grow-1"><?= $_SESSION['msg_error'] ?></div>
                                    <div class="col-auto">
                                        <a href="#" onclick="$(this).closest('.alert').remove()" class="text-decoration-none text-reset fw-bolder mx-3">
                                            <i class="fa-solid fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php unset($_SESSION['msg_error']); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    <!--END of Handling Messages Form Session -->

                    <div class="card rounded-0 shadow">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <div class="card-title col-auto flex-shrink-1 flex-grow-1">Customer List</div>
                                <div class="col-atuo">
                                    <button class="btn btn-primary btn-sm btn-flat" id="add"><i class="fa fa-plus-square"></i> Add Customer</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="container-fluid">
                                <?php if(isset($data->id)): ?>
                                    <p class="text-muted"><i>Update the details of <b><?= isset($data->name) ? $data->name : '' ?></b></i></p>
                                <?php else: ?>
                                    <p class="text-muted"><i>Add New Customer</b></i></p>
                                <?php endif; ?>
                                <form id="member-form" action="" method="POST">
                                    <input type="hidden" name="id" value="<?= isset($data->id) ? $data->id : '' ?>">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Customer Name</label>
                                        <input type="text" class="form-control rounded-0" id="name" name="name" required="required" value="<?= isset($data->name) ? $data->name : '' ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="contact" class="form-label">Contact #</label>
                                        <input type="text" class="form-control rounded-0" id="contact" name="contact" required="required" value="<?= isset($data->contact) ? $data->contact : '' ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea rows="3" class="form-control rounded-0" id="address" name="address" required="required"><?= isset($data->address) ? $data->address : '' ?></textarea>
                                        
               
                                    </div>
        <div class="mb-3">
                                        <label for="address" class="form-label">Device ID</label>
                                        <textarea rows="3" class="form-control rounded-0" id="device" name="device" required="required"><?= isset($data->device) ? $data->device : '' ?></textarea>
                                        
               
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="address" class="form-label">No.of.Days</label>
                                        <input type="text" class="form-control rounded-0" id="days" name="days" required="required" value="<?= isset($data->days) ? $data->days : '' ?>">
                                        
                                    </div>
                                    
                                </form>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                                <button class="btn btn-primary rounded-0" form="member-form"><i class="fa-solid fa-save"></i> Save Customer</button>
                                <a class="btn btn-light border rounded-0" href="./indxe.php"><i class="fa-solid fa-times"></i> Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Page Content Container -->
        </div>
    </div>
</body>
</html>