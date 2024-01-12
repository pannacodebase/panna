function sendMessage() {
    // Get user input
    const userInput = document.getElementById('userInput').value;

    // Display user message
    displayMessage('user', userInput);

    // Perform PHP request and display bot response
    fetch('get_response.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'userInput=' + encodeURIComponent(userInput),
    })
        .then(response => response.text())
        .then(data => {
            console.log('API Response:', data);
            extractLastText(data); // Call the function to extract and display the last text
        });
}
function handleKeyPress(event) {
    // Check if the key pressed is Enter (key code 13)
    if (event.keyCode === 13) {
        sendMessage();
    }
}
// function for extract
function extractLastText(response) {
    try {
        // Convert the response to a string and replace occurrences
        const responseString = response.toString().replace(/\\\\/g, '"').replace(/\\n/g, '<br>');

        // Find the last occurrence of "stream-end"
        const lastIndex = responseString.lastIndexOf('"stream-end"');

        // Check if "stream-end" is found
        if (lastIndex !== -1) {
            // Extract the substring starting from the last occurrence of "stream-end"
            const jsonString = responseString.substring(lastIndex);

            // Extract the content between "text" and "generation_id"
            const match = jsonString.match(/"text":"(.*?)","generation_id"/);

            // Check if the "text" content is found
            if (match && match[1]) {
                // Call the function to display the message with headings and cards
                displayMessageWithHeadingsAndCards(match[1]);
                return; // Exit the function
            }
        }

        // If "stream-end" or "text" is not found, log an error
        console.error('Event type "stream-end" or "text" not found');
    } catch (error) {
        console.error('Error processing response:', error);
    }
}

function displayMessageWithHeadingsAndCards(botAnswer) {
    // Display bot's answer
    displayMessage('bot', botAnswer);

    // Call the function to display the card panel
    displayCardPanel();
}

function displayMessage(sender, message) {
    const chatContainer = document.getElementById('chat');
    const messageContainer = document.createElement('div');
    messageContainer.classList.add('message-container');

    const messageElement = document.createElement('div');
    messageElement.classList.add(sender === 'user' ? 'user-message' : 'bot-message');

    // Use innerHTML to parse HTML tags and display line breaks
    messageElement.innerHTML = message.replace(/\\n/g, '<br>').replace(/\\"(.*?)\\"/g, (_, group) => `<b>${group}</b>`);

    messageContainer.appendChild(messageElement);
    chatContainer.appendChild(messageContainer);

    // Scroll to the bottom of the chat
    chatContainer.scrollTop = chatContainer.scrollHeight;
    window.scrollTo(0, document.body.scrollHeight);

}

function displayCardPanel() {
    const chatContainer = document.getElementById('chat');
    const cardPanelContainer = document.createElement('div');
    cardPanelContainer.classList.add('card-panel-container');

    // Generate 10 dummy cards
    for (let i = 1; i <= 10; i++) {
        const card = document.createElement('div');
        card.classList.add('card');
        card.innerHTML = `Card ${i} Content`;

        cardPanelContainer.appendChild(card);
    }

    // Append the card panel to the chat container
    chatContainer.appendChild(cardPanelContainer);

    // Scroll to the bottom of the chat
    chatContainer.scrollTop = chatContainer.scrollHeight;
}
