<?php 
session_start(); //bắt đầu phiên làm việc
$alert='';
 if($_SERVER['REQUEST_METHOD']=='POST'){ //đăng
try
{
    $userName = $_POST['username']; //lấy thông tin
    $userPass = $_POST['password'];   
    $_SESSION['username'] = $userName;
    $_SESSION['password'] = $userPass;

   
    $conn = new PDO("mysql:host=localhost:3307;dbname=BTTH02", 'root', '');
    $sql = "select * from users where username = :username and password = :password"; // 14->20 :lấy dữ liệu
    
    $stmt = $conn -> prepare($sql); 
    $stmt -> bindValue(':username',$userName,PDO::PARAM_STR);
    $stmt -> bindValue(':password',$userPass,PDO::PARAM_STR);
    $stmt ->execute();
    $member = $stmt ->fetchAll();
    if($stmt -> rowCount()==1 and end($member[0])==1){ //kiểm tra có tồn tại không
        header('Location: ../sinhvien/sinhviendiemdanh.php');
    }
    else if($stmt -> rowCount()==1 and end($member[0])==0)
    {
      header('Location: ../qtgiangvien/giangvien.php'); 
    }
    else {
       $alert = 'Thông tin không chính xác';
    }
} catch(PDOException $e){
    echo 'Error: ' .$e->getMessage();
}
 }?>
<!DOCTYPE html>
<html>
<head>
  <title>Đăng nhập</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
  <div class="container">
    <h2>Đăng nhập</h2>
    <form action="./index.php" method="post">
      <div class="form-group">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" class="form-control" name="username" placeholder="Nhập tên đăng nhập">
      </div>
      <div class="form-group">
        <label for="password">Mật khẩu:</label>
        <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu">
        
      </div>
      <p style="color: red;"><?php echo $alert ?> </p>
      <button type="submit" class="btn btn-primary">Đăng nhập</button>
    </form>
  </div>
</body>
</html>
