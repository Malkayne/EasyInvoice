<div id="ai-assistant" class="ai-assistant" aria-live="polite" aria-label="AI Maintenance Assistant">
  <button id="ai-assistant-toggle" class="ai-assistant__fab ai-assistant__fab--animated" aria-expanded="false" aria-controls="ai-assistant-panel" title="Open AI Maintenance Assistant">
    <span class="ai-assistant__icon d-flex align-items-center justify-content-center">
      <i class="ti ti-robot ai-assistant__icon--animated"></i>
    </span>
  </button>

  <div id="ai-assistant-panel" class="ai-assistant__panel" role="dialog" aria-modal="false" aria-hidden="true">
    <div class="ai-assistant__header">
      <div class="ai-assistant__brand">
        <img src="{{ asset('assets/img/logo.png') }}" alt="MotoDoc" class="ai-assistant__logo" />
        <div class="ai-assistant__title">
          <div class="ai-assistant__name">AI Maintenance Assistant</div>
          <div class="ai-assistant__subtitle">Here to help with your vehicle</div>
        </div>
      </div>
      <div class="ai-assistant__header-actions">
        <button class="ai-assistant__new-chat" id="ai-assistant-new-chat" aria-label="Start new chat" title="New Chat">
          <i class="ti ti-plus"></i>
        </button>
        <button class="ai-assistant__close" id="ai-assistant-close" aria-label="Close chat">
          <i class="ti ti-x"></i>
        </button>
      </div>
    </div>

    <div class="ai-assistant__body">
      <div class="ai-assistant__messages" id="ai-assistant-messages">
        <div class="ai-assistant__message ai-assistant__message--bot">
          <div class="ai-assistant__avatar d-flex align-items-center justify-content-center"><i class="ti ti-robot"></i></div>
          <div class="ai-assistant__bubble">
            Hi! I’m your AI Maintenance Assistant. Ask me about services, repairs, or tips.
          </div>
        </div>
      </div>
    </div>

    <div class="ai-assistant__footer">
      <form id="ai-assistant-form" class="ai-assistant__form" autocomplete="off">
        <input id="ai-assistant-input" class="ai-assistant__input" type="text" placeholder="Type your message..." aria-label="Message input" />
        <button class="ai-assistant__send" type="submit" aria-label="Send message">
          <i class="ti ti-send"></i>
        </button>
      </form>
    </div>
  </div>
</div>


