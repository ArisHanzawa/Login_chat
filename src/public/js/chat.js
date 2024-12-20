document.addEventListener('DOMContentLoaded', function() {
    const messages = document.querySelectorAll('li[data-message-id]');
    let lastMessageId = messages[messages.length - 1].getAttribute('data-message-id');
    let loading = false;

    window.addEventListener('scroll', function() {
        if (window.scrollY === 0 && !loading) {
            loading = true;
            fetch(`/chat/load-more/${lastMessageId}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Loaded data:', data); // レスポンスの形式を確認
                    const chatMessages = document.getElementById('chat-messages');
                    if (!chatMessages) {
                        console.error('Element with id "chat-messages" not found.');
                        return;
                    }
                    const messagesArray = Object.values(data); // オブジェクトの値を配列に変換
                    messagesArray.forEach(message => {
                        const li = document.createElement('li');
                        li.setAttribute('data-message-id', message.id);
                        li.innerHTML = `${message.created_at} - ${message.message}`;
                        if (Array.isArray(message.read_by) && message.read_by.length > 1) {
                            const span = document.createElement('span');
                            span.textContent = `既読${message.read_by.length - 1}`;
                            li.appendChild(span);
                        }
                        chatMessages.insertBefore(li, chatMessages.firstChild);
                    });
                    if (messagesArray.length > 0) {
                        lastMessageId = messagesArray[messagesArray.length - 1].id;
                    }
                    loading = false;
                })
                .catch(error => {
                    console.error('Error loading more messages:', error);
                    loading = false;
                });
        }
    });
});
