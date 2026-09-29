/**
 * Section components. One export per template-parts/sections/*.php file.
 */
const { figure, btn, link, eyebrow, FACTS } = require('./components');

/* --- 01 hero (rotating) --------------------------------------------------- */

const SLIDES = [
  ['hero-slide-1', 'Macro photograph of mixed green, amber and clear glass cullet catching natural light.',
   ['Turning waste glass', 'into valuable', 'raw material.']],
  ['hero-slide-2', '', ['Glass for', 'the next cycle.']],
  ['hero-slide-3', '', ['Cullets for', 'the next generation.']],
  ['hero-slide-4', '', ['Processed glass.', 'Ready for its next cycle.']],
];

function hero() {
  const media = SLIDES.map(([name, alt], i) =>
    `    <div class="rc-hero__slide${i === 0 ? ' is-active' : ''}" data-rc-slide="${i}">
      ${figure({ name, alt, tag: 'div', w: 2400, h: 1350, eager: i === 0 })}
    </div>`).join('\n');

  const taglines = SLIDES.map(([, , lines], i) =>
    `        <span class="rc-tagline${i === 0 ? ' is-active' : ''}" data-rc-tagline="${i}"${i === 0 ? '' : ' aria-hidden="true"'}>
${lines.map((t, l) => `          <span class="rc-tagline__line" style="--rc-i:${l}"><span>${t}</span></span>`).join('\n')}
        </span>`).join('\n');

  const bars = SLIDES.map((_, i) =>
    `            <li class="rc-hero__bar-item"><button type="button" class="rc-hero__bar${i === 0 ? ' is-active' : ''}" data-rc-goto="${i}"${i === 0 ? ' aria-current="true"' : ''}><span class="rc-sr-only">Show slide ${i + 1} of ${SLIDES.length}</span><span class="rc-hero__bar-fill" aria-hidden="true"></span></button></li>`).join('\n');

  return `
<section class="rc-hero" data-rc-hero data-nav="dark">
  <div class="rc-hero__media rc-scrim">
${media}
  </div>
  <div class="rc-hero__inner rc-container rc-container--wide">
    <div class="rc-hero__content">
      <div class="rc-reveal" style="--rc-i:0">${eyebrow('Glass Cullet / Serving Pan-India')}</div>
      <h1 class="rc-display-1 rc-hero__title">
${taglines}
      </h1>
      <p class="rc-lede rc-hero__lede rc-reveal" style="--rc-i:4">We collect, sort and process glass cullet for reuse in the glass manufacturing cycle.</p>
      <div class="rc-hero__actions rc-reveal" style="--rc-i:5">
        ${btn('Explore our cullet', 'glass-cullet.html')}
        ${btn('Our story', 'about.html', 'secondary', false)}
      </div>
      <div class="rc-hero__controls rc-reveal" style="--rc-i:6" data-rc-hero-controls>
        <button type="button" class="rc-hero__toggle" data-rc-hero-toggle aria-pressed="false">
          <span class="rc-hero__toggle-icon" aria-hidden="true"></span>
          <span class="rc-hero__toggle-text">Pause</span>
        </button>
        <ol class="rc-hero__bars">
${bars}
        </ol>
      </div>
      <p class="rc-hero__cue rc-reveal" style="--rc-i:7">Scroll to discover <span aria-hidden="true">&darr;</span></p>
    </div>
  </div>
</section>`;
}

/* --- page hero (inner pages) ---------------------------------------------- */

function pageHero(eb, title, lede) {
  return `
<section class="rc-section rc-section--tight rc-surface-paper rc-page-hero" style="padding-top:calc(var(--rc-header-h) + var(--rc-space-9))">
  <div class="rc-container rc-container--wide">
    <div class="rc-section-head rc-reveal">
      ${eb ? eyebrow(eb) : ''}
      <h1 class="rc-display-1" style="font-size:var(--rc-size-h2)">${title}</h1>
      ${lede ? `<p class="rc-lede">${lede}</p>` : ''}
    </div>
  </div>
</section>`;
}

/* --- 02 stats -------------------------------------------------------------- */

