/*! painel-acompanhamento 2017-09-13 */

function disableDefaultLinkAction(){menu=document.querySelector("div.menu").querySelectorAll("a.btn"),this.addEventListener("click",function(e){e.preventDeafult()})}function requestFields(e,t){var n;return e.get(t).then(function(e){if(e.data.length<=0)return!1;n=e.data}),n}