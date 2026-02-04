(function(){
  function clamp(n, min, max){ return Math.max(min, Math.min(max, n)); }

  // ---- Copy link helper (create page)
  const copyBtn = document.querySelector('[data-copy]');
  if (copyBtn) {
    copyBtn.addEventListener('click', async () => {
      const target = document.querySelector('[data-copy-target]');
      if (!target) return;
      const text = target.textContent.trim();
      try {
        await navigator.clipboard.writeText(text);
        copyBtn.textContent = 'Copied!';
        setTimeout(() => (copyBtn.textContent = 'Copy'), 1200);
      } catch {
        // fallback
        const ta = document.createElement('textarea');
        ta.value = text;
        document.body.appendChild(ta);
        ta.select();
        document.execCommand('copy');
        document.body.removeChild(ta);
        copyBtn.textContent = 'Copied!';
        setTimeout(() => (copyBtn.textContent = 'Copy'), 1200);
      }
    });
  }

  // ---- No-escape logic (valentine page)
  const stage = document.getElementById('stage');
  const noBtn = document.getElementById('btnNo');
  if (!stage || !noBtn) return;

  // Place No initially slightly to the right (like the reference)
  function initialPosition(){
    const rect = stage.getBoundingClientRect();
    const b = noBtn.getBoundingClientRect();
    const x = rect.width/2 + 70;
    const y = rect.height/2 - b.height/2;
    noBtn.style.left = clamp(x, 8, rect.width - b.width - 8) + 'px';
    noBtn.style.top  = clamp(y, 8, rect.height - b.height - 8) + 'px';
  }

  function randomPosition(){
    const rect = stage.getBoundingClientRect();
    const b = noBtn.getBoundingClientRect();
    const pad = 8;
    const maxX = Math.max(pad, rect.width - b.width - pad);
    const maxY = Math.max(pad, rect.height - b.height - pad);

    const x = pad + Math.random() * (maxX - pad);
    const y = pad + Math.random() * (maxY - pad);

    noBtn.style.left = x + 'px';
    noBtn.style.top  = y + 'px';
  }

  let lastMove = 0;
  function maybeDodge(clientX, clientY){
    const now = Date.now();
    if (now - lastMove < 80) return;

    const stageRect = stage.getBoundingClientRect();
    const btnRect = noBtn.getBoundingClientRect();

    const cx = btnRect.left + btnRect.width/2;
    const cy = btnRect.top + btnRect.height/2;

    const dx = clientX - cx;
    const dy = clientY - cy;
    const dist = Math.sqrt(dx*dx + dy*dy);

    // If cursor gets close, dodge!
    if (dist < 120) {
      lastMove = now;
      randomPosition();
    }
  }

  // pointer move works for mouse + pen
  stage.addEventListener('pointermove', (e) => {
    maybeDodge(e.clientX, e.clientY);
  });

  // mobile: tapping around makes it move
  stage.addEventListener('touchstart', (e) => {
    const t = e.touches && e.touches[0];
    if (t) maybeDodge(t.clientX, t.clientY);
  }, {passive:true});

  // if they somehow click it...
  noBtn.addEventListener('click', (e) => {
    e.preventDefault();
    const note = document.getElementById('note');
    if (note) {
      note.textContent = '"No" seems a bit shy 😈';
      note.style.opacity = '1';
    }
    randomPosition();
  });

  window.addEventListener('resize', initialPosition);
  initialPosition();
})();
