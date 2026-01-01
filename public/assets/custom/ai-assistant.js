(function(){
  const root = document.getElementById('ai-assistant');
  if(!root) return;
  const toggleBtn = document.getElementById('ai-assistant-toggle');
  const panel = document.getElementById('ai-assistant-panel');
  const closeBtn = document.getElementById('ai-assistant-close');
  const newChatBtn = document.getElementById('ai-assistant-new-chat');
  const form = document.getElementById('ai-assistant-form');
  const input = document.getElementById('ai-assistant-input');
  const messages = document.getElementById('ai-assistant-messages');
  
  // Track conversation history to avoid repetition
  let conversationHistory = [];
  let hasGreeted = false;
  
  // Note: Initial welcome message is not tracked in conversationHistory

  function openPanel(){
    panel.classList.add('is-open');
    toggleBtn.setAttribute('aria-expanded','true');
    panel.setAttribute('aria-hidden','false');
    setTimeout(()=>{ input && input.focus(); }, 50);
  }

  function closePanel(){
    panel.classList.remove('is-open');
    toggleBtn.setAttribute('aria-expanded','false');
    panel.setAttribute('aria-hidden','true');
  }

  function formatMessage(text) {
    if (!text) return '';
    
    // First, convert markdown links: [text](url) to <a href="url">text</a>
    text = text.replace(/\[([^\]]+)\]\(([^)]+)\)/g, '<a href="$2" class="ai-assistant__link" target="_self">$1</a>');
    
    // Then convert bold text: **text** to <strong>text</strong>
    text = text.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
    
    // Split by double line breaks to get paragraphs
    const paragraphs = text.split(/\n\n+/);
    
    let result = [];
    
    paragraphs.forEach(paragraph => {
      if (!paragraph.trim()) return;
      
      const lines = paragraph.split('\n').filter(line => line.trim());
      const isNumberedList = lines.length > 0 && /^\d+\.\s/.test(lines[0].trim());
      const isBulletList = lines.length > 0 && /^[-•]\s/.test(lines[0].trim());
      
      if (isNumberedList) {
        // Handle numbered lists
        const listItems = lines.map(line => {
          const match = line.trim().match(/^\d+\.\s(.+)$/);
          return match ? `<li>${match[1]}</li>` : '';
        }).filter(item => item);
        
        if (listItems.length > 0) {
          result.push(`<ol>${listItems.join('')}</ol>`);
        }
      } else if (isBulletList) {
        // Handle bullet lists
        const listItems = lines.map(line => {
          const match = line.trim().match(/^[-•]\s(.+)$/);
          return match ? `<li>${match[1]}</li>` : '';
        }).filter(item => item);
        
        if (listItems.length > 0) {
          result.push(`<ul>${listItems.join('')}</ul>`);
        }
      } else {
        // Regular paragraphs
        lines.forEach(line => {
          if (line.trim()) {
            result.push(`<p>${line.trim()}</p>`);
          }
        });
      }
    });
    
    return result.join('');
  }

  function appendMessage(text, role, isHTML = false){
    const wrapper = document.createElement('div');
    wrapper.className = 'ai-assistant__message ' + (role === 'user' ? 'ai-assistant__message--user' : 'ai-assistant__message--bot');
    if(role !== 'user'){
      const avatar = document.createElement('div');
      avatar.className = 'ai-assistant__avatar';
      avatar.innerHTML = '<i class="ti ti-robot"></i>';
      wrapper.appendChild(avatar);
    }
    const bubble = document.createElement('div');
    bubble.className = 'ai-assistant__bubble';
    
    if (isHTML || role === 'bot') {
      // Format bot messages as HTML
      bubble.innerHTML = isHTML ? text : formatMessage(text);
    } else {
      // User messages as plain text
      bubble.textContent = text;
    }
    
    wrapper.appendChild(bubble);
    messages.appendChild(wrapper);
    messages.scrollTop = messages.scrollHeight;
    
    // Track conversation history
    conversationHistory.push({
      role: role,
      content: text,
      timestamp: Date.now()
    });
    
    // Check if this is a greeting response (look for greeting patterns)
    if (role === 'bot') {
      const greetingPattern = /Hi\s+[^!]*!|Hello!|I'm your AI Maintenance Assistant|Vehicle Diagnostics.*Maintenance Tips/i;
      if (greetingPattern.test(text)) {
        hasGreeted = true;
      }
    }
    
    return wrapper; // Return the wrapper element
  }
  
  function startNewChat() {
    // Clear all messages except the initial welcome
    const allMessages = messages.querySelectorAll('.ai-assistant__message');
    allMessages.forEach((msg, index) => {
      // Keep only the first message (initial welcome)
      if (index > 0) {
        msg.remove();
      }
    });
    
    // Reset conversation history
    conversationHistory = [];
    hasGreeted = false;
    
    // Clear input
    input.value = '';
    input.focus();
  }

  function appendLoadingMessage(){
    const wrapper = document.createElement('div');
    wrapper.className = 'ai-assistant__message ai-assistant__message--bot';
    
    const avatar = document.createElement('div');
    avatar.className = 'ai-assistant__avatar';
    avatar.innerHTML = '<i class="ti ti-robot"></i>';
    wrapper.appendChild(avatar);
    
    const bubble = document.createElement('div');
    bubble.className = 'ai-assistant__bubble';
    
    const loadingContainer = document.createElement('div');
    loadingContainer.className = 'ai-assistant__loading';
    loadingContainer.innerHTML = '<span>thinking</span><span class="ai-assistant__loading-dot"></span><span class="ai-assistant__loading-dot"></span><span class="ai-assistant__loading-dot"></span>';
    
    bubble.appendChild(loadingContainer);
    wrapper.appendChild(bubble);
    messages.appendChild(wrapper);
    messages.scrollTop = messages.scrollHeight;
    return wrapper;
  }

  toggleBtn && toggleBtn.addEventListener('click', function(e){
    e.stopPropagation();
    if(panel.classList.contains('is-open')) closePanel(); else openPanel();
  });
  closeBtn && closeBtn.addEventListener('click', function(){ closePanel(); });
  newChatBtn && newChatBtn.addEventListener('click', function(e){
    e.stopPropagation();
    startNewChat();
  });

  document.addEventListener('click', function(e){
    if(!panel.classList.contains('is-open')) return;
    if(root.contains(e.target)) return;
    closePanel();
  });

  window.addEventListener('pageshow', function(){ closePanel(); });

  form && form.addEventListener('submit', function(e){
    e.preventDefault();
    const text = (input.value || '').trim();
    if(!text) return;
    
    appendMessage(text, 'user');
    input.value = '';
    input.disabled = true;
    
    // Show loading indicator with animation
    const loadingMessage = appendLoadingMessage();
    
    // Send message to backend with conversation history
    fetch('/ai-assistant/chat', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
      },
      body: JSON.stringify({ 
        message: text,
        hasGreeted: hasGreeted,
        conversationHistory: conversationHistory.slice(-10) // Send last 10 messages for context
      })
    })
    .then(response => response.json())
    .then(data => {
      // Remove loading message
      loadingMessage.remove();
      
      if(data.success && data.response) {
        // Display AI response (formatted)
        appendMessage(data.response, 'bot');
      } else {
        appendMessage('Sorry, I encountered an error. Please try again.', 'bot');
      }
    })
    .catch(error => {
      console.error('AI Assistant Error:', error);
      // Remove loading message
      loadingMessage.remove();
      appendMessage('Sorry, I encountered an error. Please try again.', 'bot');
    })
    .finally(() => {
      input.disabled = false;
      input.focus();
    });
  });
})();


