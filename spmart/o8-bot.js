(function() {
    // Create the shadow root to encapsulate the HTML, CSS, and JavaScript
    var shadowContainer = document.createElement('div');
    document.body.appendChild(shadowContainer);
    var shadowRoot = shadowContainer.attachShadow({ mode: 'open' });

    // Create and append the CSS link element within the shadow DOM
    var link = document.createElement('link');
    link.rel = 'stylesheet';
    link.type = 'text/css';
    link.href = './chatbotform-styles.css';
    shadowRoot.appendChild(link);

    // Create and append the Google Fonts link element within the shadow DOM
    var googleFontsLink = document.createElement('link');
    googleFontsLink.rel = 'stylesheet';
    googleFontsLink.href = 'https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap';
    shadowRoot.appendChild(googleFontsLink);

    // Create and append the Amazon Connect Chat Interface script
    var amazonConnectScript = document.createElement('script');
    amazonConnectScript.src = './amazon-connect-chat-interface.js';
    document.body.appendChild(amazonConnectScript);

    // Create and append the Backend Endpoints script
    var backendEndpointsScript = document.createElement('script');
    backendEndpointsScript.src = './backendEndpoints.js';
    document.body.appendChild(backendEndpointsScript);

    // HTML structure as a template literal, to insert into the shadow DOM
    var chatHtml = `
        <!-- Chat Button -->
        <button class="chat-button" id="openChatButton">
            <img src="smartbot.png" alt="Chat" class="chat-button-image" id="chatIcon">
            <svg class="chat-button-image minimize-icon" id="minimizeIcon" xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#e8eaed"><path d="M480-344 240-584l43-43 197 197 197-197 43 43-240 240Z"/></svg>
        </button>

        <!-- Modal for Form -->
        <div id="chatModal" class="modal">
            <div class="modal-content">
                <header>
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR4uvODVraMaquXgKDxTqxtS_GEml-x5Ra6bQ&s" alt="Octopus8 Logo">
                    <h2>O8 Chatbot</h2>
                </header>
                <div class="info-text">
                    Welcome to Octopus8 Chatbot Demo! Please fill in the form below before starting the chat.
                    <br>
                    <span class="mandatory">*Denotes mandatory fields</span>
                </div>
                <form id="contactDetails">
                    <label for="firstName">Name <span class="mandatory">*</span></label>
                    <input type="text" id="firstName" name="firstName" placeholder="Please enter your given name" required>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Please enter your email address" >
                    <label for="mobile">Mobile Number </label>
                    <input type="tel" id="mobile" name="mobile" placeholder="Please enter your mobile number" >
                    <label for="enquiry">Your Enquiry <span class="mandatory">*</span></label>
                    <textarea id="enquiry" name="enquiry" rows="4" placeholder="Please enter your enquiry" ></textarea>
                    <div class="button-wrapper">
                        <button type="submit">Start Chat</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Loading Spinner -->
        <div class="loading-spinner" id="loadingSpinner"></div>

        <!-- Chat Widget -->
        <div class="section-chat" id="section-chat">
            <div id="root"></div>
        </div>
    `;
    shadowRoot.innerHTML += chatHtml;

    amazonConnectScript.onload = function() {
        (function() {
            // Initialize the chat interface within the shadow DOM
            connect.ChatInterface.init({
                containerId: shadowRoot.getElementById('root')
            });

            shadowRoot.getElementById('contactDetails').addEventListener('submit', function(e) {
                e.preventDefault();

                var customerName = shadowRoot.getElementById('firstName').value;
                var email = shadowRoot.getElementById('email').value;
                var enquiry = shadowRoot.getElementById('enquiry').value;
                var mobile = shadowRoot.getElementById('mobile').value;

                if (!customerName) {
                    alert('You must enter a name & username');
                    shadowRoot.getElementById("contactDetails").reset();
                } else {
                    console.log("This is the first name:" + customerName);
                    shadowRoot.getElementById("contactDetails").reset();

                    // Show the loading spinner
                    var loadingSpinner = shadowRoot.getElementById("loadingSpinner");
                    loadingSpinner.style.display = "block";

                    connect.ChatInterface.initiateChat({
                        name: customerName,
                        initialMessage: enquiry,
                        region,
                        apiGatewayEndpoint,
                        contactAttributes: JSON.stringify({
                            "customerName": customerName,
                            "email": email,
                            "mobile": mobile,
                            "initialMessage": enquiry,
                            "enquiry": enquiry
                        }),
                        featurePermissions: {
                            "ATTACHMENTS": true,
                        },
                        supportedMessagingContentTypes: "text/plain", 
                        contactFlowId,
                        instanceId
                    }, successHandler, failureHandler);

                    // Hide the form modal
                    var modal = shadowRoot.getElementById("chatModal");
                    modal.classList.remove("show");
                    setTimeout(() => {
                        modal.style.display = "none";
                    }, 300);
                }
            });
        })();

        function successHandler(chatSession) {
            console.log("success!");
            shadowRoot.getElementById('section-chat').classList.add("show");

            // Hide the loading spinner
            var loadingSpinner = shadowRoot.getElementById("loadingSpinner");
            loadingSpinner.style.display = "none";
        }

        function failureHandler(error) {
            console.log("There was an error: ");
            console.log(error);

            // Hide the loading spinner
            var loadingSpinner = shadowRoot.getElementById("loadingSpinner");
            loadingSpinner.style.display = "none";
        }
    };
})();
