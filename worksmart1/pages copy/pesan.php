<?php
require '../controllers/function.php';
checkAuth();
// At the top of pesan.php after checkAuth()
if(isset($_GET['mitra_id']) && isset($_GET['workshop_title'])) {
    $mitra_id = $_GET['mitra_id'];
    $workshop_title = urldecode($_GET['workshop_title']);
    
    // Get mitra details first
    $mitra = getUserById($mitra_id);
    
    // Create initial contact if doesn't exist
    $initial_message = "Halo, saya tertarik dengan workshop: $workshop_title. Boleh tanya informasi lebih lanjut?";
    sendMessage($_SESSION['user_id'], $mitra_id, $initial_message);
    
    // Now the mitra will appear in contacts list
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(() => {
                    const mitraContact = document.querySelector(`[data-user-id='${mitra_id}']`);
                    if(mitraContact) {
                        const avatar = mitraContact.querySelector('.rounded-circle');
                        if(avatar) {
                            avatar.style.width = '35px';
                            avatar.style.height = '35px';
                            avatar.style.minWidth = '35px';
                            avatar.style.aspectRatio = '1';
                        }
                        mitraContact.click();
                    }
                }, 500);
            });
        </script>";
}

$user_id = $_SESSION['user_id'];
$contacts = getChatContacts($user_id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - WorkSmart</title>
  <meta content="WorkSmart" name="description">
  <meta content="WorkSmart" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logo-worksmart.png" rel="icon">
  <link href="assets/img/logo-worksmart.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  
  <!-- DataTables CSS -->
  <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/css/brand.css" rel="stylesheet">
  
  <style>
    .chat-contacts {
        height: 550px;
        overflow-y: auto;
        border-radius: 15px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }

    .contact-item {
        padding: 1.2rem;
        transition: all 0.3s ease;
        border-radius: 10px;
        margin: 5px 10px;
    }

    .contact-item:hover {
        background-color: rgba(0,0,0,0.05);
        transform: translateX(5px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .contact-item.active {
        background-color: rgba(0,0,0,0.1);
        border-left: 4px solid #007bff;
    }

    .chat-message {
        margin-bottom: 1.2rem;
        /* animation: fadeIn 0.5s ease; */
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .message-bubble {
        background-color: #f8f9fa;
        max-width: 70%;
        padding: 12px 20px;
        border-radius: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        position: relative;
    }

    .own-message .message-bubble {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
    }

    .chat-area {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }

    .chat-input {
        background-color: #f8f9fa;
        border-radius: 0 0 15px 15px;
        padding: 20px !important;
    }

    .chat-input .form-control {
        border-radius: 25px;
        padding: 12px 20px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .chat-input .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
    }

    .chat-input .btn {
        border-radius: 25px;
        padding: 10px 25px;
        margin-left: 10px;
        transition: all 0.3s ease;
    }

    .chat-input .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,123,255,0.3);
    }

    #user-search {
        border-radius: 25px;
        padding: 12px 20px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }

    #search-results {
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-top: 5px;
    }

    .chat-messages {
        padding: 20px;
        background: linear-gradient(to bottom, #f8f9fa, #ffffff);
        border-radius: 15px;
    }

    .avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        margin-right: 15px;
        object-fit: cover;
    }
    .rounded-circle {
        width: 35px;
        height: 35px;
        min-width: 35px;
        flex-shrink: 0;
        aspect-ratio: 1;
    }


    @media (max-width: 768px) {
        .chat-contacts {
            height: 300px;
        }
        
        .chat-area {
            height: 400px !important;
            margin-top: 20px;
        }

        .contact-item {
            padding: 0.8rem;
        }

        .message-bubble {
            max-width: 85%;
        }

        .avatar {
            width: 35px;
            height: 35px;
        }
    }
   </style>
</head>

<body>

  <?php require 'header.php'; ?>
  <?php require 'sidebar.php'; ?>

  <main id="main" class="main brand-bg-color">

    <div class="pagetitle">
      <h1 class="text-light">Pesan</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Pesan</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->
    <?php require 'alert.php'; ?>
