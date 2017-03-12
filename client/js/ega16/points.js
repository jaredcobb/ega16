/* global jQuery Cookies EGA16 */
(function pointsInstance($) {
  const points = {

    // OBJECT PROPERTIES
    $body: $('body'),
    $document: $(document),
    $scoreWrapper: $('#game-header span.score'),
    $winModal: $('#ega-win'),
    score: Cookies.get('ega16_score'),
    awardedClicks: Cookies.get('ega16_awarded_clicks'),
    awardedPages: Cookies.get('ega16_awarded_pages'),

    // REGISTER EVENT HANDLERS
    initialize() {
      const self = this;
      self.initializeCookies();

      if (EGA16.points_enabled === '1') {
        if (typeof EGA16.points_page_selectors !== 'undefined') {
          for (let i = 0; i < EGA16.points_page_selectors.length; i += 1) {
            if (
              self.$body.hasClass(EGA16.points_page_selectors[i])
              && ($.inArray(EGA16.points_page_selectors[i], self.awardedPages) === -1)
            ) {
              self.awardedPages.push(EGA16.points_page_selectors[i]);
              Cookies.set('ega16_awarded_pages', self.awardedPages);
              self.score += 20;
              Cookies.set('ega16_score', self.score);
              self.refreshScore();
            }
          }
        }

        if (typeof EGA16.points_click_selectors !== 'undefined') {
          for (let i = 0; i < EGA16.points_click_selectors.length; i += 1) {
            $(EGA16.points_click_selectors[i])
              .data('click-selector', EGA16.points_click_selectors[i])
              .on('click', self.awardClickPoints);
          }
        }
      }
    },

    initializeCookies() {
      const self = this;
      if (typeof self.score === 'undefined' || self.score === null) {
        self.score = 0;
        Cookies.set('ega16_score', self.score);
      } else {
        self.score = parseInt(self.score, 10);
      }
      if (typeof self.awardedClicks === 'undefined' || self.awardedClicks === null) {
        self.awardedClicks = [];
        Cookies.set('ega16_awarded_clicks', self.awardedClicks);
      } else {
        self.awardedClicks = JSON.parse(self.awardedClicks);
      }
      if (typeof self.awardedPages === 'undefined' || self.awardedPages === null) {
        self.awardedPages = [];
        Cookies.set('ega16_awarded_pages', self.awardedPages);
      } else {
        self.awardedPages = JSON.parse(self.awardedPages);
      }
    },

    awardClickPoints() {
      const self = points;
      const clickSelector = $(this).data('click-selector');
      if ($.inArray(clickSelector, self.awardedClicks) === -1) {
        self.awardedClicks.push(clickSelector);
        Cookies.set('ega16_awarded_clicks', self.awardedClicks);
        self.score += 20;
        Cookies.set('ega16_score', self.score);
        self.refreshScore();
      }
    },

    refreshScore() {
      const self = points;
      self.$scoreWrapper.text(self.score);
      if (parseInt(self.score, 10) === parseInt(EGA16.points_total, 10)) {
        self.displayWinner();
      }
    },

    displayWinner() {
      const self = points;
      const data = {
        action: 'get_win_content',
        nextNonce: EGA16.nonce,
      };
      $.post(EGA16.ajaxurl, data, (response) => {
        self.$winModal.html(response).foundation('open');
      });
    },

  };

  $(() => {
    points.initialize();
  });
}(jQuery));
