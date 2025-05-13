<?php
class Controller
{
    private $con;
    private $mail;
    private $base_url;

    public function __construct()
    {
        require_once('./config.php');
        $this->con = $con;
        $this->base_url = $base_url;

        require_once('./mailer.php');
        $this->mail = $mail;
    }

    function validateName($name)
    {
        return preg_match('/^[a-zA-Z\s]+$/', $name);
    }

    function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function validatePassword($password)
    {
        return preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/", $password);
    }

    function validatePhone($phone)
    {
        return preg_match('/^(09\d{9}|\+639\d{9})$/', $phone);
    }

    function isEmailTaken() {}

    function signup()
    {
        try {
            extract($_POST);

            $hash_pass = password_hash($password, PASSWORD_DEFAULT);
            $role = $role ?? 1;

            if (!$this->validateEmail($email)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid Email Address.']);
                return;
            }

            if (!$this->validatePassword($password)) {
                echo json_encode(['status' => 'error', 'message' => 'Password must contain at least 8 characters, including at least one uppercase letter, one lowercase letter, one number, and one special character.']);
                return;
            }

            if ($password != $cpassword) {
                echo json_encode(['status' => 'error', 'message' => 'Password and confirm password do not match.']);
                return;
            }

            if (!$this->validatePhone($phone)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid Phone Number. It must start with 09 or +639 followed by 9 digits.']);
                return;
            }

            if (!$this->validateName($fname)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid First Name. Only alphabets and spaces are allowed.']);
                return;
            }

            if (!$this->validateName($lname)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid Last Name. Only alphabets and spaces are allowed.']);
                return;
            }

            $sql = "SELECT * FROM users WHERE email = ?";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("s", $email);

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    echo json_encode(['status' => 'error', 'message' => 'Email is taken. Please login or register a new email.']);
                    return;
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $stmt->error . ' in query: ' . $sql]);
            }

            $stmt->close();

            $sql = "INSERT INTO users (fname, lname, phone, email, password, role) VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("sssssi", $fname, $lname, $phone, $email, $hash_pass, $role);

            if ($stmt->execute()) {
                $stmt->close();

                $token = bin2hex(random_bytes(16));
                $user_id = $this->con->insert_id;

                $sql = "INSERT INTO tokens (user_id, token) VALUES (?, ?)";

                $stmt = $this->con->prepare($sql);
                $stmt->bind_param("is", $user_id, $token);

                if ($stmt->execute()) {

                    $link = "{$this->base_url}/backend/ajax.php?action=verify&secret=$token";



                    $message = "
                        <html>
                            <body>
                                <p>Dear User,</p>
                                <p>Thank you for creating an account with us! To verify your email address, please click the link below:</p>
                                <a href='$link'>Verify Your Account</a>
                                <p>If you did not create an account, please disregard this email.</p>
                                <p>Thank you,<br>
                                The HomeMedix Team</p>
                            </body>
                        </html>
                    ";

                    $this->mail->addAddress($email);
                    $this->mail->Subject = 'Account Verification';
                    $this->mail->Body = $message;

                    if (!$this->mail->send()) {
                        echo 'Message could not be sent.';
                        echo 'Mailer Error: ' . $this->mail->ErrorInfo;
                    } else {
                        'Message has been sent';
                    }

                    if (!empty($hire_date)) {
                        $stmt->close();

                        $sql = "INSERT INTO practitioners (user_id, specialization, hire_date) VALUES (?, ?, ?)";

                        $stmt = $this->con->prepare($sql);
                        $stmt->bind_param("iss", $user_id, $specialization, $hire_date);

                        if (!$stmt->execute()) {
                            echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $stmt->error . ' in query: ' . $sql]);
                        }
                    }

                    echo json_encode(['status' => 'success', 'message' => 'Registered successfully!. Please check your email to verify your account.']);
                    return;
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $stmt->error . ' in query: ' . $sql]);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $stmt->error . ' in query: ' . $sql]);
            }
        } catch (mysqli_sql_exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $e]);
        }
    }

    function verify()
    {
        try {
            session_start();
            extract($_GET);

            $sql = "SELECT user_id FROM tokens WHERE token = ?";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("s", $secret);

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows >  0) {
                    $stmt->bind_result($user_id);
                    $stmt->fetch();

                    $stmt->close();

                    $sql = "UPDATE users SET status = 1 WHERE id = ?";

                    $stmt = $this->con->prepare($sql);
                    $stmt->bind_param("i", $user_id);

                    if ($stmt->execute()) {
                        $_SESSION['flash-msg'] = 'verified';
                        header("location: ../index.php");
                    } else {
                        $_SESSION['flash-msg'] = 'account-not-found';
                        header("location: ../index.php");
                    }
                } else {
                    $_SESSION['flash-msg'] = 'account-not-found';
                    header("location: ../index.php");
                }
            } else {
                $_SESSION['flash-msg'] = 'account-not-found';
                header("location: ../index.php");
            }
        } catch (mysqli_sql_exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $e]);
        }
    }

    function login()
    {
        try {
            extract($_POST);
            $ip = $_SERVER['REMOTE_ADDR'];
            $max_attempts = 5;
            $lockout_time = 1; // minutes

            // Check failed attempts in the last 5 minutes
            $stmt = $this->con->prepare("SELECT COUNT(*) FROM login_attempts WHERE ip_address = ? AND attempt_time > (NOW() - INTERVAL ? MINUTE)");
            $stmt->bind_param("si", $ip, $lockout_time);
            $stmt->execute();
            $stmt->bind_result($attempts);
            $stmt->fetch();
            $stmt->close();

            if ($attempts >= $max_attempts) {
                if ($attempts == $max_attempts) {
                    // Send alert to admin - suppress mail warning with @ to prevent JSON errors
                    @mail(
                        'admin@example.com', // Change to your admin email
                        'Intrusion Alert: Too Many Failed Logins',
                        "There have been $max_attempts failed login attempts from IP: $ip."
                    );

                    // Insert notification for admin dashboard
                    $notif_stmt = $this->con->prepare("INSERT INTO admin_notifications (type, message) VALUES (?, ?)");
                    $type = 'Intrusion';
                    $msg = "Blocked IP $ip after $max_attempts failed login attempts.";
                    $notif_stmt->bind_param("ss", $type, $msg);
                    $notif_stmt->execute();
                    $notif_stmt->close();
                }
                echo json_encode(['status' => 'error', 'message' => 'Too many failed login attempts. Please try again after ' . $lockout_time . ' minutes.']);
                return;
            }

            $sql = "SELECT id, fname, lname, password, status, role FROM users WHERE email = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("s", $email);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows >  0) {
                    $stmt->bind_result($id, $fname, $lname, $db_password, $status, $role);
                    $stmt->fetch();
                    if (password_verify($password, $db_password)) {
                        if ($status == 1) {
                            session_start();
                            $_SESSION['id'] = $id;
                            $_SESSION['fname'] = $fname;
                            $_SESSION['lname'] = $lname;
                            $_SESSION['email'] = $email;
                            $_SESSION['role'] = $role;
                            // Clear failed attempts on success
                            $clear = $this->con->prepare("DELETE FROM login_attempts WHERE ip_address = ?");
                            $clear->bind_param("s", $ip);
                            $clear->execute();
                            $clear->close();
                            echo json_encode(['status' => 'success']);
                        } else {
                            if ($status == 2) {
                                echo json_encode(['status' => 'error', 'message' => 'Your account is inactive!. Please contact the administrator.']);
                            } else {
                                echo json_encode(['status' => 'error', 'message' => 'Your account is unverified!. Please check your email address.']);
                            }
                        }
                    } else {
                        // Log failed attempt
                        $fail = $this->con->prepare("INSERT INTO login_attempts (ip_address, attempt_time) VALUES (?, NOW())");
                        $fail->bind_param("s", $ip);
                        $fail->execute();
                        $fail->close();
                        echo json_encode(['status' => 'error', 'message' => 'Email or password is incorrect.']);
                    }
                } else {
                    // Log failed attempt
                    $fail = $this->con->prepare("INSERT INTO login_attempts (ip_address, attempt_time) VALUES (?, NOW())");
                    $fail->bind_param("s", $ip);
                    $fail->execute();
                    $fail->close();
                    echo json_encode(['status' => 'error', 'message' => 'Email or password is incorrect.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $stmt->error . ' in query: ' . $sql]);
            }
        } catch (mysqli_sql_exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $e]);
        }
    }

    function update_user()
    {
        try {
            extract($_POST);

            if (!$this->validateEmail($email)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid Email Address.']);
                return;
            }

            if (!$this->validatePhone($phone)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid Phone Number. It must start with 09 or +639 followed by 9 digits.']);
                return;
            }

            if (!$this->validateName($fname)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid First Name. Only alphabets and spaces are allowed.']);
                return;
            }

            if (!$this->validateName($lname)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid Last Name. Only alphabets and spaces are allowed.']);
                return;
            }

            $sql = "SELECT * FROM users WHERE email = ? AND id != ?";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("si", $email, $user_id);

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    echo json_encode(['status' => 'error', 'message' => 'Email is taken.']);
                    return;
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $stmt->error . ' in query: ' . $sql]);
            }

            $stmt->close();

            $sql = "UPDATE users SET fname = ?, lname = ?, phone = ?, email = ? WHERE id = ?";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("ssssi", $fname, $lname, $phone, $email, $user_id);

            if ($stmt->execute()) {
                $stmt->close();

                if (!empty($hire_date)) {
                    $sql = "UPDATE practitioners SET specialization = ?, hire_date = ? WHERE user_id = ?";

                    $stmt = $this->con->prepare($sql);
                    $stmt->bind_param("ssi", $specialization, $hire_date, $user_id);

                    if (!$stmt->execute()) {
                        echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $stmt->error . ' in query: ' . $sql]);
                    }
                }

                echo json_encode(['status' => 'success', 'message' => 'User updated successfully!.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $stmt->error . ' in query: ' . $sql]);
            }
        } catch (mysqli_sql_exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $e]);
        }
    }

    function delete_user()
    {
        try {
            extract($_POST);

            $sql = "DELETE FROM users WHERE id = ?";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $user_id);

            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'User deleted successfully!.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $stmt->error . ' in query: ' . $sql]);
            }
        } catch (mysqli_sql_exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $e]);
        }
    }

    function add_appointment()
    {
        try {
            session_start();
            extract($_POST);

            $user_id = $user_id ?? $_SESSION['id'];

            if ($status == 0 && empty($fname) && empty($lname) && empty($sex) && empty($bday) && empty($address) && empty($barangay) && empty($city) && empty($zip) && empty($appointment_case) && empty($service) && empty($appointment_date) && empty($appointment_time) && empty($email) && empty($phone)) {
                echo json_encode(['status' => 'error', 'message' => 'Please fill at least 1 field to save as draft.']);
                return;
            }

            if ($status == 1) {
                $emptyFields = [];

                if (!isset($fname) || $fname === '') $emptyFields[] = 'First Name';
                if (!isset($lname) || $lname === '') $emptyFields[] = 'Last Name';
                if (!isset($sex) || $sex === '') $emptyFields[] = 'Sex';
                if (!isset($bday) || $bday === '') $emptyFields[] = 'Birthday';
                if (!isset($address) || $address === '') $emptyFields[] = 'Address';
                if (!isset($barangay) || $barangay === '') $emptyFields[] = 'Barangay';
                if (!isset($city) || $city === '') $emptyFields[] = 'City';
                if (!isset($zip) || $zip === '') $emptyFields[] = 'ZIP Code';
                if (!isset($appointment_case) || $appointment_case === '') $emptyFields[] = 'Appointment Case';
                if (!isset($service) || $service === '') $emptyFields[] = 'Service';
                if (!isset($appointment_date) || $appointment_date === '') $emptyFields[] = 'Appointment Date';
                if (!isset($appointment_time) || $appointment_time === '') $emptyFields[] = 'Appointment Time';
                if (!isset($email) || $email === '') $emptyFields[] = 'Email';
                if (!isset($phone) || $phone === '') $emptyFields[] = 'Phone';

                if (!empty($emptyFields)) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'The following fields are required: ' . implode(', ', $emptyFields)
                    ]);
                    return;
                }
            }

            if (!empty($phone) && !$this->validatePhone($phone)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid Phone Number. It must start with 09 or +639 followed by 9 digits.']);
                return;
            }

            if (!empty($email) && !$this->validateEmail($email)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid Email Address.']);
                return;
            }

            if (!empty($fname) && !$this->validateName($fname)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid First Name. Only alphabets and spaces are allowed.']);
                return;
            }

            if (!empty($lname) && !$this->validateName($lname)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid Last Name. Only alphabets and spaces are allowed.']);
                return;
            }

            $sql = "INSERT INTO appointments (user_id, fname, mname, lname, sex, bday, address, barangay, city, zip, appointment_case, service, payment, appointment_date, appointment_time, email, phone, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("isssissssssiissssi", $user_id, $fname, $mname, $lname, $sex, $bday, $address, $barangay, $city, $zip, $appointment_case, $service, $payment, $appointment_date, $appointment_time, $email, $phone, $status);

            if ($stmt->execute()) {
                $appointment_id = $this->con->insert_id;
                if ($status == 1) {
                    $message = 'Appointment submitted successfully!.';
                } else {
                    $message = 'Appointment saved to drafts successfully!.';
                }
                echo json_encode(['status' => 'success', 'message' => $message, 'id' => $appointment_id]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $stmt->error . ' in query: ' . $sql]);
            }
        } catch (mysqli_sql_exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $e]);
        }
    }

    function update_appointment()
    {
        try {
            extract($_POST);

            if ($status == 0 && empty($fname) && empty($lname) && empty($sex) && empty($bday) && empty($address) && empty($barangay) && empty($city) && empty($zip) && empty($appointment_case) && empty($service) && empty($appointment_date) && empty($appointment_time) && empty($email) && empty($phone)) {
                echo json_encode(['status' => 'error', 'message' => 'Please fill at least 1 field to save as draft.']);
                return;
            }

            if ($status == 1) {
                $emptyFields = [];

                if (!isset($fname) || $fname === '') $emptyFields[] = 'First Name';
                if (!isset($lname) || $lname === '') $emptyFields[] = 'Last Name';
                if (!isset($sex) || $sex === '') $emptyFields[] = 'Sex';
                if (!isset($bday) || $bday === '') $emptyFields[] = 'Birthday';
                if (!isset($address) || $address === '') $emptyFields[] = 'Address';
                if (!isset($barangay) || $barangay === '') $emptyFields[] = 'Barangay';
                if (!isset($city) || $city === '') $emptyFields[] = 'City';
                if (!isset($zip) || $zip === '') $emptyFields[] = 'ZIP Code';
                if (!isset($appointment_case) || $appointment_case === '') $emptyFields[] = 'Appointment Case';
                if (!isset($service) || $service === '') $emptyFields[] = 'Service';
                if (!isset($appointment_date) || $appointment_date === '') $emptyFields[] = 'Appointment Date';
                if (!isset($appointment_time) || $appointment_time === '') $emptyFields[] = 'Appointment Time';
                if (!isset($email) || $email === '') $emptyFields[] = 'Email';
                if (!isset($phone) || $phone === '') $emptyFields[] = 'Phone';

                if (!empty($emptyFields)) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'The following fields are required: ' . implode(', ', $emptyFields)
                    ]);
                    return;
                }
            }

            // if($status == 1 && (empty($fname) || empty($lname) || $sex == '' || empty($bday) || empty($address) || empty($barangay) || empty($city) || empty($zip) || empty($appointment_case) || service == '' || empty($appointment_date) || $appointment_time == '' || empty($email) || empty($phone))){
            //     echo json_encode(['status' => 'error', 'message' => 'Please fill all fields to submit appointment or save as draft.']);
            //     return;
            // }

            if (!empty($phone) && !$this->validatePhone($phone)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid Phone Number. It must start with 09 or +639 followed by 9 digits.']);
                return;
            }

            if (!empty($email) && !$this->validateEmail($email)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid Email Address.']);
                return;
            }

            if (!empty($fname) && !$this->validateName($fname)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid First Name. Only alphabets and spaces are allowed.']);
                return;
            }

            if (!empty($lname) && !$this->validateName($lname)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid Last Name. Only alphabets and spaces are allowed.']);
                return;
            }

            $sql = "UPDATE appointments SET fname = ?, mname = ?, lname = ?, sex = ?, bday = ?, address = ?, barangay = ?, city = ?, zip = ?, appointment_case = ?, service = ?, payment = ?, appointment_date = ?, appointment_time = ?, email = ?, phone = ?, status = ? WHERE id = ?";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("sssissssssiissssii", $fname, $mname, $lname, $sex, $bday, $address, $barangay, $city, $zip, $appointment_case, $service, $payment, $appointment_date, $appointment_time, $email, $phone, $status, $appointment_id);

            if ($stmt->execute()) {
                if ($status == 1) {
                    $message = 'Appointment submitted successfully!.';
                } else {
                    $message = 'Appointment draft updated successfully!.';
                }
                echo json_encode(['status' => 'success', 'message' => $message, 'id' => $appointment_id]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $stmt->error . ' in query: ' . $sql]);
            }
        } catch (mysqli_sql_exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $e]);
        }
    }

    function update_appoinment_status()
    {
        try {
            session_start();
            extract($_POST);

            $sql = "UPDATE appointments SET practitioner_id = ?, status = ? WHERE id = ?";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("iii", $_SESSION['id'], $status, $appointment_id);

            if ($stmt->execute()) {
                if ($status == 2) {
                    echo json_encode(['status' => 'success', 'message' => 'Appointment accepted successfully!.', 'id' => $appointment_id]);
                } else {
                    echo json_encode(['status' => 'success', 'message' => 'Appointment declined successfully!.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $stmt->error . ' in query: ' . $sql]);
            }
        } catch (mysqli_sql_exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $e]);
        }
    }

    function fetch_appointments()
    {
        session_start();
        $practitioner_id = $_SESSION['id'];

        $sql = "SELECT * FROM appointments 
                WHERE status = 2 
                AND practitioner_id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $practitioner_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $appointments = [];

            while ($row = $result->fetch_assoc()) {
                $appointments[] = [
                    'event_id' => $row['id'],
                    'title' => $row['fname'] . ($row['mname'] ? ' ' . $row['mname'] : '') . ' ' . $row['lname'],
                    'start' => $row['appointment_date'] . 'T' . $row['appointment_time'],
                    'end' => $row['appointment_date'] . 'T' . $row['appointment_time'],
                    'color' => '#28a745',
                    'service' => $this->getService($row['service']),
                ];
            }

            echo json_encode(['data' => $appointments]);
        } else {
            echo json_encode(['error' => 'Failed to fetch appointments.']);
        }

        $stmt->close();
    }

    function getService($service)
    {
        switch ($service) {
            case 0:
                return 'Physical Therapy';
            case 1:
                return 'Caregiving Service (8-hour shift)';
            case 2:
                return 'Caregiving Service (12-hour shift)';
            case 3:
                return 'Caregiving Service (24-hour shift)';
            case 4:
                return 'Nursing Home';
            default:
                return 'No selected yet.';
        }
    }

    function delete_appointment()
    {
        try {
            extract($_POST);

            $sql = "DELETE FROM appointments WHERE id = ?";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $appointment_id);

            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Appointment deleted successfully!.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $stmt->error . ' in query: ' . $sql]);
            }
        } catch (mysqli_sql_exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $e]);
        }
    }

    function logout()
    {
        session_start();
        session_destroy();

        header("location: ../index.php");
        exit;
    }
}
