// HomeMedix Chatbot
document.addEventListener('DOMContentLoaded', function() {
    // Predefined responses based on keywords
    const responses = {
        'hello': 'Hello! Welcome to HomeMedix. How can I help you today?',
        'hi': 'Hi there! Welcome to HomeMedix. How can I help you today?',
        'services': 'HomeMedix offers three main services: Physical Therapy, Caregiving Services (8/12/24-hour shifts), and Nursing Home services. Which one would you like to know more about?',
        'physical therapy': 'Our Physical Therapy services help patients regain mobility, reduce pain, and improve overall physical function. Our therapists are experts in rehabilitation for injuries, surgeries, and chronic conditions.',
        'caregiving': 'Our Caregiving Services provide compassionate in-home care with options for 8-hour, 12-hour, or 24-hour shifts. Our caregivers assist with daily activities, medication reminders, and provide companionship.',
        'nursing home': 'Our Nursing Home service provides 24/7 professional nursing care in a comfortable facility for patients who need continuous medical attention and assistance.',
        'headache': 'Headaches can have many causes including stress, dehydration, or underlying medical conditions. If you\'re experiencing persistent headaches, our Physical Therapy services might help. Would you like to schedule a consultation?',
        'back pain': 'Back pain is a common condition that our Physical Therapists specialize in treating. We offer personalized treatment plans that include exercises, manual therapy, and education to reduce pain and improve function.',
        'elderly care': 'For elderly care, we offer both Caregiving Services for in-home support and Nursing Home options for 24/7 professional care. The best choice depends on the level of medical attention needed.',
        'appointment': 'You can book an appointment through our website by visiting the Appointment page or by calling our office. Would you like the direct link to our online booking system?',
        'location': 'HomeMedix has three locations in Metro Manila: 124 A. Flores St, Marikina; 28 6th St, Marikina; and 24 Sampaguita St, Marikina.',
        'contact': 'You can reach us at 0917 102 8250 or email us at HomeMedix.ptcaregiving@gmail.com. Our office hours are Monday-Saturday, 8am-5pm.',
        'price': 'Our service prices vary depending on the type of care and duration. For a detailed quote, please contact us directly or schedule a free initial consultation.',
        'insurance': 'HomeMedix works with several HMO providers including Amaphil, Sunlife Grepa, and WellCare. Please contact us to verify if your specific insurance is accepted.',
        'hours': 'Our services are available 24/7. Office hours for inquiries are Monday-Saturday, 8am-5pm.',
        'therapist': 'All our physical therapists are licensed professionals with degrees in Physical Therapy and special training in various rehabilitation techniques.',
        'caregiver': 'Our caregivers are trained professionals who undergo background checks and receive ongoing education in patient care, safety protocols, and emergency response.',
        'recovery': 'Recovery time varies based on your condition, overall health, and adherence to treatment plans. During your initial assessment, your healthcare provider will discuss expected recovery timelines.',
        'help': 'I can provide information about our services, answer questions about symptoms, help with appointments, or tell you more about HomeMedix. What would you like to know?',
        'about': 'HomeMedix is a healthcare provider specializing in Physical Therapy, Caregiving, and Nursing Home services. We\'ve been serving the Metro Manila area since 2015 with our mission to provide compassionate, high-quality care.'
    };

    // Default response for unrecognized queries
    const defaultResponse = "I'm not sure I understand. Could you please rephrase your question? Or ask about our services, locations, appointments, or specific health concerns.";

    // Create chat UI elements
    const body = document.querySelector('body');
    
    // Chat bubble button
    const chatButton = document.createElement('div');
    chatButton.className = 'chat-bubble';
    chatButton.innerHTML = '<i class="fas fa-comments"></i>';
    chatButton.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 60px;
        height: 60px;
        background-color: #004AAD;
        color: white;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        z-index: 1000;
        font-size: 24px;
    `;
    
    // Chat container
    const chatContainer = document.createElement('div');
    chatContainer.className = 'chat-container';
    chatContainer.style.cssText = `
        position: fixed;
        bottom: 90px;
        right: 20px;
        width: 350px;
        height: 450px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        display: none;
        flex-direction: column;
        overflow: hidden;
        z-index: 1000;
        border: 1px solid #E8E8E8;
    `;
    
    // Chat header
    const chatHeader = document.createElement('div');
    chatHeader.className = 'chat-header';
    chatHeader.innerHTML = '<h4>HomeMedix Assistant</h4><span class="close-chat">&times;</span>';
    chatHeader.style.cssText = `
        background-color: #004AAD;
        color: white;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    `;
    chatHeader.querySelector('.close-chat').style.cssText = `
        cursor: pointer;
        font-size: 20px;
    `;
    
    // Chat messages area
    const chatMessages = document.createElement('div');
    chatMessages.className = 'chat-messages';
    chatMessages.style.cssText = `
        flex: 1;
        padding: 20px;
        overflow-y: auto;
    `;
    
    // Chat input area
    const chatInputArea = document.createElement('div');
    chatInputArea.className = 'chat-input-area';
    chatInputArea.style.cssText = `
        display: flex;
        padding: 10px;
        border-top: 1px solid #E8E8E8;
    `;
    
    // Chat input
    const chatInput = document.createElement('input');
    chatInput.className = 'chat-input';
    chatInput.type = 'text';
    chatInput.placeholder = 'Type your question here...';
    chatInput.style.cssText = `
        flex: 1;
        padding: 10px;
        border: 1px solid #E8E8E8;
        border-radius: 20px;
        margin-right: 10px;
    `;
    
    // Chat send button
    const chatSendButton = document.createElement('button');
    chatSendButton.className = 'chat-send-button';
    chatSendButton.innerHTML = '<i class="fas fa-paper-plane"></i>';
    chatSendButton.style.cssText = `
        background-color: #004AAD;
        color: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
    `;
    
    // Add elements to DOM
    chatInputArea.appendChild(chatInput);
    chatInputArea.appendChild(chatSendButton);
    
    chatContainer.appendChild(chatHeader);
    chatContainer.appendChild(chatMessages);
    chatContainer.appendChild(chatInputArea);
    
    body.appendChild(chatButton);
    body.appendChild(chatContainer);
    
    // Add event listeners
    chatButton.addEventListener('click', () => {
        chatContainer.style.display = 'flex';
        chatButton.style.display = 'none';
        // Welcome message
        setTimeout(() => {
            addBotMessage("Hello! I'm your HomeMedix virtual assistant. How can I help you today?");
            addBotMessage("You can ask me about our services, locations, or specific health concerns.");
        }, 500);
    });
    
    chatHeader.querySelector('.close-chat').addEventListener('click', () => {
        chatContainer.style.display = 'none';
        chatButton.style.display = 'flex';
    });
    
    // Function to fetch data from the API
    async function fetchData(type, query = '') {
        try {
            const url = query 
                ? `../backend/chatbot_api.php?action=${type}&query=${encodeURIComponent(query)}`
                : `../backend/chatbot_api.php?action=${type}`;
            const response = await fetch(url);
            const data = await response.json();
            if (data.status === 'success') {
                return data.data;
            }
            return null;
        } catch (error) {
            console.error('Error fetching data:', error);
            return null;
        }
    }

    // Function to format service response
    function formatServiceResponse(service) {
        if (!service) return 'I couldn\'t find information about that service.';
        
        let response = `Here's information about our ${service.name}:\n\n`;
        response += `${service.description}\n\n`;
        response += `Details:\n${service.details}\n\n`;
        response += `Duration: ${service.duration}\n`;
        response += `Price Range: ${service.price_range}\n\n`;
        response += 'Would you like to know more about any specific aspect of this service?';
        
        return response;
    }

    // Function to format illness response
    function formatIllnessResponse(illness) {
        if (!illness) return 'I couldn\'t find information about that condition.';
        
        let response = `Here's information about ${illness.name}:\n\n`;
        response += `${illness.description}\n\n`;
        response += `Symptoms:\n${illness.symptoms}\n\n`;
        response += `Treatment:\n${illness.treatment}\n\n`;
        response += `Prevention:\n${illness.prevention}\n\n`;
        response += `Related Services: ${illness.related_services}\n\n`;
        response += 'Would you like to know more about our treatment options for this condition?';
        
        return response;
    }

    // Function to get bot response based on user message
    async function getBotResponse(userMessage) {
        const messageLower = userMessage.toLowerCase();
        
        // Check for specific service queries
        if (messageLower.includes('physical therapy') || messageLower.includes('pt')) {
            const service = await fetchData('services', 'Physical Therapy');
            return formatServiceResponse(service);
        }
        
        if (messageLower.includes('caregiving') || messageLower.includes('caregiver')) {
            const service = await fetchData('services', 'Caregiving Services');
            return formatServiceResponse(service);
        }
        
        if (messageLower.includes('nursing home') || messageLower.includes('nursing')) {
            const service = await fetchData('services', 'Nursing Home');
            return formatServiceResponse(service);
        }

        // Check for specific illness queries
        if (messageLower.includes('back pain') || messageLower.includes('backache')) {
            const illness = await fetchData('illnesses', 'Back Pain');
            return formatIllnessResponse(illness);
        }
        
        if (messageLower.includes('stroke')) {
            const illness = await fetchData('illnesses', 'Stroke Recovery');
            return formatIllnessResponse(illness);
        }
        
        if (messageLower.includes('arthritis')) {
            const illness = await fetchData('illnesses', 'Arthritis');
            return formatIllnessResponse(illness);
        }

        // Check for general service queries
        if (messageLower.includes('service') || messageLower.includes('services')) {
            const services = await fetchData('services');
            if (services && services.length > 0) {
                let response = 'Here are our available services:\n\n';
                services.forEach(service => {
                    response += `- ${service.name}: ${service.description}\n`;
                });
                response += '\nWould you like to know more about any specific service?';
                return response;
            }
        }

        // Check for general illness queries
        if (messageLower.includes('illness') || messageLower.includes('condition') || 
            messageLower.includes('sick') || messageLower.includes('treatment')) {
            const illnesses = await fetchData('illnesses');
            if (illnesses && illnesses.length > 0) {
                let response = 'Here are some conditions we treat:\n\n';
                illnesses.forEach(illness => {
                    response += `- ${illness.name}: ${illness.description}\n`;
                });
                response += '\nWould you like to know more about any specific condition?';
                return response;
            }
        }

        // Check for predefined responses
        for (const keyword in responses) {
            if (messageLower.includes(keyword)) {
                return responses[keyword];
            }
        }
        
        return defaultResponse;
    }

    // Update the handleUserMessage function to be async
    const handleUserMessage = async () => {
        const userMessage = chatInput.value.trim();
        if (!userMessage) return;
        
        // Add user message to chat
        addUserMessage(userMessage);
        chatInput.value = '';
        
        // Process user message and get response
        setTimeout(async () => {
            const botResponse = await getBotResponse(userMessage);
            addBotMessage(botResponse);
        }, 500);
    };
    
    chatSendButton.addEventListener('click', handleUserMessage);
    chatInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            handleUserMessage();
        }
    });
    
    // Function to add user message to chat
    function addUserMessage(message) {
        const messageElement = document.createElement('div');
        messageElement.className = 'user-message';
        messageElement.textContent = message;
        messageElement.style.cssText = `
            align-self: flex-end;
            background-color: #004AAD;
            color: white;
            padding: 10px 15px;
            border-radius: 18px 18px 0 18px;
            margin: 5px 0;
            max-width: 80%;
            word-wrap: break-word;
        `;
        chatMessages.appendChild(messageElement);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    // Function to add bot message to chat
    function addBotMessage(message) {
        const messageElement = document.createElement('div');
        messageElement.className = 'bot-message';
        messageElement.textContent = message;
        messageElement.style.cssText = `
            align-self: flex-start;
            background-color: #F1F1F1;
            color: #333;
            padding: 10px 15px;
            border-radius: 18px 18px 18px 0;
            margin: 5px 0;
            max-width: 80%;
            word-wrap: break-word;
        `;
        chatMessages.appendChild(messageElement);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
}); 