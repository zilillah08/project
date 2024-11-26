<?php
// dev_mode = 1
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'function.php';
$db_path='../databases/database.php';
$fe_path='../pages/';




// Payment verification handler 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['verifyPayment'])) {
    require $db_path;
    
    $payment_id = filter_input(INPUT_POST, 'payment_id', FILTER_VALIDATE_INT);
    
    if($payment_id) {
        $sql = "UPDATE payments SET payment_status = 'successful' WHERE payment_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $payment_id);
        
        if($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Payment verified successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Failed to verify payment']);
        }
    }
    exit();
}


// Workshop Payment Processing
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['bayar'])) {
    require $db_path;
    
    // Validate input
    $workshop_id = filter_input(INPUT_POST, 'workshop_id', FILTER_VALIDATE_INT);
    $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
    $bank_id = filter_input(INPUT_POST, 'bank_id', FILTER_VALIDATE_INT);

    // Validate input with specific messages
    if(!filter_input(INPUT_POST, 'workshop_id', FILTER_VALIDATE_INT)) {
        $_SESSION['error'] = "ID Workshop tidak valid";
        header("Location: ../pages/detail-workshop.php?workshop_id=" . $_POST['workshop_id']);
        exit();
    }

    if(!filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT)) {
        $_SESSION['error'] = "Jumlah pembayaran tidak valid";
        header("Location: ../pages/detail-workshop.php?workshop_id=" . $_POST['workshop_id']);
        exit();
    }

    if(!filter_input(INPUT_POST, 'bank_id', FILTER_VALIDATE_INT)) {
        $_SESSION['error'] = "Bank tujuan belum dipilih";
        header("Location: ../pages/detail-workshop.php?workshop_id=" . $_POST['workshop_id']);
        exit();
    }
    
    if(!$workshop_id || !$amount || !$bank_id) {
        $_SESSION['error'] = "Data tidak valid";
        header("Location: ../pages/detail-workshop.php?workshop_id=" . $_POST['workshop_id']);
        exit();
    }

    // Begin transaction
    $conn->begin_transaction();
    
    try {
        // Create registration
        $registration_id = createWorkshopRegistration($_SESSION['user_id'], $workshop_id);
        if(!$registration_id) throw new Exception("Gagal membuat registrasi");

        // Handle file upload
        $upload_result = handlePaymentUpload($_FILES['payment_receipt'], $registration_id);
        if(!$upload_result['status']) throw new Exception($upload_result['message']);

        // Create payment record
        $payment_success = createPaymentRecord($registration_id, $amount, $upload_result['filename'], $bank_id);
        if(!$payment_success) throw new Exception("Gagal menyimpan data pembayaran");

        // Commit transaction
        $conn->commit();
        $_SESSION['success'] = "🎉 Selamat! Pembayaran Anda telah berhasil diupload ✅ \n\nSaat ini pembayaran sedang dalam proses verifikasi oleh tim kami. \nMohon tunggu konfirmasi selanjutnya 🙏 \n\nTerima kasih atas kesabaran Anda! 💫";        
        header("Location: ../pages/data-pembayaran.php");
        
    } catch(Exception $e) {
        $conn->rollback();
        $_SESSION['error'] = $e->getMessage();
        header("Location: ../pages/detail-workshop.php?workshop_id=" . $workshop_id);
    }
    
    exit();
}


// Tambah workshop oleh Mitra
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['createWorkshop'])) {
    $auth = checkMitraAuth();
    if (!$auth) {
        echo "<script>alert('Anda tidak diizinkan untuk operasi ini.');window.location='../pages/index.php';</script>";
        exit();
    }
    
    require $db_path;
    
    $banner = handleBannerUpload($_FILES['banner']);
    
    $createResult = createWorkshop(
        $_SESSION['user_id'], // mitra_id from session
        $_POST['title'],
        $_POST['description'],
        $banner,
        $_POST['training_overview'],
        $_POST['trained_competencies'],
        $_POST['training_session'],
        $_POST['requirements'],
        $_POST['benefits'],
        $_POST['price'],
        $_POST['location'],
        $_POST['start_date'],
        $_POST['end_date'],
        'active' // default status for new workshop
    );

    echo "<script>alert('$createResult');window.location='../pages/data-workshop.php';</script>";
}


// Update Workshop oleh Mitra
// In controller.php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateWorkshop'])) {
    $auth = checkMitraAuth();
    if (!$auth) {
        echo "<script>alert('Anda tidak diizinkan untuk operasi ini.');window.location='../pages/index.php';</script>";
        exit();
    }
    
    require $db_path;
    
    // Get current banner if no new file uploaded
    $banner = !empty($_FILES['banner']['name']) ? handleBannerUpload($_FILES['banner']) : $_POST['old_banner'];
    
    $updateResult = updateWorkshop(
        $_POST['workshop_id'],
        $_POST['title'],
        $_POST['description'],
        $banner,
        $_POST['training_overview'],
        $_POST['trained_competencies'],
        $_POST['training_session'],
        $_POST['requirements'],
        $_POST['benefits'],
        $_POST['price'],
        $_POST['location'],
        $_POST['start_date'],
        $_POST['end_date'],
        $_POST['status']
    );

    echo "<script>alert('$updateResult');window.location='../pages/data-workshop.php';</script>";
}



