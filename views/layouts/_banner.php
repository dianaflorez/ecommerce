 <style>

    .cw { width: 100%; overflow: hidden; position: relative; }
    .ct { display: flex; transition: transform 0.55s cubic-bezier(0.77,0,0.175,1); width: 100%; }
    .slide { min-width: 100%; width: 100%; height: 380px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;  top: 65px; }
    .inner { position: relative; z-index: 2; width: 100%; max-width: 1100px; margin: 0 auto; padding: 0 48px; display: flex; align-items: center; justify-content: space-between; gap: 32px; }
    .txt { flex: 0 0 auto; max-width: 370px; }
    .eyebrow { font-size: 12px; font-weight: 700; letter-spacing: 2.5px; text-transform: uppercase; margin-bottom: 10px; }
    .title { font-size: 48px; font-weight: 800; line-height: 1.05; margin-bottom: 12px; }
    .sub { font-size: 15px; line-height: 1.55; margin-bottom: 20px; max-width: 380px; }
    .badges { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 22px; }
    .badge { padding: 5px 14px; border-radius: 999px; font-size: 12px; font-weight: 700; }
    .cta { padding: 13px 30px; border-radius: 8px; font-size: 14px; font-weight: 700; border: none; cursor: pointer; transition: transform 0.15s; }
    .cta:hover { transform: translateY(-2px); }
    .vis { flex: 0 0 auto; display: flex; gap: 12px; align-items: flex-end; }
    .pcard { border-radius: 14px; padding: 16px 14px; text-align: center; min-width: 120px; border: 1.5px solid rgba(255,255,255,0.3); background: rgba(255,255,255,0.18); }
    .pcard .emo { font-size: 44px; display: block; margin-bottom: 6px; }
    .pcard .pname { font-size: 10px; opacity: 0.75; margin-bottom: 4px; color: white; }
    .pcard .pold { font-size: 10px; text-decoration: line-through; opacity: 0.5; color: white; }
    .pcard .pnew { font-size: 20px; font-weight: 800; color: white; }
    .pill-dcto { padding: 9px 22px; border-radius: 999px; font-size: 20px; font-weight: 900; background: #fff; margin-top: 8px; display: inline-block; }
    .ftag { position: absolute; top: 20px; right: 40px; padding: 7px 16px; border-radius: 8px; font-size: 13px; font-weight: 800; z-index: 4; }
    .navi { position: absolute; top: 50%; transform: translateY(-50%); z-index: 10; width: 40px; height: 40px; border-radius: 50%; border: 2px solid rgba(255,255,255,0.5); background: rgba(255,255,255,0.18); color: white; font-size: 20px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s; }
    .navi:hover { background: rgba(255,255,255,0.35); }
    .nprev { left: 14px; }
    .nnext { right: 14px; }
    .dots { position: absolute; bottom: 16px; left: 50%; transform: translateX(-50%); display: flex; gap: 7px; z-index: 10; }
    .dot { width: 7px; height: 7px; border-radius: 50%; background: rgba(255,255,255,0.4); border: none; cursor: pointer; padding: 0; transition: all 0.3s; }
    .dot.on { background: white; width: 22px; border-radius: 4px; }
    .strip { background: #0d3d47; display: flex; }
    .si { flex: 1; padding: 13px 16px; text-align: center; border-right: 1px solid rgba(255,255,255,0.08); display: flex; flex-direction: column; align-items: center; gap: 3px; cursor: pointer; transition: background 0.2s; }
    .si:last-child { border-right: none; }
    .si:hover { background: rgba(255,255,255,0.06); }
    .si-ico { font-size: 18px; }
    .si-lbl { font-size: 11px; font-weight: 600; color: #cef4f9; }
    .si-sub { font-size: 10px; color: #6ab8c4; }
    .cnt { display: flex; gap: 6px; align-items: center; margin-top: 4px; }
    .cb { background: rgba(0,0,0,0.25); border-radius: 6px; padding: 5px 9px; text-align: center; color: white; }
    .cb .n { font-size: 18px; font-weight: 800; display: block; line-height: 1; }
    .cb .l { font-size: 8px; opacity: 0.65; letter-spacing: 1px; display: block; }
    .csep { font-size: 18px; font-weight: 800; color: white; opacity: 0.6; margin-bottom: 5px; }

    @media (max-width: 768px) {
      .slide { height: auto; min-height: 320px; padding: 30px 0; }
      .inner { flex-direction: column !important; padding: 0 24px; gap: 20px; text-align: center; }
      .txt { max-width: 100%; }
      .title { font-size: 30px; }
      .sub { max-width: 100%; }
      .vis { flex-wrap: wrap; justify-content: center; }
      .badges { justify-content: center; }
      .ftag { right: 16px; top: 12px; font-size: 11px; padding: 5px 10px; }
      .strip { flex-wrap: wrap; }
      .si { flex: calc(33.33% - 1px); min-width: 100px; }
    }
  </style>

<div class="cw">
  <div class="ct" id="track">

    <!-- ===================== SLIDE 1: Salud & Belleza ===================== -->
    <div class="slide" style="background:#29B5CA;">
      <div class="ftag" style="background:#fff;color:#0d7a8a;">⭐ NUEVO 2026</div>
      <div class="inner">
        <div class="txt">
          <div class="eyebrow" style="color:#0d3d47;">✦ SALUD &amp; BELLEZA</div>
          <div class="title" style="color:#fff;">Brilla<br><span style="color:#0d3d47;">sin límites</span></div>
          <div class="sub" style="color:rgba(255,255,255,0.9);">Skincare premium, maquillaje y cuidado personal con hasta 40% de descuento</div>
          <div class="badges">
            <span class="badge" style="background:#0d3d47;color:#a8ecf5;">Envío gratis</span>
            <span class="badge" style="background:rgba(255,255,255,0.25);color:#fff;border:1.5px solid rgba(255,255,255,0.5);">Pago en cuotas</span>
          </div>
          <!-- <button class="cta" style="background:#0d3d47;color:#a8ecf5;">Ver colección →</button> -->
        </div>
        <div class="vis">
          <div class="pcard">
            <span class="emo">🧴</span>
            <div class="pname">Sérum Vitamina C</div>
            <div class="pold">$89.900</div>
            <div class="pnew">$53.900</div>
          </div>
          <div class="pcard">
            <span class="emo">💄</span>
            <div class="pname">Labial Premium</div>
            <div class="pold">$45.000</div>
            <div class="pnew">$28.000</div>
          </div>
          <div class="pcard">
              <span class="emo">✨</span>
              <div class="pname">Sérum Retinol</div>
              <div class="pold">$72.000</div>
              <div class="pnew">$43.200</div>
            </div>
          <div style="display:flex;flex-direction:column;align-items:center;gap:8px;">
            
            <span class="pill-dcto" style="color:#0d7a8a;">40% DCTO</span>
          </div>
        </div>
      </div>
    </div>

    <!-- ===================== SLIDE 2: Moda & Ropa ===================== -->
    <div class="slide" style="background:#29B5CA;">
      <div class="ftag" style="background:#0d3d47;color:#a8ecf5;">TENDENCIA ↗</div>
      <div class="inner" style="flex-direction:row-reverse;">
        <div class="txt" style="text-align:right;">
          <div class="eyebrow" style="color:#0d3d47;">✦ MODA &amp; ROPA</div>
          <div class="title" style="color:#fff;">Moda que<br><span style="color:#0d3d47;">te define</span></div>
          <div class="sub" style="color:rgba(255,255,255,0.9);">Las últimas tendencias en ropa, zapatos y accesorios para todos los estilos</div>
          <div class="badges" style="justify-content:flex-end;">
            <span class="badge" style="background:#0d3d47;color:#a8ecf5;">Tallas S–3XL</span>
            <span class="badge" style="background:rgba(255,255,255,0.25);color:#fff;border:1.5px solid rgba(255,255,255,0.5);">+500 estilos</span>
          </div>
          <!-- <button class="cta" style="background:#0d3d47;color:#a8ecf5;">Ver colección →</button> -->
        </div>
        <div class="vis">
          <div class="pcard">
            <span class="emo">👗</span>
            <div class="pname">Vestido Floral</div>
            <div class="pold">$120.000</div>
            <div class="pnew">$79.900</div>
          </div>
          <div class="pcard">
            <span class="emo">👟</span>
            <div class="pname">Sneakers Urban</div>
            <div class="pold">$180.000</div>
            <div class="pnew">$119.900</div>
          </div>
          <div class="pcard">
            <span class="emo">👜</span>
            <div class="pname">Bolso Tejido</div>
            <div class="pold">$95.000</div>
            <div class="pnew">$59.900</div>
          </div>
        </div>
      </div>
    </div>

    <!-- ===================== SLIDE 3: Oferta Flash ===================== -->
    <div class="slide" style="background:#1a8fa0;">
      <div class="ftag" style="background:#fff;color:#0d7a8a;">⚡ OFERTA FLASH</div>
      <div style="position:absolute;top:70px;left:120px;color:#fff;z-index:4;text-align:left;">
        <div style="font-size:11px;color:rgba(255,255,255,0.7);margin-bottom:8px;letter-spacing:1.5px;">TERMINA EN:</div>
        <div class="cnt" style="justify-content:center;">
        <div class="cb"><span class="n" id="ch">05</span><span class="l">HRS</span></div>
        <div class="csep">:</div>
        <div class="cb"><span class="n" id="cm">42</span><span class="l">MIN</span></div>
        <div class="csep">:</div>
        <div class="cb"><span class="n" id="cs">18</span><span class="l">SEG</span></div>
        </div>
    </div>
      <div class="inner" style="flex-direction:column;text-align:center;gap:1px;justify-content:center;">
        <div>
          <div class="eyebrow" style="color:rgba(255,255,255,0.75);">⚡ SOLO HOY — OFERTA RELÁMPAGO</div>
          <div class="title" style="color:#fff;font-size:50px;">Hasta <span style="color:#0d3d47;">60% OFF</span></div>
          <div class="sub" style="color:rgba(255,255,255,0.9);margin:0 auto;max-width:480px;">En productos seleccionados de salud, belleza y moda</div>
        </div>
        <div style="display:flex;gap:25px;justify-content:center;flex-wrap:wrap;">
          <div style="text-align:center;color:white;background:rgba(0,0,0,0.15);border-radius:12px;padding:14px 20px;min-width:90px;">
            <div style="font-size:30px;margin-bottom:4px;">🌿</div>
            <div style="font-size:11px;opacity:0.8;">Cuidado Natural</div>
            <div style="font-size:18px;font-weight:800;">-55%</div>
          </div>
          <div style="text-align:center;color:white;background:rgba(0,0,0,0.15);border-radius:12px;padding:14px 20px;min-width:90px;">
            <div style="font-size:30px;margin-bottom:4px;">💆</div>
            <div style="font-size:11px;opacity:0.8;">Spa en Casa</div>
            <div style="font-size:18px;font-weight:800;">-60%</div>
          </div>
          <div style="text-align:center;color:white;background:rgba(0,0,0,0.15);border-radius:12px;padding:14px 20px;min-width:90px;">
            <div style="font-size:30px;margin-bottom:4px;">👜</div>
            <div style="font-size:11px;opacity:0.8;">Accesorios</div>
            <div style="font-size:18px;font-weight:800;">-45%</div>
          </div>
          <div style="text-align:center;color:white;background:rgba(0,0,0,0.15);border-radius:12px;padding:14px 20px;min-width:90px;">
            <div style="font-size:30px;margin-bottom:4px;">🧘</div>
            <div style="font-size:11px;opacity:0.8;">Bienestar</div>
            <div style="font-size:18px;font-weight:800;">-50%</div>
          </div>
        </div>
        <div><br></div>
      </div>
      <button class="cta" style="background:#0d3d47;color:#a8ecf5;font-size:15px;padding:14px 36px;align-self:center;">Ver todas las ofertas →</button>

    </div>

    <!-- ===================== SLIDE 4: Bienestar & Salud ===================== -->
    <div class="slide" style="background:#29B5CA;">
      <div class="ftag" style="background:#fff;color:#0d7a8a;">MÁS VENDIDOS</div>
      <div class="inner">
        <div class="txt">
          <div class="eyebrow" style="color:#0d3d47;">✦ BIENESTAR &amp; SALUD</div>
          <div class="title" style="color:#fff;">Tu mejor<br><span style="color:#0d3d47;">versión</span><br>comienza aquí</div>
          <div class="sub" style="color:rgba(255,255,255,0.9);">Vitaminas, suplementos y equipos para ejercicio</div>
          <div style="color:#fff;font-size:15px;letter-spacing:3px;margin-bottom:14px;">★★★★★</div>
          <div class="badges">
            <span class="badge" style="background:#0d3d47;color:#a8ecf5;">+10.000 clientes</span>
            <span class="badge" style="background:rgba(255,255,255,0.25);color:#fff;border:1.5px solid rgba(255,255,255,0.5);">Garantía 30 días</span>
          </div>
          <button class="cta" style="background:#0d3d47;color:#a8ecf5;">Explorar productos →</button>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px; margin-bottom:10px; top:-20px; position:relative;">
          <div class="pcard">
            <span class="emo" style="font-size:32px;">💊</span>
            <div class="pname">Vitamina D3</div>
            <div class="pnew" style="font-size:16px;">$32.000</div>
          </div>
          <div class="pcard">
            <span class="emo" style="font-size:32px;">🏋️</span>
            <div class="pname">Proteína Whey</div>
            <div class="pnew" style="font-size:16px;">$89.900</div>
          </div>
          <div class="pcard">
            <span class="emo" style="font-size:32px;">🧘</span>
            <div class="pname">Kit Yoga</div>
            <div class="pnew" style="font-size:16px;">$64.000</div>
          </div>
          <div class="pcard">
            <span class="emo" style="font-size:32px;">🫐</span>
            <div class="pname">Colágeno Plus</div>
            <div class="pnew" style="font-size:16px;">$45.000</div>
          </div>
        </div>
      </div>
    </div>

  </div><!-- fin track -->

  <button class="navi nprev" id="prev">&#8249;</button>
  <button class="navi nnext" id="next">&#8250;</button>
  <div class="dots" id="dots">
    <button class="dot on" onclick="go(0)"></button>
    <button class="dot" onclick="go(1)"></button>
    <button class="dot" onclick="go(2)"></button>
    <button class="dot" onclick="go(3)"></button>
  </div>
</div><!-- fin cw -->

<!-- Barra de beneficios -->
<div class="strip">
  <div class="si"><span class="si-ico">🚚</span><span class="si-lbl">Envío gratis</span><span class="si-sub">Compras +$80.000</span></div>
  <div class="si"><span class="si-ico">🔒</span><span class="si-lbl">Pago seguro</span><span class="si-sub">Todas las tarjetas</span></div>
  <div class="si"><span class="si-ico">↩️</span><span class="si-lbl">Devoluciones</span><span class="si-sub">30 días sin costo</span></div>
  <div class="si"><span class="si-ico">💬</span><span class="si-lbl">Soporte 24/7</span><span class="si-sub">Chat y WhatsApp</span></div>
  <div class="si"><span class="si-ico">🎁</span><span class="si-lbl">Regalo gratis</span><span class="si-sub">En tu 1a compra</span></div>
</div>

<script>
  let cur = 0, tot = 4, timer;
  const tr = document.getElementById('track');
  const ds = document.querySelectorAll('.dot');

  function go(n) {
    cur = (n + tot) % tot;
    tr.style.transform = 'translateX(-' + (cur * 100) + '%)';
    ds.forEach((d, i) => d.classList.toggle('on', i === cur));
    clearInterval(timer);
    timer = setInterval(() => go(cur + 1), 5000);
  }

  document.getElementById('prev').onclick = () => go(cur - 1);
  document.getElementById('next').onclick = () => go(cur + 1);
  timer = setInterval(() => go(cur + 1), 5000);

  // Contador regresivo
  let s = 5 * 3600 + 42 * 60 + 18;
  setInterval(() => {
    s = Math.max(0, s - 1);
    const p = n => String(n).padStart(2, '0');
    document.getElementById('ch').textContent = p(Math.floor(s / 3600));
    document.getElementById('cm').textContent = p(Math.floor((s % 3600) / 60));
    document.getElementById('cs').textContent = p(s % 60);
  }, 1000);

  // Soporte táctil / swipe
  tr.addEventListener('touchstart', e => { tr._x = e.touches[0].clientX; });
  tr.addEventListener('touchend', e => {
    const d = tr._x - e.changedTouches[0].clientX;
    if (Math.abs(d) > 40) go(cur + (d > 0 ? 1 : -1));
  });
</script>