function stats() {
  const rows = [
    [`${FACTS.founded}`, null, '', 'Established'],
    [`${FACTS.combined}+`, FACTS.combined, '+', 'Years of combined experience'],
    [`${FACTS.companies}+`, FACTS.companies, '+', 'Companies served'],
    [`${FACTS.states}+`, FACTS.states, '+', 'States served, pan-India'],
  ];
  return `
<section class="rc-section rc-section--tight rc-surface-paper" aria-label="Company at a glance">
  <div class="rc-container rc-container--wide">
    <div class="rc-stats">
${rows.map(([val, count, suffix, label], i) => `      <div class="rc-stat rc-reveal" style="--rc-i:${i}">
        <span class="rc-stat__value rc-counter"${count ? ` data-rc-count="${count}" data-rc-suffix="${suffix}"` : ''}>${val}</span>
        <span class="rc-stat__label">${label}</span>
      </div>`).join('\n')}
    </div>
  </div>
</section>`;
}

/* --- 03 intro -------------------------------------------------------------- */

function intro() {
  return `
<section class="rc-section rc-surface-paper" aria-labelledby="rc-intro-title">
  <div class="rc-container rc-container--wide">
    <div class="rc-split rc-split--7-5">
      <div class="rc-reveal">
        ${eyebrow('Introduction')}
        <h2 class="rc-display-2 rc-intro__statement" id="rc-intro-title" style="margin-top:var(--rc-space-5)">Glass does not have to end its journey as waste.</h2>
        <div class="rc-intro__body rc-stack">
          <p class="rc-body">Rian Cullet collects, sorts and processes glass that has already served its first purpose. Sorted by type and colour and prepared to a consistent standard, it returns to the furnace as raw material rather than being treated as waste.</p>
          <p class="rc-body">That work keeps recoverable glass out of landfill and gives glass manufacturers a dependable source of recycled material.</p>
          <p>${link('What is glass cullet', 'glass-cullet.html')}</p>
        </div>
      </div>
      <div class="rc-intro__media rc-reveal" style="--rc-i:1">
        ${figure({ name: 'intro-cullet-macro', alt: 'Close-up of sorted glass cullet fragments showing colour and texture.', ratio: 'rc-ratio-portrait', cls: 'rc-zoom', w: 1200, h: 1500 })}
      </div>
    </div>
  </div>
</section>`;
}


/* --- 04 process ------------------------------------------------------------ */

const STAGES = [
  ['Collection', 'Glass is sourced from relevant industrial and post-consumer streams.'],
  ['Sorting', 'Material is separated according to relevant characteristics such as type and colour.'],
  ['Processing', 'Recovered glass is prepared into usable cullet.'],
  ['Supply', 'Processed cullet is supplied for reuse in glass manufacturing.'],
];

function process(showLink = true) {
  return `
<section class="rc-section rc-surface-green" data-nav="dark" aria-labelledby="rc-process-title">
  <div class="rc-container rc-container--wide">
    <div class="rc-split rc-split--5-7 rc-split--sticky">
      <div class="rc-split__aside rc-process__head rc-reveal">
        ${eyebrow('Process')}
        <h2 class="rc-display-2" id="rc-process-title" style="margin-top:var(--rc-space-5)">From discarded glass to industrial resource.</h2>
        <p class="rc-body" style="margin-top:var(--rc-space-6)">Four stages turn recovered glass into a material a furnace can accept.</p>
        ${showLink ? `<p style="margin-top:var(--rc-space-6)">${link('See the full process', 'process.html')}</p>` : ''}
      </div>
      <div class="rc-process__track" data-rc-process>
        <div class="rc-process__rail rc-progress" aria-hidden="true"><span class="rc-progress__fill"></span></div>
        <ol style="list-style:none;margin:0;padding:0;display:grid;gap:inherit">
${STAGES.map(([t, b], i) => `          <li class="rc-step rc-reveal">
            <span class="rc-index rc-step__index">${String(i + 1).padStart(2, '0')}</span>
            <h3 class="rc-h3 rc-step__title">${t}</h3>
            <p class="rc-step__body">${b}</p>
          </li>`).join('\n')}
        </ol>
      </div>
    </div>
  </div>
</section>`;
}

/* --- 05 product ------------------------------------------------------------ */

