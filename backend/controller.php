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
                return json_encode(['status' => 'error', 'message' => 'Invalid Email Address.']);
            }

            if (!$this->validatePassword($password)) {
                return json_encode(['status' => 'error', 'message' => 'Password must contain at least 8 characters, including at least one uppercase letter, one lowercase letter, one number, and one special character.']);
            }

            if ($password != $cpassword) {
                return json_encode(['status' => 'error', 'message' => 'Password and confirm password do not match.']);
            }

            if (!$this->validatePhone($phone)) {
                return json_encode(['status' => 'error', 'message' => 'Invalid Phone Number. It must start with 09 or +639 followed by 9 digits.']);
            }

            if (!$this->validateName($fname)) {
                return json_encode(['status' => 'error', 'message' => 'Invalid First Name. Only alphabets and spaces are allowed.']);
            }

            if (!$this->validateName($lname)) {
                return json_encode(['status' => 'error', 'message' => 'Invalid Last Name. Only alphabets and spaces are allowed.']);
            }

            $sql = "SELECT * FROM users WHERE email = ?";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("s", $email);

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    return json_encode(['status' => 'error', 'message' => 'Email is taken. Please login or register a new email.']);
                }
            } else {
                return json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $stmt->error . ' in query: ' . $sql]);
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

                    // Suppress output from mail function
                    ob_start();
                    $mailResult = $this->mail->send();
                    ob_end_clean();

                    if (!empty($hire_date)) {
                        $stmt->close();

                        $sql = "INSERT INTO practitioners (user_id, specialization, hire_date) VALUES (?, ?, ?)";

                        $stmt = $this->con->prepare($sql);
                        $stmt->bind_param("iss", $user_id, $specialization, $hire_date);

                        if (!$stmt->execute()) {
                            return json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $stmt->error . ' in query: ' . $sql]);
                        }
                    }

                    return json_encode(['status' => 'success', 'message' => 'Registered successfully!. Please check your email to verify your account.']);
                } else {
                    return json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $stmt->error . ' in query: ' . $sql]);
                }
            } else {
                return json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $stmt->error . ' in query: ' . $sql]);
            }
        } catch (mysqli_sql_exception $e) {
            return json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $e]);
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
                        // Redirect to the index page
                        header("location: " . $this->base_url . "/index.php");
                        exit;
                    } else {
                        $_SESSION['flash-msg'] = 'account-not-found';
                        header("location: " . $this->base_url . "/index.php");
                        exit;
                    }
                } else {
                    $_SESSION['flash-msg'] = 'account-not-found';
                    header("location: " . $this->base_url . "/index.php");
                    exit;
                }
            } else {
                $_SESSION['flash-msg'] = 'account-not-found';
                header("location: " . $this->base_url . "/index.php");
                exit;
            }
        } catch (mysqli_sql_exception $e) {
            $_SESSION['flash-msg'] = 'error';
            header("location: " . $this->base_url . "/index.php");
            exit;
        }
    }

    function login()
    {
        try {
            extract($_POST);
            $ip = $_SERVER['REMOTE_ADDR'];
            $max_attempts = 5;
            $lockout_time = 1; // minutes

            // Check failed attempts in the last 1 minute
            $stmt = $this->con->prepare("SELECT COUNT(*) FROM login_attempts WHERE ip_address = ? AND attempt_time > (NOW() - INTERVAL ? MINUTE)");
            $stmt->bind_param("si", $ip, $lockout_time);
            $stmt->execute();
            $stmt->bind_result($attempts);
            $stmt->fetch();
            $stmt->close();

            if ($attempts >= $max_attempts) {
                if ($attempts == $max_attempts) {
                    // Log intrusion attempt to database instead of sending email
                    $log_sql = "INSERT INTO admin_notifications (type, message, is_read) VALUES (?, ?, 0)";
                    $log_stmt = $this->con->prepare($log_sql);
                    $type = 'Security Alert';
                    $msg = "Multiple failed login attempts detected from IP: $ip. Access has been temporarily blocked.";
                    $log_stmt->bind_param("ss", $type, $msg);
                    $log_stmt->execute();
                    $log_stmt->close();
                }
                return json_encode(['status' => 'error', 'message' => 'Too many failed login attempts. Please try again after ' . $lockout_time . ' minutes.']);
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

                            $clear = $this->con->prepare("DELETE FROM login_attempts WHERE ip_address = ?");
                            $clear->bind_param("s", $ip);
                            $clear->execute();
                            $clear->close();

                            if ($role == 0) {
                                $redirect = './admin/Admin_Dashboard.php';
                            } elseif ($role == 1) {
                                $redirect = './user/LandingPage.php';
                            } elseif ($role == 2 || $role == 3) {
                                $redirect = './practitioner/Practitioner_Dashboard.php';
                            } else {
                                $redirect = './index.php';
                            }

                            return json_encode([
                                'status' => 'success',
                                'redirect' => $redirect
                            ]);
                        } else {
                            if ($status == 2) {
                                return json_encode(['status' => 'error', 'message' => 'Your account is inactive!. Please contact the administrator.']);
                            } else {
                                return json_encode(['status' => 'error', 'message' => 'Your account is unverified!. Please check your email address.']);
                            }
                        }
                    } else {
                        // Log failed attempt
                        $fail = $this->con->prepare("INSERT INTO login_attempts (ip_address, attempt_time) VALUES (?, NOW())");
                        $fail->bind_param("s", $ip);
                        $fail->execute();
                        $fail->close();
                        return json_encode(['status' => 'error', 'message' => 'Email or password is incorrect.']);
                    }
                } else {
                    // Log failed attempt
                    $fail = $this->con->prepare("INSERT INTO login_attempts (ip_address, attempt_time) VALUES (?, NOW())");
                    $fail->bind_param("s", $ip);
                    $fail->execute();
                    $fail->close();
                    return json_encode(['status' => 'error', 'message' => 'Email or password is incorrect.']);
                }
            } else {
                return json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $stmt->error . ' in query: ' . $sql]);
            }
        } catch (mysqli_sql_exception $e) {
            return json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $e]);
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

            // Check for overlapping appointments for the patient
            $check_patient = $this->con->prepare("SELECT COUNT(*) FROM appointments WHERE user_id = ? AND appointment_date = ? AND appointment_time = ? AND status IN (1,2)");
            $check_patient->bind_param("iss", $user_id, $appointment_date, $appointment_time);
            $check_patient->execute();
            $check_patient->bind_result($patient_conflict);
            $check_patient->fetch();
            $check_patient->close();
            if ($patient_conflict > 0) {
                echo json_encode(['status' => 'error', 'message' => 'You already have an appointment at this date and time.']);
                return;
            }

            // If practitioner_id is set (for therapist), check for overlapping appointments
            if (!empty($practitioner_id)) {
                $check_therapist = $this->con->prepare("SELECT COUNT(*) FROM appointments WHERE practitioner_id = ? AND appointment_date = ? AND appointment_time = ? AND status = 2");
                $check_therapist->bind_param("iss", $practitioner_id, $appointment_date, $appointment_time);
                $check_therapist->execute();
                $check_therapist->bind_result($therapist_conflict);
                $check_therapist->fetch();
                $check_therapist->close();
                if ($therapist_conflict > 0) {
                    echo json_encode(['status' => 'error', 'message' => 'The therapist already has an accepted appointment at this date and time.']);
                    return;
                }
            }

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

            // Check for overlapping appointments for the patient (on update)
            $check_patient = $this->con->prepare("SELECT COUNT(*) FROM appointments WHERE user_id = ? AND appointment_date = ? AND appointment_time = ? AND status IN (1,2) AND id != ?");
            $check_patient->bind_param("issi", $user_id, $appointment_date, $appointment_time, $appointment_id);
            $check_patient->execute();
            $check_patient->bind_result($patient_conflict);
            $check_patient->fetch();
            $check_patient->close();
            if ($patient_conflict > 0) {
                echo json_encode(['status' => 'error', 'message' => 'You already have an appointment at this date and time.']);
                return;
            }

            // If practitioner_id is set (for therapist), check for overlapping appointments (on update)
            if (!empty($practitioner_id)) {
                $check_therapist = $this->con->prepare("SELECT COUNT(*) FROM appointments WHERE practitioner_id = ? AND appointment_date = ? AND appointment_time = ? AND status = 2 AND id != ?");
                $check_therapist->bind_param("issi", $practitioner_id, $appointment_date, $appointment_time, $appointment_id);
                $check_therapist->execute();
                $check_therapist->bind_result($therapist_conflict);
                $check_therapist->fetch();
                $check_therapist->close();
                if ($therapist_conflict > 0) {
                    echo json_encode(['status' => 'error', 'message' => 'The therapist already has an accepted appointment at this date and time.']);
                    return;
                }
            }

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

    function update_appointment_status()
    {
        try {
            session_start();
            extract($_POST);
            
            if(!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
                return json_encode(['status' => 'error', 'message' => 'You must be logged in to perform this action.']);
            }
            
            if(!isset($appointment_id) || !isset($status)) {
                return json_encode(['status' => 'error', 'message' => 'Missing required parameters.']);
            }
            
            // Validate status value
            if(!in_array($status, [1, 2, 3, 4])) {
                return json_encode(['status' => 'error', 'message' => 'Invalid status value.']);
            }
            
            // Check if appointment exists
            $check_appt = $this->con->prepare("SELECT id, user_id, appointment_date, appointment_time, fname, lname FROM appointments WHERE id = ?");
            $check_appt->bind_param("i", $appointment_id);
            $check_appt->execute();
            $check_appt->store_result();
            
            if($check_appt->num_rows == 0) {
                return json_encode(['status' => 'error', 'message' => 'Appointment not found.']);
            }
            
            // Get appointment details
            $check_appt->bind_result($appt_id, $user_id, $appointment_date, $appointment_time, $fname, $lname);
            $check_appt->fetch();
            $check_appt->close();
            
            // Admin users can update any appointment without conflict checks
            if ($_SESSION['role'] == 0) {
                // For accept status, check if therapist_id is provided
                if ($status == 2 && isset($therapist_id) && !empty($therapist_id)) {
                    // First check if therapist exists and is active
                    $check_therapist = $this->con->prepare("SELECT id, fname, lname FROM users WHERE id = ? AND (role = 2 OR role = 3) AND status = 1");
                    $check_therapist->bind_param("i", $therapist_id);
                    $check_therapist->execute();
                    $check_therapist->store_result();
                    
                    if ($check_therapist->num_rows == 0) {
                        return json_encode(['status' => 'error', 'message' => 'Selected therapist does not exist or is not active.']);
                    }
                    
                    $check_therapist->bind_result($therapist_id, $therapist_fname, $therapist_lname);
                    $check_therapist->fetch();
                    $check_therapist->close();
                    
                    // Check for therapist schedule conflicts
                    $check_conflict = $this->con->prepare("SELECT COUNT(*) FROM appointments WHERE practitioner_id = ? AND appointment_date = ? AND appointment_time = ? AND status = 2 AND id != ?");
                    $check_conflict->bind_param("issi", $therapist_id, $appointment_date, $appointment_time, $appointment_id);
                    $check_conflict->execute();
                    $check_conflict->bind_result($conflict_count);
                    $check_conflict->fetch();
                    $check_conflict->close();
                    
                    if ($conflict_count > 0) {
                        return json_encode(['status' => 'error', 'message' => "The selected therapist already has another appointment at this date and time."]);
                    }
                    
                    // Update appointment status with therapist assignment
                    $sql = "UPDATE appointments SET status = ?, practitioner_id = ? WHERE id = ?";
                    $stmt = $this->con->prepare($sql);
                    $stmt->bind_param("iii", $status, $therapist_id, $appointment_id);
                } else {
                    // Regular status update without therapist assignment
                    $sql = "UPDATE appointments SET status = ? WHERE id = ?";
                    $stmt = $this->con->prepare($sql);
                    $stmt->bind_param("ii", $status, $appointment_id);
                }
                
                if ($stmt->execute()) {
                    // Prepare status text for notification
                    $status_text = '';
                    switch ($status) {
                        case 1: $status_text = 'pending review'; break;
                        case 2: $status_text = 'accepted'; break;
                        case 3: $status_text = 'declined'; break;
                        case 4: $status_text = 'completed'; break;
                    }
                    
                    // Check if user_notifications table exists before trying to use it
                    $table_check = $this->con->query("SHOW TABLES LIKE 'user_notifications'");
                    if ($table_check->num_rows > 0) {
                        // Create notification for the user
                        $notif_sql = "INSERT INTO user_notifications (user_id, type, message) VALUES (?, ?, ?)";
                        $notif_stmt = $this->con->prepare($notif_sql);
                        $type = 'Appointment Update';
                        
                        if ($status == 2 && isset($therapist_id)) {
                            $notification_message = "Your appointment #" . ($appointment_id + 100) . " has been accepted and assigned to " . $therapist_fname . " " . $therapist_lname . ".";
                        } else {
                            $notification_message = "Your appointment #" . ($appointment_id + 100) . " for " . $fname . " " . $lname . " has been marked as " . $status_text . ".";
                        }
                        
                        $notif_stmt->bind_param("iss", $user_id, $type, $notification_message);
                        $notif_stmt->execute();
                        $notif_stmt->close();
                    }
                    
                    return json_encode(['status' => 'success', 'message' => "Appointment status updated successfully."]);
                } else {
                    return json_encode(['status' => 'error', 'message' => 'Failed to update appointment status.', 'details' => $stmt->error]);
                }
            }
            
            // For practitioners (roles 2 or 3)
            if ($_SESSION['role'] == 2 || $_SESSION['role'] == 3) {
                // Only status 2 (accept) and 3 (decline) are allowed for practitioners
                if ($status != 2 && $status != 3) {
                    return json_encode(['status' => 'error', 'message' => 'You can only accept or decline appointments.']);
                }
                
                // Check for scheduling conflicts
                if ($status == 2) { // Only check for conflicts when accepting
                    // Check for overlapping appointments for the patient
                    $check_patient = $this->con->prepare("SELECT COUNT(*) FROM appointments WHERE user_id = ? AND appointment_date = ? AND appointment_time = ? AND status = 2 AND id != ?");
                    $check_patient->bind_param("issi", $user_id, $appointment_date, $appointment_time, $appointment_id);
                    $check_patient->execute();
                    $check_patient->bind_result($patient_conflict);
                    $check_patient->fetch();
                    $check_patient->close();
                    
                    if ($patient_conflict > 0) {
                        return json_encode(['status' => 'error', 'message' => 'The patient already has an accepted appointment at this date and time.']);
                    }
                    
                    // Check for overlapping appointments for the practitioner
                    $check_practitioner = $this->con->prepare("SELECT COUNT(*) FROM appointments WHERE practitioner_id = ? AND appointment_date = ? AND appointment_time = ? AND status = 2 AND id != ?");
                    $check_practitioner->bind_param("issi", $_SESSION['id'], $appointment_date, $appointment_time, $appointment_id);
                    $check_practitioner->execute();
                    $check_practitioner->bind_result($practitioner_conflict);
                    $check_practitioner->fetch();
                    $check_practitioner->close();
                    
                    if ($practitioner_conflict > 0) {
                        return json_encode(['status' => 'error', 'message' => 'You already have an accepted appointment at this date and time.']);
                    }
                }
                
                // Update appointment status and assign practitioner
                $sql = "UPDATE appointments SET status = ?, practitioner_id = ? WHERE id = ?";
                $stmt = $this->con->prepare($sql);
                $stmt->bind_param("iii", $status, $_SESSION['id'], $appointment_id);
                
                if ($stmt->execute()) {
                    // Check if user_notifications table exists before trying to use it
                    $table_check = $this->con->query("SHOW TABLES LIKE 'user_notifications'");
                    if ($table_check->num_rows > 0) {
                        // Create notification for the user
                        $notif_sql = "INSERT INTO user_notifications (user_id, type, message) VALUES (?, ?, ?)";
                        $notif_stmt = $this->con->prepare($notif_sql);
                        $type = 'Appointment Update';
                        
                        if ($status == 2) {
                            $notification_message = "Your appointment #" . ($appointment_id + 100) . " has been accepted by " . $_SESSION['fname'] . " " . $_SESSION['lname'] . ".";
                        } else {
                            $notification_message = "Your appointment #" . ($appointment_id + 100) . " has been declined by " . $_SESSION['fname'] . " " . $_SESSION['lname'] . ".";
                        }
                        
                        $notif_stmt->bind_param("iss", $user_id, $type, $notification_message);
                        $notif_stmt->execute();
                        $notif_stmt->close();
                    }
                    
                    return json_encode([
                        'status' => 'success', 
                        'message' => ($status == 2) ? "Appointment accepted successfully." : "Appointment declined successfully."
                    ]);
                } else {
                    return json_encode(['status' => 'error', 'message' => 'Failed to update appointment status.', 'details' => $stmt->error]);
                }
            }
            
            return json_encode(['status' => 'error', 'message' => 'You do not have permission to perform this action.']);
        } catch (Exception $e) {
            return json_encode(['status' => 'error', 'message' => 'An unexpected error occurred: ' . $e->getMessage()]);
        }
    }

    function fetch_appointments()
    {
        try {
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
                    $fullname = $row['fname'] . ($row['mname'] ? ' ' . $row['mname'] : '') . ' ' . $row['lname'];
                    $appointments[] = [
                        'event_id' => $row['id'],
                        'title' => $fullname,
                        'start' => $row['appointment_date'] . 'T' . $row['appointment_time'],
                        'end' => $row['appointment_date'] . 'T' . $row['appointment_time'],
                        'color' => '#28a745',
                        'service' => $this->getService($row['service']),
                    ];
                }

                return json_encode(['status' => 'success', 'data' => $appointments]);
            } else {
                return json_encode(['status' => 'error', 'message' => 'Failed to fetch appointments.']);
            }
        } catch (Exception $e) {
            return json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
        }
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

    function get_appointment_details()
    {
        try {
            extract($_POST);

            $sql = "SELECT * FROM appointments WHERE id = ?";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $appointment_id);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $appointment = $result->fetch_assoc();
                    echo json_encode(['status' => 'success', 'data' => $appointment]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Appointment not found.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $stmt->error . ' in query: ' . $sql]);
            }
        } catch (mysqli_sql_exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again later.', 'error' => 'Error: ' . $e]);
        }
    }

    function mark_notifications_read()
    {
        try {
            session_start();
            $user_id = $_SESSION['id'];

            $sql = "UPDATE user_notifications SET is_read = 1 WHERE user_id = ?";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $user_id);

            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'All notifications marked as read.']);
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

        header("location: " . $this->base_url . "/index.php");
        exit;
    }

    function get_therapists()
    {
        try {
            // Get all therapists and caregivers (role 2 and 3)
            $sql = "SELECT id, fname, lname, role FROM users WHERE (role = 2 OR role = 3) AND status = 1";
            $stmt = $this->con->prepare($sql);
            
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $therapists = [];
                
                while ($row = $result->fetch_assoc()) {
                    $therapists[] = [
                        'id' => $row['id'],
                        'fname' => $row['fname'],
                        'lname' => $row['lname'],
                        'role' => $row['role']
                    ];
                }
                
                return json_encode(['status' => 'success', 'data' => $therapists]);
            } else {
                return json_encode(['status' => 'error', 'message' => 'Failed to retrieve therapists.']);
            }
        } catch (Exception $e) {
            return json_encode(['status' => 'error', 'message' => 'An unexpected error occurred: ' . $e->getMessage()]);
        }
    }
}
