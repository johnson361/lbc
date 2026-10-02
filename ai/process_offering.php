<?php
header('Content-Type: application/json');

// Enable error reporting for your debug console
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 1. Database Configuration
$db_host = "localhost";
$db_user = "u359459502_cbcsl";
$db_pass = 'M9TU6Mv!ZpKy$N9';
$db_name = 'u359459502_faithfund';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    echo json_encode(["success" => false, "error" => "No input received"]);
    exit;
}

$action = $input['action'] ?? '';

// ============================================================================
// IMAGE COMPRESSION FUNCTION
// ============================================================================
function compressImageOnServer($base64Image, $maxQuality = 75, $maxSizeKB = 200) {
    // Remove data URI prefix if present
    $base64Image = preg_replace('#^data:image/\\w+;base64,#i', '', $base64Image);

    // Decode base64 to binary
    $imageBinary = base64_decode($base64Image);
    $originalSize = strlen($imageBinary);

    // Create image from string
    $image = imagecreatefromstring($imageBinary);
    if (!$image) {
        return array('success' => false, 'error' => 'Failed to process image');
    }

    // Get dimensions for potential resizing
    $width = imagesx($image);
    $height = imagesy($image);

    // Resize if too large (max 800x1000)
    $maxWidth = 800;
    $maxHeight = 1000;
    if ($width > $maxWidth || $height > $maxHeight) {
        $ratio = min($maxWidth / $width, $maxHeight / $height);
        $newWidth = (int)($width * $ratio);
        $newHeight = (int)($height * $ratio);

        $resized = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagedestroy($image);
        $image = $resized;
    }

    // Progressive quality reduction
    $quality = $maxQuality;
    $compressed = '';

    do {
        ob_start();
        imagejpeg($image, null, $quality);
        $compressed = ob_get_clean();
        $sizeKB = strlen($compressed) / 1024;

        if ($sizeKB <= $maxSizeKB || $quality <= 30) {
            break;
        }
        $quality -= 5;
    } while ($quality > 20);

    imagedestroy($image);

    $compressedSize = strlen($compressed);
    $compressedBase64 = base64_encode($compressed);

    return array(
        'success' => true,
        'image' => 'data:image/jpeg;base64,' . $compressedBase64,
        'stats' => array(
            'original_size_kb' => round($originalSize / 1024, 2),
            'compressed_size_kb' => round($compressedSize / 1024, 2),
            'quality' => $quality,
            'reduction_percent' => round((1 - $compressedSize / $originalSize) * 100, 1)
        )
    );
}

// --- ACTION 1: PARSE IMAGE VIA GEMINI ---
// --- ACTION 1: PARSE IMAGE VIA GEMINI ---
// --- ACTION 1: PARSE IMAGE VIA GEMINI ---
if ($action === 'parse') {
    // Compress image on server before sending to AI
    $compressionResult = compressImageOnServer($input['image'], 70, 200);
    if (!$compressionResult['success']) {
        echo json_encode(array("success" => false, "error" => $compressionResult['error']));
        exit;
    }
    
    $api_key = "AIzaSyDGnrONENyLamcLWd7csYbuJKZYmrxH5Xs";

    // CHANGE 1: Use gemini-1.5-flash-latest (This often fixes the 404)
    $url = "https://generativelanguage.googleapis.com/v1/models/gemini-2.0-flash-lite:generateContent?key=" . $api_key;

    preg_match('/^data:(image\\/\\w+);base64,/', $compressionResult['image'], $matches);

    $mime = $matches[1] ?? 'image/jpeg';

    $base64Image = preg_replace('#^data:image/\\w+;base64,#i', '', $compressionResult['image']);

    $prompt = "
        Analyze this church offering cover.

        Extract:
        - donor name
        - offering type
        - count of 500 notes
        - count of 200 notes
        - count of 100 notes
        - count of 50 notes

        Return ONLY valid JSON in this exact format:

        {
        \"name\": \"\",
        \"type\": \"\",
        \"d500\": 0,
        \"d200\": 0,
        \"d100\": 0,
        \"d50\": 0
        }
        ";

    $payload = [
        "contents" => [[
            "parts" => [
                ["text" => $prompt],
                [
                    "inline_data" => [
                        "mime_type" => $mime,
                        "data" => $base64Image
                    ]
                ]
            ]
        ]]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode([
            "success" => false,
            "error" => curl_error($ch)
        ]);
        exit;
    }

    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($http_code !== 200) {
        // This will print the EXACT error JSON from Google
        echo json_encode([
            "success" => false,
            "error" => "API Error $http_code",
            "debug_raw" => $response
        ]);
        exit;
    }

    $result = json_decode($response, true);
    if (!$result) {
        echo json_encode([
            "success" => false,
            "raw_response" => $response
        ]);
        exit;
    }

    $ai_text = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;

    $ai_text = preg_replace('/```json|```/', '', $ai_text);
    $ai_text = trim($ai_text);

    if ($ai_text) {

        $data = json_decode($ai_text, true);

        if (json_last_error() !== JSON_ERROR_NONE) {

            echo json_encode([
                "success" => false,
                "json_error" => json_last_error_msg(),
                "raw_ai" => $ai_text
            ]);

            exit;
        }

        echo json_encode([
            "success" => true,
            "data" => $data,
            "compression_stats" => $compressionResult['stats']
        ]);

        exit;
    } else {

        echo json_encode([
            "success" => false,
            "error" => "AI text empty",
            "raw" => $result
        ]);

        exit;
    }
}

// --- ACTION 2: SAVE VERIFIED DATA ---
elseif ($action === 'save') {
    $name = trim($conn->real_escape_string($input['name']));
    $service_id = (int)$input['service_id'];
    $service_date = $conn->real_escape_string($input['service_date']);
    $created_by = 1;

    // User Check/Insert
    $user_query = $conn->query("SELECT id FROM users WHERE name = '$name' LIMIT 1");
    if ($user_query && $user_query->num_rows > 0) {
        $user_id = $user_query->fetch_assoc()['id'];
    } else {
        $conn->query("INSERT INTO users (name, created_by) VALUES ('$name', $created_by)");
        $user_id = $conn->insert_id;
    }

    $sql = "INSERT INTO offerings (
        service_id, service_date, user_id,
        denomination_500, denomination_200, denomination_100, denomination_50,
        denomination_20_notes, denomination_10_notes, denomination_5_notes,
        comments, created_by
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $comments = ($input['type'] ?? 'General') . " - Verified Entry";
        $d500 = (int)($input['d500'] ?? 0);
        $d200 = (int)($input['d200'] ?? 0);
        $d100 = (int)($input['d100'] ?? 0);
        $d50  = (int)($input['d50'] ?? 0);
        $d20n = (int)($input['d20_notes'] ?? 0);
        $d10n = (int)($input['d10_notes'] ?? 0);
        $d5n  = (int)($input['d5_notes'] ?? 0);

        $stmt->bind_param(
            "isiiiiiiiisi",
            $service_id,
            $service_date,
            $user_id,
            $d500,
            $d200,
            $d100,
            $d50,
            $d20n,
            $d10n,
            $d5n,
            $comments,
            $created_by
        );

        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => $stmt->error]);
        }
        $stmt->close();
    }
}

$conn->close();