const PRODUCTS = [
  ['01', 'Factory Cullet', 'Glass generated during manufacturing.',
   'Factory cullet is produced inside flat glass or container glass plants. It is the glass waste that arises during the manufacturing process itself, in either the flat glass or the container glass industry.',
   'factory-cullet', 'Large piles of glass cullet in the yard of a glass manufacturing plant.'],
  ['02', 'Foreign Cullet', 'Post-consumer glass, recovered for reuse.',
   'Foreign cullet, also known as external or post-consumer cullet, is waste glass collected after consumption. It may be container glass or flat glass, gathered from municipal waste streams and other relevant sources.',
   'foreign-cullet', 'Post-consumer foreign cullet sorted for processing.'],
  ['03', 'Flint (White) Cullet', 'Clear, colourless glass, kept apart from colour.',
   'Flint is the glass trade’s name for clear, colourless glass. Flint cullet is sorted and processed separately from amber and green glass, which keeps it suitable for the production of clear glass.',
   'flint-cullet', 'Clear flint glass cullet, crushed and sorted.'],
];

function product() {
  return `
<section class="rc-section rc-surface-paper" aria-labelledby="rc-product-title">
  <div class="rc-container rc-container--wide">
    <div class="rc-section-head rc-reveal">
      ${eyebrow('Material')}
      <h2 class="rc-display-2" id="rc-product-title">Our glass cullet</h2>
      <p class="rc-lede">Processed glass. Ready for its next cycle.</p>
    </div>
    <div class="rc-products rc-cols rc-cols--3">
${PRODUCTS.map(([idx, name, lead, body, img, alt], i) => `      <a class="rc-card rc-reveal" href="glass-cullet.html" style="--rc-i:${i}">
        <div class="rc-card__body">
          <div class="rc-product__meta"><h3 class="rc-h3">${name}</h3><span class="rc-index">${idx}</span></div>
          <p class="rc-lede" style="font-size:var(--rc-size-body)">${lead}</p>
        </div>
        <div class="rc-product__media">${figure({ name: img, alt, ratio: 'rc-ratio-portrait', cls: 'rc-zoom', w: 1200, h: 1500 })}</div>
        <div class="rc-card__body"><p class="rc-body">${body}</p></div>
      </a>`).join('\n')}
    </div>
  </div>
</section>`;
}

/* --- 06 colour ------------------------------------------------------------- */

const COLOURS = [
  ['Clear / White', 'clear-glass', 'Clear glass cullet fragments in natural light.'],
  ['Amber', 'amber-glass', 'Amber glass cullet fragments in natural light.'],
  ['Green', 'green-glass', 'Green glass cullet fragments in natural light.'],
];

function colour() {
  return `
<section class="rc-section rc-surface-paper" aria-labelledby="rc-colour-title">
  <div class="rc-container rc-container--wide">
    <div class="rc-colour__head rc-section-head rc-reveal">
      ${eyebrow('Colour')}
      <h2 class="rc-display-2" id="rc-colour-title">Every colour has another cycle.</h2>
      <p class="rc-lede">Cullet is sorted by colour because colour determines where the glass can go next.</p>
    </div>
  </div>
  <div class="rc-colour__panels rc-bleed">
${COLOURS.map(([name, img, alt], i) => `    <figure class="rc-panel rc-zoom rc-scrim rc-ratio-panel rc-reveal" style="--rc-i:${i}">
      ${figure({ name: img, alt, cls: 'rc-panel__figure', tag: 'div', w: 1200, h: 1600 })}
      <figcaption class="rc-panel__caption">
        <span class="rc-panel__name">${name}</span>
        <span class="rc-panel__index">${String(i + 1).padStart(2, '0')}</span>
      </figcaption>
    </figure>`).join('\n')}
  </div>
</section>`;
}

/* --- 07 why ---------------------------------------------------------------- */

const REASONS = [
  ['Lower melting requirements', 'Cullet can help reduce the melting temperature required in glass manufacturing.'],
  ['Energy efficiency', 'Using recycled glass as a raw material can contribute to lower energy requirements, and to the emissions associated with them.'],
  ['Circular manufacturing', 'Recovered glass can be returned to the manufacturing cycle rather than being treated solely as waste.'],
];

function why() {
  return `
<section class="rc-section rc-surface-paper" aria-labelledby="rc-why-title">
  <div class="rc-container rc-container--wide">
    <div class="rc-section-head rc-reveal">
      ${eyebrow('Why cullet matters')}
      <h2 class="rc-display-2" id="rc-why-title">Why recycled glass matters</h2>
    </div>
    <div class="rc-why__cols rc-cols rc-cols--3 rc-ruled-cols">
${REASONS.map(([t, b], i) => `      <div class="rc-reveal" style="--rc-i:${i}">
        <span class="rc-index">${String(i + 1).padStart(2, '0')}</span>
        <h3 class="rc-h3 rc-why__title">${t}</h3>
        <p class="rc-body">${b}</p>
      </div>`).join('\n')}
    </div>
    <p class="rc-mega rc-why__statement rc-reveal">Waste becomes input.</p>
  </div>
</section>`;
}
/* --- 08 founder (no portrait, by decision) --------------------------------- */

