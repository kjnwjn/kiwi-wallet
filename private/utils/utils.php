<?php
require './vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Util
{
    function generateRandomString($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    function generateRandomInt($length = 6)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomInt = '';
        for ($i = 0; $i < $length; $i++) {
            $randomInt .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomInt;
    }

    function sendMail($data = [])
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = getenv('SMTP_USER');
            $mail->Password = getenv('SMTP_PASS');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->setFrom(getenv('SMTP_USER'), $data['title']);
            $mail->addAddress($data['email']);
            $mail->isHTML(true);
            $mail->Subject = $data['title'];
            $mail->Body = $data['content'];
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function validateBody($body = [], $validate = [])
    {
        foreach ($validate as $key => $value) {
            if (isset($value['required']) && $value['required']) {
                if (!isset($body[$key]) || empty(trim($body[$key]))) {
                    return $key . ' is not allowed to be empty.';
                }
            }
            if (isset($value['is_email']) && $value['is_email']) {
                if (isset($body[$key]) && !filter_var(($body[$key]), FILTER_VALIDATE_EMAIL)) {
                    return $key . ' must be a valid email';
                }
            }
            if (isset($value['is_number']) && $value['is_number']) {
                if (isset($body[$key])) {
                    $validNumber = is_numeric($body[$key]);
                    if (!$validNumber) {
                        return $key . ' must be a number.';
                    }
                }
            }
            if (isset($value['min'])) {
                if (!isset($body[$key]) || $value['min'] > strlen($body[$key])) {
                    return $key . ' must be at least ' . $value['min'] . ($value['min'] > 1 ? ' characters.' : ' character.');
                }
            }
            if (isset($value['max'])) {
                if (!isset($body[$key]) || strlen($body[$key]) > $value['max']) {
                    return $key . ' must not more than ' . $value['max'] . ' characters.';
                }
            }
            if (isset($value['tel']) && $value['tel']) {
                if (isset($body[$key])) {
                    $validPhoneNumber = preg_match("/^[0]{1}[0-9]{9}$/", $body[$key]);
                    if (!$validPhoneNumber) {
                        return $key . ' must be a valid phone number.';
                    }
                }
            }
            if (isset($value['date']) && $value['date']) {
                if (isset($body[$key])) {
                    $validateTimeStamp = ((string) (int) $body[$key] === $body[$key])
                        && ($body[$key] <= PHP_INT_MAX)
                        && ($body[$key] >= ~PHP_INT_MAX);
                    if (!$validateTimeStamp) {
                        return $key . ' must be a valid date.';
                    }
                }
            }
            if (isset($value['gender']) && $value['gender']) {
                if (isset($body[$key])) {
                    $validateGender = $body[$key] === 'Male' || $body[$key] === 'Female';
                    if (!$validateGender) {
                        return $key . ' must be a valid gender.';
                    }
                }
            }
            if(isset($value['match']) && $value['match']) {
                if (isset($body[$key])) {
                    $matched = $body[$key] === $body[$value['match']];
                    if (!$matched) {
                        return $key . ' must be matched with ' . $value['match'] ;
                    }
                }
            }

        }
    }

    function validateFiles($files = [], $validate = [])
    {
        foreach ($validate as $key => $value) {
            if (isset($value['required']) && $value['required']) {
                if (!isset($files[$key]) || $files[$key]['size'] === 0) {
                    return $key . ' is not allowed to be empty.';
                }
            }
            if (isset($value['image']) && $value['image']) {
                if (isset($files[$key])) {
                    if (
                        $files[$key]['type'] !== 'image/jpeg' &&
                        $files[$key]['type'] !== 'image/png' &&
                        $files[$key]['type'] !== 'image/jpg'
                    ) {
                        return $key . ' only accept image type.';
                    }
                }
            }
            if (isset($value['size']) && $value['size']) {
                if (isset($files[$key])) {
                    if ($files[$key]['size'] > $value['size'] * 1000000) {
                        return $key . ' must be equal or less than ' . $value['size'] . ' MB.';
                    }
                }
            }
        }
    }

    function handleUpload($files = [], $name = [])
    {
        $result = [];
        foreach ($name as $key => $value) {
            if (isset($files[$value])) {
                $fileName = bin2hex(random_bytes(10)) . '_' . $files[$value]['name'];
                $target_dir = "public/assest/img/uploads/";
                $target_file = $target_dir . $fileName;
                (!file_exists($target_dir)) ? mkdir($target_dir, 0777, true) : null; /* Create dir if not exist */
                $path = getenv('BASE_URL') . $target_dir . rawurlencode($fileName);
                if (!move_uploaded_file($files[$value]["tmp_name"], $target_file)) {
                    $result[$value] = array(
                        'origin_name' => $files[$value]['name'],
                        'name' => $fileName,
                        'type' => null,
                        'size' => 0,
                        'err' => 'Cannot upload file.',
                        'path' => null
                    );
                };
                $result[$value] = array(
                    'origin_name' => $files[$value]['name'],
                    'name' => $fileName,
                    'type' => $files[$value]['type'],
                    'size' => $files[$value]['size'],
                    'err' => '',
                    'path' => $path
                );
            }
        }
        return $result;
    }

}