// Handler for deleting workshop
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['deleteWorkshop'])) {
    $auth = checkMitraAuth();
    if (!$auth) {
        echo "<script>alert('You are not authorized for this operation.');window.location='../pages/index.php';</script>";
        exit();
    } else {
        require $db_path;

        $workshop_id = mysqli_real_escape_string($conn, $_GET['deleteWorkshop']);
        $deleteResult = deleteWorkshop($workshop_id);
        
        if ($deleteResult === "Workshop berhasil dihapus.") {
            echo "<script>alert('$deleteResult');</script>";
        } else {
            echo "<script>alert('$deleteResult');</script>";
        }
        echo "<script>window.location.href='../pages/data-workshop.php';</script>";    
        exit;
    }
}

// Menangani request untuk login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    require $db_path;
    $username_email = mysqli_real_escape_string($conn, $_POST['username_email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    login($username_email, $password, $role);
}

// Menangani request untuk menampilkan semua pengguna (Read)
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['getUsers'])) {
    checkAuth();  // Pastikan pengguna sudah login
    require $db_path;

    $users = getUsers();
    $_SESSION['users'] = $users;
    header('Location: user_list.php');  // Redirect untuk menampilkan daftar pengguna
    exit;
}

// Menangani request untuk menampilkan data pengguna berdasarkan ID (Read - by ID)
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['getUser'])) {
    checkAuth();  // Pastikan pengguna sudah login
    require $db_path;

    $user_id = mysqli_real_escape_string($conn, $_GET['getUser']);
    $user = getUserById($user_id);
    $_SESSION['user_to_edit'] = $user;
    header('Location: edit_user.php');  // Redirect untuk mengedit pengguna
    exit;
}

// Create User Request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['createUser'])) {
    require $db_path;

    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $username = strtolower($first_name . $last_name); // Convert to lowercase
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    if($_SESSION['role']!='admin'){
        $role = mysqli_real_escape_string($conn, $_POST['role']);
    }else{
        $role = 'user';
    }
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $createResult = createUser($first_name, $last_name, $username, $password, $email, $role, $phone);

    if(!isset($_SESSION['user_id'])){
        if ($createResult === "success") {
            $_SESSION['success_message'] = "Pendaftaran berhasil! Silahkan login.";
            echo "<script>window.alert('Pendaftaran berhasil. Silahkan login.');</script>";
            header('Location: ' . $fe_path . 'index.php');
            exit();
        } else {
            $_SESSION['error_message'] = $createResult;
            header('Location: ' . $fe_path . 'register.php');
            exit();
        }
    }else{
        echo "<script>alert('Peserta berhasil ditambahkan');window.location='../pages/data-peserta.php';</script>";
    }
}

// Create User Request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['createMitra'])) {
    require $db_path;

    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $username = strtolower($first_name . $last_name); // Convert to lowercase
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    if($_SESSION['role']!='admin'){
        $role = mysqli_real_escape_string($conn, $_POST['role']);
    }else{
        $role = 'mitra';
    }
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $createResult = createUser($first_name, $last_name, $username, $password, $email, $role, $phone);

    if(!isset($_SESSION['user_id'])){
        if ($createResult === "success") {
            $_SESSION['success_message'] = "Pendaftaran berhasil! Silahkan login.";
            echo "<script>window.alert('Pendaftaran berhasil. Silahkan login.');</script>";
            header('Location: ' . $fe_path . 'index.php');
            exit();
        } else {
            $_SESSION['error_message'] = $createResult;
            header('Location: ' . $fe_path . 'register.php');
            exit();
        }
    }else{
        echo "<script>alert('Mitra berhasil ditambahkan');window.location='../pages/data-mitra.php';</script>";
    }
}

// Update login handling in controller.php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    require $db_path;
    $username_email = mysqli_real_escape_string($conn, $_POST['username_email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    
    $login_result = login($username_email, $password, $role);
    
    if ($login_result['status'] === 'success') {
        $_SESSION['login_success'] = $login_result['message'];
        header("Location: ../pages/dashboard.php");
    } else {
        $_SESSION['login_error'] = $login_result['message'];
        header("Location: ../pages/index.php");
    }
    exit();
}

// Update auth check in other endpoints
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['getUsers'])) {
    if (!checkAuth()) {
        $_SESSION['error_message'] = 'Please login first';
        header('Location: ../pages/index.php');
        exit();
    }
    require $db_path;

    $users = getUsers();
    $_SESSION['users'] = $users;
    header('Location: user_list.php');  // Redirect untuk menampilkan daftar pengguna
    exit;
}

