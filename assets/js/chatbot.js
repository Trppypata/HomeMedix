<<<<<<< HEAD
document.addEventListener('DOMContentLoaded', function() {
    // Conversation memory to track context
    let conversationContext = {
        lastTopic: null,
        mentionedServices: [],
        userPreferences: {},
        appointmentInterest: false
    };
    
    // Predefined responses based on keywords
    const responses = {
        'hello': 'Hello! Welcome to HomeMedix. How can I help you today?',
        'hi': 'Hi there! Welcome to HomeMedix. How can I help you today?',
        'services': {
            message: 'HomeMedix offers three main services: Physical Therapy, Caregiving Services (8/12/24-hour shifts), and Nursing Home services. Which one would you like to know more about?',
            suggestions: ['Tell me about Physical Therapy', 'Tell me about Caregiving', 'Tell me about Nursing Home']
        },
        'physical therapy': {
            message: 'Our Physical Therapy services help patients regain mobility, reduce pain, and improve overall physical function. Our therapists are experts in rehabilitation for injuries, surgeries, and chronic conditions. We treat conditions like low back pain, stroke, spinal cord injury, frozen shoulder, osteoarthritis, and more.',
            suggestions: ['What conditions do you treat?', 'How much does physical therapy cost?', 'Do you do home visits?']
        },
        'caregiving': {
            message: 'Our Caregiving Services provide compassionate in-home care with options for 8-hour, 12-hour, or 24-hour shifts. Our caregivers assist with daily activities, medication reminders, and provide companionship.',
            suggestions: ['Tell me about 8-hour shifts', 'Tell me about 24-hour care', 'How are caregivers selected?']
        },
        'nursing home': {
            message: 'Our Nursing Home service provides 24/7 professional nursing care in a comfortable facility for patients who need continuous medical attention and assistance.',
            suggestions: ['What facilities do you have?', 'What is the cost?', 'Can I visit anytime?']
        },
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
        'about': 'HomeMedix is a healthcare provider specializing in Physical Therapy, Caregiving, and Nursing Home services. We\'ve been serving the Metro Manila area since 2015 with our mission to provide compassionate, high-quality care.',
        
        // Additional detailed service responses
        'low back pain': 'Our Physical Therapy service for Low Back Pain includes Hot Moist Pack therapy, which uses heat and moisture to relieve pain and relax muscles in the lower back. We also offer exercise programs, manual therapy, and education on proper posture and body mechanics.',
        'stroke': 'For stroke patients, we offer Proprioceptive Neuromuscular Facilitation (PNF) exercises that involve stretching and strengthening techniques to improve motor function and coordination. Our rehabilitation program is tailored to each patient\'s specific needs and recovery stage.',
        'spinal cord injury': 'Our spinal cord injury therapy includes bed mobility exercises designed to enhance movement and independence. We work closely with patients to improve strength, flexibility, and functional abilities while preventing complications.',
        'frozen shoulder': 'For frozen shoulder treatment, we use joint mobilization techniques that involve moving the shoulder joint in specific ways to improve range of motion and reduce stiffness. We complement this with targeted exercises and pain management strategies.',
        'deconditioning': 'Our therapy for deconditioning includes strengthening and endurance exercises aimed at rebuilding muscle strength and cardiovascular endurance following a period of inactivity. We create personalized programs that gradually increase intensity as your condition improves.',
        'pneumonia': 'For pneumonia recovery, we offer chest tapping and postural drainage techniques to clear mucus from the lungs. These respiratory therapies help improve breathing capacity and prevent complications.',
        'heart attack': 'After a myocardial infarction (heart attack), we provide carefully designed endurance exercises to improve cardiovascular health. Our cardiac rehabilitation program follows medical guidelines to ensure safe and effective recovery.',
        'myocardial infarction': 'Our cardiac rehabilitation for myocardial infarction patients includes low to moderate-intensity physical activities designed to improve cardiovascular health and endurance. We monitor vital signs throughout therapy sessions for safety.',
        'vascular': 'For peripheral vascular diseases, we offer ambulation (walking) exercises that promote circulation and improve blood flow. These exercises are designed to increase walking distance and reduce symptoms like pain and fatigue.',
        'peripheral vascular': 'Our therapy for peripheral vascular diseases includes walking exercises that promote circulation and improve blood flow. We also provide education on lifestyle modifications to improve vascular health.',
        'carpal tunnel': 'For Carpal Tunnel Syndrome, we use ultrasound and TENS (Transcutaneous Electrical Nerve Stimulation) therapy to alleviate pain and promote healing in the wrist. We also teach exercises to improve wrist flexibility and strength.',
        'osteoarthritis': 'Our osteoarthritis treatment includes Closed Kinematic Chain exercises, which are weight-bearing exercises that strengthen muscles around affected joints while minimizing stress. We also provide joint protection education and pain management strategies.',
        'arthritis': 'For arthritis, we offer a comprehensive approach including pain management, joint protection techniques, and specialized exercise programs. Our goal is to reduce pain and improve function in everyday activities.',
        
        // Detailed caregiving responses
        '8 hour': 'Our 8-hour caregiving shift provides personal care and assistance for a standard 8-hour period. This service is ideal for individuals who need help during the day or night with daily activities such as bathing, grooming, and meal preparation.',
        '8-hour': 'Our 8-hour caregiving shift provides personal care and assistance for a standard 8-hour period. This service is ideal for individuals who need help during the day or night with daily activities such as bathing, grooming, and meal preparation.',
        '12 hour': 'Our 12-hour caregiving shift offers extended support and care, ideal for individuals who need assistance for a longer duration. Caregivers work for 12 hours at a time, providing continuous monitoring and helping with more complex tasks.',
        '12-hour': 'Our 12-hour caregiving shift offers extended support and care, ideal for individuals who need assistance for a longer duration. Caregivers work for 12 hours at a time, providing continuous monitoring and helping with more complex tasks.',
        '24 hour': 'Our 24-hour caregiving service provides round-the-clock care for a full day. This comprehensive service ensures that individuals receive constant support, supervision, and assistance with all daily living activities. It\'s ideal for those requiring continuous care.',
        '24-hour': 'Our 24-hour caregiving service provides round-the-clock care for a full day. This comprehensive service ensures that individuals receive constant support, supervision, and assistance with all daily living activities. It\'s ideal for those requiring continuous care.',
        
        // Nursing home detailed response
        'nursing care': 'Our Nursing Care service includes licensed nurses providing comprehensive healthcare including assessment, planning, intervention, evaluation, and emotional support tailored to patients\' needs. We offer 24/7 professional supervision in a comfortable facility.',
        'nurse': 'Our nursing services are provided by licensed professionals who offer comprehensive healthcare including medication management, wound care, vital signs monitoring, and coordination with doctors. We provide both in-home nursing and facility-based nursing home care.',
        
        // Additional symptom/condition responses
        'diabetes': 'For patients with diabetes, we offer specialized care including monitoring blood sugar levels, medication management, wound care for diabetic foot conditions, and education on lifestyle modifications. Both our nursing and caregiving services can support diabetic patients.',
        'alzheimer': 'We provide specialized care for Alzheimer\'s patients through our caregiving and nursing home services. Our trained staff understands the unique challenges of dementia care and creates safe, supportive environments while providing cognitive stimulation activities.',
        'dementia': 'Our dementia care services include specialized caregiving and nursing support designed to maintain quality of life, ensure safety, and provide appropriate cognitive and social stimulation. We train our staff in the latest dementia care approaches.',
        'parkinson': 'For Parkinson\'s disease, we offer specialized physical therapy to improve mobility, balance, and coordination. Our caregivers are also trained to assist with the unique challenges Parkinson\'s patients face in daily activities.',
        'cancer': 'We provide supportive care for cancer patients through our caregiving and nursing services. This includes assistance during treatment recovery, pain management, nutritional support, and emotional care for both patients and families.',
        'rehabilitation': 'Our rehabilitation services are comprehensive and personalized, addressing physical, cognitive, and functional abilities. Whether recovering from surgery, injury, or illness, we develop targeted programs to help patients regain independence.',
        'covid': 'We offer specialized care for COVID-19 recovery, including respiratory therapy, strength rebuilding, and monitoring for long-term effects. Our staff follows strict infection control protocols to ensure safety.',
        'respiratory': 'Our respiratory care includes breathing exercises, chest physical therapy, and oxygen therapy monitoring. We work with patients who have COPD, asthma, pneumonia, and other respiratory conditions.',
        'wound care': 'We provide professional wound care services through our nursing team, including cleaning, dressing changes, infection prevention, and monitoring healing progress. This is available in both our in-home and facility-based care.',
        'mobility': 'Our mobility assistance services help patients who have difficulty walking or moving. We provide gait training, transfer assistance, and education on using mobility aids like walkers and wheelchairs.',
        'pain management': 'Our pain management approach combines physical therapy techniques, proper positioning, exercise, and coordination with medical professionals for medication management when necessary.',
        
        // Payment and logistics questions
        'payment': 'We accept various payment methods including cash, credit cards, bank transfers, and select insurance plans. For long-term care arrangements, we can discuss monthly payment plans.',
        'booking': 'Booking a service is simple! You can use our online appointment system on our website, call us directly at 0917 102 8250, or visit one of our locations in person.',
        'cancel': 'To cancel or reschedule an appointment, please contact us at least 24 hours in advance by phone or email. We understand that circumstances change and we\'re flexible with rescheduling.',
        'home visit': 'Yes, we offer home visits for all our physical therapy and caregiving services. Our professionals will come to your location with all necessary equipment to provide quality care in the comfort of your home.',
        'emergency': 'For medical emergencies, please call 911 immediately. For urgent but non-emergency situations related to our services, you can reach our 24/7 support line at 0917 102 8250.',
        'covid protocol': 'We follow strict COVID-19 safety protocols including regular staff testing, proper PPE usage, symptom screening, and adherence to DOH guidelines. The safety of our clients and staff is our top priority.'
    };
=======
// HomeMedix Chatbot
document.addEventListener('DOMContentLoaded', function () {
  // Predefined responses based on keywords
  const responses = {
    hello: 'Hello! Welcome to HomeMedix. How can I help you today?',
    hi: 'Hi there! Welcome to HomeMedix. How can I help you today?',
    services:
      'HomeMedix offers three main services: Physical Therapy, Caregiving Services (8/12/24-hour shifts), and Nursing Home services. Which one would you like to know more about?',
    'physical therapy':
      'Our Physical Therapy services help patients regain mobility, reduce pain, and improve overall physical function. Our therapists are experts in rehabilitation for injuries, surgeries, and chronic conditions. We treat conditions like low back pain, stroke, spinal cord injury, frozen shoulder, osteoarthritis, and more.',
    caregiving:
      'Our Caregiving Services provide compassionate in-home care with options for 8-hour, 12-hour, or 24-hour shifts. Our caregivers assist with daily activities, medication reminders, and provide companionship.',
    'nursing home':
      'Our Nursing Home service provides 24/7 professional nursing care in a comfortable facility for patients who need continuous medical attention and assistance.',
    headache:
      "Headaches can have many causes including stress, dehydration, or underlying medical conditions. If you're experiencing persistent headaches, our Physical Therapy services might help. Would you like to schedule a consultation?",
    'back pain':
      'Back pain is a common condition that our Physical Therapists specialize in treating. We offer personalized treatment plans that include exercises, manual therapy, and education to reduce pain and improve function.',
    'elderly care':
      'For elderly care, we offer both Caregiving Services for in-home support and Nursing Home options for 24/7 professional care. The best choice depends on the level of medical attention needed.',
    appointment:
      'You can book an appointment through our website by visiting the Appointment page or by calling our office. Would you like the direct link to our online booking system?',
    location:
      'HomeMedix has three locations in Metro Manila: 124 A. Flores St, Marikina; 28 6th St, Marikina; and 24 Sampaguita St, Marikina.',
    contact:
      'You can reach us at 0917 102 8250 or email us at HomeMedix.ptcaregiving@gmail.com. Our office hours are Monday-Saturday, 8am-5pm.',
    price:
      'Our service prices vary depending on the type of care and duration. For a detailed quote, please contact us directly or schedule a free initial consultation.',
    insurance:
      'HomeMedix works with several HMO providers including Amaphil, Sunlife Grepa, and WellCare. Please contact us to verify if your specific insurance is accepted.',
    hours:
      'Our services are available 24/7. Office hours for inquiries are Monday-Saturday, 8am-5pm.',
    therapist:
      'All our physical therapists are licensed professionals with degrees in Physical Therapy and special training in various rehabilitation techniques.',
    caregiver:
      'Our caregivers are trained professionals who undergo background checks and receive ongoing education in patient care, safety protocols, and emergency response.',
    recovery:
      'Recovery time varies based on your condition, overall health, and adherence to treatment plans. During your initial assessment, your healthcare provider will discuss expected recovery timelines.',
    help: 'I can provide information about our services, answer questions about symptoms, help with appointments, or tell you more about HomeMedix. What would you like to know?',
    about:
      "HomeMedix is a healthcare provider specializing in Physical Therapy, Caregiving, and Nursing Home services. We've been serving the Metro Manila area since 2015 with our mission to provide compassionate, high-quality care.",
>>>>>>> 2a0035b6943126ad6f34d108f74d430631f68ff7

    // Additional detailed service responses
    'low back pain':
      'Our Physical Therapy service for Low Back Pain includes Hot Moist Pack therapy, which uses heat and moisture to relieve pain and relax muscles in the lower back. We also offer exercise programs, manual therapy, and education on proper posture and body mechanics.',
    stroke:
      "For stroke patients, we offer Proprioceptive Neuromuscular Facilitation (PNF) exercises that involve stretching and strengthening techniques to improve motor function and coordination. Our rehabilitation program is tailored to each patient's specific needs and recovery stage.",
    'spinal cord injury':
      'Our spinal cord injury therapy includes bed mobility exercises designed to enhance movement and independence. We work closely with patients to improve strength, flexibility, and functional abilities while preventing complications.',
    'frozen shoulder':
      'For frozen shoulder treatment, we use joint mobilization techniques that involve moving the shoulder joint in specific ways to improve range of motion and reduce stiffness. We complement this with targeted exercises and pain management strategies.',
    deconditioning:
      'Our therapy for deconditioning includes strengthening and endurance exercises aimed at rebuilding muscle strength and cardiovascular endurance following a period of inactivity. We create personalized programs that gradually increase intensity as your condition improves.',
    pneumonia:
      'For pneumonia recovery, we offer chest tapping and postural drainage techniques to clear mucus from the lungs. These respiratory therapies help improve breathing capacity and prevent complications.',
    'heart attack':
      'After a myocardial infarction (heart attack), we provide carefully designed endurance exercises to improve cardiovascular health. Our cardiac rehabilitation program follows medical guidelines to ensure safe and effective recovery.',
    'myocardial infarction':
      'Our cardiac rehabilitation for myocardial infarction patients includes low to moderate-intensity physical activities designed to improve cardiovascular health and endurance. We monitor vital signs throughout therapy sessions for safety.',
    vascular:
      'For peripheral vascular diseases, we offer ambulation (walking) exercises that promote circulation and improve blood flow. These exercises are designed to increase walking distance and reduce symptoms like pain and fatigue.',
    'peripheral vascular':
      'Our therapy for peripheral vascular diseases includes walking exercises that promote circulation and improve blood flow. We also provide education on lifestyle modifications to improve vascular health.',
    'carpal tunnel':
      'For Carpal Tunnel Syndrome, we use ultrasound and TENS (Transcutaneous Electrical Nerve Stimulation) therapy to alleviate pain and promote healing in the wrist. We also teach exercises to improve wrist flexibility and strength.',
    osteoarthritis:
      'Our osteoarthritis treatment includes Closed Kinematic Chain exercises, which are weight-bearing exercises that strengthen muscles around affected joints while minimizing stress. We also provide joint protection education and pain management strategies.',
    arthritis:
      'For arthritis, we offer a comprehensive approach including pain management, joint protection techniques, and specialized exercise programs. Our goal is to reduce pain and improve function in everyday activities.',

    // Detailed caregiving responses
    '8 hour':
      'Our 8-hour caregiving shift provides personal care and assistance for a standard 8-hour period. This service is ideal for individuals who need help during the day or night with daily activities such as bathing, grooming, and meal preparation.',
    '8-hour':
      'Our 8-hour caregiving shift provides personal care and assistance for a standard 8-hour period. This service is ideal for individuals who need help during the day or night with daily activities such as bathing, grooming, and meal preparation.',
    '12 hour':
      'Our 12-hour caregiving shift offers extended support and care, ideal for individuals who need assistance for a longer duration. Caregivers work for 12 hours at a time, providing continuous monitoring and helping with more complex tasks.',
    '12-hour':
      'Our 12-hour caregiving shift offers extended support and care, ideal for individuals who need assistance for a longer duration. Caregivers work for 12 hours at a time, providing continuous monitoring and helping with more complex tasks.',
    '24 hour':
      "Our 24-hour caregiving service provides round-the-clock care for a full day. This comprehensive service ensures that individuals receive constant support, supervision, and assistance with all daily living activities. It's ideal for those requiring continuous care.",
    '24-hour':
      "Our 24-hour caregiving service provides round-the-clock care for a full day. This comprehensive service ensures that individuals receive constant support, supervision, and assistance with all daily living activities. It's ideal for those requiring continuous care.",

    // Nursing home detailed response
    'nursing care':
      "Our Nursing Care service includes licensed nurses providing comprehensive healthcare including assessment, planning, intervention, evaluation, and emotional support tailored to patients' needs. We offer 24/7 professional supervision in a comfortable facility.",
    nurse:
      'Our nursing services are provided by licensed professionals who offer comprehensive healthcare including medication management, wound care, vital signs monitoring, and coordination with doctors. We provide both in-home nursing and facility-based nursing home care.',

    // Additional symptom/condition responses
    diabetes:
      'For patients with diabetes, we offer specialized care including monitoring blood sugar levels, medication management, wound care for diabetic foot conditions, and education on lifestyle modifications. Both our nursing and caregiving services can support diabetic patients.',
    alzheimer:
      "We provide specialized care for Alzheimer's patients through our caregiving and nursing home services. Our trained staff understands the unique challenges of dementia care and creates safe, supportive environments while providing cognitive stimulation activities.",
    dementia:
      'Our dementia care services include specialized caregiving and nursing support designed to maintain quality of life, ensure safety, and provide appropriate cognitive and social stimulation. We train our staff in the latest dementia care approaches.',
    parkinson:
      "For Parkinson's disease, we offer specialized physical therapy to improve mobility, balance, and coordination. Our caregivers are also trained to assist with the unique challenges Parkinson's patients face in daily activities.",
    cancer:
      'We provide supportive care for cancer patients through our caregiving and nursing services. This includes assistance during treatment recovery, pain management, nutritional support, and emotional care for both patients and families.',
    rehabilitation:
      'Our rehabilitation services are comprehensive and personalized, addressing physical, cognitive, and functional abilities. Whether recovering from surgery, injury, or illness, we develop targeted programs to help patients regain independence.',
    covid:
      'We offer specialized care for COVID-19 recovery, including respiratory therapy, strength rebuilding, and monitoring for long-term effects. Our staff follows strict infection control protocols to ensure safety.',
    respiratory:
      'Our respiratory care includes breathing exercises, chest physical therapy, and oxygen therapy monitoring. We work with patients who have COPD, asthma, pneumonia, and other respiratory conditions.',
    'wound care':
      'We provide professional wound care services through our nursing team, including cleaning, dressing changes, infection prevention, and monitoring healing progress. This is available in both our in-home and facility-based care.',
    mobility:
      'Our mobility assistance services help patients who have difficulty walking or moving. We provide gait training, transfer assistance, and education on using mobility aids like walkers and wheelchairs.',
    'pain management':
      'Our pain management approach combines physical therapy techniques, proper positioning, exercise, and coordination with medical professionals for medication management when necessary.',

    // Payment and logistics questions
    payment:
      'We accept various payment methods including cash, credit cards, bank transfers, and select insurance plans. For long-term care arrangements, we can discuss monthly payment plans.',
    booking:
      'Booking a service is simple! You can use our online appointment system on our website, call us directly at 0917 102 8250, or visit one of our locations in person.',
    cancel:
      'To cancel or reschedule an appointment, please contact us at least 24 hours in advance by phone or email. We understand that circumstances change and were flexible with rescheduling.',
    'home visit':
      'Yes, we offer home visits for all our physical therapy and caregiving services. Our professionals will come to your location with all necessary equipment to provide quality care in the comfort of your home.',
    emergency:
      'For medical emergencies, please call 911 immediately. For urgent but non-emergency situations related to our services, you can reach our 24/7 support line at 0917 102 8250.',
    'covid protocol':
      'We follow strict COVID-19 safety protocols including regular staff testing, proper PPE usage, symptom screening, and adherence to DOH guidelines. The safety of our clients and staff is our top priority.',
  };

  // Default response for unrecognized queries
  const defaultResponse =
    "I'm not sure I understand. Could you please rephrase your question? Or ask about our services, locations, appointments, or specific health concerns.";

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
  chatHeader.innerHTML =
    '<h4>HomeMedix Assistant</h4><span class="close-chat">&times;</span>';
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
<<<<<<< HEAD
    
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
            addSuggestedQuestions([
                "What services do you offer?",
                "How much does physical therapy cost?",
                "Where are your locations?",
                "How do I book an appointment?"
            ]);
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
=======

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
      addBotMessage(
        "Hello! I'm your HomeMedix virtual assistant. How can I help you today?"
      );
      addBotMessage(
        'You can ask me about our services, locations, or specific health concerns.'
      );
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
        ? `../backend/chatbot_api.php?action=${type}&query=${encodeURIComponent(
            query
          )}`
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
    if (!service) return "I couldn't find information about that service.";

    let response = `Here's information about our ${service.name}:\n\n`;
    response += `${service.description}\n\n`;
    response += `Details:\n${service.details}\n\n`;
    response += `Duration: ${service.duration}\n`;
    response += `Price Range: ${service.price_range}\n\n`;
    response +=
      'Would you like to know more about any specific aspect of this service?';

    return response;
  }

  // Function to format illness response
  function formatIllnessResponse(illness) {
    if (!illness) return "I couldn't find information about that condition.";

    let response = `Here's information about ${illness.name}:\n\n`;
    response += `${illness.description}\n\n`;
    response += `Symptoms:\n${illness.symptoms}\n\n`;
    response += `Treatment:\n${illness.treatment}\n\n`;
    response += `Prevention:\n${illness.prevention}\n\n`;
    response += `Related Services: ${illness.related_services}\n\n`;
    response +=
      'Would you like to know more about our treatment options for this condition?';

    return response;
  }

  // Function to get bot response based on user message
  async function getBotResponse(userMessage) {
    const messageLower = userMessage.toLowerCase();

    // Check for specific service queries
    if (
      messageLower.includes('physical therapy') ||
      messageLower.includes('pt')
    ) {
      const service = await fetchData('services', 'Physical Therapy');
      return formatServiceResponse(service);
>>>>>>> 2a0035b6943126ad6f34d108f74d430631f68ff7
    }

    if (
      messageLower.includes('caregiving') ||
      messageLower.includes('caregiver')
    ) {
      const service = await fetchData('services', 'Caregiving Services');
      return formatServiceResponse(service);
    }

    if (
      messageLower.includes('nursing home') ||
      messageLower.includes('nursing')
    ) {
      const service = await fetchData('services', 'Nursing Home');
      return formatServiceResponse(service);
    }

    // Check for specific illness queries
    if (
      messageLower.includes('back pain') ||
      messageLower.includes('backache')
    ) {
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
        services.forEach((service) => {
          response += `- ${service.name}: ${service.description}\n`;
        });
        response += '\nWould you like to know more about any specific service?';
        return response;
      }
    }

    // Check for general illness queries
    if (
      messageLower.includes('illness') ||
      messageLower.includes('condition') ||
      messageLower.includes('sick') ||
      messageLower.includes('treatment')
    ) {
      const illnesses = await fetchData('illnesses');
      if (illnesses && illnesses.length > 0) {
        let response = 'Here are some conditions we treat:\n\n';
        illnesses.forEach((illness) => {
          response += `- ${illness.name}: ${illness.description}\n`;
        });
        response +=
          '\nWould you like to know more about any specific condition?';
        return response;
      }
    }

<<<<<<< HEAD
    // Function to get bot response based on user message
    async function getBotResponse(userMessage) {
        const messageLower = userMessage.toLowerCase().trim();
        
        // Helper function to check if any keywords are in the message
        function containsAny(message, keywords) {
            return keywords.some(keyword => message.includes(keyword));
        }
        
        // Check for specific service queries
        if (containsAny(messageLower, ['physical therapy', 'pt', 'physiotherapy', 'physical therapist'])) {
            const service = await fetchData('services', 'Physical Therapy');
            return formatServiceResponse(service);
        }
        
        if (containsAny(messageLower, ['caregiving', 'caregiver', 'care giver', 'home care'])) {
            const service = await fetchData('services', 'Caregiving Services');
            return formatServiceResponse(service);
        }
        
        if (containsAny(messageLower, ['nursing home', 'nursing', 'nurse', 'nursing care'])) {
            const service = await fetchData('services', 'Nursing Home');
            return formatServiceResponse(service);
        }

        // Check for specific illness queries
        if (containsAny(messageLower, ['back pain', 'backache', 'lower back', 'lumbar pain'])) {
            const illness = await fetchData('illnesses', 'Back Pain');
            return formatIllnessResponse(illness);
        }
        
        if (containsAny(messageLower, ['stroke', 'brain attack', 'cerebrovascular'])) {
            const illness = await fetchData('illnesses', 'Stroke Recovery');
            return formatIllnessResponse(illness);
        }
        
        if (containsAny(messageLower, ['arthritis', 'joint pain', 'rheumatism', 'joint inflammation'])) {
            const illness = await fetchData('illnesses', 'Arthritis');
            return formatIllnessResponse(illness);
        }
        
        if (containsAny(messageLower, ['frozen shoulder', 'adhesive capsulitis', 'shoulder pain', 'shoulder stiffness'])) {
            return responses['frozen shoulder'];
        }
        
        if (containsAny(messageLower, ['spinal cord injury', 'spinal injury', 'spine trauma', 'spinal damage'])) {
            return responses['spinal cord injury'];
        }
        
        if (containsAny(messageLower, ['deconditioning', 'weak muscles', 'muscle loss', 'weakness after illness'])) {
            return responses['deconditioning'];
        }
        
        if (containsAny(messageLower, ['pneumonia', 'lung infection', 'chest infection'])) {
            return responses['pneumonia'];
        }
        
        if (containsAny(messageLower, ['heart attack', 'myocardial infarction', 'cardiac', 'heart problem'])) {
            return responses['myocardial infarction'];
        }
        
        if (containsAny(messageLower, ['peripheral vascular', 'vascular disease', 'poor circulation', 'blood vessel disease'])) {
            return responses['peripheral vascular'];
        }
        
        if (containsAny(messageLower, ['carpal tunnel', 'wrist pain', 'hand numbness', 'median nerve'])) {
            return responses['carpal tunnel'];
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

    // Function to add user message to chat
    function addUserMessage(message) {
        const messageElement = document.createElement('div');
        messageElement.className = 'user-message';
        messageElement.textContent = message;
        messageElement.style.cssText = `
=======
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
>>>>>>> 2a0035b6943126ad6f34d108f74d430631f68ff7
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
<<<<<<< HEAD
        chatMessages.appendChild(messageElement);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    // Function to show typing indicator
    function showTypingIndicator() {
        const typingIndicator = document.createElement('div');
        typingIndicator.className = 'typing-indicator';
        typingIndicator.innerHTML = '<span></span><span></span><span></span>';
        typingIndicator.style.cssText = `
            align-self: flex-start;
            background-color: #E1E1E1;
            padding: 12px 20px;
            border-radius: 18px 18px 18px 0;
            margin: 5px 0;
            width: 50px;
            display: flex;
            justify-content: center;
        `;
        
        typingIndicator.querySelector('span:nth-child(1)').style.cssText = `
            background-color: #666;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            margin: 0 2px;
            animation: typing 1.3s infinite ease-in-out;
            animation-delay: 0s;
        `;
        
        typingIndicator.querySelector('span:nth-child(2)').style.cssText = `
            background-color: #666;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            margin: 0 2px;
            animation: typing 1.3s infinite ease-in-out;
            animation-delay: 0.2s;
        `;
        
        typingIndicator.querySelector('span:nth-child(3)').style.cssText = `
            background-color: #666;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            margin: 0 2px;
            animation: typing 1.3s infinite ease-in-out;
            animation-delay: 0.4s;
        `;
        
        const style = document.createElement('style');
        style.textContent = `
            @keyframes typing {
                0% { transform: translateY(0px); }
                25% { transform: translateY(-4px); }
                50% { transform: translateY(0px); }
            }
        `;
        document.head.appendChild(style);
        
        chatMessages.appendChild(typingIndicator);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        
        return typingIndicator;
    }
    
    // Function to remove typing indicator
    function removeTypingIndicator(indicator) {
        if (indicator && indicator.parentNode) {
            indicator.parentNode.removeChild(indicator);
        }
    }
    
    // Function to add suggested questions for the user
    function addSuggestedQuestions(questions) {
        const suggestionsContainer = document.createElement('div');
        suggestionsContainer.className = 'suggestions-container';
        suggestionsContainer.style.cssText = `
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 10px 0;
            width: 100%;
        `;
        
        questions.forEach(question => {
            const suggestionButton = document.createElement('button');
            suggestionButton.className = 'suggestion-btn';
            suggestionButton.textContent = question;
            suggestionButton.style.cssText = `
                background-color: #e6f0ff;
                color: #004AAD;
                border: 1px solid #004AAD;
                border-radius: 16px;
                padding: 6px 12px;
                font-size: 12px;
                cursor: pointer;
                transition: all 0.2s ease;
            `;
            
            suggestionButton.addEventListener('mouseenter', () => {
                suggestionButton.style.backgroundColor = '#004AAD';
                suggestionButton.style.color = 'white';
            });
            
            suggestionButton.addEventListener('mouseleave', () => {
                suggestionButton.style.backgroundColor = '#e6f0ff';
                suggestionButton.style.color = '#004AAD';
            });
            
            suggestionButton.addEventListener('click', () => {
                chatInput.value = question;
                handleUserMessage();
            });
            
            suggestionsContainer.appendChild(suggestionButton);
        });
        
        chatMessages.appendChild(suggestionsContainer);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    // Function to update conversation context
    function updateConversationContext(userMessage) {
        const messageLower = userMessage.toLowerCase();
        
        // Track the last topic discussed
        if (messageLower.includes('physical therapy') || messageLower.includes('pt')) {
            conversationContext.lastTopic = 'physical therapy';
            if (!conversationContext.mentionedServices.includes('physical therapy')) {
                conversationContext.mentionedServices.push('physical therapy');
            }
        } else if (messageLower.includes('caregiving') || messageLower.includes('caregiver')) {
            conversationContext.lastTopic = 'caregiving';
            if (!conversationContext.mentionedServices.includes('caregiving')) {
                conversationContext.mentionedServices.push('caregiving');
            }
        } else if (messageLower.includes('nursing home') || messageLower.includes('nursing')) {
            conversationContext.lastTopic = 'nursing home';
            if (!conversationContext.mentionedServices.includes('nursing home')) {
                conversationContext.mentionedServices.push('nursing home');
            }
        }
        
        // Track appointment interest
        if (messageLower.includes('appointment') || messageLower.includes('book') || 
            messageLower.includes('schedule') || messageLower.includes('visit')) {
            conversationContext.appointmentInterest = true;
        }
        
        // Track other user preferences
        if (messageLower.includes('home visit') || messageLower.includes('at home')) {
            conversationContext.userPreferences.homeVisit = true;
        }
        
        if (messageLower.includes('urgent') || messageLower.includes('emergency') || 
            messageLower.includes('as soon as possible')) {
            conversationContext.userPreferences.urgent = true;
        }
    }
    
    // Update the handleUserMessage function to be async
    const handleUserMessage = async () => {
        const userMessage = chatInput.value.trim();
        if (!userMessage) return;
        
        // Add user message to chat
        addUserMessage(userMessage);
        chatInput.value = '';
        
        // Update conversation context
        updateConversationContext(userMessage);
        
        // Show typing indicator
        const typingIndicator = showTypingIndicator();
        
        // Process user message and get response with a realistic delay
        setTimeout(async () => {
            // Remove typing indicator
            removeTypingIndicator(typingIndicator);
            
            const response = await getBotResponse(userMessage);
            
            // If response is an object with message and suggestions
            if (typeof response === 'object' && response.message) {
                addBotMessage(response.message);
                if (response.suggestions) {
                    setTimeout(() => {
                        addSuggestedQuestions(response.suggestions);
                    }, 300);
                }
            } else {
                // If response is just a string
                addBotMessage(response);
                
                // Add contextual suggestions based on the conversation context
                if (conversationContext.lastTopic === 'physical therapy') {
                    setTimeout(() => {
                        addSuggestedQuestions([
                            "What conditions do you treat?",
                            "How much does PT cost?",
                            "Do you offer home PT visits?"
                        ]);
                    }, 300);
                } else if (conversationContext.lastTopic === 'caregiving') {
                    setTimeout(() => {
                        addSuggestedQuestions([
                            "What are your caregiving hours?", 
                            "What's included in caregiving service?",
                            "How much is 24-hour care?"
                        ]);
                    }, 300);
                } else if (conversationContext.appointmentInterest) {
                    setTimeout(() => {
                        addSuggestedQuestions([
                            "How do I book an appointment?",
                            "What information do I need for booking?",
                            "Can I reschedule if needed?"
                        ]);
                    }, 300);
                }
            }
        }, 1000 + Math.random() * 1000); // Random delay between 1-2 seconds for realism
    };
    
    chatSendButton.addEventListener('click', handleUserMessage);
    chatInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            handleUserMessage();
        }
    });
}); 
=======
    chatMessages.appendChild(messageElement);
    chatMessages.scrollTop = chatMessages.scrollHeight;
  }
});
>>>>>>> 2a0035b6943126ad6f34d108f74d430631f68ff7
