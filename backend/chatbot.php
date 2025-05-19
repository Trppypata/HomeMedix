<?php
// Set CORS headers to allow cross-origin requests
header('Access-Control-Allow-Origin: *'); // For production, replace * with your specific domain
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// If this is a preflight OPTIONS request, return early with 200
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Include database connection
if (file_exists('./config.php')) {
    require_once('./config.php');
} elseif (file_exists('../backend/config.php')) {
    require_once('../backend/config.php');
} else {
    die(json_encode(['status' => 'error', 'message' => 'Configuration file not found']));
}

session_start();

// Create a unique session ID for the chat if it doesn't exist
if (!isset($_SESSION['chat_id'])) {
    $_SESSION['chat_id'] = uniqid('chat_');
}

// Initialize or continue chat history
if (!isset($_SESSION['chat_history'])) {
    $_SESSION['chat_history'] = [];
}

// Set header for JSON response
header('Content-Type: application/json');

// Process user message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $userMessage = trim($_POST['message']);
    
    // Store user message in session history
    $_SESSION['chat_history'][] = [
        'sender' => 'user',
        'message' => $userMessage,
        'timestamp' => time()
    ];
    
    // Generate bot response
    $botResponse = getBotResponse($userMessage);
    
    // Store bot response in session history
    $_SESSION['chat_history'][] = [
        'sender' => 'bot',
        'message' => $botResponse['message'],
        'timestamp' => time()
    ];
    
    // Return response
    echo json_encode([
        'status' => 'success',
        'response' => $botResponse['message'],
        'suggestions' => $botResponse['suggestions'] ?? []
    ]);
    exit;
}

// Get chat history
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'history') {
    echo json_encode([
        'status' => 'success',
        'history' => $_SESSION['chat_history']
    ]);
    exit;
}

// Clear chat history
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'clear') {
    $_SESSION['chat_history'] = [];
    echo json_encode([
        'status' => 'success',
        'message' => 'Chat history cleared'
    ]);
    exit;
}

// Initialize chat
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'init') {
    // Welcome message
    $welcomeMessage = "Hello! I'm your HomeMedix virtual assistant. How can I help you today?";
    $followupMessage = "You can ask me about our services, locations, or specific health concerns.";
    
    // Add welcome messages to history if it's empty
    if (empty($_SESSION['chat_history'])) {
        $_SESSION['chat_history'][] = [
            'sender' => 'bot',
            'message' => $welcomeMessage,
            'timestamp' => time()
        ];
        
        $_SESSION['chat_history'][] = [
            'sender' => 'bot',
            'message' => $followupMessage,
            'timestamp' => time()
        ];
    }
    
    echo json_encode([
        'status' => 'success',
        'welcome' => $welcomeMessage,
        'followup' => $followupMessage,
        'suggestions' => [
            "What services do you offer?",
            "How much does physical therapy cost?",
            "Where are your locations?",
            "How do I book an appointment?"
        ]
    ]);
    exit;
}

/**
 * Generate a response based on user message
 * 
 * @param string $userMessage
 * @return array Response with message and optional suggestions
 */