<section class="section dashboard">
            <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-0 mt-3">
                            <!-- Contacts List -->
                            <div class="col-12 col-lg-4 border-end">
                                <div class="px-4 d-none d-md-block">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <input type="text" class="form-control my-3" placeholder="Search...">
                                        </div>
                                    </div>
                                </div>

                                <div class="chat-contacts">
                                    <?php foreach($contacts as $contact): ?>
                                        <a href="#" class="list-group-item list-group-item-action border-0 contact-item" 
                                        data-user-id="<?= $contact['user_id'] ?>">
                                            <div class="d-flex align-items-start">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                                <?= strtoupper(substr($contact['first_name'], 0, 1)) ?>
                                            </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h5 class="mb-0 text-dark"><?= $contact['first_name'] . ' ' . $contact['last_name'] ?></h5>
                                                        <small class="text-muted"><?= date('H:i', strtotime($contact['last_message_time'])) ?></small>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <small class="text-truncate"><?= $contact['last_message'] ?></small>
                                                        <?php if($contact['unread_count'] > 0): ?>
                                                            <span class="badge bg-primary rounded-pill"><?= $contact['unread_count'] ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Chat Area -->
                            <div class="col-12 col-lg-8">
                                <div class="chat-area d-flex flex-column" style="height: 600px;">
                                <div class="px-4 d-md-block">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <input type="text" class="form-control my-3" id="user-search" 
                                                placeholder="Search by email or username...">
                                            <div id="search-results" class="list-group d-none">
                                                <!-- Search results will appear here -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    
                                    <div class="chat-messages p-4 flex-grow-1" style="overflow-y: auto;">
                                        <!-- Messages will be loaded here -->
                                    </div>

                                    <div class="chat-input px-4 py-3 border-top">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="message-input" placeholder="Type your message...">
                                            <button class="btn brand-btn" type="button" id="send-message"><i class="bi bi-send"></i> Send</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>  
  </main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer brand-bg-color">
    <div class="copyright text-light">
      © Copyright <strong><span>WorkSmart</span></strong>. All Rights Reserved
    </div>
  </footer>
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  
  <!-- DataTables JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/autohide.js"></script>

