/*! painel-acompanhamento 2017-09-12 */

function requestFields(t,e){var n;return t.get(e).then(function(t){if(t.data.length<=0)return!1;n=t.data}),n}