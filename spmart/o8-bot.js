(function() {
    // Create and append the CSS link element
    var link = document.createElement('link');
    link.rel = 'stylesheet';
    link.type = 'text/css';
    link.href = './chatbotform-styles.css'; // Ensure this path is correct
    document.head.appendChild(link);

    // Create and append the Google Fonts link element
    var googleFontsLink = document.createElement('link');
    googleFontsLink.rel = 'stylesheet';
    googleFontsLink.href = 'https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap';
    document.head.appendChild(googleFontsLink);

    // Create and append the Amazon Connect Chat Interface script
    var amazonConnectScript = document.createElement('script');
    amazonConnectScript.src = './amazon-connect-chat-interface.js'; // Ensure this path is correct
    document.body.appendChild(amazonConnectScript);

    // Create and append the Backend Endpoints script
    var backendEndpointsScript = document.createElement('script');
    backendEndpointsScript.src = './backendEndpoints.js'; // Ensure this path is correct
    document.body.appendChild(backendEndpointsScript);

    // Create and append the HTML content
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
                    <h2>Octopus8 Live Chat</h2>
                </header>
                <div class="info-text">
                    Welcome to Octopus8 Live Chat! Please take some time to fill in the form below before starting the chat.
                    <br>
                    <span class="mandatory">*Denotes mandatory fields</span>
                </div>
                <form id="contactDetails">
                    <label for="firstName">Name <span class="mandatory">*</span></label>
                    <input type="text" id="firstName" name="firstName" placeholder="Please enter your given name" required>
                    <label for="email">Email <span class="mandatory">*</span></label>
                    <input type="email" id="email" name="email" placeholder="Please enter your email address" >
                    <label for="mobile">Mobile Number <span class="mandatory">*</span></label>
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
    document.body.insertAdjacentHTML('beforeend', chatHtml);

    // Add the JavaScript functionality
    amazonConnectScript.onload = function() {
        (function() {
            connect.ChatInterface.init({
                containerId: 'root' // This is the id of the container where you want the widget to reside
            });

            document.getElementById('contactDetails').addEventListener('submit', function(e) {
                e.preventDefault();

                var customerName = document.getElementById('firstName').value;
                var email = document.getElementById('email').value;
                var enquiry = document.getElementById('enquiry').value;

                if (!customerName) {
                    alert('You must enter a name & username');
                    document.getElementById("contactDetails").reset();
                } else {
                    console.log("This is the first name:" + customerName);
                    document.getElementById("contactDetails").reset();

                    // Show the loading spinner
                    var loadingSpinner = document.getElementById("loadingSpinner");
                    loadingSpinner.style.display = "block";

                    connect.ChatInterface.initiateChat({
                        name: customerName,
                        initialMessage: enquiry,
                        region,
                        apiGatewayEndpoint,
                        contactAttributes: JSON.stringify({
                            "customerName": customerName,
                            "email": email,
                            "initialMessage": enquiry
                        }),
                        featurePermissions: {
                            "ATTACHMENTS": true,  // this is the override flag from user for attachments
                        },
                        supportedMessagingContentTypes: "text/plain", // enable rich messaging
                        contactFlowId,
                        instanceId
                    }, successHandler, failureHandler);

                    // Hide the form modal
                    var modal = document.getElementById("chatModal");
                    modal.classList.remove("show");
                    setTimeout(() => {
                        modal.style.display = "none";
                    }, 300); // Match the duration of the CSS transition

                    // Change the chat button behavior to control the chat widget
                    var chatButton = document.getElementById("openChatButton");
                    chatButton.onclick = function() {
                        var chatSection = document.getElementById("section-chat");
                        if (chatSection.classList.contains("show")) {
                            chatSection.classList.remove("show");
                            document.getElementById("chatIcon").classList.remove("slide-down");
                            document.getElementById("chatIcon").classList.add("slide-up");
                            document.getElementById("minimizeIcon").classList.remove("slide-up");
                            document.getElementById("minimizeIcon").classList.add("slide-down");
                        } else {
                            chatSection.classList.add("show");
                            document.getElementById("chatIcon").classList.remove("slide-up");
                            document.getElementById("chatIcon").classList.add("slide-down");
                            document.getElementById("minimizeIcon").classList.remove("slide-down");
                            document.getElementById("minimizeIcon").classList.add("slide-up");
                        }
                    };
                }
            });

            // Get the modal
            var modal = document.getElementById("chatModal");

            // Get the button that opens the modal
            var btn = document.getElementById("openChatButton");

            // Get the <span> element that closes the modal
            var span = document.getElementById("closeChatModal");

            // When the user clicks the button, toggle the modal 
            btn.onclick = function() {
                if (modal.classList.contains("show")) {
                    modal.classList.remove("show");
                    setTimeout(() => {
                        modal.style.display = "none";
                    }, 300); // Match the duration of the CSS transition

                    document.getElementById("chatIcon").classList.remove("slide-down");
                    document.getElementById("chatIcon").classList.add("slide-up");
                    document.getElementById("minimizeIcon").classList.remove("slide-up");
                    document.getElementById("minimizeIcon").classList.add("slide-down");
                } else {
                    modal.style.display = "block";
                    setTimeout(() => {
                        modal.classList.add("show");
                    }, 10); // Small delay to trigger the transition
                    document.getElementById("chatIcon").classList.remove("slide-up");
                    document.getElementById("chatIcon").classList.add("slide-down");
                    document.getElementById("minimizeIcon").classList.remove("slide-down");
                    document.getElementById("minimizeIcon").classList.add("slide-up");
                }
            }

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                if (modal.classList.contains("show")) {
                    modal.classList.remove("show");
                    setTimeout(() => {
                        modal.style.display = "none";
                    }, 300); // Match the duration of the CSS transition

                    document.getElementById("chatIcon").classList.remove("slide-down");
                    document.getElementById("chatIcon").classList.add("slide-up");
                    document.getElementById("minimizeIcon").classList.remove("slide-up");
                    document.getElementById("minimizeIcon").classList.add("slide-down");
                } else {
                    modal.style.display = "block";
                    setTimeout(() => {
                        modal.classList.add("show");
                    }, 10); // Small delay to trigger the transition
                    document.getElementById("chatIcon").classList.remove("slide-up");
                    document.getElementById("chatIcon").classList.add("slide-down");
                    document.getElementById("minimizeIcon").classList.remove("slide-down");
                    document.getElementById("minimizeIcon").classList.add("slide-up");
                }
            }
        })();

        function successHandler(chatSession) {
            console.log("success!");
            document.getElementById('section-chat').classList.add("show");

            // Hide the loading spinner
            var loadingSpinner = document.getElementById("loadingSpinner");
            loadingSpinner.style.display = "none";

            chatSession.onChatDisconnected(function(data) {
                //document.getElementById('section-chat').classList.remove("show");
            });
        }

        function failureHandler(error) {
            console.log("There was an error: ");
            console.log(error);

            // Hide the loading spinner
            var loadingSpinner = document.getElementById("loadingSpinner");
            loadingSpinner.style.display = "none";
        }
    };
})();