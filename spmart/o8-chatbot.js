

(
    function() 
{
    
    // Create and append the necessary HTML elements
    const createElement = (tag, attributes, parent) => {
        const element = document.createElement(tag);
        for (let key in attributes) {
            element.setAttribute(key, attributes[key]);
        }
        if (parent) {
            parent.appendChild(element);
        }
        return element;
    };

    // Create the chat button
    const chatButton = createElement('button', { class: 'chat-button', id: 'openChatButton' }, document.body);
    chatButton.innerText = 'Chat';

    // Create the modal for the form
    const chatModal = createElement('div', { id: 'chatModal', class: 'modal' }, document.body);
    const modalContent = createElement('div', { class: 'modal-content' }, chatModal);
    const closeModal = createElement('span', { class: 'close', id: 'closeChatModal' }, modalContent);
    closeModal.innerHTML = '&times;';
    const header = createElement('header', {}, modalContent);
    createElement('img', { src: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR4uvODVraMaquXgKDxTqxtS_GEml-x5Ra6bQ&s', alt: 'Octopus8 Logo' }, header);
    createElement('h2', {}, header).innerText = 'Octopus8 Live Chat';
    const infoText = createElement('div', { class: 'info-text' }, modalContent);
    infoText.innerHTML = 'Welcome to Octopus8 Live Chat! Please take some time to fill in the form below before starting the chat.<br><span class="mandatory">*Denotes mandatory fields</span>';
    
    // Create the form
    const form = createElement('form', { id: 'contactDetails' }, modalContent);
    const createFormField = (labelText, inputType, inputId, placeholder) => {
        createElement('label', { for: inputId }, form).innerHTML = `${labelText} <span class="mandatory">*</span>`;
        createElement('input', { type: inputType, id: inputId, name: inputId, placeholder: placeholder, required: true }, form);
    };
    createFormField('Name', 'text', 'firstName', 'Please enter your given name');
    createFormField('Email', 'email', 'email', 'Please enter your email address');
    createFormField('Mobile Number', 'tel', 'mobile', 'Please enter your mobile number');
    createElement('label', { for: 'enquiry' }, form).innerHTML = 'Your Enquiry <span class="mandatory">*</span>';
    createElement('textarea', { id: 'enquiry', name: 'enquiry', rows: '4', placeholder: 'Please enter your enquiry', required: true }, form);
    createElement('button', { type: 'submit' }, form).innerText = 'Start Chat';

    // Create the loading spinner
    createElement('div', { class: 'loading-spinner', id: 'loadingSpinner' }, modalContent);

    // Create the chat widget container
    const sectionChat = createElement('div', { class: 'section-chat', id: 'section-chat' }, document.body);
    createElement('div', { id: 'root' }, sectionChat);

    // Add CSS for the loading spinner and modal
    const style = document.createElement('style');
    style.innerHTML = `
        .loading-spinner {
            display: none;
            position: absolute;
            z-index: 9999;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 9998;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            position: relative;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .chat-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .chat-button:hover {
            background-color: #2980b9;
        }
        .section-chat {
            display: none;
        }
        .section-chat.show {
            display: block;
        }
    `;
    document.head.appendChild(style);

    // Initialize the chat interface
    connect.ChatInterface.init({ containerId: 'root' });

    // Form submission handler
    document.getElementById('contactDetails').addEventListener('submit', function(e) {
        e.preventDefault();
        const customerName = document.getElementById('firstName').value;
        if (!customerName) {
            alert('You must enter a name');
            return;
        }
        document.getElementById("loadingSpinner").style.display = "block";
        connect.ChatInterface.initiateChat({
            name: customerName,
            region,
            apiGatewayEndpoint,
            contactAttributes: JSON.stringify({ "customerName": customerName }),
            featurePermissions: { "ATTACHMENTS": true },
            supportedMessagingContentTypes: "text/plain",
            contactFlowId,
            instanceId
        }, successHandler, failureHandler);
        document.getElementById("chatModal").style.display = "none";
    });

    // Chat button click handler
    document.getElementById('openChatButton').onclick = function() {
        const modal = document.getElementById("chatModal");
        modal.style.display = modal.style.display === "block" ? "none" : "block";
    };

    // Close modal handler
    document.getElementById('closeChatModal').onclick = function() {
        document.getElementById("chatModal").style.display = "none";
    };

    // Close modal when clicking outside of it
    window.onclick = function(event) {
        if (event.target == document.getElementById("chatModal")) {
            document.getElementById("chatModal").style.display = "none";
        }
    };

    // Success handler
    function successHandler(chatSession) {
        document.getElementById('section-chat').classList.add("show");
        document.getElementById("loadingSpinner").style.display = "none";
        chatSession.onChatDisconnected(function() {
            document.getElementById('section-chat').classList.remove("show");
        });
    }

    // Failure handler
    function failureHandler(error) {
        console.error("There was an error: ", error);
        document.getElementById("loadingSpinner").style.display = "none";
    }
})();