function getBotResponse($userMessage) {
    global $con;
    $userMessage = strtolower($userMessage);
    
    // Basic responses based on keywords
    $responses = [
        'hello' => [
            'message' => 'Hello! Welcome to HomeMedix. How can I help you today?',
            'suggestions' => []
        ],
        'hi' => [
            'message' => 'Hi there! Welcome to HomeMedix. How can I help you today?',
            'suggestions' => []
        ],
        'services' => [
            'message' => 'HomeMedix offers three main services: Physical Therapy, Caregiving Services (8/12/24-hour shifts), and Nursing Home services. Which one would you like to know more about?',
            'suggestions' => ['Tell me about Physical Therapy', 'Tell me about Caregiving', 'Tell me about Nursing Home']
        ],
        'physical therapy' => [
            'message' => 'Our Physical Therapy services help patients regain mobility, reduce pain, and improve overall physical function. Our therapists are experts in rehabilitation for injuries, surgeries, and chronic conditions.',
            'suggestions' => ['What conditions do you treat?', 'How much does physical therapy cost?', 'Do you do home visits?']
        ],
        'caregiving' => [
            'message' => 'Our Caregiving Services provide compassionate in-home care with options for 8-hour, 12-hour, or 24-hour shifts. Our caregivers assist with daily activities, medication reminders, and provide companionship.',
            'suggestions' => ['Tell me about 8-hour shifts', 'Tell me about 24-hour care', 'How are caregivers selected?']
        ],
        'nursing home' => [
            'message' => 'Our Nursing Home service provides 24/7 professional nursing care in a comfortable facility for patients who need continuous medical attention and assistance.',
            'suggestions' => ['What facilities do you have?', 'What is the cost?', 'Can I visit anytime?']
        ],
        'appointment' => [
            'message' => 'You can book an appointment through our website by visiting the Appointment page or by calling our office. Would you like the direct link to our online booking system?',
            'suggestions' => ['Yes, give me the link', 'What information do I need to book?', 'How far in advance should I book?']
        ],
        'price' => [
            'message' => 'Our service prices vary depending on the type of care and duration. For a detailed quote, please contact us directly or schedule a free initial consultation.',
            'suggestions' => ['Tell me about Physical Therapy costs', 'Tell me about Caregiving costs', 'Tell me about Nursing Home costs']
        ],
        'location' => [
            'message' => 'HomeMedix has three locations in Metro Manila: 124 A. Flores St, Marikina; 28 6th St, Marikina; and 24 Sampaguita St, Marikina.',
            'suggestions' => ['How do I get to your main office?', 'Do you offer home visits?', 'Are all services available at each location?']
        ],
        'contact' => [
            'message' => 'You can reach us at 0917 102 8250 or email us at HomeMedix.ptcaregiving@gmail.com. Our office hours are Monday-Saturday, 8am-5pm.',
            'suggestions' => ['Is someone available 24/7?', 'How quickly do you respond to emails?', 'Can I book an appointment now?']
        ]
    ];
    
    // Check for service queries from database
    $query = "SELECT * FROM services WHERE status = 1";
    $result = mysqli_query($con, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        while ($service = mysqli_fetch_assoc($result)) {
            $serviceName = strtolower($service['name']);
            if (strpos($userMessage, $serviceName) !== false) {
                return [
                    'message' => "{$service['name']}: {$service['description']}\n\n{$service['details']}\n\nDuration: {$service['duration']}\nPrice Range: {$service['price_range']}",
                    'suggestions' => ['Tell me about other services', 'How do I book this service?', 'What conditions do you treat?']
                ];
            }
        }
    }
    
    // Check for illness queries from database
    $query = "SELECT * FROM illnesses WHERE status = 1";
    $result = mysqli_query($con, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        while ($illness = mysqli_fetch_assoc($result)) {
            $illnessName = strtolower($illness['name']);
            if (strpos($userMessage, $illnessName) !== false) {
                return [
                    'message' => "{$illness['name']}: {$illness['description']}\n\n{$illness['symptoms']}\n\n{$illness['treatment']}\n\n{$illness['prevention']}\n\nRecommended services: {$illness['related_services']}",
                    'suggestions' => ['Tell me about these services', 'Book an appointment', 'More health information']
                ];
            }
        }
    }
    
    // Match keyword-based responses
    foreach ($responses as $keyword => $response) {
        if (strpos($userMessage, $keyword) !== false) {
            return $response;
        }
    }
    
    // Default response if no match found
    return [
        'message' => "I'm not sure I understand your question. You can ask me about our services, specific health conditions, pricing, locations, or booking an appointment.",
        'suggestions' => ['What services do you offer?', 'How do I book an appointment?', 'Tell me about your prices', 'Where are you located?']
    ];
} 