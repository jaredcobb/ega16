/* global jQuery Cookies EGA16 Audio */
(function audioInstance($) {
  const audio = {

    // OBJECT PROPERTIES
    $body: $('body'),
    $toggleButton: $('a.audio-toggle'),
    audioStatus: Cookies.get('ega16_audio_status'),
    audioObject: null,

    // REGISTER EVENT HANDLERS
    initialize() {
      const self = this;
      self.initializeCookies();

      if (self.audioStatus === 'on') {
        self.$toggleButton.text('Sound: on');

        if (EGA16.audio_page_hash !== 'undefined') {
          $.each(EGA16.audio_page_hash, (index, value) => {
            if (self.$body.hasClass(index)) {
              self.audioObject = new Audio(value);
              self.audioObject.play();
            }
          });
        }
      }

      self.$toggleButton.on('click', self.toggleAudio);
    },

    initializeCookies() {
      const self = this;
      if (typeof self.audioStatus === 'undefined' || self.audioStatus === null) {
        self.audioStatus = 'off';
        Cookies.set('ega16_audio_status', self.audioStatus);
      }
    },

    toggleAudio() {
      const self = audio;
      if (self.audioStatus === 'on') {
        self.audioStatus = 'off';
        self.$toggleButton.text('Sound: off');
        if (self.audioObject !== null) {
          self.audioObject.pause();
        }
      } else {
        self.audioStatus = 'on';
        self.$toggleButton.text('Sound: on');
        if (
          typeof EGA16.audio_toggle_file !== 'undefined'
          && EGA16.audio_toggle_file.length
        ) {
          self.audioObject = new Audio(EGA16.audio_toggle_file);
          self.audioObject.play();
        }
      }

      Cookies.set('ega16_audio_status', self.audioStatus);
    },

  };

  $(() => {
    audio.initialize();
  });
}(jQuery));