// Update admin check in relevant endpoints
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateUser'])) {
    $auth = checkInputAuth();
    if (!$auth) {
        echo "<script>alert('Anda tidak diizinkan untuk operasi ini.');window.location='../pages/index.php';</script>";
        exit();
    } else {
        require $db_path;

        $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);

        // Check if a new password is provided; if empty, pass null
        $password = !empty($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : null;

        // Update the user with the provided data
        $updateResult = updateUser($user_id, $first_name, $last_name, $username, $password, $email, $phone);

        // Redirect after updating
        if ($updateResult === "Pengguna berhasil diperbarui.") {
            echo "<script>alert('$updateResult');</script>";
            echo "<script>window.location.href='../pages/data-peserta.php';</script>";
        } else {
            echo "<script>alert('$updateResult');</script>";
            echo "<script>window.location.href='../pages/data-peserta.php';</script>";
        }
    }
}

// Update admin check in relevant endpoints
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateMitra'])) {
    $auth = checkInputAuth();
    if (!$auth) {
        echo "<script>alert('Anda tidak diizinkan untuk operasi ini.');window.location='../pages/index.php';</script>";
        exit();
    } else {
        require $db_path;

        $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);

        // Check if a new password is provided; if empty, pass null
        $password = !empty($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : null;

        // Update the user with the provided data
        $updateResult = updateUser($user_id, $first_name, $last_name, $username, $password, $email, $phone);

        // Redirect after updating
        if ($updateResult === "Pengguna berhasil diperbarui.") {
            echo "<script>alert('Mitra berhasil diperbarui.');</script>";
            echo "<script>window.location.href='../pages/data-mitra.php';</script>";
        } else {
            echo "<script>alert('Mitra gagal diperbarui.');</script>";
            echo "<script>window.location.href='../pages/data-mitra.php';</script>";
        }
    }
}

// Menangani request untuk menghapus pengguna (Delete)
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['deleteUser'])) {
    $auth = checkInputAuth();
    if (!$auth) {
        echo "<script>alert('Anda tidak diizinkan untuk operasi ini.');window.location='../pages/index.php';</script>";
        exit();
        }else{
            require $db_path;

            $user_id = mysqli_real_escape_string($conn, $_GET['deleteUser']);
            $deleteResult = deleteUser($user_id);
            
            // Setelah penghapusan, redirect ke daftar pengguna
            if ($deleteResult === "Pengguna berhasil dihapus.") {
                echo "<script>alert('$deleteResult');</script>";
            } else {
                echo "<script>alert('$deleteResult');</script>";
            }
            echo "<script>window.location.href='../pages/data-peserta.php';</script>";    
            exit;
        }
}

// Logout
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: ../index.html');
    exit;
}


// Profil
// Update Profile
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateProfile'])) {
    checkAuth();
    require $db_path;
    
    $update_result = updateUserProfile(
        $_SESSION['user_id'],
        $_POST['first_name'],
        $_POST['last_name'], 
        $_POST['email'],
        $_POST['phone']
    );
    
    if($update_result) {
        $_SESSION['success'] = "Profile updated successfully";
    } else {
        $_SESSION['error'] = "Failed to update profile";
    }
    header("Location: ../pages/profil.php");
    exit();
}

// Update Password
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updatePassword'])) {
    checkAuth();
    require $db_path;
    
    if($_POST['new_password'] !== $_POST['confirm_password']) {
        $_SESSION['error'] = "New passwords do not match";
        header("Location: ../pages/profil.php");
        exit();
    }
    
    $update_result = updateUserPassword(
        $_SESSION['user_id'],
        $_POST['current_password'],
        $_POST['new_password']
    );
    
    if($update_result) {
        $_SESSION['success'] = "Password updated successfully";
    } else {
        $_SESSION['error'] = "Current password is incorrect";
    }
    header("Location: ../pages/profil.php");
    exit();
}

// Add new rating
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addRating'])) {
    checkAuth();
    require $db_path;
    
    $workshop_id = filter_input(INPUT_POST, 'workshop_id', FILTER_VALIDATE_INT);
    $rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);
    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
    
    if(addRating($_SESSION['user_id'], $workshop_id, $rating, $comment)) {
        $_SESSION['success'] = "Rating added successfully";
    } else {
        $_SESSION['error'] = "Failed to add rating";
    }
    
    header("Location: ../pages/rating.php");
    exit();
}

// Update existing rating
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editRating'])) {
    checkAuth();
    require $db_path;
    
    $feedback_id = filter_input(INPUT_POST, 'feedback_id', FILTER_VALIDATE_INT);
    $rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);
    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
    
    if(updateRating($feedback_id, $rating, $comment)) {
        $_SESSION['success'] = "Rating updated successfully";
    } else {
        $_SESSION['error'] = "Failed to update rating";
    }
    
    header("Location: ../pages/rating.php");
    exit();
}



