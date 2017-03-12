/* global jQuery Cookies XMLHttpRequest EGA16 Image */
(function crtInstance($) {
  const crt = {

    // OBJECT PROPERTIES
    $body: $('body'),
    $toggleButton: $('.crt-toggle a'),
    crtStatus: Cookies.get('ega16_crt_status'),
    hexJSON: null,
    rgbColors: [],

    // REGISTER EVENT HANDLERS
    initialize() {
      const self = this;

      // setup cookie data
      self.initializeCookies();

      // load the JSON hex color palette
      self.loadJSON((response) => {
        self.sassVariables = JSON.parse(response);
        self.parseHexObject();
        if (self.crtStatus === 'on') {
          self.drawImages();
        }
      });

      // event handler if the crt toggle button exists
      if (self.$toggleButton.length) {
        self.$toggleButton.on('click', self.toggleCRT);
      }
    },

    /**
     * Setup default cookie data
     */
    initializeCookies() {
      const self = this;
      if (typeof self.crtStatus === 'undefined' || self.score === null) {
        self.crtStatus = 'off';
        Cookies.set('ega16_crt_status', self.crtStatus);
      }
    },

    /**
     * Toggle the CRT monitor effect
     */
    toggleCRT() {
      const self = crt;

      if (self.crtStatus === 'on') {
        self.$body.removeClass('crt-on')
          .removeClass('crt-toggle-on')
          .addClass('crt-toggle-off');
        self.crtStatus = 'off';
        $('canvas.pixelated').remove();
        self.$toggleButton.text('CRT: off');
      } else {
        self.$body.removeClass('crt-toggle-off')
          .addClass('crt-on')
          .addClass('crt-toggle-on');
        self.crtStatus = 'on';
        self.drawImages();
        self.$toggleButton.text('CRT: on');
      }

      Cookies.set('ega16_crt_status', self.crtStatus);
    },

    /**
     * Helper method to load JSON file
     */
    loadJSON(callback) {
      const xobj = new XMLHttpRequest();
      xobj.overrideMimeType('application/json');
      xobj.open('GET', `${EGA16.template_directory}/static/js/palette.json`, true);
      xobj.onreadystatechange = function routeResponse() {
        if (xobj.readyState === 4 && xobj.status === 200) {
          callback(xobj.responseText);
        }
      };
      xobj.send(null);
    },

    /**
     * Use canvas to limit color scheme and pixelate the images
     */
    drawImages() {
      const self = this;
      const imageElements = document.querySelectorAll('#page img:not(.no-crt)');
      let w;
      let h;
      for (let i = 0; i < imageElements.length; i += 1) {
        const size = 0.5;
        const canvas = document.createElement('canvas');
        const pixelatedCanvas = document.createElement('canvas');
        canvas.width = imageElements[i].width;
        canvas.height = imageElements[i].height;
        pixelatedCanvas.width = imageElements[i].width;
        pixelatedCanvas.height = imageElements[i].height;

        w = canvas.width * size;
        h = canvas.height * size;
        const ctx = canvas.getContext('2d');
        const pctx = pixelatedCanvas.getContext('2d');

        const pixelatedImage = new Image();
        pixelatedImage.src = imageElements[i].src;

        ctx.mozImageSmoothingEnabled = false;
        ctx.webkitImageSmoothingEnabled = false;
        ctx.imageSmoothingEnabled = false;

        pctx.drawImage(pixelatedImage, 0, 0, w, h);

        let imageData = null;

        try {
          imageData = pctx.getImageData(0, 0, pixelatedCanvas.width, pixelatedCanvas.height);
        } catch (e) {
          imageData = null;
        }

        if (imageData !== null) {
          const data = imageData.data;

          let mappedColor;
          for (let j = 0; j < data.length; j += 4) {
            mappedColor = self.mapColorToPalette(data[j], data[j + 1], data[j + 2]);
            if (
              data[j + 3] > 10
            ) {
              data[j] = mappedColor.r;
              data[j + 1] = mappedColor.g;
              data[j + 2] = mappedColor.b;
            }
          }
          pctx.putImageData(imageData, 0, 0);
          ctx.drawImage(pixelatedCanvas, 0, 0, w, h, 0, 0, canvas.width, canvas.height);
        } else {
          ctx.drawImage(pixelatedCanvas, 0, 0, w, h, 0, 0, canvas.width, canvas.height);
        }

        const imageClasses = imageElements[i].className.split(/\s+/);
        if (imageClasses.length) {
          for (let j = 0; j < imageClasses.length; j += 1) {
            if (imageClasses[j].length) {
              canvas.classList.add(imageClasses[j]);
            }
          }
        }
        canvas.classList.add('pixelated');
        imageElements[i].parentNode.appendChild(canvas);
      }
    },

    /**
     * Find the closest RGB match from a pixel and
     * map it to the predefined 16 color palette
     */
    mapColorToPalette(red, green, blue) {
      const self = crt;
      let distance = 25000;
      let color;
      let diffR;
      let diffG;
      let diffB;
      let diffDistance;
      let mappedColor;
      if (self.rgbColors.length > 0) {
        for (let i = 0; i < self.rgbColors.length; i += 1) {
          color = self.rgbColors[i];
          diffR = (color.r - red);
          diffG = (color.g - green);
          diffB = (color.b - blue);
          diffDistance = (diffR * diffR) + (diffG * diffG) + (diffB * diffB);
          if (diffDistance < distance) {
            distance = diffDistance;
            mappedColor = self.rgbColors[i];
          }
        }
      }
      return (mappedColor);
    },

    /**
     * Helper method to convert a the hex values to a
     * new RGB object
     */
    parseHexObject() {
      const self = this;
      $.each(self.sassVariables, (key, value) => {
        self.rgbColors.push(self.hexToRgb(value));
      });
    },

    /**
     * Helper method to convert a hex color to RGB color
     */
    hexToRgb(hex) {
      const shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
      let parsedHex = hex;
      parsedHex = parsedHex.replace(shorthandRegex, (m, r, g, b) => r + r + g + g + b + b);

      const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(parsedHex);
      return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16),
      } : null;
    },
  };

  $(() => {
    crt.initialize();
  });
}(jQuery));
