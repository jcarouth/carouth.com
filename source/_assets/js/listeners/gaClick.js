export function trackGaClick (e) {
  let $el = e.target;
  let label = $el.textContent.trim();
  let data = {
    'template': null,
    'module': null,
    'element': null,
    'item': null,
    'position': null,
  };

  if ($el.tagName.toLowerCase() === 'a') {
    label = $el.href;
  }

  for (let node = e.target; node && node.tagName.toLowerCase() !== 'html'; node = node.parentNode ) {
    let gaAttrs = Array.from(node.attributes)
      .filter( attr => /^data-ga/.test(attr.nodeName))
      .filter( attr => attr.nodeName !== 'data-ga-click');

    gaAttrs.forEach( (attr) => {
      let { name, value } = attr;
      name = name.replace('data-ga-', '');

      if (data[name] === null) {
        data[name] = value;
      }
    });
  }

  $el.classList.add('ga-click-set');

  gtag('event', data.element, {
    'event_category': 'clicks',
    'event_label': label,
    'dimension1': data.template,
    'dimension2': data.module,
    'dimension3': data.element,
    'dimension4': data.item,
    'dimension5': data.position,
  })
}