<!-- Chat fungsi -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements with null checks
    const elements = {
        userSearch: document.getElementById('user-search'),
        searchResults: document.getElementById('search-results'),
        contactItems: document.querySelectorAll('.contact-item'),
        messageInput: document.getElementById('message-input'),
        sendButton: document.getElementById('send-message'),
        chatMessages: document.querySelector('.chat-messages'),
        chatRecipient: document.getElementById('chat-recipient')
    };

    let currentReceiverId = null;

    // Initialize Contact List Events
    elements.contactItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            initializeChat(this.dataset.userId, this.querySelector('h5').textContent);
            elements.contactItems.forEach(i => i.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Initialize Message Input Events
    if (elements.sendButton) {
        elements.sendButton.addEventListener('click', sendMessage);
    }
    
    if (elements.messageInput) {
        elements.messageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
    }

    // Initialize Search Functionality
    if (elements.userSearch) {
        elements.userSearch.addEventListener('input', debounce(function() {
            const searchTerm = this.value.trim();
            if (searchTerm.length < 2) {
                elements.searchResults.classList.add('d-none');
                return;
            }
            performSearch(searchTerm);
        }, 300));
    }

    if (elements.searchResults) {
        elements.searchResults.addEventListener('click', function(e) {
            const resultItem = e.target.closest('.search-result');
            if (!resultItem) return;
            
            e.preventDefault();
            
            // Create new contact item
            const newContact = `
                <a href="#" class="list-group-item list-group-item-action border-0 contact-item"
                data-user-id="${resultItem.dataset.userId}">
                <div class="d-flex align-items-start">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2 overflow-hidden" style="width: 40px; height: 40px; min-width: 40px; flex-shrink: 0;aspect-ratio: 1;">
                            ${resultItem.dataset.userName.charAt(0).toUpperCase()}
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 text-dark">${resultItem.dataset.userName}</h5>
                                <small class="text-muted">${new Date().toLocaleTimeString()}</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small class="text-truncate">Start a conversation</small>
                            </div>
                        </div>
                    </div>                
                </a>
            `;

            // Add to chat contacts
            document.querySelector('.chat-contacts').insertAdjacentHTML('afterbegin', newContact);
            
            // Initialize chat with new contact
            initializeChat(resultItem.dataset.userId, resultItem.dataset.userName);
            
            // Clear search
            elements.searchResults.classList.add('d-none');
            elements.userSearch.value = '';
            
            // Add click event to new contact
            const newContactElement = document.querySelector(`[data-user-id="${resultItem.dataset.userId}"]`);
            newContactElement.addEventListener('click', function(e) {
                e.preventDefault();
                initializeChat(this.dataset.userId, resultItem.dataset.userName);
                document.querySelectorAll('.contact-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });
    }

    function initializeChat(userId, userName) {
        if (!userId) return;
        currentReceiverId = userId;
        if (elements.chatRecipient) {
            elements.chatRecipient.textContent = userName || 'Chat';
        }
        loadChatHistory(userId);
    }

    function loadChatHistory(receiverId) {
        if (!elements.chatMessages) return;

        fetch(`../controllers/get_chat_history.php?receiver_id=${receiverId}`)
            .then(response => response.json())
            .then(data => {
                elements.chatMessages.innerHTML = '';
                data.forEach(message => {
                    const isOwn = message.sender_id == <?= $user_id ?>;
                    const messageHtml = `
                        <div class="chat-message ${isOwn ? 'own-message text-end' : 'other-message'}">
                            <div class="message-bubble d-inline-block p-2 mb-2 rounded">
                                <div class="message-text">${message.message}</div>
                                <small class="text-muted">${message.sent_at}</small>
                            </div>
                        </div>
                    `;
                    elements.chatMessages.insertAdjacentHTML('beforeend', messageHtml);
                });
            });
    }

    function sendMessage() {
        if (!currentReceiverId || !elements.messageInput) return;
        
        const message = elements.messageInput.value.trim();
        if (!message) return;

        fetch('../controllers/send_messages.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                receiver_id: currentReceiverId,
                message: message
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                elements.messageInput.value = '';
                loadChatHistory(currentReceiverId);
            }
        });
    }

    function performSearch(searchTerm) {
        fetch(`../controllers/search_users.php?term=${searchTerm}`)
            .then(response => response.json())
            .then(users => {
                if (!elements.searchResults) return;
                
                elements.searchResults.innerHTML = users.map(user => `
                    <a href="#" class="list-group-item list-group-item-action search-result"
                       data-user-id="${user.user_id}"
                       data-user-name="${user.first_name} ${user.last_name}">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-1">${user.first_name} ${user.last_name}</h6>
                            <small>${user.username}</small>
                        </div>
                        <small>${user.email}</small>
                    </a>
                `).join('');
                elements.searchResults.classList.remove('d-none');
            });
    }

    // Add this inside your existing DOMContentLoaded event listener
    if (elements.userSearch) {
        elements.userSearch.addEventListener('input', debounce(function() {
            const searchTerm = this.value.trim();
            if (searchTerm.length < 2) {
                elements.searchResults.classList.add('d-none');
                return;
            }
            performSearch(searchTerm);
        }, 300));
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func.apply(this, args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Add periodic chat updates
        function startRealtimeUpdates() {
            if (currentReceiverId) {
                loadChatHistory(currentReceiverId);
            }
        }

        // Update every 3 seconds
        setInterval(startRealtimeUpdates, 3000);

        // Also update the contact list
        function updateContacts() {
            fetch('get_contacts.php')
                .then(response => response.json())
                .then(contacts => {
                    const contactsContainer = document.querySelector('.chat-contacts');
                    // Update contacts list with new messages and unread counts
                });
        }

        setInterval(updateContacts, 5000);

});
</script>
</body>

</html>