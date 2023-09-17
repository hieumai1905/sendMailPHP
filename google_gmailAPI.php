<?php
require_once 'vendor/autoload.php';

use Google\Service\Gmail;

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function get_gmail_client() {
    // Đường dẫn đến tệp tin token đã được cấu hình và có quyền truy cập Gmail API
    $token_path = 'token.json';

    // Các thông tin xác thực OAuth 2.0
    $client_id = 'YOUR_CLIENT_ID';
    $client_secret = 'YOUR_CLIENT_SECRET';
    $redirect_uri = 'YOUR_REDIRECT_URI';

    // Khởi tạo client
    $client = new Google\Client();
    $client->setAuthConfig('credentials.json');
    $client->addScope(Google\Service\Gmail::GMAIL_SEND);

    // Kiểm tra tính hợp lệ của token
    if (file_exists($token_path)) {
        $client->setAccessToken(file_get_contents($token_path));
    } else {
        // Xác thực OAuth 2.0
        $auth_url = $client->createAuthUrl();
        echo "Open the following link in your browser:\n";
        echo $auth_url;

        // Nhập mã xác thực từ trình duyệt
        $auth_code = readline("Enter the authorization code: ");

        // Lấy token truy cập từ mã xác thực
        $access_token = $client->fetchAccessTokenWithAuthCode($auth_code);
        $client->setAccessToken($access_token);

        // Lưu token truy cập vào tệp tin
        file_put_contents($token_path, json_encode($access_token));
    }

    // Kiểm tra tính hợp lệ của token
    if ($client->isAccessTokenExpired()) {
        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        file_put_contents($token_path, json_encode($client->getAccessToken()));
    }

    return $client;
}

function send_gmail_message($to, $subject, $message_body) {
    // Khởi tạo client Gmail
    $client = get_gmail_client();

    // Khởi tạo dịch vụ Gmail
    $service = new Gmail($client);

    // Tạo nội dung email
    $message = new Google\Service\Gmail\Message();
    $message->setRaw(base64url_encode(
        "From: maivanhieu19052002@gmail.com\r\n" .
        "To: $to\r\n" .
        "Subject: $subject\r\n\r\n" .
        "$message_body"
    ));

    try {
        // Gửi email
        $service->users_messages->send('me', $message);

        echo "Email sent successfully.";
    } catch (Exception $e) {
        echo "An error occurred: " . $e->getMessage();
    }
}

// Gọi hàm gửi email
send_gmail_message('hieumai1905it@gmail.com', 'Test Email', 'This is a test email.');