function founder(showLink = true) {
  return `
<section class="rc-section rc-surface-paper rc-founder" aria-labelledby="rc-founder-title">
  <div class="rc-container rc-container--wide"><hr class="rc-rule"></div>
  <div class="rc-container rc-container--text rc-founder__inner">
    <div class="rc-reveal">
      ${eyebrow('Our story')}
      <h2 class="rc-display-2 rc-founder__statement" id="rc-founder-title">A vision that began in ${FACTS.founded}.</h2>
    </div>
    <div class="rc-founder__body rc-stack rc-reveal" style="--rc-i:1">
      <p class="rc-body">The journey of Rian Cullet is driven by the vision and leadership of its founder, Ms. Indu Bhatia. With a strong focus on sustainability and responsible waste management, she established the foundation for a business dedicated to transforming waste glass into a valuable and reusable resource.</p>
      <p class="rc-body">Her vision has been to create a reliable source of quality glass cullet for the glass manufacturing industry while contributing towards a cleaner and more sustainable environment.</p>
    </div>
    <div class="rc-founder__signature rc-reveal" style="--rc-i:2">
      <p class="rc-founder__name">Ms. Indu Bhatia</p>
      <p class="rc-founder__role">Founder, Rian Cullet</p>
    </div>
    ${showLink ? `<p class="rc-founder__more rc-reveal" style="--rc-i:3">${link('Read our story', 'about.html')}</p>` : ''}
  </div>
  <div class="rc-container rc-container--wide"><hr class="rc-rule"></div>
</section>`;
}

/* --- 09 heritage ----------------------------------------------------------- */

function heritage() {
  const points = [
    ['Generations', 'Experience in glass cullet, carried from one generation to the next.'],
    [`${FACTS.founded}`, 'Rian Cullet established in Delhi.'],
    [`${FACTS.companies}+`, 'Companies served across the glass manufacturing and recycling ecosystem.'],
    ['Today', `Serving pan-India, across ${FACTS.states}+ states.`],
  ];
  return `
<section class="rc-section rc-surface-ink" data-nav="dark" aria-labelledby="rc-heritage-title">
  <div class="rc-container rc-container--wide">
    <div class="rc-split rc-split--6-6">
      <div class="rc-reveal">
        ${eyebrow('Heritage')}
        <span class="rc-mega rc-heritage__year" id="rc-heritage-title" style="margin-top:var(--rc-space-5)">${FACTS.combined}+<span class="rc-sr-only"> years of combined experience</span></span>
      </div>
      <div class="rc-reveal" style="--rc-i:1">
        <p class="rc-lede rc-heritage__lede">Years of combined experience, built across generations.</p>
        <p class="rc-body" style="margin-top:var(--rc-space-5)">Rian Cullet is a generational business. Established in Delhi in ${FACTS.founded}, it brings that experience to the collection, sorting, processing and recycling of foreign and post-consumer glass cullet, serving customers pan-India.</p>
      </div>
    </div>
    <ol class="rc-timeline">
${points.map(([m, l], i) => `      <li class="rc-timeline__item rc-reveal" style="--rc-i:${i}">
        <span class="rc-index rc-timeline__marker">${m}</span>
        <p class="rc-timeline__label">${l}</p>
      </li>`).join('\n')}
    </ol>
  </div>
</section>`;
}

/* --- 10 sustainability flow ------------------------------------------------ */

const FLOW = [
  ['Waste glass', 'Glass that has served its first purpose.'],
  ['Recovery', 'Collected from relevant streams.'],
  ['Sorting', 'Separated by type and colour.'],
  ['Processing', 'Prepared into usable cullet.'],
  ['Cullet', 'Ready for the furnace.'],
  ['New glass', 'Returned to manufacturing.'],
];

