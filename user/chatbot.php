<!-- PHP Chatbot UI -->
<div class="chat-bubble" id="chat-bubble">
    <i class="fas fa-comments"></i>
</div>

<div class="chat-container" id="chat-container">
    <div class="chat-header">
        <h4>HomeMedix Assistant</h4>
        <span class="close-chat">&times;</span>
    </div>
    
    <div class="chat-messages" id="chat-messages">
        <!-- Messages will be inserted here dynamically -->
    </div>
    
    <div class="suggested-questions" id="suggested-questions">
        <!-- Suggested questions will be inserted here dynamically -->
    </div>
    
    <div class="chat-input-area">
        <input type="text" id="chat-input" class="chat-input" placeholder="Type your question here...">
        <button id="chat-send-button" class="chat-send-button">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>
</div>

<style>
.chat-bubble {
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
}

.chat-container {
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
}

.chat-header {
    background-color: #004AAD;
    color: white;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.close-chat {
    cursor: pointer;
    font-size: 20px;
}

.chat-messages {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
}

.suggested-questions {
    padding: 10px;
    border-top: 1px solid #e8e8e8;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.suggested-question {
    background-color: #f0f4ff;
    border: 1px solid #d0d8ff;
    border-radius: 15px;
    padding: 5px 12px;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s;
}

.suggested-question:hover {
    background-color: #d0d8ff;
}

.chat-input-area {
    display: flex;
    padding: 10px;
    border-top: 1px solid #E8E8E8;
}

.chat-input {
    flex: 1;
    padding: 10px;
    border: 1px solid #E8E8E8;
    border-radius: 20px;
    margin-right: 10px;
}

.chat-send-button {
    background-color: #004AAD;
    color: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
}

.message {
    max-width: 70%;
    margin-bottom: 10px;
    padding: 10px 15px;
    border-radius: 15px;
    line-height: 1.4;
}

.user-message {
    background-color: #004AAD;
    color: white;
    margin-left: auto;
    border-top-right-radius: 0;
}

.bot-message {
    background-color: #F0F0F0;
    color: #333;
    margin-right: auto;
    border-top-left-radius: 0;
}

.typing-indicator {
    display: flex;
    padding: 10px 15px;
    background-color: #F0F0F0;
    border-radius: 15px;
    width: fit-content;
    margin-bottom: 10px;
}

.typing-dot {
    width: 8px;
    height: 8px;
    background-color: #888;
    border-radius: 50%;
    margin: 0 2px;
    animation: typing 1.5s infinite ease-in-out;
}

.typing-dot:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-dot:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes typing {
    0%, 60%, 100% {
        transform: translateY(0);
        opacity: 0.6;
    }
    30% {
        transform: translateY(-5px);
        opacity: 1;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatBubble = document.getElementById('chat-bubble');
    const chatContainer = document.getElementById('chat-container');
    const closeChat = document.querySelector('.close-chat');
    const chatMessages = document.getElementById('chat-messages');
    const chatInput = document.getElementById('chat-input');
    const chatSendButton = document.getElementById('chat-send-button');
    const suggestedQuestionsContainer = document.getElementById('suggested-questions');
    
    // Open chat
    chatBubble.addEventListener('click', function() {
        chatContainer.style.display = 'flex';
        chatBubble.style.display = 'none';
        
        // Initialize chat
        fetch('https://homemedix.free.nf/backend/chatbot.php?action=init')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Check if we already have messages
                    if (chatMessages.childNodes.length === 0) {
                        addBotMessage(data.welcome);
                        addBotMessage(data.followup);
                        
                        // Add suggested questions
                        if (data.suggestions && data.suggestions.length > 0) {
                            showSuggestedQuestions(data.suggestions);
                        }
                    }
                }
            })
            .catch(error => console.error('Error initializing chat:', error));
    });
    
    // Close chat
    closeChat.addEventListener('click', function() {
        chatContainer.style.display = 'none';
        chatBubble.style.display = 'flex';
    });
    
    // Send message on button click
    chatSendButton.addEventListener('click', sendMessage);
    
    // Send message on Enter key
    chatInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
    
    // Send a message to the chatbot
    function sendMessage() {
        const message = chatInput.value.trim();
        
        if (message !== '') {
            // Add user message to chat
            addUserMessage(message);
            
            // Clear input
            chatInput.value = '';
            
            // Show typing indicator
            const typingIndicator = showTypingIndicator();
            
            // Send message to server
            const formData = new FormData();
            formData.append('message', message);
            
            fetch('https://homemedix.free.nf/backend/chatbot.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Remove typing indicator
                removeTypingIndicator(typingIndicator);
                
                if (data.status === 'success') {
                    // Add bot response
                    addBotMessage(data.response);
                    
                    // Show suggested questions if any
                    if (data.suggestions && data.suggestions.length > 0) {
                        showSuggestedQuestions(data.suggestions);
                    }
                } else {
                    addBotMessage("Sorry, I'm having trouble processing your request right now. Please try again later.");
                }
            })
            .catch(error => {
                console.error('Error sending message:', error);
                removeTypingIndicator(typingIndicator);
                addBotMessage("Sorry, there was an error communicating with the server. Please try again later.");
            });
        }
    }
    
    // Add a user message to the chat
    function addUserMessage(text) {
        const messageElement = document.createElement('div');
        messageElement.className = 'message user-message';
        messageElement.textContent = text;
        
        chatMessages.appendChild(messageElement);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    // Add a bot message to the chat
    function addBotMessage(text) {
        const messageElement = document.createElement('div');
        messageElement.className = 'message bot-message';
        
        // Handle line breaks in the text
        const formattedText = text.replace(/\n\n/g, '<br><br>').replace(/\n/g, '<br>');
        messageElement.innerHTML = formattedText;
        
        chatMessages.appendChild(messageElement);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    // Show typing indicator
    function showTypingIndicator() {
        const indicator = document.createElement('div');
        indicator.className = 'typing-indicator';
        
        for (let i = 0; i < 3; i++) {
            const dot = document.createElement('div');
            dot.className = 'typing-dot';
            indicator.appendChild(dot);
        }
        
        chatMessages.appendChild(indicator);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        
        return indicator;
    }
    
    // Remove typing indicator
    function removeTypingIndicator(indicator) {
        if (indicator && indicator.parentNode) {
            indicator.parentNode.removeChild(indicator);
        }
    }
    
    // Show suggested questions
    function showSuggestedQuestions(questions) {
        // Clear previous suggestions
        suggestedQuestionsContainer.innerHTML = '';
        
        questions.forEach(question => {
            const suggestionElement = document.createElement('div');
            suggestionElement.className = 'suggested-question';
            suggestionElement.textContent = question;
            
            suggestionElement.addEventListener('click', function() {
                chatInput.value = question;
                sendMessage();
            });
            
            suggestedQuestionsContainer.appendChild(suggestionElement);
        });
    }
    
    // Load chat history
    function loadChatHistory() {
        fetch('https://homemedix.free.nf/backend/chatbot.php?action=history')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success' && data.history && data.history.length > 0) {
                    // Clear chat messages
                    chatMessages.innerHTML = '';
                    
                    // Add each message to the chat
                    data.history.forEach(item => {
                        if (item.sender === 'user') {
                            addUserMessage(item.message);
                        } else {
                            addBotMessage(item.message);
                        }
                    });
                }
            })
            .catch(error => console.error('Error loading chat history:', error));
    }
    
    // Call loadChatHistory if there's an existing session
    loadChatHistory();
});
</script> 