function sustainability(showLink = true) {
  return `
<section class="rc-section rc-surface-paper" aria-labelledby="rc-sustainability-title">
  <div class="rc-container rc-container--wide">
    <div class="rc-section-head rc-reveal">
      ${eyebrow('Sustainability')}
      <h2 class="rc-display-2" id="rc-sustainability-title">Building a more circular glass industry</h2>
      <p class="rc-lede">Glass that is recovered, sorted and processed can re-enter manufacturing as raw material. The cycle closes rather than ending at landfill.</p>
    </div>
    <ol class="rc-flow" data-rc-process>
${FLOW.map(([l, n], i) => `      <li class="rc-flow__node rc-step rc-reveal" style="--rc-i:${i}"><span class="rc-flow__label">${l}</span><span class="rc-flow__note">${n}</span></li>`).join('\n')}
    </ol>
    ${showLink ? `<p style="margin-top:var(--rc-space-8)">${link('Our approach to sustainability', 'sustainability.html')}</p>` : ''}
  </div>
</section>`;
}
/* --- 11 cta ---------------------------------------------------------------- */

function cta() {
  return `
<section class="rc-section rc-surface-green" data-nav="dark" aria-labelledby="rc-cta-title">
  <div class="rc-container rc-container--wide">
    <div class="rc-cta__inner rc-reveal">
      ${eyebrow('Enquiries')}
      <h2 class="rc-display-2" id="rc-cta-title" style="margin-top:var(--rc-space-5)">Looking for a reliable glass cullet source?</h2>
      <p class="rc-lede" style="margin-top:var(--rc-space-5)">Connect with our team to discuss your material requirements.</p>
      <div class="rc-cta__actions">
        ${btn('Send an enquiry', 'contact.html#rc-enquiry')}
        ${btn('Contact us', 'contact.html', 'secondary', false)}
      </div>
    </div>
  </div>
</section>`;
}

/* --- 12 contact ------------------------------------------------------------ */

const FIELDS = [
  ['Name', 'text', true], ['Company', 'text', false],
  ['Email', 'email', true], ['Phone', 'tel', false],
];

function contact() {
  return `
<section class="rc-section rc-surface-paper" id="rc-enquiry" aria-labelledby="rc-contact-title">
  <div class="rc-container rc-container--wide">
    <div class="rc-split rc-split--4-8">
      <div class="rc-reveal">
        ${eyebrow('Contact')}
        <h2 class="rc-display-3" id="rc-contact-title" style="margin-top:var(--rc-space-5)">Discuss material requirements</h2>
        <div class="rc-contact__group" style="margin-top:var(--rc-space-7)">
          <p class="rc-eyebrow rc-eyebrow--plain" style="color:var(--rc-ink-muted)">Registered address</p>
          <address class="rc-contact__details rc-body" style="margin-top:var(--rc-space-4)">
            <span><strong>Rian Cullet</strong></span>
            <span>Khasra No. 45/23, 8 Tikri Kalan</span>
            <span>Delhi &ndash; 110041</span>
            <span>India</span>
          </address>
        </div>
      </div>
      <div class="rc-reveal" style="--rc-i:1">
        <div class="rc-contact__form">
          <form class="rc-form" method="post" action="#" novalidate>
${FIELDS.map(([label, type, req]) => `            <div class="rc-field"><label class="rc-label" for="f-${label.toLowerCase()}">${label}${req ? ' <span class="rc-label__req" aria-hidden="true">*</span>' : ''}</label><input class="rc-input" type="${type}" id="f-${label.toLowerCase()}" name="${label.toLowerCase()}"></div>`).join('\n')}
            <div class="rc-field rc-field--full"><label class="rc-label" for="f-req">Material requirement</label>
              <select class="rc-select" id="f-req" name="requirement">
                <option value="">Select an option</option>
                <option value="factory">Factory cullet</option>
                <option value="foreign">Foreign / post-consumer cullet</option>
                <option value="flint">Flint (white) cullet</option>
                <option value="multiple">More than one</option>
                <option value="other">Other / not sure yet</option>
              </select>
            </div>
            <div class="rc-field rc-field--full"><label class="rc-label" for="f-message">Message <span class="rc-label__req" aria-hidden="true">*</span></label><textarea class="rc-textarea" id="f-message" name="message" rows="6"></textarea></div>
            <div class="rc-contact__submit"><button type="submit" class="rc-btn rc-btn--primary">Submit enquiry <span class="rc-btn__arrow" aria-hidden="true">&rarr;</span></button></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>`;
}

module.exports = {
  hero, pageHero, stats, intro, process, product, colour,
  why, founder, heritage, sustainability, cta, contact,
};
